<?php

namespace App\Http\Controllers;

use App\Models\LiveMatch;
use App\Models\Prediction;
use App\Models\WebsiteAds;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Utilities\VideoStream;
// use Jenssegers\Agent\Facades\Agent;
 use Jenssegers\Agent\Agent;



class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {
    //     $agent = new Agent();
    //     $device = $agent->device();
    //     $browser = $agent->browser();

    //     $platform = $agent->platform();
    //     $version = $agent->version($platform);

    //     $bot = $agent->isRobot();
    //    $mobile = $agent->isMobile();
    //    $tablet =  $agent->isTablet();

    //     dd($agent,$browser,$platform,$version,$bot, $mobile,$tablet);
        $subscription = Subscription::get();
    	return view('welcome',compact('subscription'));
    }

    // public function logincheck(request $request)
    // {
    //     $agent = new Agent();
    //    $mobile = $agent->isMobile();
    //    $tablet =  $agent->isTablet();
    //     if ($mobile || $tablet) {
    //         echo 'ok';
    //     } else {
    //         echo 'not';
    //     }
    // }
}
