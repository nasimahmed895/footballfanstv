<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\LiveMatch;
use App\Models\Prediction;
use App\Models\Setting;
use App\Models\StreamingSource;
use App\Models\AppContent;
use App\Models\AppModel;
use App\Models\Promotion;
use App\Models\PopularSeries;
use App\Models\SportsType;
use Illuminate\Http\Request;
use App\Models\Fixure;
use App\Models\Highlight;
use App\Models\HighlightStreamingSource;
use DB;
use Cache;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController extends Controller
{
    public function live_matches(Request $request, $app_unique_id) 
    {
		$base_url = url('/');
        $status = true;
        $live_matches = Cache::rememberForever('live_matches_' . $app_unique_id, function () use($base_url, $app_unique_id) {
                return LiveMatch::select('live_matches.*', \DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), \DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"))
                        ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                        ->join('apps', 'apps.id', 'live_match_apps.app_id')
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('position', 'ASC')
                        ->get()
                        ->makeHidden(['status', 'created_at', 'updated_at']);
        });


        return response()->json(['status' => $status, 'data' => $live_matches]);
    }
	
	
	
	public function live_matches_by_type(Request $request, $app_unique_id)
	{
		$base_url = url('/');
        $status = true;

        $data = Cache::rememberForever('sports_types', function () use ($base_url){
			return SportsType::select('*', \DB::raw("CONCAT('$base_url/public/uploads/sports_images/', sports_skq, '.png') AS sports_image"))
								->get();
		});

        if($request->skq != '' && $request->skq != 'all'){
        	$types = $data->where('sports_skq', $request->skq)->pluck('id')->toArray();
        }else{
        	$types = $data->pluck('id')->toArray();
        }
			
        $live_matches = Cache::rememberForever('live_matches_' . $app_unique_id, function () use($base_url, $app_unique_id) {
            return LiveMatch::select('live_matches.*', \DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), \DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"))
                    ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                    ->join('apps', 'apps.id', 'live_match_apps.app_id')
                    ->where('apps.app_unique_id', $app_unique_id)
                    ->orderBy('position', 'ASC')
                    ->get()
                    ->makeHidden(['status', 'created_at', 'updated_at']);
        });

        

        $live_matches = $live_matches->whereIn('sports_type_id', $types)->values();

        
        return response()->json(['status' => $status, 'data' => $live_matches]);
	}
	
	public function streaming_sources(Request $request, $app_unique_id, $match_id) 
    {
		$base_url = url('/');
        $status = true;
        $platform = $request->platform ?? 'both';

        $live_match = Cache::rememberForever('live_match_' . $match_id, function () use ($match_id, $app_unique_id){
            return LiveMatch::select('live_matches.*')
                        ->join('live_match_apps', 'live_match_apps.match_id', 'live_matches.id')
                        ->join('apps', 'apps.id', 'live_match_apps.app_id')
						->where('live_matches.id', $match_id)
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('id', 'DESC')
                        ->first();
        });
		
		if(!$live_match){
			return response()->json(['status' => false, 'message' => 'No matches found.']);
		}

        $ip = $request->ip_address ?? $request->getClientIp(true);
        $streaming_sources = array();
        $streamingSources = Cache::rememberForever('streamingSources_' . $live_match->id, function () use ($live_match){
        	return StreamingSource::where('match_id', $live_match->id)->orderBy('position', 'ASC')->get();
        });

        $streamingSources = $streamingSources->whereIn('platform', ['both', $platform]);

        $i = 0;
        foreach ($streamingSources as $key2 => $source) {
        	if ($source->stream_type == 'root_stream') {
				$source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
				$streaming_sources[$i] = $source->makeHidden(['created_at', 'updated_at']);
			}else{
				$streaming_sources[$i] = $source->makeHidden(['created_at', 'updated_at']);
			}
			$i++;
        }
        return response()->json(['status' => $status, 'data' => $streaming_sources]);
    }

	
	public function highlights(Request $request, $app_unique_id) 
    {
		$base_url = url('/');
        $status = true;
        $highlights = Cache::rememberForever('highlights_' . $app_unique_id, function () use($base_url, $app_unique_id) {
                return Highlight::select('highlights.*', \DB::raw("CASE WHEN team_one_image_type = 'url' THEN team_one_url WHEN team_one_image_type = 'image' THEN CONCAT('$base_url/', team_one_image) ELSE '$base_url/public/default/default-team.png' END AS team_one_image"), \DB::raw("CASE WHEN team_two_image_type = 'url' THEN team_two_url WHEN team_two_image_type = 'image' THEN CONCAT('$base_url/', team_two_image) ELSE '$base_url/public/default/default-team.png' END AS team_two_image"), \DB::raw("CASE WHEN cover_image_type = 'url' THEN cover_url WHEN cover_image_type = 'image' THEN CONCAT('$base_url/', cover_image) ELSE '$base_url/public/default/default-team.png' END AS cover_image"))
                        ->join('highlight_apps', 'highlight_apps.highlight_id', 'highlights.id')
                        ->join('apps', 'apps.id', 'highlight_apps.app_id')
                        ->where('apps.app_unique_id', $app_unique_id)
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->makeHidden(['status', 'created_at', 'updated_at']);
        });

        $data = array();
        $ip = $request->ip();
        $i = 0;

        foreach ($highlights as $key => $value) {

            $data[$i] = $value->makeHidden(['sports_type_id', 'team_one_image_type', 'team_one_url', 'team_two_image_type', 'team_two_url', 'cover_image_type', 'cover_url']);
            
            $streaming_sources = array();
            $streamingSources = Cache::rememberForever('highlightStreamingSources_' . $value->id, function () use ($value){
            	return HighlightStreamingSource::where('highlight_id', $value->id)->get();
            });
            foreach ($streamingSources as $key2 => $source) {

                if ($source->stream_type == 'root_stream') {
                    $source->stream_url = getGeneratedToken($source->stream_url, $source->stream_key, $ip);
					
                    $streaming_sources[] = $source->makeHidden(['created_at', 'updated_at']);
                }else{

					if($request->platform == 'android' && $source->stream_type == 'restricted'){
						$headers = array();
						$i2 = 0;
						foreach(json_decode($source->headers, true) AS $key => $value){

							if($key != 'User-Agent'){
								$headers[$i2]['name'] = $key;
								$headers[$i2]['value'] = $value;
								$i2 ++;
							}else{
								$source->$key = $value;
							}


						}
						$source->headers = $headers;
					}
					
					
                    $streaming_sources[] = $source->makeHidden(['created_at', 'updated_at']);
                }
            }
            $data[$i]['streaming_sources'] = $streaming_sources;

            $i++;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }

    public function promotions(Request $request, $app_unique_id) {
        $status = false;
		$app = Cache::rememberForever('app_' . $app_unique_id, function () use ($app_unique_id){

			return AppModel::where('app_unique_id', $app_unique_id)->first();
		});

        $promotions = [];
		$base_url = url('/');
		
		$promotionData = Cache::rememberForever('promotions_' . $app_unique_id, function () use($base_url){
			return Promotion::select('*', \DB::raw("CASE WHEN promotion_type = 'image' THEN CONCAT('$base_url/', image) ELSE '' END AS image"), \DB::raw("CASE WHEN promotion_type = 'video' THEN CONCAT('$base_url/', video) ELSE '' END AS video"))
                            ->where('status', 1)
                            ->orderBy('id', 'DESC')
                            ->get();
		});
        foreach ($promotionData as $key => $promotion) {
            if(in_array($app->id, json_decode($promotion->apps) ?? ['n/a'])){
                $promotions[] = $promotion->makeHidden(['id', 'apps', 'created_at', 'updated_at', 'status']);
            }
        }
        $status = true;
        return response()->json(['status' => $status, 'data' => $promotions]);
    }

    public function settings(Request $request, $app_unique_id, $platform = '') {
        $status = false;

        $app = Cache::rememberForever('app_' . $app_unique_id, function () use ($app_unique_id){
			return AppModel::where('app_unique_id', $app_unique_id)->first();
		});
		if($app){
			if ($platform) {
				$settings = Cache::rememberForever('settings_' . $app->id, function () use ($platform, $app){
                	return AppContent::where('platform', $platform)
								->where('app_id', $app->id)
								->pluck('value', 'name')
								->toArray();
                });
			}else{
			    $settings = Cache::rememberForever('settings_' . $app->id, function () use ($app){
                	return AppContent::where('app_id', $app->id)
								->pluck('value', 'name')
								->toArray();
                });
			}

            $settings['ip'] = get_option('server');
			$status = true;
        	return response()->json(['status' => $status, 'data' => $settings]);
		}
		abort(404);
        
    }

	
	//SportsType.php
	public function sports_type(Request $request) {
        $status = false;
		$base_url = url('/');

		$data = Cache::rememberForever('sports_types', function () use ($base_url){
			return SportsType::select('*', \DB::raw("CONCAT('$base_url/public/uploads/sports_images/', sports_skq, '.png') AS sports_image"))
								->where('status', 1)
								->get();
		});
		
		$status = true;
		return response()->json(['status' => $status, 'data' => $data]);
        
    }
	
	
	public function newsapi(Request $request)
    {
        $status = false;
        $type = $request->type ?? 'football';
        $language = $request->language ?? 'en';
        $seconds = (60 * 60);
        $seconds = 1;
        $api_key = env('NEWS_API_KEY');
        
        $news = \Cache::remember("news_{$type}_$language", $seconds, function () use($type, $language, $api_key) {
            
            try {
                $client = new Client();
                $guzzleResponse = $client->get(
                    "https://newsapi.org/v2/everything?q=$type&pageSize=100&apiKey=$api_key&sortBy=publishedAt&language=$language", [
                    "headers" => [
                        //'APP_KEY'=>'QAWLhIK2p5'
                    ],
                ]);
                if ($guzzleResponse->getStatusCode() == 200) {
                    return json_decode($guzzleResponse->getBody(),true)['articles'];
                }
                
            } catch (RequestException $e) {
                return [];
            } catch(Exception $e){
                return [];
            }
        });
        return $news;
    }
}
