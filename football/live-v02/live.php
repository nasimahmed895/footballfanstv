<?php

    include('rex_tools.php');
  
    header('content-type: application/json');
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST':
                $data=json_decode(file_get_contents('php://input'), true);
                if($data["live-key"] == "6B35E89B9C6"){
                    postRequestCapture($data);
                } else {
                    echo '{"Error":"Somthing is worng?"}';
                }
            break;
        default:
                echo '{"Error":"Somthing is worng?"}';
            break;
    }
    
    function postRequestCapture(){

        // this is url for espn
        $html = file_get_html('https://www.espn.in/football/fixtures');
        
        $json_array = array();
        $FT_array = array();
        $index = 1;
    
        $mHtml = $html->find('div[id="sched-container"]');
        
        foreach($mHtml as $article) {
    
            foreach($article->find('tbody') as $a2){
    
                foreach($a2->find('tr') as $a){
    
                    $s_team1 = $a->find('abbr', 0)->innertext;
                    $f_team1 = $a->find('a span', 0)->innertext;
                    $image1 = $a->find('img', 0)->src;
                    $scr = $a->find('.record a', 0)->innertext;
                    $live = $a->find('.live a', 0)->innertext;
                    $ftscore = hpt($a->find('td', 2)->innertext);
                    if (strtolower($live) == "live") {
                        $liveScore = $live;
                    } else if (strtolower($ftscore) == "ft") {
                        $liveScore = $ftscore;
                    } else {
                        $liveScore = $scr;
                    }
                    $f_team2 = $a->find('a span', 1)->innertext;
                    $s_team2 = $a->find('abbr', 1)->innertext;
                    $image2 = $a->find('img', 1)->src;
                    $result = $a->find('td a', 1)->innertext;
                    $series_id21 = $a->find('a', 3)->href;
                    $m_index = (string) $index;
    
                    if (!empty($series_id21) || !empty($s_team1)) {
                        $gameId = (int) filter_var($series_id21, FILTER_SANITIZE_NUMBER_INT);
                        
                        if ($liveScore == "LIVE") {
                            $json_array[] = array('id' => $m_index, 'gameId' => (string) $gameId, 'tName1' => $f_team1, 's_tName1' => $s_team1, 'image1' => $image1, 'result' => $result, 'tName2' => $f_team2, 's_tName2' => $s_team2, 'image2' => $image2, 'result' => $liveScore, 'score' => $result);
                            $index++;
                        } else if ($liveScore == "FT") {
                            $FT_array[] = array('id' => $m_index, 'gameId' => (string) $gameId, 'tName1' => $f_team1, 's_tName1' => $s_team1, 'image1' => $image1, 'result' => $result, 'tName2' => $f_team2, 's_tName2' => $s_team2, 'image2' => $image2, 'result' => $liveScore, 'score' => $result);
                            $index++;
                        }

                    }
                    
              }
    
            }
    
        }
    
        $object = array('live'=>$json_array, 'ft'=>$FT_array);
        echo json_encode($object);
        
    }
    
    function hpt($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = str_replace('&quot;', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        return $str;
    }

?>