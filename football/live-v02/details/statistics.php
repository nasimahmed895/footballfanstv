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
        $url = "https://www.espn.in/football/matchstats?gameId=".$gameId;
        $html =  file_get_html($url);

        $mHtml = $html->find('.data-vis');
        $mHtml2 = $html->find('.stat-list');

        $team_array = array();
        $graph_array = array();
        $matchInfo_array = array();

        foreach($mHtml as $article) {

            foreach($article->find('.away picture img') as $element) {
               $awayTmImg = $element->getAttribute('src');
            }
            $awayTname = $article->find('.away .team-name', 0)->innertext;

            foreach($article->find('.home picture img') as $element) {
               $homeTmImg = $element->getAttribute('src');
            }
            $homeTname = $article->find('.home .team-name', 0)->innertext;

            $awayChart = $article->find('.stat-graph .chartValue', 0)->innertext;
            $homeChart = $article->find('.stat-graph .chartValue', 1)->innertext;

            foreach($article->find('.shots') as $el) {
               $homeShots = $el->find('.number', 0)->innertext;
            }

            foreach($article->find('.shots') as $el) {
               $awayShots = $el->find('.number', 1)->innertext;
            }
            $graph_array = array('awayChart' => $awayChart, 'homeChart' => $homeChart, 'homeShots' => $homeShots, 'awayShots' => $awayShots);
            $team_array = array('awayTname' => $awayTname, 'awayTimg' => $awayTmImg, 'homeTname' => $homeTname, 'homeTimg' => $homeTmImg, 'graph' => $graph_array);

        }

        foreach($mHtml2 as $datas) {

            foreach($datas->find('tbody tr') as $state) {

                $home = $state->find('td', 0)->innertext;
                $problem = $state->find('td', 1)->innertext;
                $away = $state->find('td', 2)->innertext;

                $matchInfo_array[] = array('home' => $home, 'problem' => $problem, 'away' => $away);

            }

        }

        $object = array('team'=>$team_array, 'info'=>$matchInfo_array);
        echo json_encode($object);

    }

?>