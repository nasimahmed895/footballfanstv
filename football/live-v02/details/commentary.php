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
        $url = "https://www.espn.in/football/commentary?gameId=".$gameId;
        $html = file_get_html($url);

        $commentaryArray = array();
        $iconFinder = "";
    
        $matchCommentary = $html->find('.match-commentary .accordion');
    
        foreach($matchCommentary as $msc) {
            
            foreach($msc->find('tr') as $a){
                $timeStamp = $a->find('.time-stamp', 0)->innertext;
                $gameDetails = $a->find('.game-details', 0)->innertext;
    
                if($a->find('.icon-soccer-foul-before', 0)) {
                    $iconFinder = 'foul.png';
                } else if($a->find('.icon-soccer-corner-kick-before', 0)){
                    $iconFinder = 'corner.png';
                } else if($a->find('.icon-soccer-substitution-before', 0)){
                    $iconFinder = 'substitution.png';
                } else if($a->find('.icon-soccer-shot-off-target-before', 0)){
                    $iconFinder = 'shot.png';
                } else if($a->find('.icon-soccer-offside-before', 0)){
                    $iconFinder = 'offside.png';
                } else if($a->find('.icon-soccer-goal-before', 0)){
                    $iconFinder = 'goal.png';
                } else if($a->find('.icon-soccer-halftime-before', 0)){
                    $iconFinder = 'halftime.png';
                } else if($a->find('.icon-soccer-shot-on-target-before', 0)){
                    $iconFinder = 'shot-on.png';
                } else if($a->find('.icon-soccer-yellow-card-before', 0)){
                    $iconFinder = 'yellowcard.png';
                } else {
                    $iconFinder = '';
                }
    
                $commentaryArray[] = array('timeStamp' => trim($timeStamp), 'gameDetails' => trim(hpt($gameDetails)), "iconFinder" => $iconFinder);
            }
    
        }
        
        $object = array('commentary'=>$commentaryArray);
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