<?php
	require_once('../private/initialize.php');
	$result = log_out();
	header("Location: https://" . SUBDOMAIN . ".requestx.ch/login");
?>