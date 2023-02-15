<?php

	include('rex-tools.php');

    header('content-type: application/json');
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST':
                $data=json_decode(file_get_contents('php://input'), true);
                if($data["api_key"] == "7f581f7766bb683c1e785253fc75395a4245fe94f003f5318665b73c8d021424"){
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

        $mUrl = $data["url"];
        $html = file_get_html($mUrl);
        $mHtml = $html->find('.style_1j45z8k .style_1k79xgg');

        $mFBNewsArray = array();
		$title = "";
		$time = "";
		$figcaption = "";
		$image = "";

        foreach($mHtml as $article) {

            $title = $article->find('h1', 0)->innertext ?? '';
            $time = $article->find('time', 0)->innertext ?? '';
            $figcaption = $article->find('figcaption', 0)->innertext ?? '';
            $image = $article->find('picture img', 1)->src ?? ''; 
			
            foreach ($article->find('p') as $value) {
                $mamun = $value->innertext . '<br>';
                $mFBNewsArray[] = array('details' => hpt($mamun));
            }

        }
		
		$object = array('title'=>$title, 'time'=>$time, 'figcaption'=>$figcaption, 'image'=>$image, 'desc'=>$mFBNewsArray);
        $response['news-dtls'] = $object;
        echo json_encode($response);

    }

    function hpt($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = preg_replace('/\t/', '', $str);
        $str = preg_replace('/\%/', '', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        return $str;
    }
    

?>
