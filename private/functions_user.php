<?php

function find_all_users() {
	global $db;
	$sql = "SELECT * FROM users ";
	$sql .= "WHERE flg_deleted = 0 ";
	$sql .= "ORDER BY name_first ASC, name_last ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

function find_all_active_userkeys() {
	global $db;
	$sql = "SELECT kp_user, name_abbr FROM users ";
	$sql .= "WHERE flg_active = 1 ";
	$sql .= "ORDER BY name_first ASC, name_last ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

function find_user_by_kp($key) {
	global $db;
	$sql = "SELECT * FROM users ";
	$sql .= "WHERE kp_user = " . $key . " ";
	$sql .= "AND flg_deleted = 0";
	$result = mysqli_query($db, $sql);
	$request = mysqli_fetch_assoc($result);
	return $request;
}

function find_userabbr_by_kp($key) {
	global $db;
	$sql = "SELECT name_abbr FROM users ";
	$sql .= "WHERE kp_user = " . $key;
	$result = mysqli_query($db, $sql);
	$request = mysqli_fetch_assoc($result);
	$userabbr = $request['name_abbr'];
	return $userabbr;
}

function find_useremail_by_kp($key) {
    global $db;
    $sql = "SELECT email FROM users ";
    $sql .= "WHERE kp_user = " . $key;
    $result = mysqli_query($db, $sql);
    $request = mysqli_fetch_assoc($result);
    $useremail = $request['email'];
    // TODO: cover no-email
    return $useremail;
}

function find_user_by_nameuser($name_user) {
	global $db;
	$sql = "SELECT * FROM users ";
	$sql .= "WHERE name_user = '" . $name_user . "' ";
//	$sql .= "AND flg_active = 1";
	$result = mysqli_query($db, $sql);
	if($result->num_rows == 0) {
	    return false;
    } else {
        $request = mysqli_fetch_assoc($result);
        return $request;
    }
}

function find_userkp_by_nameuser($name_user) {
    global $db;
    $sql = "SELECT kp_user FROM users ";
    $sql .= "WHERE name_user = '" . $name_user . "' ";
//	$sql .= "AND flg_active = 1";
    $result = mysqli_query($db, $sql);
    if($result->num_rows == 0) {
        return false;
    } else {
        $request = mysqli_fetch_assoc($result);
        return $request;
    }
}

function find_user_by_apikey($apikey) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE apikey = '" . $apikey . "' ";
//	$sql .= "AND flg_active = 1";
    $result = mysqli_query($db, $sql);
    $request = mysqli_fetch_assoc($result);
    return $request;
}

function validate_user($user) {
	$errors = [];

    if(is_blank($user['name_abbr'])) {
		$errors[] = "Abkürzung kann nicht leer sein";
	}
	
    if(is_blank($user['name_user'])) {
		$errors[] = "Benutzername kann nicht leer sein";
	} else {
        if(!is_username_unique($user['name_user'], $user['key'])) {
            $errors[] = "Benutzername ist bereits besetzt";		
        }
    }
    
    
	
	return $errors;
}

function update_password($user) {
	global $db;
	
	$sql = "UPDATE users SET ";
	$sql .= "password_hashed='" . db_escape($db, $user['password_hashed']) . "', ";
	$sql .= "utl_modification_user_kp='" . db_escape($db, $user['kp_user']) . "' ";
	
	$sql .= "WHERE kp_user='" . db_escape($db, $user['kp_user']) . "' ";
//	$sql .= "WHERE kp_request='2' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	return $result;
}

function delete_password($key) {
	global $db;
	
	$sql = "UPDATE users SET ";
	$sql .= "password_hashed=null, ";
	$sql .= "utl_modification_user_kp='" . $_SESSION['kp_user'] . "' ";

	$sql .= "WHERE kp_user='" . $key . "' ";
//	$sql .= "WHERE kp_request='2' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	return $result;
}

function new_apikey($key) {
    global $db;

    $sql = "UPDATE users SET ";
    $sql .= "apikey='" . get_uid() . "', ";
    $sql .= "utl_modification_user_kp='" . $_SESSION['kp_user'] . "' ";

    $sql .= "WHERE kp_user='" . $key . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    return $result;
}

function update_user($user) {
	global $db;
	
	$errors = validate_user($user);
	if(!empty($errors)) {
		return $errors;
	}
	
	$sql = "UPDATE users SET ";
	$sql .= "name_first='" . db_escape($db, $user['name_first']) . "', ";
	$sql .= "name_last='" . db_escape($db, $user['name_last']) . "', ";
	$sql .= "name_abbr='" . db_escape($db, $user['name_abbr']) . "', ";
	$sql .= "name_user='" . db_escape($db, $user['name_user']) . "', ";
	$sql .= "email='" . db_escape($db, $user['email']) . "', ";
	$sql .= "note='" . db_escape($db, $user['note']) . "', ";
//	$sql .= "utl_modification_user_kp=5 ";
	$sql .= "utl_modification_user_kp='" . $_SESSION['kp_user'] . "' ";

	$sql .= "WHERE kp_user='" . db_escape($db, $user['key']) . "' ";
//	$sql .= "WHERE kp_request='2' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	return $result;
}

function insert_user($user) {
    global $db;
	
	$errors = validate_user($user);
	if(!empty($errors)) {
		return $errors;
	}

    $sql = "INSERT INTO users ";
    $sql .= "(name_first, name_last, name_abbr, name_user, email, note, utl_creation_user_kp) ";
//    $sql .= "(name_first, name_last, name_abbr, name_user, email, note) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['name_first']) . "',";
    $sql .= "'" . db_escape($db, $user['name_last']) . "',";
    $sql .= "'" . db_escape($db, $user['name_abbr']) . "',";
    $sql .= "'" . db_escape($db, $user['name_user']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['note']) . "',";
	$sql .= "'" . $_SESSION['kp_user'] . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
	return $result;
}

function log_in($user) {
	session_regenerate_id();
	$_SESSION['kp_user'] = $user['kp_user'];
	$_SESSION['name_user'] = $user['name_user'];
    
    $selection_set = find_selectionkeys_by_list('status');
    while ($selection = mysqli_fetch_assoc($selection_set)) {
        $_SESSION['filter_requeststatus'][$selection['kp_selection']] = true;
    }
    $_SESSION['filter_requeststatus'][28] = false;
//    $_SESSION['filter_requests'] = $selection_set;
//    var_dump(debug_backtrace($selection_set));

    setcookie('username', $user['name_user'], time() + 60*60*24*14, SUBDOMAIN . '.requestx.ch', '', true, false);

	return true;
}

function log_out() {
	session_destroy();
//	unset($_SESSION['kp_user']);
	return true;
}

function is_logged_in() {
	return isset($_SESSION['kp_user']);
}

function require_login() {
	if(!is_logged_in()) {
		header("Location: https://" . SUBDOMAIN . ".requestx.ch/login");
	}
}

function setLanguage($language="de") {
    global $db;
    if ($language == 'de') {
        $sql = "SELECT object, de AS copy FROM copy";
    } else {
        $sql = "SELECT object, en AS copy FROM copy";
    }
    $result = mysqli_query($db, $sql);
    while ($request = mysqli_fetch_assoc($result)) {
        $_SESSION['copy'][$request['object']] = $request['copy'];
    }
}

?>