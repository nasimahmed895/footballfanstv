<?php
    
    include_once 'rex_tools.php';

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

        $gameId = $data["gameId"];
        $url = "https://www.espn.in/football/lineups?gameId=".$gameId;

        $tNo = $data["tNo"];
        $html =  file_get_html($url);
        $mHtml = $html->find('.sub-module', $tNo);
        $mHtml1 = $html->find('.sub-module', 0);
        $mHtml2 = $html->find('.sub-module', 1);
        $t1_array = array();
        $t2_array = array();
        $t1Player_array = array();
        $t1allPly_array = array();
        $endIconFindArray =  array();

        $iconT1Start = "";
        $yelloCrd = "";
        $redCrd = "";
        $goalFor = "";
        $EKNo01 = "";


        foreach($mHtml1->find('.content') as $article) {

            foreach($article->find('.formation .formations__header .formations__image img') as $element) {
                $imgLink = $element->getAttribute('src');
            }
            foreach($article->find('.formation .formations__header .formations__text') as $element) {
                $herTxt = $element->innertext;
            }
            $t1_array = array('t1Image' => $imgLink, 't1Text' => $herTxt);
        }

        foreach($mHtml2->find('.content') as $article) {

            foreach($article->find('.formation .formations__header .formations__image img') as $element) {
                $imgLink = $element->getAttribute('src');
            }
            foreach($article->find('.formation .formations__header .formations__text') as $element) {
                $herTxt = $element->innertext;
            }
            $t2_array = array('t1Image' => $imgLink, 't1Text' => $herTxt);
        }


        foreach($mHtml->find('.content') as $article) {

            foreach($article->find('.formation ul .player') as $player) {
                
                $t1pName = $player->find('.player-name', 0)->innertext;
                $t1pJsNo = $player->find('text', 0)->innertext;
                $t1Player_array[] = array('t1pName' => $t1pName, 't1pJsNo' => $t1pJsNo); 

            }

            foreach($article->find('table tbody tr .accordion-header') as $stv){

                if($stv->find('.name .icon-soccer-substitution-before', 0)){
                    $iconT1Start = 'substitution.png';
                } else {
                    $iconT1Start = '';
                }

                if($stv->find('.name .icon-redcard', 0)){
                    $redCrd = 'redcard.png';
                } else {
                    $redCrd = '';
                }

                if($stv->find('.name .icon-yellowcard', 0)){
                    $yelloCrd = 'yellow.png';
                } else {
                    $yelloCrd = '';
                }

                if($stv->find('.name .icon-soccer-goal-before', 0)){
                    $goalFor = 'goal.png';
                } else {
                    $goalFor = '';
                }

                $t1pNo = hpt($stv->find('.name', 0)->innertext);
                $t1pName = hpt($stv->find('.name', 1)->innertext);
                $tT1no = trim(str_replace(array("\t"), '', $t1pNo));
                $tpName420 = str_replace(array("/\s/"), '', $t1pName);
                $tpName = str_replace(array("\t"), '', $tpName420);
                $tT1pName = trim(preg_replace('/[0-9]+/Ui', '', $tpName));

                list($rexNo01, $rexNo02) = explode("'", $tT1no);
                if ($rexNo02 == "") {
                    $EKNo01 = str_replace('  ', '', $tT1no);
                } else {
                    $EKNo01 = str_replace('  ', '', $rexNo02);
                }

                $endIconFindArray = array('yelloCrd' => $yelloCrd, 'redCrd' => $redCrd, 'goal' => $goalFor);
                $t1allPly_array[] = array('iconT1Start' => $iconT1Start, 't1pNo' => $EKNo01, 't1pName' => hptTwo($tT1pName), 'endIcon' => $endIconFindArray);
                
            }

        }

        $object = array('header1'=>$t1_array, 'header2'=>$t2_array, 'player-list'=>$t1allPly_array);
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

    function hptTwo($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = str_replace("'", '', $str);
        $str = str_replace('  OG', '', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        return $str;
    }

?>