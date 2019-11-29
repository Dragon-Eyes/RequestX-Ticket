<?php
			$key = $_GET['key'];
?>

				<a href="<?php echo 'details?key=' . $key . '&action=show'; ?>"><?php echo $_SESSION['copy']['cancel']; ?>&nbsp;&raquo;</a>

				<?php
					if (!empty($errors)) {
						echo display_validation_errors($errors);
					} else {
						$request = find_request_by_kp($key);
					}
				?>

				<form action="<?php echo 'details?key=' . $key . '&action=edit'; ?>" method="post">
					<dl>
						<dt><?php echo $_SESSION['copy']['ticket']; ?></dt>
						<dd><?php echo $key; ?></dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['description']; ?></dt>
						<dd>
							<textarea name="description" rows="1" cols="60"><?php echo h($request['description']); ?></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['requester']; ?></dt>
						<dd>
							<select name="source">
								<?php
									$user_set = find_all_active_userkeys();
									while ($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if (h($user['kp_user']) == $request['source']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl<?php if (!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>>
						<dt><?php echo $_SESSION['copy']['system']; ?></dt>
						<dd>
							<select name="entity">
								<?php
									$selection_set = find_selections_by_list('entity');
									while ($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if ($request['entity'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['category']; ?></dt>
						<dd>
							<select name="category" size="4">
								<?php
									$selection_set = find_selections_by_list('category');
									while ($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if ($request['category'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
                    <dl>
                        <dt><?php echo $_SESSION['copy']['priority']; ?></dt>
                        <dd>
                            <select name="priority" size="3">
                                <?php
                                $selection_set = find_selections_by_list('priority');
                                while ($selection = mysqli_fetch_assoc($selection_set)) { ?>
                                    <option value="<?php echo h($selection['kp_selection']); ?>"<?php if ($request['priority'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['responsible']; ?></dt>
						<dd>
							<select name="responsible">
								<?php
									$user_set = find_all_active_userkeys();
									while ($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if (h($user['kp_user']) == $request['responsible']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['status']; ?></dt>
						<dd>
							<select name="status" size="5">
 								<?php
									$selection_set = find_selections_by_list('status');
									while ($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if ($request['status'] == $selection['kp_selection']) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['details']; ?></dt>
						<dd>
							<textarea name="note" rows="5" cols="60"><?php echo h($request['note']); ?></textarea>
						</dd>
					</dl>
                    <dl>
                        <dt><?php echo $_SESSION['copy']['followers']; ?></dt>
                        <dd>
                            <?php $user_set = find_all_active_usernames(); ?>
                            <select name="followers[]" multiple size="<?php echo mysqli_num_rows($user_set) ?>">
                                <?php
                                while ($user = mysqli_fetch_assoc($user_set)) { ?>
                                    <option value="<?php echo h($user['kp_user']); ?>"<?php if(in_array(h($user['kp_user']), $request['followers'])) { echo ' selected'; } ?>><?php echo h($user['name_user']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="<?php echo $_SESSION['copy']['save']; ?>" />
					</div>

				</form>

				<?php
?>