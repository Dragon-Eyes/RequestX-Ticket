<?php require_once('../private/initialize.php'); ?>
<?php require_login(); ?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Details</title>
    <link rel="canonical" href="https://<?php echo SUBDOMAIN; ?>.requestx.ch/details">
	<link rel="stylesheet" href="styles/requestx.css">
</head>
<body>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['key']) && $_GET['action'] == 'show') {
			// show request
//			require('../private/subs_request/details_get_show.php');
         
         require ('../private/subs_request/details_get_showreq.php');
			if(FEATURE_COMMENTS) {
				include ('../private/subs_request/details_get_showcomnewbtn.php');
				include ('../private/subs_request/details_get_showcomlist.php');
			}
         
         
         
         
		} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['key']) && $_GET['action'] == 'comnew') {
			// show request
         require ('../private/subs_request/details_get_showreq.php');
         require ('../private/subs_request/details_get_showcomnewfrm.php');
         require ('../private/subs_request/details_get_showcomlist.php');

         
		} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['key']) && $_GET['action'] == 'edit') {
			// show request as form
			require ('../private/subs_request/details_get_editreq.php');
		} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['key']) && $_GET['action'] == 'new') {
			// show empty form
			require ('../private/subs_request/details_get_newreq.php');
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['key']) && $_GET['action'] == 'edit') {
			// save changes to db
//			echo 'EDIT';
			require ('../private/subs_request/details_post_updatereq.php');
			// redirect to show
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['key']) && $_GET['action'] == 'new') {
			// save new record to db
			require ('../private/subs_request/details_post_insertreq.php');
			// redirect to show



      } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['key']) && $_GET['action'] == 'comnew') {
			// save new comment record to db

//			echo 'POST comnew';
         require ('../private/subs_request/details_post_insertcom.php');

        } else {
			// redirect to index
			header("Location: index");
		}
	?>
</body>
</html>