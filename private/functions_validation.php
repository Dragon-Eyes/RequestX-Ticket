<?php

function is_blank( $value ) {
	return !isset($value) || trim($value) === '';
}

function is_not_blank( $value ) {
	return isset($value) && trim($value) !== '';
}

function display_validation_errors($errors=array()) {
	$output = '';
	if(!empty($errors)) {
		$output = '<div class="msgerror">';
		$output .= "Bitte korrigieren Sie folgende Fehler:";
		$output .= "<ul>";
		foreach($errors as $error) {
			$output .= "<li>" . h($error) . "</li>";
		}
		$output .= "</ul></div>";
		return $output;
	}
}

function is_username_unique($nameuser, $keyuser) {
	global $db;
	$sql = "SELECT kp_user FROM users ";
	$sql .= "WHERE name_user = '" . $nameuser . "'";
    if(isset($keyuser)) {
        $sql .= " AND kp_user != '" . $keyuser . "'";
    }
	$result = mysqli_query($db, $sql);
//	$request = mysqli_fetch_assoc($result);
//	$valid = !$request ? true : false;
	$count = mysqli_num_rows($result);
	return $count > 0 ? false : true;
}

function is_password_strong_enough($string) {
	if( ( preg_match('~[a-z]~', $string) || preg_match('~[A-Z]~', $string) ) && preg_match('~[0-9]~', $string) && strlen($string) > 5 ) {
		return true;
	} else {
		return false;
	}
}
