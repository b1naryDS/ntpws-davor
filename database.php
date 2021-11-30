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
	if (isset($_POST['name'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['passwordRepeat'], $_POST['country'], $_POST['city'], $_POST['street'], $_POST['birth']))
	{
		if ($_POST['sifraA'] == $_POST['sifraB'])
		{
			$ime = htmlspecialchars($_POST['name']);
			$prezime = htmlspecialchars($_POST['lastname']);
			$email = htmlspecialchars($_POST['email']);
			$sifra = password_hash(htmlspecialchars($_POST['password']), CRYPT_BLOWFISH);
			$zemlja = htmlspecialchars($_POST['country']);
			$grad = htmlspecialchars($_POST['city']);
			$ulica = htmlspecialchars($_POST['street']);
			$rodjenje = htmlspecialchars($_POST['birth']);


			$query = "INSERT INTO users (name, lastname, email, password, country, city, street, dateofbirth)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?);";

			$statement = mysqli_stmt_init($connection);

			mysqli_stmt_prepare($statement, $query);
			mysqli_stmt_bind_param($statement, "sssssssi", $ime, $prezime, $email, $sifra, $zemlja, $grad, $ulica, $rodjenje);
			mysqli_stmt_execute($statement);

			echo("<br/>You are registered!<br/>");

		}
		else
			echo("<br/><b>Passwords do not match</b><br/>");
	}
}

function prijava($connection)
{
	if (isset($_POST['email'], $_POST['password']))
	{

		$email = htmlspecialchars($_POST['email']);
		$sifra = htmlspecialchars($_POST['password']);

		$query = 'SELECT users.email, users.password FROM users WHERE email = ? LIMIT 1;';

		$statement = mysqli_stmt_init($connection);

		mysqli_stmt_prepare($statement, $query);
		mysqli_stmt_bind_param($statement, "s", $email);
		mysqli_stmt_bind_result($statement, $dbEmail, $dbPassword);
		mysqli_stmt_execute($statement);
		mysqli_stmt_fetch($statement);
		//echo(mysqli_error($connection));

		if (isset($dbEmail, $dbPassword))
		{
			if (password_verify($sifra, $dbPassword))
			{
				$_SESSION["login"] = 1;
				header("Refresh:0");
			}
		}
	}
}
?>