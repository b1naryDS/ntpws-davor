<?php
function connect()
{
	$dbAddress = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "ntpws";
	$dbPort = "3306";

	return mysqli_connect($dbAddress, $dbUsername, $dbPassword, $dbName, $dbPort);
}

function popuni()
{
	$popunilo = array("AF", "AX", "AL", "DZ", "AS", "AD", "AO", "AI", "AQ", "AG", "AR", "AM", "AW", "AU", "AT", "AZ", "BH", "BS", "BD", "BB", "BY", "BE", "BZ", "BJ", "BM", "BT", "BO", "BQ", "BA", "BW", "BV", "BR", "IO", "BN", "BG", "BF", "BI", "KH", "CM", "CA", "CV", "KY", "CF", "TD", "CL", "CN", "CX", "CC", "CO", "KM", "CG", "CD", "CK", "CR", "CI", "HR", "CU", "CW", "CY", "CZ", "DK", "DJ", "DM", "DO", "EC", "EG", "SV", "GQ", "ER", "EE", "ET", "FK", "FO", "FJ", "FI", "FR", "GF", "PF", "TF", "GA", "GM", "GE", "DE", "GH", "GI", "GR", "GL", "GD", "GP", "GU", "GT", "GG", "GN", "GW", "GY", "HT", "HM", "VA", "HN", "HK", "HU", "IS", "IN", "ID", "IR", "IQ", "IE", "IM", "IL", "IT", "JM", "JP", "JE", "JO", "KZ", "KE", "KI", "KP", "KR", "KW", "KG", "LA", "LV", "LB", "LS", "LR", "LY", "LI", "LT", "LU", "MO", "MK", "MG", "MW", "MY", "MV", "ML", "MT", "MH", "MQ", "MR", "MU", "YT", "MX", "FM", "MD", "MC", "MN", "ME", "MS", "MA", "MZ", "MM", "NA", "NR", "NP", "NL", "NC", "NZ", "NI", "NE", "NG", "NU", "NF", "MP", "NO", "OM", "PK", "PW", "PS", "PA", "PG", "PY", "PE", "PH", "PN", "PL", "PT", "PR", "QA", "RE", "RO", "RU", "RW", "BL", "SH", "KN", "LC", "MF", "PM", "VC", "WS", "SM", "ST", "SA", "SN", "RS", "SC", "SL", "SG", "SX", "SK", "SI", "SB", "SO", "ZA", "GS", "SS", "ES", "LK", "SD", "SR", "SJ", "SZ", "SE", "CH", "SY", "TW", "TJ", "TZ", "TH", "TL", "TG", "TK", "TO", "TT", "TN", "TR", "TM", "TC", "TV", "UG", "UA", "AE", "GB", "US", "UM", "UY", "UZ", "VU", "VE", "VN", "VG", "VI", "WF", "EH", "YE", "ZM", "ZW");

	foreach ($popunilo as $popunak)
	{
		echo ("<option value=\"$popunak\">$popunak</option>");
	}
}

function register($connection)
{
	if (isset($_POST['name'], $_POST['username'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['passwordRepeat'], $_POST['country'], $_POST['city'], $_POST['address'], $_POST['dateofbirth']))
	{
		if ($_POST['password'] == $_POST['passwordRepeat'])
		{
		    $db = new mysqli("localhost","root","","ntpws");
            $query1  = "SELECT * FROM users";
            $query1 .= " WHERE email='" .  $_POST['email'] . "'";
            $query1 .= " OR username='" .  $_POST['username'] . "'";
            $result = @mysqli_query($db, $query1);
            $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);

            if (!is_array($row)) {
                $mysqli = new mysqli("localhost","root","","ntpws");

                $ime = htmlspecialchars($_POST['name']);
                $username = htmlspecialchars($_POST['username']);
                $prezime = htmlspecialchars($_POST['lastname']);
                $email = htmlspecialchars($_POST['email']);
                $sifra = password_hash(htmlspecialchars($_POST['password']), CRYPT_BLOWFISH);
                $zemlja = htmlspecialchars($_POST['country']);
                $grad = htmlspecialchars($_POST['city']);
                $ulica = htmlspecialchars($_POST['address']);
                $rodjenje = htmlspecialchars($_POST['dateofbirth']);

                $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $query = "INSERT INTO users (name, username, lastname, email, password, country, city, address, dateofbirth, role)";
                $query .= " VALUES ('" . $_POST['name'] . "',  '" . $_POST['username'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "', '" . $_POST['city'] . "', '" . $_POST['address'] . "', '" . $_POST['dateofbirth'] . "', '" . 'user' . "')";
                if ($connection->query($query) === TRUE) {
                  echo "New record created successfully";
                } else {
                  echo "Error: " . $query . "<br>" . $connection->error;
                }

                echo("<br/>You are registered!<br/>");
            }

		}
		else
			echo("<br/><b>Passwords do not match</b><br/>");
	}
	else
	    echo("ne radi");
}

function login($connection)
{
	if (isset($_POST['username'], $_POST['password']))
	{
	    echo("<br/> bla <br/>");
	    $db = new mysqli("localhost","root","","ntpws");

		$query  = "SELECT * FROM users";
		$query .= " WHERE username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($db, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);

		if (password_verify($_POST['password'], $row['password'])) {
		     echo("<br/>Successful login - Session active");
		     $_SESSION["favcolor"] = "green";

			 $_SESSION['user']['valid'] = 'true';
			 $_SESSION['user']['id'] = $row['id'];
			 $_SESSION['user']['name'] = $row['name'];
			 $_SESSION['user']['lastname'] = $row['lastname'];
             $_SESSION['user']['role'] = $row['role'];
			 $_SESSION['message'] = '<p>Welcome, ' . $_SESSION['user']['name'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			 header("Location: index.php?izbor=1");
		}

		# Bad username or password
		else {
			unset($_SESSION['user']);
			$_SESSION['message'] = '<p>You entered wrong email or password!</p>';
// 			header("Location: index.php?izbor=5");
		}
	}
}
?>