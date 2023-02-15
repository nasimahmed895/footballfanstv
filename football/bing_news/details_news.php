<?php

	include('rex-tools.php');

    $request = $_SERVER['REQUEST_METHOD'];
    switch ($request) {
        case 'GET':
                if (urldecode($_GET["url"]) != "") {
                    $urls = urldecode($_GET["url"]);
                    postRequestCapture($urls);
                } else {
                    echo '{"Error":"Somthing is worng?"}';
                }
            break;
        default:
                echo '{"Error":"Somthing is worng?"}';
            break;
    }


    function postRequestCapture($urls){

        $html = file_get_html($urls);
        $dtlsNews = $html->find('.bingsport .main .news-container .detail-news-container .left-container-news .content-container');

        foreach($dtlsNews as $dtlsNewsValue) {

            $response = '<head><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>' . $dtlsNewsValue;
            $response2 = str_replace("<p>", "<p style='text-align: justify; color:#12002C; font-size: 18px;'>", $response);
            $response3 = str_replace("<img", '<img width="100%" height="45%"', $response2);
            $response4 = str_replace("<a", '<!--   <a', $response3);
            $response5 = str_replace("</a>", "</a> -->", $response4);
            echo str_replace("<h2>", "<h4 style='text-align: center;'>", $response5);

        }

    }
    

?>
