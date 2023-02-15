<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\AppModel;
use Illuminate\Support\Facades\Auth;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordMail;
use App\Utilities\Overrider;
use App\Mail\OTPMail;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        if ($request->provider == 'google' || $request->provider == 'apple' || $request->provider == 'facebook') {
            $user = User::where('email', $request->email)->where('user_type', 'user')->exists();
            if ($user) {
                return $this->signin($request);
            }
        }

        $user = User::where('email', $request->email)->where('status', 0)->where('user_type', 'user')->first();
        if ($user) {
            $user->tokens()->delete();
            $user->delete();
        }

        $validator = \Validator::make($request->all(), [

            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:191|unique:users',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
            'device_token' => 'required',
            'device_name' => 'required',
            'platform' => 'required',
            'provider' => 'required',
            'image' => 'nullable|image'

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->first()]);
        }

        $otp = rand(100000, 999999);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->user_type = 'user';
        $user->subscription_id = 0;
        $user->expired_at = null;
        $user->device_token = $request->device_token;
        $user->provider = $request->provider;

        if ($request->provider != "email") {
            $user->status = 1;
            $user->verification = null;
        } else {
            $user->status = 0;
            $user->verification = encrypt($otp);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->resize(300, 300)->save(base_path('public/uploads/images/users/') . $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }else{
            $user->image = $request->image ?? asset('public/default/profile.png');
        }

        $user->save();

        $user_device = new UserDevice();
        $user_device->user_id = $user->id;
        $user_device->device_token = $request->device_token;
        $user_device->device_name = $request->device_name;
        $user_device->platform = $request->platform;
        $user_device->save();

        $user->subscription_id = $user->subscription->name;

        // $mail_data = [
        //     'recipient' => $user->email,
        //     'subject' => 'Email Varification',
        //     'body' => 'Email Varification',
        //     'user' => $user,
        //     'app_name' => 'Xoom Sport',
        //     'otp' => $otp
        // ];

        // Mail::send('mail.verify-email', $mail_data, function ($message) use ($mail_data) {
        //     $message->to($mail_data['recipient'])
        //         ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
        //         ->subject($mail_data['subject']);
        // });

        $tokenResult = $user->createToken($request->device_token)->plainTextToken;

        if ($request->provider == 'email') {
            $this->send_message($user, "Email Verify", "Email Verify", "email-verify");

            return response()->json([
                'status' => true,
                'access_token' => $tokenResult,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'access_token' => $tokenResult,
                'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'email_verified_at', 'status', 'subscription']),
            ]);
        }
    }

    public function signin(Request $request)
    {
        // $validator = \Validator::make($request->all(), [

        //     'app_id' => 'required',
        //     'platform' => 'nullable',

        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['result' => false, 'message' => $validator->errors()->first()]);
        // }

        // $app_unique_id = $request->app_id;

        // $app = AppModel::where('app_unique_id', $app_unique_id)->firstOrFail();
        // $request->merge(['email' => "{$app->id}_$request->email"]);
        $validator = \Validator::make($request->all(), [

            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
            'device_token' => 'required',
            'provider' => 'required',
            'device_token' => 'required',
            'device_name' => 'required',
            'platform' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->first()]);
        }

        // Auth::logoutOtherDevices($currentPassword);
        $user = User::where('email', $request->email)->where('user_type', 'user')->first();

        if(!$user || ($user->provider != 'google' && $user->provider != 'apple' && $user->provider != 'facebook')){
            if ((!$user || !\Hash::check($request->password, $user->password)) ) {
                return response()->json([
                    'status' => false,
                    'message' => 'These credentials do not match our records.',
                ]);
            }
        }

        if($request->provider == 'google' || $request->provider == 'apple' || $request->provider == 'facebook'){
            if($request->provider != $user->provider){
                return response()->json([
                    'status' => false,
                    'message' => 'These credentials do not match our recordsd.',
                ]);
            }
        }

        // $user->tokens()->delete();

        // $user->device_token = $request->device_token;

        $user->save();

         $userdevice = new UserDevice();
        $userdevice->user_id = $user->id;
        $userdevice->device_token = $request->device_token;
        $userdevice->device_name = $request->device_name;
        $userdevice->platform = $request->platform;
        $userdevice->save();


        $user->email = $user->display_email;
        $user->subscription_id = $user->subscription->name;

        $tokenResult = $user->createToken($request->device_token)->plainTextToken;
        return response()->json([
            'status' => true,
            'access_token' => $tokenResult,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if($user->expired_at < date('Y-m-d')){
            $user->subscription_id = 0;
            $user->expired_at = null;
            $user->save();
        }

        $user->email = $user->display_email;
        $user->subscription_id = $user->subscription->name;

        return response()->json([
            'status' => true,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    public function user_update(Request $request)
    {
        $user = $request->user();
        $validator = \Validator::make($request->all(), [

            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => false, 'message' => $validator->errors()->first()]);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->save();

        $user->email = $user->display_email;
        $user->subscription_id = $user->subscription->name;

        return response()->json([
            'status' => true,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'apps', 'app_id', 'email_verified_at', 'status', 'subscription']),
        ]);
    }

    public function change_password(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = $request->user();

        if (\Hash::check($request->old_password, $user->password)) {

            if (!\Hash::check($request->password, $user->password)) {

                $user->password = \Hash::make($request->password);
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Password has been changed!',
                ]);
            } else {

                return response()->json([
                    'status' => false,
                    'message' => 'New Password can not be the old password!',
                ]);
            }
        } else {

            return response()->json([
                'status' => false,
                'message' => 'Old Password not match!',
            ]);
        }
    }

    public function forget_password(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'app_id' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        $app_unique_id = $request->app_id;
        $app = AppModel::where('app_unique_id', $app_unique_id)->firstOrFail();
        $request->merge(['email' => "{$app->id}_$request->email"]);

        $user = User::where('email', $request->email)->where('provider', 'email')->first();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Please enter your valid email address.',
            ]);
        }

        $password = substr(rand(), 0, 6);

        $user->password = \Hash::make($request->password);
        $user->save();

        $user->newPassword = $password;

        $this->send_message($user);

        return response()->json([
            'status' => true,
            'message' => 'Please check your email for your password.',
        ]);
    }

    public function send_message($user, $subject, $message, $context)
    {
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

        // Timezone
        config(['app.timezone' => get_option('timezone')]);

        // Email
        config(['mail.driver' => 'smtp']);
        config(['mail.from.name' => get_option('from_name')]);
        config(['mail.from.address' => get_option('from_mail')]);
        config(['mail.host' => get_option('smtp_host')]);
        config(['mail.port' => get_option('smtp_port')]);
        config(['mail.username' => get_option('smtp_username')]);
        config(['mail.password' => get_option('smtp_password')]);
        config(['mail.encryption' => get_option('smtp_encryption')]);

        // $mail_data = [
        //     'recipient' => $user->email,
        //     'subject' => 'Forget Password',
        //     'body' => 'Forget Password',
        //     'user' => $user,
        //     'app_name' => 'Xoom Sport'
        // ];

        // Mail::send('mail.forget-password-mail', $mail_data, function ($message) use ($mail_data) {
        //     $message->to($mail_data['recipient'])
        //         ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
        //         ->subject($mail_data['subject']);
        // });

        $mail  = new \stdClass();
        $mail->name = $user->name;
        $mail->email = $user->email;
        $mail->subject = $subject;
        $mail->message = $message;
        $mail->user = $user;
        $mail->app_name = get_option('from_name');

        if ($context == "email-verify") {
            try {
                Mail::to($user->email)->send(new OTPMail($mail));
                return json_encode(array('result' => true, 'message' => _lang('Your Message send sucessfully.')));
            } catch (\Exception $e) {
                return json_encode(array('result' => false, 'message' => _lang('Error Occured, Please try again !')));
            }
        }

        if ($context == "forget-password") {
            try {
                Mail::to($user->email)->send(new ForgetPasswordMail($mail));
                return json_encode(array('result' => true, 'message' => _lang('Your Message send sucessfully.')));
            } catch (\Exception $e) {
                return json_encode(array('result' => false, 'message' => _lang('Error Occured, Please try again !')));
            }
        }
    }

    public function file_upload(Request $request)
    {
        $validator = \Validator::make($request->all(), [

            'field' => 'required|in:picture,birth_certificate,transcripts,highlight_one,highlight_two,highlight_three',
            'file' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        \DB::beginTransaction();

        $user = $request->user();

        $additional_data = additional_data($user);


        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            return $this->saveFile($save->getFile());
        }
        $handler = $save->handler();


        $additional_data->save();

        \DB::commit();

        $user->name = $user->first_name;

        return response()->json([
            'status' => true,
            'access_token' => $request->bearerToken(),
            'data' => $user->makeHidden(['created_at', 'updated_at', 'email_verified_at']),
            'additional_data' => $additional_data,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            return $this->saveFile($save->getFile());
        }
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }


    /**
     * Saves the file to S3 server
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFileToS3($file)
    {
        $fileName = $this->createFilename($file);
        $disk = Storage::disk('s3');
        $disk->putFileAs('photos', $file, $fileName);
        $mime = str_replace('/', '-', $file->getMimeType());
        unlink($file->getPathname());
        return response()->json([
            'path' => $disk->url($fileName),
            'name' => $fileName,
            'mime_type' =>$mime
        ]);
    }
    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        $mime = str_replace('/', '-', $file->getMimeType());
        $filePath = "public/uploads/images/";
        $file->move(base_path($filePath), $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }
    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename =  md5(time()) . "." . $extension;
        return $filename;
    }

     public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'otp' => 'required|string|max:6|min:6',

        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'message' => $validator->errors()->first()]);
        }

        $user = $request->user();


        if (!$user || $request->otp == decrypt($user->verification)) {
            return response()->json([
                'status' => false,
                'message' => 'Otp not match.',
            ]);
        }

        $user->status = 1;
        $user->verification = null;
        $user->email_verified_at = now();

        $user->tokens()->delete();

        $user->save();

        $tokenResult = $user->createToken($request->otp)->plainTextToken;

        $user->subscription_id = $user->subscription->name;

        return response()->json([
            'status' => true,
            'access_token' => $tokenResult,
            'data' => $user->makeHidden(['id', 'user_type', 'created_at', 'updated_at', 'email_verified_at', 'status', 'subscription']),
        ]);
    }
}
