<?php

session_start();

$error = 0;
$error_list = "";



if(strlen(trim($_POST['location'])) == 0){
	$error_list = $error_list."Please enter a location<br>";
	$error = 1;
}



if(strlen(trim($_POST['check_in'])) != 0 && strlen(trim($_POST['check_out'])) != 0){
	$date = explode("/", $_POST['check_in']);
	if(!checkdate(intval($date[0]), intval($date[1]), intval($date[2]))){
		$error_list = $error_list."Please enter a valid date. Ensure it is in the format MM/DD/YYYY<br>";
		$error = 1;		
	}
	else{
		if(strtotime('today') > strtotime($_POST['check_in'])){
			$error_list = $error_list."Check in date cannot be before today<br>";
			$error = 1;	
		}
	}

	$date = explode("/", $_POST['check_out']);
	if(!checkdate(intval($date[0]), intval($date[1]), intval($date[2]))){
		$error_list = $error_list."Please enter a valid date. Ensure it is in the format MM/DD/YYYY<br>";
		$error = 1;
	}
	else{
		if(strtotime('today') > strtotime($_POST['check_out'])){
			$error_list = $error_list."Check out date cannot be before today<br>";
			$error = 1;
		}
		else{
			if(strtotime($_POST['check_in']) > strtotime($_POST['check_out'])){
				$error_list = $error_list."Check out date cannot be before the check in date<br>";
				$error = 1;
			}
		}
	}
}
else{
	if(!(strlen(trim($_POST['check_in'])) == 0 && strlen(trim($_POST['check_out'])) == 0)){
		$error_list = $error_list."Either enter both the Check-in and Check-out date, or don't put either<br>";
		$error = 1;	
	}
	else{
		$dates = array();
		$dates['homeaway'] = "arrival:".str_replace("/", "-", $_POST['check_in'])."/departure:".str_replace("/", "-", $_POST['check_out']);
		$dates['airbnb'] = "&checkin=".$_POST['check_in']."&checkout=".$_POST['check_out'];
	}
}



if($error == 1){
	  $_SESSION['error'] = $error_list;
          header("Location:index.php");
}
else{
	$guests = explode(" ",$_POST['guests']);
	$_SESSION['homeaway'] = "http://www.homeaway.com/search/refined/keywords:".urlencode($_POST['location'])."/Sleeps:".$guests[0]."/".$dates['homeaway'];
	$_SESSION['homeaway_maps_url'] = "http://www.homeaway.com/ajax/map/search/refined/keywords:".urlencode($_POST['location'])."/Sleeps:".$guests[0]."/".$dates['homeaway'];
	$_SESSION['airbnb'] = "https://www.airbnb.com/s?location=".urlencode($_POST['location']).$dates['airbnb']."&guests=".$guests[0];

	  header("Location:search_results/index.php");
}

?>
