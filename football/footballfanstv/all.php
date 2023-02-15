<?php

include_once 'scraping.php';
$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

$html = file_get_html('https://onefootball.com/fr/home', false, $context);

$html1 = $html->find('body');

$club = file_get_html('https://www.parisfans.fr/club/', false, $context);
$i = file_get_html('https://www.parisfans.fr/l-1', false, $context);

$olympique = file_get_html('https://www.olympique-et-lyonnais.com/rubrique/une/', false, $context);

$parisfans = $club->find('body');
$parisfans1 = $i->find('body');


$olympique1 = $olympique->find('body');

// $asm = file_get_html('https://asm-supporters.fr/actualites/', false, $context);

// $supporters = $asm->find('.su-posts');
$coeur = file_get_html('https://www.coeurmarseillais.fr/ligue1/', false, $context);
$football365 = file_get_html('https://www.football365.fr/', false, $context);

$football = $football365->find('#content');


$coeurmarseillais = $coeur->find('body');

$top = array();
$bottom = array();
$supportersArray = array();
$coeurmarseillaisArray = array();
$allnewsArray = array();

$bas_url = 'https://onefootball.com/';

$data1array = array();
$psg = array();
$ligue = array();

$top = array();
$bottom = array();


foreach ($html1 as $value) {
    foreach ($value->find('.teaser__link') as $table) {
        $links = $table->href ?? '';
        $link = $bas_url . $links;
        $image = $table->find('.of-image__picture source', 0)->srcset ?? '';
        $title = $table->find('.teaser__content h3', 0)->innertext ?? '';
        $paragraph  = $table->find('.teaser__content p', 0)->innertext ?? '';
        $time  = $table->find('.teaser__content .publisher__time', 0)->innertext ?? '';
        $data1array[] = array('link' => $link, 'image' => $image, 'title' => $title, 'paragraph' => $paragraph, 'time' => $time, 'source' => 'onefootball');
    }
}

foreach ($parisfans as $value) {
    foreach ($value->find('.mvp-blog-story-wrap ') as $table) {
        $link = $table->find('a', 0)->href ?? '';
        $image = $table->find('.mvp-blog-story-img img', 0)->getAttribute('data-lazy-srcset') ?? '';
        $title = $table->find('.mvp-blog-story-text h2 a', 0)->innertext ?? '';
        $paragraph  = $table->find('.mvp-blog-story-text p', 0)->innertext ?? '';
        $time  = $table->find('.mvp-post-info-date', 0)->innertext ?? '';
        $psg[] = array('link' => $link, 'image' => $image, 'title' => $title, 'paragraph' => $paragraph, 'time' => $time, 'source' => 'parisfans');
    }
}
foreach ($parisfans1 as $value) {

    foreach ($value->find('.mvp-blog-story-wrap ') as $table) {
        $link = $table->find('a', 0)->href ?? '';
        $image = $table->find('.mvp-blog-story-img img', 0)->getAttribute('data-lazy-srcset') ?? '';
        $title = $table->find('.mvp-blog-story-text h2 a', 0)->innertext ?? '';
        $paragraph  = $table->find('.mvp-blog-story-text p', 0)->innertext ?? '';
        $time  = $table->find('.mvp-post-info-date', 0)->innertext ?? '';
        $ligue[] = array('link' => $link, 'image' => $image, 'title' => $title, 'paragraph' => $paragraph, 'time' => $time, 'source' => 'parisfans');
    }
}

foreach ($olympique1 as $value) {
    foreach ($value->find('.titrecontent') as $table) {
        $link = $table->find('a', 0)->href ?? '';
        $image = $table->find('img', 0)->getAttribute('data-src-img') ?? '';
        $title = $table->find('a', 0)->getAttribute('title') ?? '';
        $top[] = array('link' => $link, 'image' => $image, 'title' => $title, 'source' => 'olympique');
    }
    foreach ($value->find('.content-colonne') as $table2) {
        $link = $table2->find('a', 0)->href ?? '';
        $image = $table2->find('img', 0)->getAttribute('data-src-img') ?? '';
        $title = $table2->find('a', 0)->getAttribute('title') ?? '';
        $bottom[] = array('link' => $link, 'image' => $image, 'title' => $title, 'source' => 'olympique');
    }
}
// foreach ($supporters as $value) {
//     foreach ($value->find('.su-post') as $table) {
//         $link = $table->find('a', 0)->href ?? '';
//         $image = $table->find('img', 0)->src ?? '';
//         $title = $table->find('.su-post-title a', 0)->innertext ?? '';
//         $paragraph  = $table->find('.su-post-excerpt p', 0)->innertext ?? '';
//         $times  = $table->find('.su-post-meta', 0)->plaintext ?? '';
//         $time = trim(hpt($times));
//         $supportersArray[] = array('link' => $link, 'image' => $image, 'title' => $title, 'paragraph' => $paragraph, 'time' => str_replace('Publié: ', '', $time), 'source' => 'asm-supporters');
//     }
// }
foreach ($coeurmarseillais as $value) {
    foreach ($value->find('.mvp-blog-story-wrap ') as $table) {
        $link = $table->find('a', 0)->href ?? '';
        $image = $table->find(
            '.mvp-blog-story-img img',
            0
        )->getAttribute('data-lazy-src') ?? '';
        $title = $table->find('.mvp-blog-story-text h2 a', 0)->innertext ?? '';
        $paragraph  = $table->find('.mvp-blog-story-text p', 0)->innertext ?? '';
        $time  = $table->find('.mvp-post-info-date', 0)->innertext ?? '';
        $coeurmarseillaisArray[] = array('link' => $link, 'image' => $image, 'title' => $title, 'paragraph' => $paragraph, 'time' => $time, 'source' => 'coeurmarseillais');
        $allnewsArray[] = array($data1array, $bottom,);
    }
    foreach ($html1 as $value) {
        foreach ($value->find('.post-item-col') as $table) {
            if ($table->find('.post-item-title a', 0) != '') {
                $title = $table->find('.post-item-title a', 0)->plaintext ?? '';
            }
            $link = $table->find('.post-item-title a', 0)->href ?? '';
            $image = $table->find('.post-item-img img', 0)->getAttribute('data-src') ?? '';

            // echo $link . '<br>';
            // echo $title . '<br>';
            // echo "<img src='$image' alt='' srcset=''>" . '<br>';
            $data1array[] = array('link' => $link, 'title' => $title, 'image' => $image, 'source' => 'football365');
            // echo $table . '<br>';
        }

        // echo $value;

        // $data1array[] = array('round' => $round, );
    }
}
foreach ($football as $value) {
    foreach ($value->find('.post-item-col') as $table) {
        if ($table->find('.post-item-title a', 0) != '') {
            $title = $table->find('.post-item-title a', 0)->plaintext ?? '';
        }
        $link = $table->find('.post-item-title a', 0)->href ?? '';
        $image = $table->find('.post-item-img img', 0)->getAttribute('data-src') ?? '';
        $footballarray[] = array('link' => $link, 'title' => $title, 'image' => $image, 'source' => 'football365');
    }
}
$allnewsArray[] = array($data1array, $psg, $top, $bottom, $coeurmarseillaisArray, $footballarray);
$response = array('news' => $allnewsArray);
echo json_encode($response);

function hpt($str)
{
    $str = str_replace('\t\t\t\t\tPublié: ', ' ', $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT, 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);
    return $str;
}