<?php
session_start();

if(!isset($_SESSION['homeaway'])){
	header("Location:../../index.php");
}

$images = array();
$titles = array();
$descriptions = array();
$price = array();
$reviews = array();
$links = array();
$sorted = array();
$no_of_entries = 0;
$m = array();
$ip = $_SERVER['REMOTE_ADDR'];

$everything = file_get_contents('../json/'.$ip.'_'.$_SESSION['time'].'.json');
$everything = rtrim(ltrim($everything,'{{'),'}}');
$array_all = explode('},{', $everything);
$individual = array();
foreach($array_all as &$val){
	$val = $everything = rtrim(ltrim($val,'"'),'"');
	$individual[] = explode('","', $val);
}

foreach($individual as &$hit){
	$images[] = substr($hit[0],strpos($hit[0],':')+2);
	$titles[] = substr($hit[1],strpos($hit[1],':')+2);
	$links[] = substr($hit[2],strpos($hit[2],':')+2);
	$descriptions[] = substr($hit[3],strpos($hit[3],':')+2);
	$price[] = substr($hit[4],strpos($hit[4],':')+2);
	$reviews[] = substr($hit[5],strpos($hit[5],':')+2);
	$sorted[] = $no_of_entries;
	$current_price = substr($hit[4],strpos($hit[4],':')+2);

	if(preg_match("|\d+|", str_replace(",","",$current_price), $j)){
		$m[] = intval($j[0]);
	}
	else
		$m[] = 0;
	if(preg_match("/[0-9]+/", substr($hit[5],strpos($hit[5],':')+2), $j)){
		$review_sort[] = intval($j[0]);
	}
	else
		$review_sort[] = 0;
	$no_of_entries++;
}

if(isset($_GET['sort'])){
	if($_GET['sort'] == 1){
		array_multisort($m, SORT_ASC, SORT_NUMERIC, $sorted);
	}
	if($_GET['sort'] == 2){
		array_multisort($m, SORT_DESC, SORT_NUMERIC, $sorted);
	}
	if($_GET['sort'] == 3){
		array_multisort($review_sort, SORT_DESC, SORT_NUMERIC, $sorted);
	}
}


echo
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	

<style>

/*
body{
	background-image:url("'.$_SESSION['home'].'/images/bg.jpg");
	background-repeat:repeat;
}

#search_form{
	background-color:white;
	width:890px;
}

#page{
	width:890px;
}

#main_table{
	width: 640px;
	border: 1px solid #000000;
}

#map_canvas {
	width: 250px;
	height: 400px;
	float:left;
}

#container {
  margin:auto;
  background: #ffffff;
  border: 1px solid #4C3C1B;
    padding: 5px;
 
    background-color: #EFEECB;
}

#header {
  background: #ffffff;
}

#leftBar {
  float: left; 
  width: 25%; 
  height : 150px;
  background: #EBEBEB; 
}

#content {
  float:left;
  width:50%;
  min-height : 142px;
  background-color: #FFFFFF;
     border-top-width: 4px;
    border-bottom-width: 4px;
    border-top-style: double;
    border-bottom-style: double;
    border-top-color: #E1A60A;
    border-bottom-color: #E1A60A;
    padding: 0px 0px;
}

#rightBar { 
  float:right; 
  width: 25%; 
  height :150px;
  background: #ffffff; 
}

#footer { 
  clear:both;
  background:#ffffff;
} 
#container #content p a {
	font-family: Tahoma, Geneva, sans-serif;
}
#container #content p a {
	font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;
}
*/


body{
//	background-image:url("'.$_SESSION['home'].'/images/bg.jpg");
//	background-repeat:repeat;
}

#search_form{
	background-color:white;
	width:940px;
}

#page{
	width:940px;
}

#main_table{
	width: 670px;
	border: 1px solid #000000;
}

#map_canvas {
	width: 270px;
	height: 400px;
	float:left;
}

#container {
  margin:auto;
  background: #ffffff;
  border: 1px solid #4C3C1B;
    padding: 7px;
    background-color: #EFEECB;
    height:130px;
}

#inner {
  height:130px;
  width:630px;
  background-color: #ffffff;
}

#header {
  background: #ffffff;
}

