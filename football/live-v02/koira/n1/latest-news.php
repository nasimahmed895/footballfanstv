<?php
    
    include_once 'rex_tools.php';

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

        $html =  file_get_html('https://www.goal.com/kr/%EB%89%B4%EC%8A%A4/1');
        $test_array = array();
        $mHtml = $html->find('.newsarchive-card-group');
        $link = "";
        $title = "";
        $category = "";
        $date = "";
        $image = "";

        foreach($mHtml as $article) {

          foreach ($article->find('.widget-news-card') as $value) {

              foreach($value->find('.widget-news-card__image a img') as $element) {
                $imgLink = $element->getAttribute('src');
                list($img1, $img2) = explode('?', $imgLink);
                $image = $img1;
              }

              foreach($value->find('.widget-news-card__content') as $element){
                $link = $element->find('.widget-news-card__title a', 0)->href;
                $title = $element->find('.widget-news-card__title a', 0)->innertext;
                $category = $element->find('.widget-news-card__category', 0)->innertext;
                $date = $element->find('.widget-news-card__date', 0)->innertext;
              }

              $test_array[] = array('link' => "https://www.goal.com".$link, 'image' => $image, 'title' => hpt($title), 'category' => hpt($category), 'date' => $date);
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