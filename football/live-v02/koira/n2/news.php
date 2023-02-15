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

        $pageNo = $data["page-no"];
        $pageUrl = "http://kspnet.co.kr/news/list.php?cIdx=65&searchText=&s_f=&s_v=&page=".$pageNo;
        $html =  file_get_html($pageUrl);

        $test_array = array();
        $mHtml = $html->find('.dual-posts .row-25 .layout_3--item');
        $image = "";

        foreach($mHtml as $article) {
          foreach ($article->find('a') as $value) {

            $link = $value->href;
            foreach($value->find('.list-fl-l .thumb img') as $element) {
              $image = $element->getAttribute('src');
            }
            $title = $article->find('.list-fl-r h4', 0)->innertext;
            $desc = $article->find('.list-fl-r p', 0)->innertext;
            $date_time = $article->find('.list-fl-r .meta .date', 0)->innertext;

            $test_array[] = array('link' => "http://kspnet.co.kr".$link, 'image' => $image, 'title' => hpt($title), 'desc' => hpt($desc), 'date_time' => hpt($date_time));
          }
        }

        $object = array('news'=>$test_array);
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