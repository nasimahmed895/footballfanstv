<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use DataTables;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $promotions = Promotion::orderBy('id', 'DESC');

        if ($request->ajax()) {
            return DataTables::of($promotions)
                ->addColumn('status', function ($promotion) {
                    return $promotion->status == 1 ? status(_lang('Active'), 'success') : status(_lang('In-Active'), 'danger');
                })
                ->addColumn('action', function($promotion){

                    $action = '<div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ' . _lang('Action') . '
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                    $action .= '<a href="' . route('promotions.edit', $promotion->id) . '" class="dropdown-item" >
                                        <i class="fas fa-edit"></i>
                                        ' . _lang('Edit') . '
                                    </a>';
                    $action .= '<form action="' . route('promotions.destroy', $promotion->id) . '" method="post" class="ajax-delete">'
                                . csrf_field()
                                . method_field('DELETE')
                                . '<button type="button" class="btn-remove dropdown-item">
                                        <i class="fas fa-trash-alt"></i>
                                        ' . _lang('Delete') . '
                                    </button>
                                </form>';
                    $action .= '</div>
                            </div>';
                    return $action;
                })
                ->setRowId(function ($promotion) {
                    return "row_" . $promotion->id;
                })
                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }

        return view('backend.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->ajax()) {
            return view('backend.promotions.create');
        } else {
            return view('backend.promotions.modal.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validator = \Validator::make($request->all(), [

            'description' => 'required|string',
            'promotion_type' => 'required|string',
            'video' => 'nullable|required_if:promotion_type,video|string|max:191',
            'image' => 'nullable|required_if:promotion_type,image|image',
            'action_url' => 'required|url',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $promotion = new Promotion();

        $promotion->description = $request->description;
        $promotion->promotion_type = $request->promotion_type;
        if($request->promotion_type == 'video'){
            $promotion->video = $request->video;
            $promotion->image = '';
        }else{
            $promotion->video = '';
        }
        $promotion->action_url = $request->action_url;
        $promotion->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->save(base_path('public/uploads/images/promotions/') . $ImageName);
            $promotion->image = 'public/uploads/images/promotions/' . $ImageName;
        }

        $promotion->save();

        if (!$request->ajax()) {
            return redirect('promotions')->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('promotions'), 'message' => _lang('Information has been added sucessfully.')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $promotion = Promotion::find($id);

        if (!$request->ajax()) {
            return view('backend.promotions.edit', compact('promotion'));
        } else {
            return view('backend.promotions.modal.edit', compact('promotion'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [

            'description' => 'required|string',
            'promotion_type' => 'required|string',
            'video' => 'nullable|string|max:191',
            'image' => 'nullable|image',
            'action_url' => 'required|url',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $promotion = Promotion::find($id);

        $promotion->description = $request->description;
        $promotion->promotion_type = $request->promotion_type;
        if($request->promotion_type == 'video'){
            $promotion->video = $request->video;
            $promotion->image = '';
        }else{
            $promotion->video = '';
        }
        $promotion->action_url = $request->action_url;
        $promotion->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            \Image::make($image)->save(base_path('public/uploads/images/promotions/') . $ImageName);
            $promotion->image = 'public/uploads/images/promotions/' . $ImageName;
        }

        $promotion->save();

        if (!$request->ajax()) {
            return redirect('promotions')->with('success', _lang('Information has updated added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('promotions'), 'message' => _lang('Information has been updated sucessfully.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        $promotion->delete();

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        dd($request->all());
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
        $filePath = "uploads/promotions/";
        $file->move(public_path($filePath), $fileName);

        return response()->json([
            'path' => 'public/' . $filePath,
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
}
