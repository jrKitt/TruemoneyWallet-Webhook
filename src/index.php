<?php
header('Content-Type: application/json; charset=UTF-8'); 


if (empty($_POST['msg'])) {
    $arr_msg = array(
        "status" => "false",
        "code" => "400",
        "msg" => "Input is empty",
        "error" => "empty",
        "data" => "none"
    );
    echo json_encode($arr_msg);
    exit;
}

$jwtToken = $_POST['msg']; 
$jwtParts = explode('.', $jwtToken);

try {
    if (count($jwtParts) === 3) {
        list($headerBase64, $payloadBase64, $signature) = $jwtParts;
    
        $header = json_decode(base64_decode($headerBase64), true);
        $payload = json_decode(base64_decode($payloadBase64), true);
    
        $isoDate = $payload['received_time'];
        $dateTime = new DateTime($isoDate);
        $thailandTimeZone = new DateTimeZone('Asia/Bangkok');
        $dateTime->setTimezone($thailandTimeZone);
        $convertedDateTime = $dateTime->format('Y-m-d H:i:s');

        

        echo "Decoded Header: ";
        print_r($header);
    
        echo "Decoded Payload: ";
        
        print_r($payload);
    } else {
        echo "Invalid JWT format.";
    }    
} catch (Exception $e) {
    $arr_msg = array(
        "status" => "false",
        "code" => "401",
        "msg" => "Invalid Token",
        "error" => $e->getMessage(),
        "data" => "none"
    );
    echo json_encode($arr_msg);
}
?>