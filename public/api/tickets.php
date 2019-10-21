<?php require_once('../../private/initialize.php');

//header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Authorization, Accept");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET");
header('Access-Control-Allow-Origin: https://jstests.dragoneyes.software');
header('Content-Type: application/json');
// header('Content-Type: text/plain');
// header("WWW-Authenticate: Basic realm=\"My Realm\"");

if(!FEATURE_API) {
    http_response_code(410);
    echo json_encode(array(
        "success" => false,
        "message" => "Service not enabled"
    ));
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    exit();
}

// $a = base64_decode( substr($_SERVER["REMOTE_USER"],6)) ;
// list($name, $password) = explode(':', $a);
// $_SERVER['PHP_AUTH_USER'] = $name;
// $_SERVER['PHP_AUTH_PW']    = $password;
// echo 'PHP_AUTH_USER =' . $_SERVER['PHP_AUTH_USER'] . '<br>';
// echo 'PHP_AUTH_PW =' . $_SERVER['PHP_AUTH_PW'] . '<br>';
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

http_response_code(200);

// return all tickets
$request_set = find_all_requests();
$request = mysqli_fetch_assoc($request_set);
$tickets = array(
    array(
        "id" => $request['kp_request'],
        "description" => $request['description'],
        "category" => find_selectiontext_by_kp(h($request['category'])),
        "priority" => find_selectiontext_by_kp(h($request['priority'])),
        "source" => find_userabbr_by_kp(h($request['source'])),
        "status" => find_selectiontext_by_kp(h($request['status'])),
        "responsible" => find_userabbr_by_kp(h($request['responsible']))
    )
);
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

$response = array(
    "success" => true,
    "tickets" => $tickets
);

echo json_encode($response);
