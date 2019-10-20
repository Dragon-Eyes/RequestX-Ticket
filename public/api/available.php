<?php require_once('../../private/initialize.php');

header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Methods: GET");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// header("WWW-Authenticate: Basic realm=\"My Realm\"");

if(!FEATURE_API) {
    http_response_code(410);
    echo json_encode(array(
        "success" => false,
        "message" => "Service not enabled"
    ));
    exit();
}

$token = substr($_SERVER['REMOTE_USER'], 7);

$user = find_user_by_apikey($token);

// TODO: sanitize $token
if(!$user) {
    http_response_code(401);
    echo json_encode(array(
        "success" => false,
        "message" => "Valid access token required to process the request"
    ));
    exit();
}

if(is_blank($_GET['responsible'])) {
    http_response_code(400);
    echo json_encode(array(
        "success" => false,
        "message" => "Username required to process the request"
    ));
    exit();
}

// get user kp
$user = find_userkp_by_nameuser($_GET['responsible']);
if (!$user) {
    http_response_code(404);
    echo json_encode(array(
        "success" => false,
        "message" => "Username not found"
    ));
    exit();
}
$userKp = $user['kp_user'];

// return available tickets for a user
$request_set = find_requests_by_availability_and_user($userKp);
if(!$request_set) {
    http_response_code(200);
    echo json_encode(array(
        "success" => true,
        "tickets" => array()
    ));
    exit();
}

while($request = mysqli_fetch_assoc($request_set)) {
    $tickets[] = array(
        "id" => $request['kp_request'],
        "description" => $request['description'],
        "category" => find_selectiontext_by_kp(h($request['category'])),
        "priority" => find_selectiontext_by_kp(h($request['priority'])),
        "source" => find_userabbr_by_kp(h($request['source'])),
        "status" => find_selectiontext_by_kp(h($request['status'])),
        "responsible" => find_userabbr_by_kp(h($request['responsible']))
    );
}

http_response_code(200);
$response = array(
    "success" => true,
    "tickets" => $tickets
);

echo json_encode($response);
