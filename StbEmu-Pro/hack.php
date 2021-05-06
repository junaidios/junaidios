<?php
    
    $host = $_GET['host'];
    
    $macs = array();
    $respList = array();
    
    $hex = array("1","2","3","4","5","6","7","8","9","0","A","B","C","D","E","F");
//    $hex = array("3","9");
    foreach ($hex as $idx1) {
        foreach ($hex as $idx2) {
//            foreach ($hex as $idx3) {
//                foreach ($hex as $idx4) {
                    array_push($macs, "00:1A:79:51:".$idx1.$idx2.":93");//.$idx3.$idx4);
                }
//            }
//        }
    }
    
//    echo json_encode($macs);
//    return;
//    $macs = array("00:1A:79:51:99:99",
//                  "00:1A:79:51:99:93");

    foreach ($macs as $mac) {
        
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
        
        $pid = json_decode($response, true)["js"]["id"];
        if ($pid != "") {
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
            
            $mainResp = json_decode($resp4, true)["js"];
            $mainResp["id"] = $pid;
            array_push($respList, $mainResp);
        }
        else {
            array_push($respList, $pid);
        }
        
    }
    
    echo json_encode($respList);
    
    ?>


