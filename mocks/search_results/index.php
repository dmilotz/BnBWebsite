<?php

session_start();

if(!isset($_SESSION['homeaway'])){
	header("Location:../index.php");
}

$ip=$_SERVER['REMOTE_ADDR'];
$_SESSION['time'] = md5($ip.strval(rand()));

include 'simplehtmldom/simple_html_dom.php';
$home_url = $_SESSION['homeaway'];
$air_url = $_SESSION['airbnb'];

$home_away = file_get_html($home_url);
$home_away_maps = file_get_html($_SESSION['homeaway_maps_url']);

$airbnb = file_get_html($air_url);

$images = array();
$titles = array();
$descriptions = array();
$price = array();
$reviews = array();
$links = array();

$images1 = array();
$titles1 = array();
$descriptions1 = array();
$price1 = array();
$reviews1 = array();
$links1 = array();

$images2 = array();
$titles2 = array();
$descriptions2 = array();
$price2 = array();
$reviews2 = array();
$links2 = array();
       

foreach($home_away->find('div[class=listing-main]') as $result){
       foreach($result->find('div[class=listing-img]') as $image){
		$images2[] = $image->ref;
	}
       foreach($result->find('h3[class=listing-title]') as $heading){
       		foreach($heading->find('a') as $title){
			$titles2[] = $title->innertext;
		}
	}
       foreach($result->find('div[class=listing-description]') as $desc){
	  	$formatted = preg_replace("|<li class='summary-list-item-li'><div class='summary-list-item'>|", "", $desc);
		$descriptions2[] = preg_replace("|</div></li>|", "", $formatted);
	}
	foreach($result->find('div[class=hit-rates]') as $cost){
		$price2[] = $cost->innertext;
	}
       foreach($result->find('div[class=body-footer]') as $rev_cont){
       		if(strpos($rev_cont->plaintext,'#') == 5)
			$reviews2[] = ' ';
		else
       		foreach($rev_cont->find('div[class=review-text review-lnk]') as $review){
			$reviews2[] = $review->firstChild()->plaintext;
		}
	}
       foreach($result->find('span[class=listing-propertyid]') as $link){
       		$links2[] = "http://www.homeaway.com/p" . substr($link->innertext,1);
	}
}

foreach($airbnb->find('ul[id=results]') as $result){
       foreach($result->find('img[class=search_thumbnail]') as $image){
       		$sub = substr($image->outertext, strpos($image->outertext, 'data-original="'));
		$sub = trim($sub, 'data-original="');
		$sub = substr($sub, 0, strpos($sub, '"')); 
		$images1[] = $sub;
	}
	foreach($result->find('li[class=search_result]') as $list)
	       foreach($list->find('h3') as $heading){
       	       		foreach($heading->find('a') as $title){
				$titles1[] = $title->innertext;
				$links1[] = 'https://www.airbnb.com'.$title->href;
			}
		}
       foreach($result->find('div[class=descriptor descriptor-gray overflow-ellipsis]') as $desc){
	  	$descriptions1[] = $desc;
	}
	foreach($result->find('div[class=price]') as $cost){
		$price1[] = $cost->innertext;
	}
       foreach($result->find('ul[class=reputation unstyled]') as $rev_cont){
       		$reviews1[] = $rev_cont->firstChild()->plaintext;
       }
}

if(sizeof($links2) > sizeof($links1)){
	for($i = 0; $i < sizeof($links2); $i++){
	       $links[] = $links2[$i];
	       $images[] = $images2[$i];
	       $titles[] = $titles2[$i];
	       $descriptions[] = $descriptions2[$i];
	       $price[] = $price2[$i];
	       $reviews[] =$reviews2[$i];
	       if($i < sizeof($links1)){
	       	     $links[] = $links1[$i];
		     $images[] = $images1[$i];
		     $titles[] = $titles1[$i];
		     $descriptions[] = $descriptions1[$i];
	     	     $price[] = $price1[$i];
       		     $reviews[] =$reviews1[$i];
	       }
	}
}
else{
	for($i = 0; $i < sizeof($links1); $i++){
	       $links[] = $links1[$i];
	       $images[] = $images1[$i];
	       $titles[] = $titles1[$i];
	       $descriptions[] = $descriptions1[$i];
	       $price[] = $price1[$i];
       	       $reviews[] =$reviews1[$i];
	       if($i < sizeof($links2)){
	       	     $links[] = $links2[$i];
	      	     $images[] = $images2[$i];
	      	     $titles[] = $titles2[$i];
	      	     $descriptions[] = $descriptions2[$i];
	      	     $price[] = $price2[$i];
	      	     $reviews[] =$reviews2[$i];
	       }
	}
}


$count = 0;
$file = fopen('json/'.$ip.'_'.$_SESSION['time'].'.json', 'w');
fwrite($file, '{');
foreach($links as &$link){
	if($count == 0)
 		 $comma = '';
	else $comma = ',';
	$entry = $comma.'{"image":"'.$images[$count].'","title":"'.$titles[$count].'","link":"'.$links[$count].'","description":"'.$descriptions[$count].'","price":"'.str_replace("\n", " ", $price[$count]).'","review":"'.$reviews[$count].'"}';
	$count++;
	fwrite($file, $entry);
}
fwrite($file, '}');
fclose($file);


preg_match('/AirbnbSearch.resultsJson = {(.*?)};/ms', $airbnb, $matches);
$_SESSION["airbnb_maps"] = $matches[1];

preg_match('/mapData.hits = {(.*?)};/ms', $home_away_maps, $matches); 
$_SESSION["homeaway_maps"] = $matches[1];

header("Location:search/index.php");

?>
