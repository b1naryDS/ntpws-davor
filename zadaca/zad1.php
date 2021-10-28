<!DOCTYPE HTML>
<html>
	<head>
		<title>zadaca1</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="author" content="Davor Šehić">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	</head>

    <body>       
        <?php
            $vozila = array("Mercedes", "BMW", "Audi", "Citroen", "Renault", "Volkswagen", "KIA", "Hyundai", "MINI");

            foreach ($vozila as $vozilo) {
                print "<li>" . $vozilo . "</li>";
            }
            print "</ol>";
        ?>
    </body>    

</html>   