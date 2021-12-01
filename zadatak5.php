<?php
$apiKey = "2a5ec173300513ddea7611749520963e";
print '

    <main>
    '; if ($_POST['action'] == FALSE) {
        print '
        <h1> Current weather </h1>
        <form action="" method="POST">
            <input type="hidden" id="action" name="action" value="TRUE">
            <label for="city">Enter a city:</label><br />
            <input type="text" id="city" name="city"><br /><br />
            <input type="submit">
        </form>
        ';
    } else if ($_POST['action'] == TRUE) {
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $_POST['city'] . "&lang=en&units=metric&appid=" . $apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);
        $currentTime = time();

        print'
        <h1>Weather in '; echo $res->name; print'</h1>
          <div style="padding: 30px; font-weight: bold">
              <div> Time of request: '; echo date("l g:i a", $currentTime); print ' </div><br>
              <div> Date of request: '; echo date("jS F, Y",$currentTime); print '</div>
              <div><br/>
                 Weather: ' . $res->weather[0]->main;
                 print '</div>  <br/>
              <div>Desc: ';  echo $res->weather[0]->description; print '</div><br>
              <div>Temp: '; echo $res->main->temp . '°C'; print'</div><br>
              <div>Feels like: '; echo $res->main->feels_like . '°C'; print'</div><br>
              <div>Humidity: ';  echo $res->main->humidity . '%' ; print'</div><br>
              <div>Wind: '; echo $res->wind->speed . 'km/h'; print '</div>  <br>
          </div>
      ';
    }
    print '
    </main>
';
?>