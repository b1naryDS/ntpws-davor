<?php
    $db = new mysqli("localhost","root","","ntpws");

    function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}



	# Update user profile
	if (isset($_POST['edit']) && $_POST['action'] == 'TRUE') {
		$query  = "UPDATE users SET name='" . $_POST['name'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', country='" . $_POST['country'] . "' , role='" . $_POST['role'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($db, $query);
		# Close MySQL connection
		@mysqli_close($db);

		$_SESSION['message'] = '<p>You successfully changed user profile!</p>';

	}
	# End update user profile

	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {

		$query  = "DELETE FROM users";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($db, $query);

		$_SESSION['message'] = '<p>You successfully deleted user profile!</p>';
	}
	# End delete user profile


	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($db, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>User profile</h2>
		<p><b>First name:</b> ' . $row['name'] . '</p>
		<p><b>Last name:</b> ' . $row['lastname'] . '</p>
		<p><b>Username:</b> ' . $row['username'] . '</p>
        <p><b>Role:</b> ' . $row['role'] . '</p>';

		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE country_code='" . $row['country'] . "'";
		$_result = @mysqli_query($db, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Country:</b> ' .$_row['country_name'] . '</p>
		<p><b>Date:</b> ' . pickerDateToMysql($row['date']) . '</p>
		<p><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'">Back</a></p>';
	}
	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($db, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>Edit user profile</h2>
		<div class="news">
            <form action="" id="registration_form" name="registration_form" method="POST">
                <input type="hidden" id="action" name="action" value="TRUE">
                <input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">

                <label for="fname">First Name</label><br/>
                <input type="text" id="name" name="name" value="' . $row['name'] . '" placeholder="First name" required><br/>
                <label for="lname">Last Name</label><br/>
                <input type="text" id="lastname" name="lastname" value="' . $row['lastname'] . '" placeholder="Last name" required><br/>

                <label for="email">Your E-mail</label><br/>
                <input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Your e-mail.." required><br/>

                <label for="username">Username</label><br/>
                <input type="text" id="username" name="username" value="' . $row['username'] . '" pattern=".{4,10}" placeholder="Username.." required><br/>

                <label for="username">Role</label><br/>
                <select name="role" id="role"><br/>
                <option value="" selected disabled hidden>Select</option><br/>
                <option value="administrator">Administrator</option>
                <option value="editor">Editor</option>
                <option value="user">User</option>
                </select>
                <br/>

                <label for="country">Country</label><br/>
                <select name="country" id="country">
                    <option value="">Select</option>';
                    $_query  = "SELECT * FROM countries";
                    $_result = @mysqli_query($db, $_query);
                    while($_row = @mysqli_fetch_array($_result)) {
                        print '<option value="' . $_row['country_code'] . '"';
                        if ($row['country'] == $_row['country_code']) { print ' selected'; }
                        print '>' . $_row['country_name'] . '</option>';
                    }
                print '
                </select>


                <hr>

                <input type="submit" value="Submit">
            </form>
		<p><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'">Back</a></p>
		</div>';

	}
	else if ($_SESSION['user']['role'] === 'administrator') {
		print '
		<h2 style="text-align:center">List of users</h2>';
        $query  = "SELECT * FROM users";
	    $result = @mysqli_query($db, $query);
        if ($result -> num_rows !== 0 ) {
        print'
		<div id="users">
			<table  style="display:flex;flex-direction:column;align-items:center;margin-bottom:50px;">
				<thead>
					<tr>
                        <th width="50"></th>
						<th width="50"></th>
						<th width="150">First name</th>
						<th width="150">Last name</th>
						<th width="150">E mail</th>
						<th width="150">Country</th>
                        <th width="150">Role</th>
						<th width="150"></th>
					</tr>
				</thead>
				<tbody>';
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr style="text-align:center">
                        <td width="50"><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'&amp;edit=' .$row['id']. '">Edit</a></td>
                        <td width="50"><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'&amp;delete=' .$row['id']. '">Delete</a></td>
						<td width="150"><strong>' . $row['name'] . '</strong></td>
						<td width="150"> <strong>' . $row['lastname'] . '</strong></td>
						<td width="150">' . $row['email'] . '</td>
						<td width="150">';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE country_code='" . $row['country'] . "'";
							$_result = @mysqli_query($db, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
                        <td width="150"> '. $row['role'] .'</td>
						 <td width="150">';

						print '
						 </td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
    } else {
        print '<h3>There are no users yet!</h3>';
    }
	}

	# Close MySQL connection
	@mysqli_close($db);
?>