<?php

	include('simple_html_dom.php');

    header('content-type: application/json');
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
        case 'POST':
                $data=json_decode(file_get_contents('php://input'), true);
                if($data["key"] == "6B35E89B9C6"){
                    postRequestCapture();
                } else {
                    echo '{"Error":"Somthing is worng?"}';
                }
            break;
        default:
                echo '{"Error":"Somthing is worng?"}';
            break;
    }

    function postRequestCapture(){

        $html = file_get_html('https://onefootball.com/en/home');
        $mHtml = $html->find('.xpa-layout-home__section');

        $news_array = array();
        $preview = "";
        $images = "";

        foreach($mHtml as $article) {

            foreach ($article->find('.teaser__link') as $value) {

                $link = $value->href;

                foreach($value->find('.teaser__img-wrapper .of-image picture img') as $element) {
                     $images = $element->getAttribute('src');
                }

                $title = $value->find('.teaser__title', 0)->innertext;
                if ($value->find('.teaser__preview', 0)) {
                    $preview = $value->find('.teaser__preview', 0)->innertext;
                } else {
                    $preview = "";
                }
                $time = $value->find('.publisher__time', 0)->innertext;

                $news_array[] = array('link' => "https://onefootball.com".$link, 'title' => $title, 'preview' => $preview, 'image' => $images, 'time' => $time);

            }

        }

        $object = array('news'=>$news_array);
        echo json_encode($object, true);

    }

?>