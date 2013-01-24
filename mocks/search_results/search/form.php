<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Search</title>
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
	</head>
	<body> 
		<form id="search_form" name="search" action="<?php echo$_SESSION['home']?>/process.php" method="POST">
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
	</body>
</html>