#leftBar img{
  float: left; 
  width: 100px;
  height : 100px;
  background: #FFFFFF;
}

#content {
  float:left;
  width:356px;
  margin-left:10px;
  height : 100px;
  background-color: #FFFFFF;
}

#rightBar { 
  float:right; 
  width: 150px; 
  height :100px;
  padding-left:10px;
  padding-bottom:5px;
  padding-top:10px;
  background: #ffffff; 
}

#footer { 
  float:left;
  height:15px;
  width:110px;
  background:#ffffff;
} 

#social{
  float:left;
}

#container #content p a {
	font-family: Tahoma, Geneva, sans-serif;
}
#container #content p a {
	font-family: Lucida Sans Unicode, Lucida Grande, sans-serif;
}


</style>
<script type="text/javascript">
var airbnb_maps = {'.$_SESSION['airbnb_maps'].'};
add_airbnb_markers = function() {
  $.each(airbnb_maps.properties, function(index, property) {
    add_location(property.lat, property.lng, property.name);
  });
};

var homeaway_maps = {'.$_SESSION['homeaway_maps'].'};

add_homeaway_markers = function() {
  $.each(homeaway_maps, function(index, property) {
    add_location(decodeURI(property.lat), decodeURI(property.lng), property.hdln);
  });
};


</script>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="../../google_maps/googlemaps.js" type="text/javascript"></script>

<!--
<script src="http://static.ak.fbcdn.net/connect.php/js/fb.Share" type="text/javascript"></script>
-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>





	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="ppanel.css">	
	<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

	<script>
    // increase the default animation speed to exaggerate the effect
    $.fx.speeds._default = 1000;

    $(function() {
        $( "#dialog" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
	    width: "600",
	    height: "400"
        });
 
        $( ".opener" ).click(function() {
            $( "#dialog" ).dialog( "open" );
               $("#frame").attr("src",$(this).attr("link"));
            return false;
        });
    });

	</script>


</head>

<body>
';

include "form.php";

echo '

<div id="page">	
<div id="map_canvas"></div>

<table id="main_table">
<tr><td><div"><a href="?sort=3" style="float:left;">View Most Reviewed</a></div><div style="float:right"> Sort by price: &nbsp; &nbsp;<a href="?sort=1">Ascending</a> &nbsp; &nbsp; <a href="?sort=2">Descending</a></div></td></tr>
';

$count = 0;
foreach($links as &$link){
echo  '<tr><td><div id="container">
<div id="inner">
<div id="leftBar">
    <img src="'.$images[$sorted[$count]].'" alt="" name="img" width="150" height="150" id="img" />
  </div>
  <div id="content">
    <a href="'.$links[$sorted[$count]].'" target="_blank">'.$titles[$sorted[$count]].'</a>
    <p>'.$descriptions[$sorted[$count]].'</p>
  </div>
  <div id="rightBar">
    '.str_replace("\n", " ", $price[$sorted[$count]]).'</div>
  <div id="footer" >'.$reviews[$sorted[$count]].'</div>
<div id="social">
<button class="opener" link="'.$links[$sorted[$count]].'">Quick View</button>

<!--
<a name="fb_share" type="button_count" share_url='.$links[$sorted[$count]].' target="_blank">Facebook Share</a>
-->

	<a href="mailto:?Subject=Check%20out%20this%20place&Body='.$links[$sorted[$count]].'" target="_blank">
		<img src="https://sphotos-b.xx.fbcdn.net/hphotos-prn1/604005_4632378604110_1966836505_n.jpg" height="20"/></a>
	
	<a href="http://www.facebook.com/sharer.php?u=location.href='.$links[$sorted[$count]].'" target="_blank">
		<img src="https://sphotos-a.xx.fbcdn.net/hphotos-prn1/32420_4632387724338_1600349022_n.jpg" height="20"/></a>


	<a href="https://twitter.com/share" class="twitter-share-button" data-url='.$links[$sorted[$count]].' data-lang="en">Tweet</a>
</div>

</div>

</div>
</div>
</td>
</tr>
';

$count++;
}

echo '</table>

<div id="dialog" title="Quick View - Preview Panel">
     <iframe id="frame" src="">
     </iframe>
</div> <!-- div for dialog box -->



</div>	
</body>
</html>
';

?>
