<?php
          $db = new mysqli("localhost","root","","ntpws");

     function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}

	if (isset($_POST['action']) && $_POST['action'] == 'add_news') {
		$_SESSION['message'] = '';
		$approved = 1;
		if ($_SESSION['user']['role'] === 'user') {
			$approved = 0;
		}
		$query  = "INSERT INTO news (title, description, date, approved)";
		$query .= " VALUES ('" . $_POST['title'] . "', '" . $_POST['description'] . "', '" . date("Y-m-d G:i") . "', '".$approved."')";
		$result = @mysqli_query($db, $query);
        $ID = mysqli_insert_id($db);
		$count = count($_FILES['picture']['name']);
		for($i = 0; $i < $count; $i++) {
			$ext = strtolower(strrchr($_FILES['picture']['name'][$i], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'][$i], "assets/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg' || $ext == '.gif') {
				$_query  = "INSERT INTO pictures (description,img, newsId) VALUES ('". $_POST['imageDesc']. "','".$_picture."', '".$ID."')";
				$_result = @mysqli_query($db, $_query);
			}
		}
		$_SESSION['message'] .= "<p>You successfully added ".$count." images!</p>";
	}

	if (isset($_POST['action']) && $_POST['action'] == 'edit_news' && ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor')) {
		$query  = "UPDATE news SET title='" .$_POST['title']. "', description='" .$_POST['description']. "', approved='".$_POST['approved']."'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($db, $query);

		$ID = mysqli_insert_id($db);
		$count = count($_FILES['picture']['name']);
		for($i = 0; $i < $count; $i++) {
			$ext = strtolower(strrchr($_FILES['picture']['name'][$i], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			if (empty($_FILES['picture'])) {
				copy($_FILES['picture']['tmp_name'][$i], "assets/".$_picture);
				if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg' || $ext == '.gif') {
					$desc = "aaaa";
					$_query  = "INSERT INTO pictures (description,img, newsId) VALUES ('". $desc. "','".$_picture."', '".$ID."')";
					$_result = @mysqli_query($db, $_query);
				}
			}
		}
		$_SESSION['message'] .= "<p>You successfully added ".$count." images!</p>";

	}

	if (isset($_GET['delete']) && $_GET['delete'] != '') {

		$newsId = $_GET['delete'];
		$query  = "DELETE FROM pictures WHERE newsId='".$newsId."'";
		$result = @mysqli_query($db, $query);
		$file = "assets/".$newsId."*"."."."*";
		foreach(glob($file) as $img) {
			unlink($img);
		}
    	$query  = "DELETE FROM news WHERE id='".(int)$_GET['delete']."'";
		$result = @mysqli_query($db, $query);

		$_SESSION['message'] = '<p>You successfully deleted news!</p>';

	}

	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($db, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>News overview</h2>
		<div class="news">
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['description'] . '
			<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
			<hr>
		</div>
		<p><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'">Back</a></p>';
	}

	else if (isset($_GET['add']) && $_GET['add'] != '') {
		print '
		<h2>Add news</h2>
		<main>
		<form style="" action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="action" name="action" value="add_news">

			<label for="title">Title</label><br/>
			<input type="text" id="title" name="title" placeholder="News title" required><br/>
			<label for="description">Description</label><br/>
			<textarea rows="12" cols="80" id="description" name="description" placeholder="Description" required></textarea><br/>

			<label for="picture[]">Picture</label><br/>
			<input type="file" multiple id="picture" name="picture[]"><br/>

			<label for="imageDesc">Image description</label><br/>
			<input required placeholder="Image description" type="text" id="imageDesc" name="imageDesc"><br/>
			<hr>
			<input type="submit" value="Submit">
		</form>
		</main>
		<p><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'">Back</a></p>';
	}



	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '' && ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor')) {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($db, $query);
		$row = @mysqli_fetch_array($result);

		print '
		<h2>Edit news</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="action" name="action" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			<label for="title">Title</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="Title" required>
			<label for="description">Description *</label>
			<textarea id="description" name="description" placeholder="Description" required>' . $row['description'] . '</textarea>
			<label for="picture[]">Picture</label>
			<input type="file" id="picture" multiple name="picture[]">
			<label for="approved">Approved</label>
            <select name="approved" id="approved">
			<option value="" selected disabled hidden>Select</option>
            <option value="1">True</option>
            <option value="0">False</option>
            </select>
			<hr>

			<input type="submit" value="Submit">
		</form>
		<p><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'">Back</a></p>';
	}
	else {
		print '
		<h2 style="text-align:center">News</h2>
		<br>
		<div id="news">
			<table style="display:flex;flex-direction:column;align-items:center;">
				<thead>
					<tr>
						<th width="50"></th>
						';
						if ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor') {
							print '
							<th width="50"></th>
							<th width="50"></th>';
						}
						print '
						<th width="150">Title</th>
						<th width="300">Description</th>
						<th width="150">Date</th>
						<th width="150"></th>
					</tr>
				</thead>
				<tbody style="display: flex;flex-direction:column;row-gap:30px;">';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($db, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td width="150"><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'&amp;id=' .$row['id']. '"></a></td>';

						if ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor') {
							print '
							<td width="50"><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'&amp;edit=' .$row['id']. '">Edit</a></td>
							<td width="50"><a href="index.php?izbor='.$izbor.'&amp;action='.$action.'&amp;delete=' .$row['id']. '">Delete</a></td>
							';
						} print '
						<td width="150">' . $row['title'] . '</td>
						<td width="300">';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td width="150">' . pickerDateToMysql($row['date']) . '</td>
						<td width="150">
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>

		</div>
		<a style="display: flex;justify-content: center;margin-top: 30px;margin-bottom:30px;" href="index.php?izbor=' . $izbor . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add news</a>';
	}

	@mysqli_close($db);
?>