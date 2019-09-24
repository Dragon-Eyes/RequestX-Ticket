				<p><a href="<?php echo 'details?key=' . $_GET['key'] . '&action=show'; ?>">Abbrechen&nbsp;&raquo;</a></p>

<?php

    if(is_blank(trim($_POST['comment'])) && is_blank($_FILES['attachment']['name'])) {
        // all empty
        header("Location: details?key=" . $_GET['key'] . "&action=show");
        exit;
    }

    $comment = [];
    $comment['key'] = $_GET['key'] ?? '';

    if(!is_blank($_FILES['attachment']['name'])) {
        $fileNameNew = get_uid() . '.' . pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['attachment']['tmp_name'], 'files/' . $fileNameNew);
        $comment['attachment_filename'] = $fileNameNew;
    }

    if(!is_blank(trim($_POST['comment']))) {
        $comment['comment'] = trim($_POST['comment']) ?? '';
    }

    $result = insert_comment($comment);
    if($result === true) {
        header("Location: details?key=" . $_GET['key'] . "&action=show");
        exit();
    } else {
        $errors = $result;
        echo display_validation_errors($errors);
?>

        <?php require ('../private/subs_request/details_get_showcomnewfrm.php'); ?>
<!--				<form action="<?php /*echo 'details?key=' . $key . '&action=comnew'; */?>" method="post">
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
-->
<?php
				}
?>