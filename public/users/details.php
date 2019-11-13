<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Requestx | <?php echo $_SESSION['copy']['userDetails']; ?></title>
    <link rel="canonical" href="https://<?php echo SUBDOMAIN; ?>.requestx.ch/users/details">
	<link rel="stylesheet" href="../styles/requestx.css">
</head>
<body>
	<?php
		if( $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['key']) && $_GET['action'] == 'edit') {
			// show user as form
			require('../../private/subs_user/details_get_edit.php');
		} elseif( $_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['key']) && $_GET['action'] == 'new') {
			// show empty form
			require('../../private/subs_user/details_get_new.php');
		} elseif( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['key']) && $_GET['action'] == 'edit') {
			// save changes to db
			require('../../private/subs_user/details_post_update.php');
			// redirect to show
		} elseif( $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['key']) && $_GET['action'] == 'new') {
			// save new record to db
			require('../../private/subs_user/details_post_insert.php');
			// redirect to show
		} else {
			// redirect to index
			header("Location: index");
		}
	?>
</body>
</html>