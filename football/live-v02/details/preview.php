<?php

    include_once 'rex_tools.php';
    
    header('content-type: application/json');
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST':
                $data=json_decode(file_get_contents('php://input'), true);
                if($data["key"] == "6B35E89B9C6"){
                    postmethod($data);
                } else {
                    echo '{"Error":"Somthing is worng?"}';
                }
            break;
        default:
                echo '{"Error":"Somthing is worng?"}';
            break;
    }
    
    function postmethod($data){
        
        $gameId = $data["gameId"];
        $url = "https://www.espn.in/football/match/_/gameId/".$gameId;
        $html = file_get_html($url);

        $json_array = array();
        $headerINFO = $html->find('.game-strip');
        $game_time = "";

        $game_info = array();
        $gameInfo = $html->find('.soccer-game-information');
        $vanue = "";
        $info_gtime = "";

        $teamStatsArray = array();
        $teamStats = $html->find('.team-stats');
        $countIndex = 0;

        $mostAssistsArray = array();
        $mostAssists = $html->find('.topScorer .team-stats');
        $countIndex2 = 0;

        $headToHeadArray = array();
        $headToHead = $html->find('.head-to-head');
        $imgHder = "https://a.espncdn.com/combiner/i?img=/i/teamlogos/soccer/500/";
        $imgFdr = ".png&h=60&scale=crop&w=60";
    
        foreach($headerINFO as $a) {
            $league = $a->find('.header', 0)->innertext;
            $homeAway = $a->find('.away .long-name', 0)->innertext;
            $tHomeImg = $a->find('.away .team-info-logo img', 0)->src;
            $tHomeSnm = $a->find('.away .abbrev', 0)->innertext;

            foreach($a->find('.game-status') as $e) {
               $game_time = $e->find('span', 0)->getAttribute('data-date');
            }

            $tAway = $a->find('.home .long-name', 0)->innertext;
            $tAwayImg = $a->find('.home .team-info-logo img', 0)->src;
            $tAwaySnm = $a->find('.home .abbrev', 0)->innertext;
    
            $json_array = array("league"=>trim($league), "tAway"=>$tAway, "tAwayImg"=>$tAwayImg, "tAwaySnm"=>trim($tAwaySnm), "game_time"=>$game_time, "homeAway"=>$homeAway, "tHomeImg"=>$tHomeImg, "tHomeSnm"=>trim($tHomeSnm));
        }

        foreach($gameInfo as $gi) {
            foreach ($gi->find('.gi-group') as $value) {
                if ($value->find('.venue', 0)) {
                    $vanue = hpt($value->find('.venue', 0)->innertext);
                }
                foreach($gi->find('.gi-group .subdued') as $e) {
                   $info_gtime = $e->find('span', 0)->getAttribute('data-date');
                }
                $game_info = array('vanue' => trim($vanue), 'gtime' => $info_gtime);
            }
        }

        $teamStatsArray = array();
        foreach ($html->find('#gamepackage-soccer-top-scorers .topScorer .team-stats > li') as $key => $th) {

            $players = array();
            foreach ($th->find('li') as $key2 => $pj) {
                $pJarcyNo = $pj->find('.headshot-jersey-md .player-number', 0)->innertext;
                $pName = $pj->find('.player-detail .player-name', 0)->innertext;
                $pStatus = hpt($pj->find('.player-detail .player-stats', 0)->innertext);

                $players[] = array("pJarcyNo"=> $pJarcyNo, "pName"=> $pName, "pStatus"=>trim($pStatus));
            }

            $teamStatsArray[$key] = $players;
        }

        $mostAssistsArray = array();
        foreach ($html->find('#gamepackage-soccer-most-assists .topScorer .team-stats > li') as $key => $th) {

            $players = array();
            foreach ($th->find('li') as $key2 => $pj) {
                $pJarcyNo = $pj->find('.headshot-jersey-md .player-number', 0)->innertext;
                $pName = $pj->find('.player-detail .player-name', 0)->innertext;
                $pStatus = hpt($pj->find('.player-detail .player-stats', 0)->innertext);

                $players[] = array("pJarcyNo"=> $pJarcyNo, "pName"=> $pName, "pStatus"=>trim($pStatus));
            }

            $mostAssistsArray[$key] = $players;
        }

        foreach($headToHead as $hth) {
            
            foreach ($hth->find('tbody tr') as $pHtoH) {

                $team1 = $pHtoH->find('td .long-name', 0)->innertext;
                $t1ImgID = $pHtoH->find('.logo a', 0)->href;
                $t1id = (int) filter_var($t1ImgID, FILTER_SANITIZE_NUMBER_INT);
                $t1Img = $imgHder.(string)$t1id.$imgFdr; 

                $team2 = $pHtoH->find('td .long-name', 1)->innertext;
                $t2ImgID = $pHtoH->find('.logo a', 1)->href;
                $t2id = (int) filter_var($t2ImgID, FILTER_SANITIZE_NUMBER_INT);
                $t2Img = $imgHder.(string)$t2id.$imgFdr; 

                $score = $pHtoH->find('td .webview-internal', 0)->innertext;
                $gameDate = $pHtoH->find('td .game-date', 0)->innertext;
                $league = $pHtoH->find('.competition span', 0)->innertext;

                $headToHeadArray[] = array("team1"=> trim($team1), "t1Img"=> $t1Img, "score"=> trim($score), "team2"=>trim($team2), "t2Img"=> $t2Img, "gameDate"=>trim($gameDate), "league"=>trim($league));

            }

        }
        
        $object = array('header' => $json_array, 'game-info' => $game_info, 'top-scorers' => $teamStatsArray, 'most-assists' => $mostAssistsArray, 'headToHead' => $headToHeadArray);
        echo json_encode($object);

    }
    
    function hpt($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        return $str;
    }

?>