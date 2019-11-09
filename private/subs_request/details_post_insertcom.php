				<p><a href="<?php echo 'details?key=' . $_GET['key'] . '&action=show'; ?>">Abbrechen&nbsp;&raquo;</a></p>

<?php

    if(is_blank(trim($_POST['comment'])) && is_blank($_FILES['attachment']['name'])) {
        // all empty
        header("Location: details?key=" . $_GET['key'] . "&action=show");
        exit;
    }

    $comment = [];
    $comment['key'] = $_GET['key'] ?? '';

                            // echo '<pre>';
					        // print_r($_POST);
					        // echo '</pre>';
					        // exit();



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

        // alert all followers except the current user
        if(FEATURE_NOTIFICATIONS) {
            // send mail
            // $user = find_user_by_kp($_POST['responsible']);
            $sender = find_user_by_kp($_SESSION['kp_user']);

            $recipientArray = explode(',', $_POST['followers']);
//                            echo '<pre>';
//					        print_r($recipientArray);
//					        echo '</pre>';

//					        echo $_SESSION['kp_user'] . '<br>';
					        // echo array_search($_SESSION['kp_user'], $recipientArray);

					        // unset($recipientArray[array_search($_SESSION['kp_user'], $recipientArray)]);

            $recipientArray = array_diff($recipientArray, [$_SESSION['kp_user']]);


//            $recipientArray = array_splice($recipientArray, 1, 1);
//            echo '<pre>';
//            print_r($recipientArray);
//            echo '</pre>';

//            print_r(count($recipientArray));

            $recipients = '';
            if (count($recipientArray)) {
                foreach ($recipientArray as $recipient) {
                    $user = find_user_by_kp($recipient);
                    // $mailaddress =
                    $recipients .= $user['email'] . ', ';
                }
                $recipients = substr($recipients, 0, strlen($recipients) - 2);


                if(FEATURE_MESSAGESERVICE) {
                    $mail = new Mail();
                    $mail->recipient = $recipients;
                    $mail->replyto = $sender['email'];
                    $mail->subject = "Neuer Kommentar [" . SUBDOMAIN . " " . $comment['key'] . "]";
                    $mail->body = htmlspecialchars($comment['comment']) . "\n\nhttps://" . SUBDOMAIN . ".requestx.ch/details?key=" . $comment['key'] . "&action=show";

//					        echo '<pre>';
//					        print_r($mail);
//					        echo '</pre>';
//					        exit();


                    $mail->send();
                }





            }

            // echo '<p>' . $recipients . '</p>';

            // exit();


        }


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

