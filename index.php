<?php
 session_start();
 include("database.php");
 $connection = connect();

?>
<!DOCTYPE HTML>
<html>
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
    <body>
        <header>
            <div  class="crop-height">
                <img class="scale" src="assets/banner.jpg" />
            </div>

        </header>

        <nav>
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php?izbor=0">Home</a></li>
                <li class="nav-item"><a href="index.php?izbor=1">News</a></li>
                <li class="nav-item"><a href="index.php?izbor=2">Contact</a></li>
                <li class="nav-item"><a href="index.php?izbor=3">About</a></li>
                <li class="nav-item"><a href="index.php?izbor=4">Gallery</a></li>

                <?php
//                 if (isset($_SESSION["login"]) and $_SESSION["login"] == 1)
//                 {
//                     echo("<a href=\"index.php?izbor=7\">Odjava </a>");
//                 }
//                 else
                    echo("<li class='nav-item'><a href=\"index.php?izbor=5\">Login </a></li><li class='nav-item'><a href=\"index.php?izbor=6\">Register </a></li>");
                ?>
            </ul>
        </nav>
        <?php
        		if (isset($_GET['izbor']))
        			$switcheroo = $_GET['izbor'];
        		else
        			$switcheroo = 0;

        			switch($switcheroo)
        			{
        				case 1:
        					include("news.php");
        					break;
        				case 2:
        					include("contact.php");
        					break;
        				case 3:
        					include("about.php");
        					break;
        				case 4:
        					include("gallery.php");
        					break;
        				case 5:
        					include("login.php");
        					break;
        				case 6:
        					include("reg.php");
        					break;
        				case 7:
        					{
                                session_unset();
                                session_destroy();
                                header("Refresh:0, url=index.php?izbor=0");
        					}
        					break;
        				default:
        					include("main.php");
        					break;
        			}
        		?>
        <footer class="footer">
            <a class="footer-github-link" href="https://github.com/b1naryDS/ntpws-davor">
                <img src="assets/github.png" title="Github" alt="Github"/>
                </a>
              Copyright &copy; 2021. Davor Šehić


          </footer>
    </body>
</html>