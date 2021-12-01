<?php
session_start();
include("database.php");
$connection = connect();
if(isset($_GET['izbor'])) { $izbor   = (int)$_GET['izbor']; }
if(!isset($izbor)) {$izbor = 1;}
if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
if(!isset($_POST['action']))  { $_POST['action'] = FALSE;  }


if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

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
                <li class="nav-item"><a href="index.php?izbor=9">API-task5</a></li>

                <?php
                    if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
                                print '
                                <li class="nav-item"><a href="index.php?izbor=5">Login</a></li>
                                <li class="nav-item"><a href="index.php?izbor=6">Register</a></li>
                                ';
                              }
                              else if ($_SESSION['user']['valid'] == 'true' && $_SESSION['user']['role'] === 'administrator') {
                                print '
                                <li class="nav-item"><a href="index.php?izbor=7">Admin</a></li>
                                <li class="nav-item"><a href="signout.php">Sign Out</a></li>';
                              } else if ($_SESSION['user']['role'] !== 'administrator') {
                                print '<li class="nav-item"><a href="signout.php">Sign Out</a></li>'
                               ;

                              }
//                  ?>
            </ul>
        </nav>
        <?php
                if (isset($_GET['news-story'])) {
                    include("news-story.php");
               }
        		if (isset($_GET['izbor']))
        			$izbor = $_GET['izbor'];
        		else
        			$izbor = 0;

        			switch($izbor)
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
        					include("admin.php");
        					break;
        				case 8:
        					{
                                session_unset();
                                session_destroy();
                                header("Refresh:0, url=index.php?izbor=0");
        					}
        					break;
        				case 9:
        					include("zadatak5.php");
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