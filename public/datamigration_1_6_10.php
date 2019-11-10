<?php
    require_once ('../private/initialize.php');
    require_login();

    $sql = "SELECT * FROM requests";
    $result = mysqli_query($db, $sql);

    while ($request = mysqli_fetch_assoc($result)) {
        $request['followers'] = $request['source'] . ',' . $request['responsible'];
        $sql = "UPDATE requests SET ";
        $sql .= "followers='" . db_escape($db, $request['followers']) . "' ";
        $sql .= "WHERE kp_request='" . db_escape($db, $request['kp_request']) . "' ";
        $sql .= "LIMIT 1";
        $update = mysqli_query($db, $sql);
    }
