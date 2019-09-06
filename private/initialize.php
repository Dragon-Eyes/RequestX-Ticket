<?php
	ob_start();
	session_start();

	define("PRIVATE_PATH", dirname(__FILE__));
	define("PROJECT_PATH", dirname(PRIVATE_PATH));
	define("PUBLIC_PATH", PROJECT_PATH . '/public');
	define("SHARED_PATH", PRIVATE_PATH . '/shared');

	$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
	$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
	define("WWW_ROOT", $doc_root);

	require_once('configuration.php');
	require_once('functions.php');
	require_once('functions_database.php');
	require_once('functions_validation.php');
	require_once('functions_user.php');
	require_once('functions_request.php');
	require_once('functions_selection.php');

	$db = db_connect();
	$errors = [];
	$message = [];
?>