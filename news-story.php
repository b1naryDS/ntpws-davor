<?php
$query  = "SELECT * FROM news WHERE id=". htmlspecialchars($_GET["news-story"])."";
$result = @mysqli_query($db, $query);
$row = @mysqli_fetch_array($result);
$db = new mysqli("localhost","root","","ntpws");
$query = "SELECT * FROM pictures WHERE newsId='".$_GET['news-story']."'";
$resultImages = @mysqli_query($db, $query);

print '
    <head>
    		<title>NTPWS</title>
    		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    		<meta name="description" content="">
    		<meta name="keywords" content="">
    		<meta name="author" content="Davor Šehić">
    		<meta name="viewport" content="width=device-width, initial-scale=1">
    		<link rel="shortcut icon" type="image/x-icon" href="assets/favicon.ico">
            <link rel="stylesheet" href="styles/style.css" />
    	</head>
    <main>
    <section class="newss">';


    $db = new mysqli("localhost","root","","ntpws");
    $query = "SELECT * FROM pictures WHERE newsId='".$_GET['news-story']."'";
    $resultImages = @mysqli_query($db, $query);
    while ($img = @mysqli_fetch_array($resultImages)) {
        print '
            <figure class="singlenews">
            <img style="max-width: 200px" src="assets/'.$img['img'].'" title="'.$img['description'].'" />
            <figcaption>'.$img['description'].'</figcaption>
            </figure>
            </section>
            <a href="index.php?izbor=1">news</a>
            <br/><br/>
            </main>
';
    }
?>