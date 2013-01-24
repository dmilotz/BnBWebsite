<?php session_start();
$pattern = '|'.$_SERVER['DOCUMENT_ROOT'].'|';
$_SESSION['home'] = preg_replace($pattern, '', getcwd());
include 'search_results/simplehtmldom/simple_html_dom.php';
?>
<!doctype html>
<html lang="en">
      <head>

		<meta charset="utf-8" />
		<title>Bed and Breakfast - Sleeping Noms</title>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css" />
		<script>
		$(function() {
			$( "#check_in" ).datepicker({minDate: 0});
			$( "#check_out" ).datepicker({minDate: 0});
		});
		</script>

	<style type="text/css" media="screen">
	       body{
	       }
	       #container{
			width:800px;
			margin:auto;
	       }
	       #container h1{
			text-align:center;
			margin-top:70px;
			height:100px;
	       }

	       #container img{
	       		margin-top:-70px;
	       		float:left;
	       }
	       #slides{
			margin:auto;
			margin-top:100px;
			width:400px;
			
	       }
	       #slides .slides_container {
			text-align:center;
			width:400px;
			height:325px;
			display:none;
		}
		#slides .slides_container div {
			width:400px;
			height:325px;
			display:block;
		}
		.pagination{
			display:none;
		}
		.prev, .next{
			font-size:20px;
			color:grey;
			text-decoration:none;
			margin-left:75px;
			margin-right:110px;
		}
	</style>
	<!--
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	-->
	<script src="js/slides.min.jquery.js"></script>
	
	<script>
		$(function(){
			$('#slides').slides({
				generateNextPrev: true,
				play: 4500
			});
		});
	</script>

	</head>
	<body> 
	<div id="container">
	<img src="images/bed.jpg" style="height:150px;"/>
	<h1>Bed&Breakfast by Sleeping Noms 2012</h1>
		<form id="search_form" name="search" action="process.php" method="POST">
			<?php if(isset($_SESSION['error'])) echo $_SESSION['error'];?>
			<input type="text" name="location" id="location" length="32" />
			<input type="text" name="check_in" id="check_in" />
			<input type="text" name="check_out" id="check_out"  />
			<select name="guests" id="guests">
				 <option>1 Guest</option>
				 <option>2 Guest</option>
  				 <option>3 Guest</option>
  				 <option>4 Guest</option>
  				 <option>5 Guest</option>
  				 <option>6 Guest</option>
				 <option>7 Guest</option>
				 <option>8 Guest</option>
  				 <option>9 Guest</option>
  				 <option>10 Guest</option>
  				 <option>11 Guest</option>
  				 <option>12 Guest</option>
  				 <option>13 or more Guest</option>
			</select>
			<input type="submit" name="submit_form" id="submit_form" value="Search" />
			<br>
			Location &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			Check-in date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			Check-out date
		</form>

	<div id="slides">
	     <h2>Check out one of the following great places</h2>
		<div class="slides_container">

<?php 
$top_picks = file_get_html("http://www.homeaway.com");

for($i = 2; $i <= 20; $i++)
       foreach($top_picks->find('div[id=slide-'.$i.']') as $result){
	 $image = $result->ref;
	 $link = array();
       	 foreach($result->find('a') as $result1){
	 	$link[] = $result1->href;
	 	$link[] = $result1->innertext;
	 }
	 echo '<div><p>'.preg_replace("|View all in |", "" , $link[3]).'</p><a href="http://www.homeaway.com'.$link[0].'"><div style="background:url('.$image.') no-repeat scroll center center transparent;">';
	 echo '</div></a></div>';
       }

?>
		</div>
	</div>
	</div>
	</body>
</html>
