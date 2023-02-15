<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::Group(['middleware' => 'check_api_key'], function () {

    //ip
    Route::post('/v1/ip', function (Request $request) {
        return $request->getClientIp(true);
    });

    Route::post('/v1/live_matches/{app_unique_id}', 'App\Http\Controllers\Api\v1\ApiController@live_matches');
    Route::post('/v1/highlights/{app_unique_id}', 'App\Http\Controllers\Api\v1\ApiController@highlights');
    Route::post('/v1/live_matches_by_type/{app_unique_id}', 'App\Http\Controllers\Api\v1\ApiController@live_matches_by_type');
    Route::post('/v1/streaming_sources/{app_unique_id}/{match_id}', 'App\Http\Controllers\Api\v1\ApiController@streaming_sources');
    Route::post('/v1/settings/{app_unique_id}/{platform?}', 'App\Http\Controllers\Api\v1\ApiController@settings');
    Route::post('/v1/promotions/{app_unique_id}', 'App\Http\Controllers\Api\v1\ApiController@promotions');
    Route::post('/v1/popular_series/{app_unique_id}', 'App\Http\Controllers\Api\v1\ApiController@popular_series');
    Route::post('/v1/support', 'App\Http\Controllers\Api\v1\ApiController@support');
    Route::post('/v1/sports/type', 'App\Http\Controllers\Api\v1\ApiController@sports_type');

    Route::post('/v1/newsapi', 'App\Http\Controllers\Api\v1\ApiController@newsapi');

    //FootballfanstvController
    Route::post('/v1/footballfanstv/news', 'App\Http\Controllers\Api\v1\FootballfanstvController@news');

    //AuthController
    Route::post('/v1/signup', 'App\Http\Controllers\Api\v1\AuthController@signup');
    Route::post('/v1/signin', 'App\Http\Controllers\Api\v1\AuthController@signin');
    Route::post('/v1/forget_password', 'App\Http\Controllers\Api\v1\AuthController@forget_password');

    //SubscriptionController
    Route::post('/v1/subscriptions', 'App\Http\Controllers\Api\v1\SubscriptionController@subscriptions');

    //optiona_auth
    Route::middleware('optiona_auth')->group(function () {
        //HomeController
        // Route::post('/v1/home', 'App\Http\Controllers\Api\v1\HomeController@home');
    });

    //auth
    Route::middleware('auth:sanctum')->group(function () {

        //AuthController
        Route::post('/v1/user', 'App\Http\Controllers\Api\v1\AuthController@user');
        Route::post('/v1/user_update', 'App\Http\Controllers\Api\v1\AuthController@user_update');
        Route::post('/v1/change_password', 'App\Http\Controllers\Api\v1\AuthController@change_password');
        // Route::post('/v1/verification', 'App\Http\Controllers\Api\v1\AuthController@verification');
            Route::post('/v1/verification', function (Request $request) {


        $user = $request->user();


        // if (!$user || $request->otp == decrypt($user->verification)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Otp not match.',
        //     ]);
        // }

        // $user->status = 1;
        // $user->verification = null;
        // $user->email_verified_at = now();

        // $user->tokens()->delete();

        // $user->save();

        // $tokenResult = $user->createToken($request->otp)->plainTextToken;

        // $user->subscription_name = $user->subscription->name;

        return response()->json([
            'status' => true,
            // 'access_token' => $tokenResult,
            'data' => $user,
        ]);
    });


        //SubscriptionController
        Route::post('/v1/subscription_update', 'App\Http\Controllers\Api\v1\SubscriptionController@subscription_update');
        Route::post('/v1/subscription_expired', 'App\Http\Controllers\Api\v1\SubscriptionController@subscription_expired');
        Route::post('/v1/subscription_restore', 'App\Http\Controllers\Api\v1\SubscriptionController@subscription_restore');
        Route::post('/v1/payments', 'App\Http\Controllers\Api\v1\SubscriptionController@payments');
    });



    //-------------Football App Api--------------//
    //-------------------------------------------//
    Route::post('/v1/football/schedules', 'App\Http\Controllers\Api\v1\FootballApiController@match_schedules');
    Route::post('/v1/football/liveFT/match', 'App\Http\Controllers\Api\v1\FootballApiController@liveAndFtMatch');
    Route::post('/v1/football/preview', 'App\Http\Controllers\Api\v1\FootballApiController@match_preview');
    Route::post('/v1/football/header', 'App\Http\Controllers\Api\v1\FootballApiController@header');
    Route::post('/v1/football/lineups', 'App\Http\Controllers\Api\v1\FootballApiController@lineups');
    Route::post('/v1/football/commentary', 'App\Http\Controllers\Api\v1\FootballApiController@commentary');
    Route::post('/v1/football/statistics', 'App\Http\Controllers\Api\v1\FootballApiController@statistics');
    Route::post('/v1/football/standing/league', 'App\Http\Controllers\Api\v1\FootballApiController@standingLeague');
    Route::post('/v1/football/standing/year', 'App\Http\Controllers\Api\v1\FootballApiController@standingYear');
    Route::post('/v1/football/standing/details', 'App\Http\Controllers\Api\v1\FootballApiController@standingDetails');
    Route::post('/v1/football/news', 'App\Http\Controllers\Api\v1\FootballApiController@news');
    Route::post('/v1/football/news_details', 'App\Http\Controllers\Api\v1\FootballApiController@newsDetails');


    //--------------------------------//
    //--------Football New Api -> WindFootball--------//
    //--------------------------------//
    //-> Home Api
    Route::post('/v3/football/home', 'App\Http\Controllers\Api\v1\FotbalNewApiController@football_home');
    Route::post('/v3/football/home/details/news', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_home_dtls_news');
    //-------Team Details Api-------//
    Route::post('/v3/football/team/fixtures', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_team_fixtures');
    Route::post('/v3/football/team/squad', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_team_squad');
    Route::post('/v3/football/team/stats', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_team_stats');
    Route::post('/v3/football/team/transfers', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_team_transfers');
    //-------END Team Details Api-------//

    //-------League Details Api-------//
    Route::post('/v3/football/league/fixtures', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_league_fixtures');
    Route::post('/v3/football/league/table', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_league_table');
    Route::post('/v3/football/league/stats', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_league_stats');
    Route::post('/v3/football/league/team', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_league_team');
    Route::post('/v3/football/league/transfers', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_league_transfers');
    //-------END League Details Api-------//

    //-------All Teams Start Api-------//
    Route::post('/v3/football/all/teams', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_all_teamsl');
    Route::post('/v3/football/tournament/teams', 'App\Http\Controllers\Api\v1\FotbalNewApiController@fbal_turnament_teamsls');
    //-------All Teams End Api-------//

});