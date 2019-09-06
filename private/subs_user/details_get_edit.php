<?php
			$key = $_GET['key'];
			$user = find_user_by_kp($key);
			$pwreset = $_GET['pwreset'] === 'true';
?>

				<a href="<?php echo 'index'; ?>">Abbrechen&nbsp;&raquo;</a>

				<form action="<?php echo 'details?key=' . $key . '&action=edit'; ?>" method="post">
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

<?php
					if($pwreset) {
						$result = delete_password($key);
						if( $result === true ) {
							header('Location: details?key=' . $key . '&action=edit');
							exit;
						} else {
							$errors = $result;
							echo 'Error DB: ' . $errors;
						}
					}

					if(isset($user['password_hashed'])) {
						echo '<p>Wenn Sie das Passwort eines Benutzers zurücksetzen, wird das Passowort des Benutzers in der Datenbank gelöscht und, wie bei neuen Benutzern, wird das Passwort, das der Benutzer beim ersten Login eingibt, verschlüsselt gespeichert und ist für spätere Logins notwendig.</p>
						<a href=';
							echo 'details?key=' . $key . '&action=edit&pwreset=true>Passwort zurücksetzen&nbsp;&raquo;</a>';
					} else {
						echo '<p>Passwort ist (noch) nicht gesetzt.</p>';
					}
?>