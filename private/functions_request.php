<?php

function find_all_requests() {
	global $db;

	$sql = "SELECT * FROM requests ";
	$sql .= "WHERE flg_deleted = 0";

//    $sql .= "AND status = 3";

    $result = mysqli_query($db, $sql);
	return $result;
}

function find_requests_by_status() {
    global $db;

    $sql = "SELECT * FROM requests ";
    $sql .= "WHERE flg_deleted = 0 AND (";
    if($_SESSION['filter_requeststatus'][1]) {
        $sql .= "status = 1 ";
        $conditionPresent = 1;
    }
    if($_SESSION['filter_requeststatus'][2]) {
        if ($conditionPresent) {$sql .= " OR ";}
        $sql .= "status = 2 ";
        $conditionPresent = 1;
    }
    if($_SESSION['filter_requeststatus'][3]) {
        if ($conditionPresent) {$sql .= " OR ";}
        $sql .= "status = 3 ";
        $conditionPresent = 1;
    }
    if($_SESSION['filter_requeststatus'][4]) {
        if ($conditionPresent) {$sql .= " OR ";}
        $sql .= "status = 4 ";
        $conditionPresent = 1;
    }
    if($_SESSION['filter_requeststatus'][28]) {
        if ($conditionPresent) {$sql .= " OR ";}
        $sql .= "status = 28 ";
        $conditionPresent = 1;
    }
    if(!$conditionPresent) {
        $sql .= "false";
    }
    $sql .= ")";
//    $sql .= "AND flg_deleted = 0";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_request_by_kp($key) {
	global $db;
	$sql = "SELECT * FROM requests ";
	$sql .= "WHERE kp_request = " . $key . " ";
	$sql .= "AND flg_deleted = 0";
	$result = mysqli_query($db, $sql);
	$request = mysqli_fetch_assoc($result);
	return $request;
}

function find_comments_by_requestkp($key) {
	global $db;
	$sql = "SELECT * FROM comments ";
	$sql .= "WHERE kf_request = " . $key . " ";
	$sql .= "AND flg_deleted = 0 ";
	$sql .= "ORDER BY utl_creation_ts DESC";
	$result = mysqli_query($db, $sql);
	return $result;
}

function insert_request($request) {
    global $db;

	$errors = validate_request($request);
	if(!empty($errors)) {
		return $errors;
	}

    $sql = "INSERT INTO requests ";
    $sql .= "(description, source, entity, category, priority, responsible, status, note, utl_creation_user_kp) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $request['description']) . "',";
    $sql .= "'" . db_escape($db, $request['source']) . "',";
    $sql .= "'" . db_escape($db, $request['entity']) . "',";
    $sql .= "'" . db_escape($db, $request['category']) . "',";
    $sql .= "'" . db_escape($db, $request['priority']) . "',";
    $sql .= "'" . db_escape($db, $request['responsible']) . "',";
	$sql .= "'" . db_escape($db, $request['status']) . "',";
	$sql .= "'" . db_escape($db, $request['note']) . "',";
	$sql .= "'" . $_SESSION['kp_user'] . "'";
	$sql .= ")";
    $result = mysqli_query($db, $sql);
	return $result;
}

function insert_comment($comment) {
    global $db;

/*	$errors = validate_comment($comment);
	if(!empty($errors)) {
		return $errors;
	}*/

   $sql = "INSERT INTO comments ";
   $sql .= "(comment, attachment_filename, kf_request, utl_creation_user_kp) ";
   $sql .= "VALUES (";
   $sql .= "'" . db_escape($db, $comment['comment']) . "',";
   $sql .= "'" . db_escape($db, $comment['attachment_filename']) . "',";
   $sql .= "'" . db_escape($db, $comment['key']) . "',";
	$sql .= "'" . $_SESSION['kp_user'] . "'";
	$sql .= ")";
    $result = mysqli_query($db, $sql);
	return $result;
}

function update_request($request) {
	global $db;
	
	$errors = validate_request($request);
	if(!empty($errors)) {
		return $errors;
	}
	
	$sql = "UPDATE requests SET ";
	$sql .= "description='" . db_escape($db, $request['description']) . "', ";
	$sql .= "source='" . db_escape($db, $request['source']) . "', ";
	$sql .= "entity='" . db_escape($db, $request['entity']) . "', ";
	$sql .= "category='" . db_escape($db, $request['category']) . "', ";
    $sql .= "priority='" . db_escape($db, $request['priority']) . "', ";
	$sql .= "responsible='" . db_escape($db, $request['responsible']) . "', ";
	$sql .= "status='" . db_escape($db, $request['status']) . "', ";
	$sql .= "note='" . db_escape($db, $request['note']) . "', ";
	$sql .= "utl_modification_user_kp='" . $_SESSION['kp_user'] . "' ";


	$sql .= "WHERE kp_request='" . db_escape($db, $request['key']) . "' ";
//	$sql .= "WHERE kp_request='2' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	return $result;
}

function validate_request($request) {
	$errors = [];
	
	if (is_blank($request['description'])) {
		$errors[] = "Beschreibung kann nicht leer sein";
	}
	return $errors;
}

function validate_comment($comment) {
    // not needed any more
	$errors = [];
	
	if (is_blank($comment['comment'])) {
		$errors[] = "Kommentar kann nicht leer sein";
	}
	return $errors;
}
