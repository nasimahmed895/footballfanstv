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

        $item = array();
        $index2 = 1;
    
        $mHtml = $html->find('div[id="sched-container"]');
        
        foreach($mHtml as $article) {
    
            foreach($article->find('h2') as $node) {
                $series = $node->plaintext;
                $m_index2 = (string) $index2;
                $item[] = array('id' => $m_index2, 'series_name' => $series);
                $index2++;
            }
    
        }
    
        $response['rex-lg'] = $item;
        echo json_encode($response);
        
    }

?>