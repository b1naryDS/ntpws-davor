<!DOCTYPE html>
<html lang="en">
	<head>
		<title>zadaca1</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="author" content="Davor Šehić">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	</head>
<body>
    <form action="" method="POST">
    <label for="kolokvij1">ocjena 1. kolokvija</label>
    <input type="number" id ="kol1" min="1" max="5" name="grade1" >
    <label for="kolokvij2">ocjena 2. kolokvija</label>
    <input type="number" id="kol2"  min="1" max="5" name="grade2">
    <input type="submit">
</form> 


<?php
  $grade1 = $_GET["grade1"];
  $grade2 = $_GET["grade2"];
  $finalgrade = 1;
  $avrggrade = 1;

  if ($grade1 > 1 and $grade2 > 1)
  {
     $finalgrade = round(($grade1 + $grade2) / 2);
  }
  echo "konačnu ocjenu iz predmeta je " . $finalgrade;
  echo "prosjek ocjenu iz predmeta je " . ($grade1 + $grade2) / 2;
?> 
</body>
</html>