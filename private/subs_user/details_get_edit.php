<?php
			$key = $_GET['key'];
			$user = find_user_by_kp($key);
			$pwreset = $_GET['pwreset'] === 'true';
            $apikeyreset = $_GET['apikeyreset'] === 'true';
?>

				<a href="<?php echo 'index'; ?>"><?php echo $_SESSION['copy']['cancel']; ?>&nbsp;&raquo;</a>

				<form action="<?php echo 'details?key=' . $key . '&action=edit'; ?>" method="post">
					<dl>
						<dt><?php echo $_SESSION['copy']['nameFirst']; ?></dt>
						<dd>
							<textarea name="name_first" rows="1" cols="40"><?php echo h($user['name_first']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['nameLast']; ?></dt>
						<dd>
							<textarea name="name_last" rows="1" cols="40"><?php echo h($user['name_last']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['nameAbbr']; ?></dt>
						<dd>
							<textarea name="name_abbr" rows="1" cols="20"><?php echo h($user['name_abbr']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['username']; ?></dt>
						<dd>
							<textarea name="name_user" rows="1" cols="40"><?php echo h($user['name_user']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['username']; ?></dt>
						<dd>
							<textarea name="email" rows="1" cols="40"><?php echo h($user['email']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['note']; ?></dt>
						<dd>
							<textarea name="note" rows="2" cols="40"><?php echo h($user['note']); ?></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="<?php echo $_SESSION['copy']['save']; ?>" />
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

                    if($apikeyreset) {

                        $result = new_apikey($key);

                        if( $result === true ) {
                            header('Location: details?key=' . $key . '&action=edit');
                            exit;
                        } else {
                            $errors = $result;
                            echo 'Error DB: ' . $errors;
                        }
                    } ?>

					<dl>
                        <dt>API-Key</dt>
                        <dd><?php echo h($user['apikey']); ?></dd>
                        <dd><a href='details?key=<?php echo $key; ?>&action=edit&apikeyreset=true'>Neuen Key erzeugen&nbsp;&raquo;</a></dd>
                    </dl><br />

                    <?php
					if(isset($user['password_hashed'])) {
						echo '<p>Wenn Sie das Passwort eines Benutzers zurücksetzen, wird das Passwort des Benutzers in der Datenbank gelöscht und, wie bei neuen Benutzern, wird das Passwort, das der Benutzer beim ersten Login eingibt, verschlüsselt gespeichert und ist für spätere Logins notwendig.</p>
						<a href=';
							echo 'details?key=' . $key . '&action=edit&pwreset=true>Passwort zurücksetzen&nbsp;&raquo;</a>';
					} else {
						echo '<p>Passwort ist (noch) nicht gesetzt.</p>';
					}
?>