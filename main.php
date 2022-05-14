<?php

    date_default_timezone_set("America/Monterrey");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $start_msg = $_ENV['START_MSG']; 

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
|
| Current timezone for Logging Activities with time
| It can be obtained from http://1min.in/content/international/time-zones
| By Default it's in IST
|
*/
$config['timeZone'] =  $_ENV['TIMEZONE'];



if($message == "/start"){
    send_message($chat_id,$message_id, "***Hi $firstname \nUse .bin xxxxxx to Check BIN \nSupport: juanchivox54654@dnmx.org\n$start_msg***");
}

//Bin Lookup
if(strpos($message, ".bin") === 0){
    $bin = substr($message, 5);
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://binsu-api.vercel.app/api/".$bin,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
    "sec-fetch-dest: document",
    "sec-fetch-site: none",
    "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
   ],
   ]);

 $result = curl_exec($curl);
 curl_close($curl);
 $data = json_decode($result, true);
 $bank = $data['data']['bank'];
 $country = $data['data']['country'];
 $brand = $data['data']['vendor'];
 $level = $data['data']['level'];
 $type = $data['data']['type'];
 $flag = $data['data']['countryInfo']['emoji'];
 $result1 = $data['result'];
 
    
            $timetakeen = (microtime(true) - $startTime);
            $timetaken = substr_replace($timetakeen, '',4);
            $startTime = microtime(true); 
    
    if ($result1 == true) {
        
    send_message($chat_
                 
                 ,$message_id, "***------- Bin Info -------
 ✅ Valid BIN ✅
💎Bin: $bin
💳Brand: $brand
💳Level: $level
💳Type: $type
🏦Bank: $bank
🌎Country: $country $flag
----------------------------
Checked By ---» @$username
USER ID: ---» $id
♦Bot By ---» juanchivox54654@dnmx.org✉️ ***");
 
        



    }
else {
    send_message($chat_id,$message_id, "***❌Enter Valid BIN❌***");
}
}
    function send_message($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text&parse_mode=Markdown");
    }
?>
