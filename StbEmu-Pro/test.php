<?php

$curl = curl_init();
$mac = $_GET['mac'];
$host = $_GET['host'];
$metrics = '{"mac":"'.$mac.'"}';
$cookie = 'Cookie: mac='.$mac.'; timezone=GMT';

    
$url = $host."/portal.php?type=stb&action=handshake";

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 60,
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

        $url1 = $host.'/portal.php?type=stb&action=get_profile&auth_second_step=1&metrics={"mac":"'.$mac.'"}&hw_version_2=d6b3eba9bdc7fb3858d07cdcaa7a27ed8b10ecc6';
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url1,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 60,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array($auth, $cookie),
        ));

        $response = curl_exec($curl);

    curl_close($curl);
    $resp2 = $response;
//
//
//    $curl = curl_init();
//
//    curl_setopt_array($curl, array(
//      CURLOPT_URL =>  $host.'/portal.php?type=itv&action=get_genres',
//      CURLOPT_RETURNTRANSFER => true,
//      CURLOPT_ENCODING => '',
//      CURLOPT_MAXREDIRS => 10,
//      CURLOPT_TIMEOUT => 60,
//      CURLOPT_FOLLOWLOCATION => true,
//      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//      CURLOPT_CUSTOMREQUEST => 'GET',
//      CURLOPT_HTTPHEADER => array($auth, $cookie),
//    ));
//
//    $resp3 = curl_exec($curl);
//
//    curl_close($curl);
//
//
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL =>  $host.'/portal.php?type=account_info&action=get_main_info',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 60,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array($auth, $cookie),

    ));

    $resp4 = curl_exec($curl);

    curl_close($curl);
    
    $resp = json_decode($resp3, true);
    $resp = $resp["js"];
    $names = array_map( function($p) { return $p['title']; }, $resp);

    $mainResp["url"] = $url1;
    $mainResp["host"] = $host;
    $mainResp["mac"] = $mac;
    $mainResp["cookie"] = $cookie;
    $mainResp["token"] = $auth;
    $mainResp["account"] = json_decode($resp4, true)["js"]["phone"];
    $mainResp["groups"] = $names;
//    $mainResp["lists"] = json_decode($resp3);
//    $mainResp["info"] = json_decode($resp2);

echo json_encode($mainResp);
