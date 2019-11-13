<?php ?>
				<a href="index"><?php echo $_SESSION['copy']['cancel']; ?>&nbsp;&raquo;</a>

				<form action="<?php echo 'details?action=new'; ?>" method="post">
					<dl>
						<dt><?php echo $_SESSION['copy']['nameFirst']; ?></dt>
						<dd>
							<textarea name="name_first" rows="1" cols="40"></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['nameLast']; ?></dt>
						<dd>
							<textarea name="name_last" rows="1" cols="40"></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['nameAbbr']; ?></dt>
						<dd>
							<textarea name="name_abbr" rows="1" cols="20"></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['username']; ?></dt>
						<dd>
							<textarea name="name_user" rows="1" cols="40"></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['email']; ?></dt>
						<dd>
							<textarea name="email" rows="1" cols="40"></textarea>
						</dd>
					</dl>
<!--
					<dl>
						<dt>Password</dt>
						<dd>
							<input type="password" name="password" value="" />
						</dd>
					</dl>
-->
					<dl>
						<dt><?php echo $_SESSION['copy']['note']; ?></dt>
						<dd>
							<textarea name="note" rows="2" cols="40"></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="<?php echo $_SESSION['copy']['save']; ?>" />
					</div>

				</form>

				<p>Wenn Sie einen neuen Benutzer anlegen, bleibt dessen Passwort in der Datenbank temporär leer.</p>
				<p>Das Passwort, welches der Benutzer beim ersten Login eingibt, wird verschlüsselt gespeichert und ist für spätere Logins notwendig.</p>


<?php ?>