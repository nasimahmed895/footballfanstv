<?php

    include('simple_html_dom.php');

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
        
        $url = $data["url"];

        $html = file_get_html($url);
        $mHtml = $html->find('.xpa-switch-article');
        $image = "";

        $dtls_array = array();


        foreach($mHtml as $value) {

            foreach($value->find('.of-image picture img') as $key => $element) {

               $image = $element->getAttribute('src');;
               break;
            }

            foreach($value->find('.news-paragraph') as $dtls){

                $mamun = $dtls->innertext;
                $dtls_array[] = array('details' => $mamun);

            }

        }

        $object = array('image'=>$image, 'desc'=>$dtls_array);
        $response['news-dtls'] = $object;
        echo json_encode($response);

    }


?>