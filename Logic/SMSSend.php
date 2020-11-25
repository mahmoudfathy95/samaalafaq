<?php

function SendSMS($Number, $MSG) {  
    if (!has_prefix($Number, "+"))
    {
        if(!has_prefix($Number, "966"))
        {
            $Number = "966" . $Number; 
        }
        $Number = "+" . $Number; 
    }
    $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
                'api_key' => '53e7a698',
                'api_secret' => 'QnUwYr2Bw5t4OW0y',
                'to' => $Number,
                'from' => '+966500010290',
                'text' => $MSG
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch); 
}
function has_prefix($string, $prefix) {
   return substr($string, 0, strlen($prefix)) == $prefix;
}
?>