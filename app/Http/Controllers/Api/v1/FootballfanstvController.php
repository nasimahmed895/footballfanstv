<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FootballfanstvController extends Controller
{

    public function news()
    {

        require_once(public_path('php/scraping.php'));

        $context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                )
            )
        );

        $onefootball_hom = file_get_html('https://onefootball.com/fr/home', false, $context);


        $onefootball = $onefootball_hom->find('body');
        $bas_url = 'https://onefootball.com/';

        $onefootballArray = array();
        $footmercatoArray = array();

        $footmercato_net = file_get_html('https://www.footmercato.net/', false, $context);
        $basurl = 'https://www.footmercato.net';
        $footmercato = $footmercato_net->find('.main ');

        foreach ($onefootball as $value) {
            foreach ($value->find('.Gallery_galleryItems__2B1_m li') as $table) {
                $links = $table->find('a', 0)->href ?? 'ok';
                $link = $bas_url . $links;
                $image = $table->find('.ImageWithSets_of-image__W9T4F img', 0)->src ?? '';
                $title = $table->find('.NewsTeaserV2_teaser__title__ZWaW0', 0)->innertext ?? '';
                $time  = $table->find('.NewsTeaserV2_publisherTime__HuVrl', 0)->innertext ?? '';
                $onefootballArray[] = array('link' => $link, 'image' => $this->newsImghpt($image), 'title' => trim($this->hpt($title)), 'time' => str_replace(" il y a ", "", $time), 'source' => 'onefootball');
            }
        }


        foreach ($footmercato as $value) {
            foreach ($value->find('.articleInline__container') as $table) {
                if ($table->find('.articleInline__imageLink', 0) != '' || $table->find('.articleInline__imageLink', 0)->href ?? '' != '') {
                    $title = $table->find('.articleTitleMetas__title', 0)->plaintext ?? '';
                    $links = $table->find('.articleInline__imageLink', 0)->href ?? '';

                    if ($links != 'https://www.footmercato.net') {
                        $link = $table->find('.articleInline__imageLink', 0)->href ?? '';
                    } else {
                        $link = $basurl . $links;
                    }

                    $image = $table->find('.articleInline__imageLink img', 0)->getAttribute('data-src') ?? '';
                }
                $date = $table->find('.articleTitleMetas__date', 0)->innertext ?? '';
                $footmercatoArray[] = array('link' => $link, 'title' => trim($this->hpt($title)), 'image' => $image, 'time' => str_replace(" ", "", $date), 'source' => 'footmercato');
            }
        }
        $array = array_merge($onefootballArray, $footmercatoArray);

        $response = array('news' => $array);

        return json_encode($response);
    }

    function hpt($str)
    {
        $str = str_replace('\t\t\t', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT, 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
        return $str;
    }

    function newsImghpt($str)
    {
        $str = str_replace('&amp;', '&', $str);
        return $str;
    }
}