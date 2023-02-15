<?php

	include('rex_tools.php');
	
	header('content-type: application/json');
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST':
                $data=json_decode(file_get_contents('php://input'), true);
                if($data["key"] == "6B35E89B9C6"){
                    postRequestCapture($data);
                } else {
                    echo '{"Error":"Somthing is worng?"}';
                }
            break;
        default:
                echo '{"Error":"Somthing is worng?"}';
            break;
    }
    
    function postRequestCapture($data){
        
        $mDate = $data["date"];
        $html = file_get_html('https://www.espn.in/football/fixtures/_/date/'.$mDate);

        $json_array = array();
        $index = 1;
        $mTime = "";
        $result = "";
        $liveScore = "";
    
        $mHtml = $html->find('div[id="sched-container"]');
        
        foreach($mHtml as $article) {
    
             foreach($article->find('tbody') as $a2){
    
                $m_index = (string) $index;
    
                foreach($a2->find('tr') as $a){
    
                    $s_team1 = $a->find('abbr', 0)->innertext;
                    $f_team1 = $a->find('a span', 0)->innertext;
                    $image1 = $a->find('img', 0)->src;
                    $scr = $a->find('.record a', 0)->innertext;
                    $live = $a->find('.live a', 0)->innertext;
                    if (strtolower($live) == "live") {
                        $liveScore = $live;
                    } else {
                        $liveScore = $scr;
                    }
                    $f_team2 = $a->find('a span', 1)->innertext;
                    $s_team2 = $a->find('abbr', 1)->innertext;
                    $image2 = $a->find('img', 1)->src;
                    $result = $a->find('a', 3)->innertext;
                    $series_id21 = $a->find('a', 3)->href;
    
                    if (!empty($series_id21) || !empty($s_team1)) {
                        if ($result == "") {
                            $mTime = $a->find('td', 2)->getAttribute('data-date');
                            $mTimeStamp = strtotime($mTime);
                            $mTimes = (string) $mTimeStamp;
                        } else {
                            $mTimes = "";
                        }
                        $gameId = (int) filter_var($series_id21, FILTER_SANITIZE_NUMBER_INT);
                        $json_array[] = array('s_id' => $m_index, 'match_id' => (string)$gameId, 'tName1' => $f_team1, 's_tName1' => $s_team1, 'image1' => $image1, 'result' => $result, 'tName2' => $f_team2, 's_tName2' => $s_team2, 'image2' => $image2, 'score' => $liveScore, 'result' => $result, 'mtime' => $mTimes);
                    }
                    
              }
    
              $index++;
    
            }
    
        }
    
        $response['rex-fix'] = $json_array;
        echo json_encode($response);
        
    }

?>