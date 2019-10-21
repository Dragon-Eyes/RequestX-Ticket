<?php require_once('../../private/initialize.php');

header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if(!FEATURE_API) {
    http_response_code(410);
    echo json_encode(array(
        "success" => false,
        "message" => "Service not enabled"
    ));
    exit();
}

http_response_code(200);
echo json_encode(array(
    "success" => true,
    "message" => "Service is available"
));
