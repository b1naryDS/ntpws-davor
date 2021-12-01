
<?php
print '
    <main>
        <div class="news">
          <h1>News!</h1>
          <div class="container">
          ';
          $db = new mysqli("localhost","root","","ntpws");

          $query  = "SELECT * FROM news WHERE approved='1'";
          $result = @mysqli_query($db, $query);

          while($row = @mysqli_fetch_array($result)) {
            $queryImage = "SELECT * FROM pictures WHERE newsId='".$row['id']."' LIMIT 1";
            $resultImage = @mysqli_query($db, $queryImage);
            $rowImage = @mysqli_fetch_array($resultImage);
            print '
            <div class="news-item"><br/>
            <a href="index.php?news-story='. $row['id'] .'"><br/>
                <img src="assets/'.$rowImage['img'].'" title=".."><br/>
                </a>
                <div class="titleAndContent">
                    <h2>'. $row['title'] . '</h2><br/>
                    <p> '. $row['description'] . '</p><br/>
                </div>
            </div>';}
            print '
           </div>
           </div>
        </main>
    ';
?>