				<a href="index"><?php echo $_SESSION['copy']['cancel']; ?>&nbsp;&raquo;</a>

				<form action="<?php echo 'details?action=new'; ?>" method="post">
					<dl>
						<dt><?php echo $_SESSION['copy']['ticket']; ?></dt>
						<dd>(<?php echo $_SESSION['copy']['newLc']; ?>)</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['description']; ?></dt>
						<dd>
							<textarea name="description" rows="1" cols="60"></textarea>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['requester']; ?></dt>
						<dd>
							<select name="source">
								<?php
									$user_set = find_all_active_userkeys();
									while($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if(h($user['kp_user']) == $_SESSION['kp_user']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>>
						<dt><?php echo $_SESSION['copy']['system']; ?></dt>
						<dd>
							<select name="entity">
								<?php
									$selection_set = find_selections_by_list('entity');
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if(h($selection['flg_default']) == 1) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
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
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if(h($selection['flg_default']) == 1) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
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
                                while($selection = mysqli_fetch_assoc($selection_set)) { ?>
                                    <option value="<?php echo h($selection['kp_selection']); ?>"<?php if(h($selection['flg_default']) == 1) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
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
									while($user = mysqli_fetch_assoc($user_set)) { ?>
								<option value="<?php echo h($user['kp_user']); ?>"<?php if(h($user['kp_user']) == $_SESSION['kp_user']) { echo ' selected'; } ?>><?php echo h($user['name_abbr']); ?></option>
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
									while($selection = mysqli_fetch_assoc($selection_set)) { ?>
								<option value="<?php echo h($selection['kp_selection']); ?>"<?php if(h($selection['flg_default']) == 1) { echo ' selected'; } ?>><?php echo h($selection['text']); ?></option>
								<?php } ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['details']; ?></dt>
						<dd>
							<textarea name="note" rows="5" cols="60"></textarea>
						</dd>
					</dl>
					<div style="display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
						<input type="submit" value="<?php echo $_SESSION['copy']['save']; ?>" />
					</div>

				</form>

<?php ?>