<?php

function find_selections_by_list($list) {
	global $db;
	$sql = "SELECT * FROM selections ";
	$sql .= "WHERE list = '" . $list . "' ";
//	$sql .= "WHERE list = 'category' ";
	$sql .= "AND flg_active = 1 ";
	$sql .= "ORDER BY position ASC, text ASC";
	$result = mysqli_query($db, $sql);
	return $result;
}

function find_selectionkeys_by_list($list) {
    global $db;
	$sql = "SELECT kp_selection FROM selections ";
	$sql .= "WHERE list = '" . $list . "' ";
//	$sql .= "WHERE list = 'category' ";
	$sql .= "AND flg_active = 1 ";
	$sql .= "ORDER BY position ASC, text ASC";
	$result = mysqli_query($db, $sql);
//    $keys = mysqli_fetch_row($result);
//	return $keys;
	return $result;
}

function find_selectiontext_by_kp($key) {
	global $db;
	$sql = "SELECT text FROM selections ";
	$sql .= "WHERE kp_selection = '" . $key . "'";
	$result = mysqli_query($db, $sql);
	$request = mysqli_fetch_assoc($result);
	$text = $request['text'];
	return $text;
}

function find_selectiontext_by_key($key) {
    global $db;
    if ($_SESSION['copy']['languageAbbr'] == 'DE' ) {
        $sql = "SELECT text_de AS text FROM selections ";
    } else {
        $sql = "SELECT text_en AS text FROM selections ";
    }
    $sql .= "WHERE kp_selection = '" . $key . "'";
    $result = mysqli_query($db, $sql);
    $request = mysqli_fetch_assoc($result);
    $text = $request['text'];
    return $text;
}

function find_selectionposition_by_kp($key) {
	global $db;
	$sql = "SELECT position FROM selections ";
	$sql .= "WHERE kp_selection = '" . $key . "'";
	$result = mysqli_query($db, $sql);
	$request = mysqli_fetch_assoc($result);
	$position = $request['position'];
	return $position;
}

?>