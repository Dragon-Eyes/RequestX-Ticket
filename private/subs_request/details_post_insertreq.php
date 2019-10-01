				<a href="index">Abbrechen&nbsp;&raquo;</a>
<?php

			$request = [];
			$request['description'] = $_POST['description'] ?? '';
			$request['source'] = $_POST['source'] ?? '';
			$request['entity'] = $_POST['entity'] ?? '';
			$request['category'] = $_POST['category'] ?? '';
            $request['priority'] = $_POST['priority'] ?? '';
			$request['responsible'] = $_POST['responsible'] ?? '';
			$request['status'] = $_POST['status'] ?? '';
			$request['note'] = $_POST['note'] ?? '';


				$result = insert_request($request);
				if($result === true) {
					$new_key = mysqli_insert_id($db);
					if(FEATURE_NOTIFICATIONS) {
                        // send mail
                        $user = find_user_by_kp($_POST['responsible']);
                        if(FEATURE_MESSAGESERVICE) {
					        $mail = new Mail();
					        $mail->recipient = $user['email'];
					        $mail->subject = "Neues Ticket [" . SUBDOMAIN . " " . $new_key . "]";
					        $mail->body = $request['description'] . "\nhttps://" . SUBDOMAIN . ".requestx.ch/details?key=" . $new_key . "&action=show";
					        $mail->send();
                        } else {
                            //                    $to = SUPPORT_EMAIL;
                            $to = $user['email'];
                            $subject = "Neues Ticket [" . SUBDOMAIN . " " . $new_key . "]";
                            $message = $request['description'] . "\nhttps://" . SUBDOMAIN . ".requestx.ch/details?key=" . $new_key . "&action=show";
                            // $headers = "From: Request X <benachrichtigung@requestx.ch>\r\n";
                            $headers = 'From: Request X <benachrichtigung@requestx.ch>' . "\r\n";
                            if (DEBUG_MODE) {
                                // $headers .= 'Bcc: christoph@dragoneyes.org' . "\r\n";
                            }
                            mail($to, $subject, $message, $headers);
                        }
                    }
                    header("Location: details?key=" . $new_key . "&action=show");
					exit;
				} else {
					$errors = $result;
					echo display_validation_errors($errors);
                
                
?>
                
				<form action="<?php echo 'details?action=new'; ?>" method="post">
					<dl>
						<dt>Ticket</dt>
						<dd>(neu)</dd>
					</dl>
					<dl>
						<dt>Beschreibung</dt>
						<dd>
							<textarea name="description" rows="1" cols="60"><?php echo h($request['description']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt>Anforderung</dt>
						<dd>
							<select name="source">
								<?php
									$user_set = find_all_active_userkeys();
									while($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if(h($user['kp_user']) == $request['source']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>>
						<dt>System</dt>
						<dd>
							<select name="entity">
								<?php
									$selection_set = find_selections_by_list('entity');
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if($request['entity'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>Kategorie</dt>
						<dd>
							<select name="category" size="6">
								<?php
									$selection_set = find_selections_by_list('category');
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if($request['category'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
                    <dl>
                        <dt>Priorität</dt>
                        <dd>
                            <select name="priority" size="3">
                                <?php
                                $selection_set = find_selections_by_list('priority');
                                while($selection = mysqli_fetch_assoc($selection_set)) { ?>
                                    <option value="<?php echo h($selection['kp_selection']); ?>"<?php if($request['priority'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
					<dl>
						<dt>Umsetzung</dt>
						<dd>
							<select name="responsible">
								<?php
									$user_set = find_all_active_userkeys();
									while($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if(h($user['kp_user']) == $request['responsible']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>Status</dt>
						<dd>
							<select name="status" size="4">
 								<?php
									$selection_set = find_selections_by_list('status');
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if($request['status'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>Details /<br>Kommentar</dt>
						<dd>
							<textarea name="note" rows="5" cols="60"><?php echo h($request['note']); ?></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="Speichern" />
					</div>

				</form>

				<?php

                
                
                
                
				}

?>