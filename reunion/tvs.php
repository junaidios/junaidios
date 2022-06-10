
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$curl = curl_init();
$mac = $_POST['mac'];
$host = $_POST['host_url'];
$cookie = 'Cookie: mac='.$mac."; timezone=Asia/Karachi";
   
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $host.'/portal.php?type=stb&action=handshake',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($cookie),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
$resp1 = $response;

$resp = json_decode($response, true);

$token = $resp["js"]["token"];

$auth = 'Authorization: Bearer '.$token;
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $host.'/portal.php?type=stb&action=get_profile&auth_second_step=1&hw_version_2=d6b3eba9bdc7fb3858d07cdcaa7a27ed8b10ecc6',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($auth,$cookie),
    ));

    $resp2 = curl_exec($curl);

    curl_close($curl);
//    echo $response;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $host.'/portal.php?type=account_info&action=get_main_info',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($auth,$cookie),
    ));

    $resp4 = curl_exec($curl);

    curl_close($curl);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL =>  $host.'/portal.php?type=itv&action=get_genres',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 60,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($auth,$cookie),
    ));

    $resp3 = curl_exec($curl);

    curl_close($curl);
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL =>  $host.'/portal.php?type=itv&action=get_all_channels',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 60,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($auth,$cookie),
    ));

    $resp5 = curl_exec($curl);

    curl_close($curl);

    
    $resp = json_decode($resp3, true);
    $resp = $resp["js"];
    $names = array_map( function($p) { return $p['title']; }, $resp);
    $expiry = json_decode($resp4, true)["js"]["phone"];
    $default_timezone = json_decode($resp2, true)["js"]["default_timezone"];
    $parent_password = json_decode($resp2, true)["js"]["parent_password"];
    $ch_count = json_decode($resp5, true)["js"]["total_items"];
    $ch_list = json_decode($resp5, true)["js"]["data"];
    $ch_names = array_map( function($p) { return $p['name']; }, $ch_list);

    $mainResp["host"] = $host;
    $mainResp["token"] = $auth;
    $mainResp["account"] = $expiry;
    $mainResp["groups"] = $names;
//    $mainResp["lists"] = json_decode($resp3);
//    $mainResp["info"] = json_decode($resp4);
//echo json_encode($mainResp);
}
?>


<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="css/main.css" rel="stylesheet" />
<head>
<style>
.grid-container {
  display: grid;
  grid-gap: 10px;
  grid-template-columns: auto auto auto auto auto;
  padding: 10px;
}

.grid-item {
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 10px;
  font-size: 16px;
  text-align: center;
}
</style>
</head>
  </head>
  <body>
    <div class="s01">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <fieldset>
          <legend>Stalker TV Details:</legend>
        </fieldset>
        <div class="inner-form">
          <div class="input-field first-wrap">
            <input id="host_url" type="text" name="host_url" placeholder="Portal Address: http://name.xyz:8880" value="<?php echo $host;?>" />
          </div>
          <div class="input-field second-wrap">
            <input id="mac" type="text" name="mac" placeholder="MAC: 00:1A:79:XX:XX:XX" value="<?php echo $mac;?>" />
          </div>
          <div class="input-field third-wrap">
            <button class="btn-search" type="submit">LOGIN</button>
          </div>

        </div>

<?php
    if ($names != null) {

        echo '<h1 class="input-field third-wrap">Account Info:</h1>';
        echo '<div class="grid-container"> ';
        
        echo '<div class="grid-item">Expiry: ' . $expiry . '</div>';
        echo '<div class="grid-item">Parental Code: ' . $parent_password . '</div>';
        echo '<div class="grid-item">Timezone: ' . $default_timezone . '</div>';
        echo '</div>';
        
        echo '<h1 class="input-field third-wrap">Groups:  ('. sizeof($names) .')</h1>';

        echo '<div >';
        echo '<div class="grid-container">';
        foreach ($names as $val) {
            echo '<div class="grid-item">' . $val . '</div>';
        }
        echo '</div>';
        echo '</div>';

        echo '<h1 class="input-field third-wrap">All Channels: ('. $ch_count .')</h1>';
        echo '<div >';
        echo '<div class="grid-container">';
        foreach ($ch_names as $val) {
            echo '<div class="grid-item">' . $val . '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
?>

      </form>
    </div>
  </body>
</html>
