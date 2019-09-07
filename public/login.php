<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
    <link rel="canonical" href="https://<?php echo SUBDOMAIN; ?>.requestx.ch/login">
	<link rel="stylesheet" href="styles/requestx.css">

    <link rel="shortcut icon" href="/assets/ReqX_Ticket.ico?v=1.0">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/assets/ReqX_Ticket.ico?v=1.0">
    <link rel="icon" type="image/png" sizes="196x196" href="/assets/ReqX_Ticket-192.png?v=1.0">
    <link rel="icon" type="image/png" sizes="160x160" href="/assets/ReqX_Ticket-160.png?v=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/ReqX_Ticket-96.png?v=1.0">
    <link rel="icon" type="image/png" sizes="64x64" href="/assets/ReqX_Ticket-64.png?v=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/ReqX_Ticket-32.png?v=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/ReqX_Ticket-16.png?v=1.0">
    <link rel="apple-touch-icon" href="/assets/ReqX_Ticket-57.png?v=1.0">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/ReqX_Ticket-114.png?v=1.0">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/ReqX_Ticket-72.png?v=1.0">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/ReqX_Ticket-144.png?v=1.0">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/ReqX_Ticket-60.png?v=1.0">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/ReqX_Ticket-120.png?v=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/ReqX_Ticket-76.png?v=1.0">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/ReqX_Ticket-152.png?v=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/ReqX_Ticket-180.png?v=1.0">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/assets/ReqX_Ticket-144.png?v=1.0">

</head>
<body>

<?php require_once('../private/initialize.php'); ?>
    
    <h1>Request X - <?php echo PROJECT; ?></h1>
    <p>Version <?php echo REQX_VERSION; ?> (<?php echo REQX_RELEASENO; ?>)</p>
    
    <?php
	$usernameAttempted = '';
	
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$usernameAttempted = trim($_POST['name_user']);
		$passwordAttempted = $_POST['password'];

		// check if username and password are set
		if(is_blank($usernameAttempted)) {
			$errors[] = "Benutzername ist erforderlich";
		}
		if(is_blank($passwordAttempted)) {
			$errors[] = "Passwort ist erforderlich";
		}
		if(!empty($errors)) {
//			echo display_validation_errors($errors);
		} else {
		// process login

//			echo $passwordAttempted;
			$user = find_user_by_nameuser($usernameAttempted);
			if($user) {
//				echo $user['name_user'];
				$passwordStored = $user['password_hashed'] ?? '';
//				echo $user['password_hashed'];

				// if stored password is empty store attempted
				if($passwordStored === '') {
					if(is_password_strong_enough($passwordAttempted)) {
						$user['password_hashed'] = password_hash($passwordAttempted, PASSWORD_DEFAULT);
						$result = update_password($user);
						if( $result === true ) {
//							echo 'successfully updates';
							$result = log_in($user);
							header("Location: index");
//							exit;
						} else {
							$errors = $result;
							echo 'Error DB: ' . $errors;
						}
						
					} else {
						$errors[] = "Das Passwort muss mindestens 6 Zeichen lang sein und aus Buchstaben und Zahlen bestehen";
//						$tempuser = $usernameAttempted;
					}

				} elseif(password_verify($passwordAttempted, $passwordStored)) {
//				} elseif($passwordAttempted === $passwordStored) {
					// if successful, redirect
//					echo 'SUCCESS<br>';
//					$result = log_in($user);
//					echo $_SESSION['user_kp'];
					$result = log_in($user);
					header("Location: index");
				} else {
					// if not successful, display POST values in form
					$errors[] = "Log-in nicht erfolgreich (Passwort nicht korrekt)";
				}
				
			} else {
				// username not found
				$errors[] = "Log-in nicht erfolgreich (Benutzer nicht vorhanden)";
			}
		}
	}


	// display errors if any
	echo display_validation_errors($errors);


		if(isset($_SESSION['user_kp'])) {
			echo '<p>Logged in</p>';
		}
?>
	
	
	<form action="<?php echo 'login'; ?>" method="post">
		<dl>
			<dt>Benutzername</dt>
			<dd>
				<input type="text" name="name_user" value="<?php echo $usernameAttempted; ?>" autofocus>
			</dd>
		</dl>
		<dl>
			<dt>Passwort</dt>
			<dd>
				<input type="password" name="password" id="userpw">
			</dd>
		</dl>
		<div style="display: block; clear: left; padding: 30px 0 0 165px;">
			<input type="checkbox" onclick="showpw()">Passwort anzeigen
			<script>
				function showpw() {
					var x = document.getElementById("userpw");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
			</script>
		</div>
		<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
			<input type="submit" value="Einloggen" />
		</div>

	</form>

	<p>Gross- und Kleinschreibung werden beim Passwort unterschieden.</p>

    <p>
        Request X Ticket 1.x is <a href="https://github.com/Dragon-Eyes/RequestX-Ticket/blob/master/LICENSE" target="_blank">Open Source Software</a> published under the MIT license.
    </p>

</body>
</html>