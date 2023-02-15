<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
            Session::flush();
            Auth::logout();
           return redirect('/');

        /* Call original logout method */
        // $user_type = Auth::user()->user_type;

        // $this->performLogout($request);

        // switch ($user_type) {
        //   case 'admin':
        //     return redirect()->route('admin.login');
        //   case 'user':
        //     return redirect()->route('index');
        //   default:
        //     return route('index');
        // }
    }

    /**
      * Where to redirect users after login.
      *
      * @var string
      */
    // protected $redirectTo = RouteServiceProvider::HOME;


    /**
      * Where to redirect users after login.
      *
      * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
      */
    public function redirectTo()
    {
        $user_type = Auth::user()->user_type;
        //   $user = User::find(Auth::user()->id);
        //     $user->device_login = Auth::user()->device_login+1;
        //      $user->update();
        switch ($user_type) {
            case 'admin':
              return route('live_matches.index');
            case 'user':
              return route('index');


            default:
              return route('index');
        }
    }

     /**
      * Show the application's login form.
      *
      * @return \Illuminate\View\View
      */
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function showUserLoginForm()
    {
        return view('auth.login');
    }
}
