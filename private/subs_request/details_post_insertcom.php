				<p><a href="<?php echo 'details?key=' . $_GET['key'] . '&action=show'; ?>">Abbrechen&nbsp;&raquo;</a></p>

<?php

            // TODO: add attachment

			$comment = [];
			$comment['comment'] = trim($_POST['comment']) ?? '';
			$comment['key'] = $_GET['key'] ?? '';

				$result = insert_comment($comment);
				if($result === true) {
//					echo 'tru';
					header("Location: details?key=" . $_GET['key'] . "&action=show");
					exit;
				} else {
										
					$errors = $result;
					echo display_validation_errors($errors);
?>

				<form action="<?php echo 'details?key=' . $key . '&action=comnew'; ?>" method="post">
					<dl>
						<dt>Kommentar</dt>
						<dd>
							<textarea name="comment" rows="2" cols="60"></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="Speichern" />
					</div>

				</form>

<?php
				}
?>