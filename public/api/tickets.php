<?php require_once('../../private/initialize.php');

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
