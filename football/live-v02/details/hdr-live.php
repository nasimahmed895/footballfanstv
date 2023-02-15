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
    
    function postmethod($data) {
        
        $gameId = $data["gameId"];
        $url = "https://www.espn.in/football/matchstats?gameId=".$gameId;
        $html = file_get_html($url);

        $json_array = array();
        $iconFinder = "";
        $headerINFO = $html->find('.game-strip');
    
        foreach($headerINFO as $a) {
            $league = $a->find('.header', 0)->innertext;
            $teamAway = $a->find('.away .long-name', 0)->innertext;
            $teamAwayImg = $a->find('.away .team-info-logo img', 0)->src;
            $teamAwayScore = $a->find('.away .score-container .score', 0)->innertext;
            $game_time = $a->find('.game-status .game-time', 0)->innertext;
            $game_play = $a->find('.game-status .game-play', 0)->innertext;
            $homeAway = $a->find('.home .long-name', 0)->innertext;
            $teamHomeImg = $a->find('.home .team-info-logo img', 0)->src;
            $teamHomeScore = $a->find('.home .score-container .score', 0)->innertext;
    
            $json_array = array("league"=>trim($league), "teamAway"=>$teamAway, "teamAwayImg"=>$teamAwayImg, "teamAwayScore"=>trim($teamAwayScore), "game_time"=>$game_time, "game_play"=>$game_play, "homeAway"=>$homeAway, "teamHomeImg"=>$teamHomeImg, "teamHomeScore"=>trim($teamHomeScore));
        }
        
        $object = array('data'=>$json_array);
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