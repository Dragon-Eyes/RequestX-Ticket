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

    $commenttext = trim($_POST['comment']);

    if (!is_blank($commenttext)) {
        // checks no email body
        if (strpos($commenttext, '%%noemailbody%%') !== false) {
            $noemailbody = true;
            $commenttext = str_replace('%%noemailbody%%', '', $commenttext);
        }
        // checks no email reply
        if (strpos($commenttext, '%%noemailreply%%') !== false) {
            $noemailreply = true;
            $commenttext = str_replace('%%noemailreply%%', '', $commenttext);
        }
        // checks silent instruction
        if (strpos($commenttext, '%%silent%%') !== false) {
            $silent = true;
            $commenttext = str_replace('%%silent%%', '', $commenttext);
        }
        $comment['comment'] = $commenttext ?? '';
    }

    $result = insert_comment($comment);
    if ($result === true) {
        if ($silent) {
            $_SESSION['message'] = 'Es wurde keine Benachrichtigung verschickt.';
        } else {
            // alert all followers except the current user
            if (FEATURE_NOTIFICATIONS) {
                // $user = find_user_by_kp($_POST['responsible']);
                $sender = find_user_by_kp($_SESSION['kp_user']);

                $recipientArray = explode(',', $_POST['followers']);
                $recipientArray = array_diff($recipientArray, [$_SESSION['kp_user']]);
                $recipients = '';
                if (count($recipientArray)) {
                    foreach ($recipientArray as $recipient) {
                        $user = find_user_by_kp($recipient);
                        // $mailaddress =
                        $recipients .= $user['email'] . ', ';
                    }
                    $recipients = substr($recipients, 0, strlen($recipients) - 2);

                    if (FEATURE_MESSAGESERVICE) {
                        $mail = new Mail();
                        $mail->recipient = $recipients;
                        $mail->replyto = $noemailreply ? 'noemailreply@requestx.ch' : $sender['email'];
                        $mail->subject = "Neuer Kommentar [" . SUBDOMAIN . " " . $comment['key'] . "]";
                        if($noemailbody) {
                            $mail->body = "https://" . SUBDOMAIN . ".requestx.ch/details?key=" . $comment['key'] . "&action=show";
                        } else {
                            $mail->body = htmlspecialchars($comment['comment']) . "\n\nhttps://" . SUBDOMAIN . ".requestx.ch/details?key=" . $comment['key'] . "&action=show";
                        }
                        $mail->send();
                    }
                }
            }
        }
        header("Location: details?key=" . $_GET['key'] . "&action=show");
        exit();
    } else {
        $errors = $result;
        echo display_validation_errors($errors);


        require ('../private/subs_request/details_get_showcomnewfrm.php');
				}
    ?>

