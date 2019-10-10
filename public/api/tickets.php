<?php require_once('../../private/initialize.php');

    header('Access-Control-Allow: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');

    // return all tickets



    $return = array(
        "success" => true,
        "response" => array(
            "name" => 'Georg',
            "age" => 34
        )
    );

    echo json_encode($return);