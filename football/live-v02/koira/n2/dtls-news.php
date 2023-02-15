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

        $mUrl = $data["url"];
        $html = file_get_html($mUrl);
        $json_array = array();
        $short_array = array();
        $image = "";

        $mHtml = $html->find('.col-md-8 .post-wrapper');

        foreach($mHtml as $article) {

            $title = $article->find('.post-title h2', 0)->innertext;
            $date = $article->find('.post-title .post-user .date', 0)->innertext;
            $short_array = array('title' => hpt($title), 'date' => hpt($date));

            foreach($article->find('.news-article-Body p') as $p){
                $mamun = $p->innertext . '<br>';
                if (hpt($mamun) != "") {
                    $json_array[] = array('desc' => hpt($mamun));
                }
            }

        }

        $object = array('header'=>$short_array, 'body'=>$json_array);
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