<?php require_once('../../private/initialize.php');

header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("WWW-Authenticate: Basic realm=\"My Realm\"");

// session_regenerate_id();


// $a = base64_decode( substr($_SERVER["REMOTE_USER"],6)) ;
// list($name, $password) = explode(':', $a);
// $_SERVER['PHP_AUTH_USER'] = $name;
// $_SERVER['PHP_AUTH_PW']    = $password;
// echo 'PHP_AUTH_USER =' . $_SERVER['PHP_AUTH_USER'] . '<br>';
// echo 'PHP_AUTH_PW =' . $_SERVER['PHP_AUTH_PW'] . '<br>';
$token = substr($_SERVER['REMOTE_USER'], 7);

http_response_code(200);
echo json_encode(array(
    "token" => $token
));



// echo $token;
// echo 'REMOTE_USER =' . $_SERVER['REMOTE_USER'];
exit();

$_SESSION['Test'] = 'successful';

$user = $_SERVER['PHP_AUTH_USER'];
$user = $_SERVER['REMOTE_USER'];
// $user = 'something';

echo json_encode($_SERVER);
echo json_encode($_SESSION);

exit();



//    header('Access-Control-Allow: *');
    header('Content-Type: application/json');
//    header('Access-Control-Allow-Methods: GET');

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
