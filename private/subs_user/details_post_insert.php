			<a href="<?php echo 'index'; ?>">Abbrechen&nbsp;&raquo;</a>
<?php

			$user = [];
			$user['name_first'] = trim($_POST['name_first']) ?? '';
			$user['name_last'] = trim($_POST['name_last']) ?? '';
			$user['name_abbr'] = $_POST['name_abbr'] ?? '';
			$user['name_user'] = $_POST['name_user'] ?? '';
			$user['email'] = $_POST['email'] ?? '';
			$user['note'] = $_POST['note'] ?? '';


				$result = insert_user($user);
				if($result === true) {
//					$new_key = mysqli_insert_id($db);
					header("Location: index");
					exit;
				} else {
					$errors = $result;
					echo display_validation_errors($errors);
					echo "insert_user not true";
				}

?>

				<form action="<?php echo 'details?action=new'; ?>" method="post">
					<dl>
						<dt>Vorname</dt>
						<dd>
							<textarea name="name_first" rows="1" cols="40"><?php echo h($user['name_first']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>Nachname</dt>
						<dd>
							<textarea name="name_last" rows="1" cols="40"><?php echo h($user['name_last']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>Abkürzung</dt>
						<dd>
							<textarea name="name_abbr" rows="1" cols="20"><?php echo h($user['name_abbr']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>Benutzername</dt>
						<dd>
							<textarea name="name_user" rows="1" cols="40"><?php echo h($user['name_user']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>E-Mail</dt>
						<dd>
							<textarea name="email" rows="1" cols="40"><?php echo h($user['email']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>Notiz</dt>
						<dd>
							<textarea name="note" rows="2" cols="40"><?php echo h($user['note']); ?></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="Speichern" />
					</div>

				</form>
