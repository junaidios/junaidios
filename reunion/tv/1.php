<?php

$curl = curl_init();
$mac = $_GET['mac'];
$host = $_GET['host'];
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

    $response = curl_exec($curl);

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

    $resp = json_decode($resp3, true);
    $resp = $resp["js"];
    $names = array_map( function($p) { return $p['title']; }, $resp);

    $mainResp["host"] = $host;
    $mainResp["token"] = $auth;
    $mainResp["account"] = json_decode($resp4, true)["js"];
    $mainResp["groups"] = $names;
//    $mainResp["lists"] = json_decode($resp3);
//    $mainResp["info"] = json_decode($resp4);

echo json_encode($mainResp);
