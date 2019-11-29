			<?php
				$key = $_GET['key'];
            $request = find_request_by_kp($key);
            // $request['followers'] = get_as_array($request['followers']);

//            echo '<pre>';
//            print_r($request);
//            echo '</pre>';

            // TODO: show checkbox-set for all users
            // TODO: update function for followers

            ?>
	
				<a href="index"><?php echo $_SESSION['copy']['listShow']; ?>&nbsp;&raquo;</a><br>
            <?php // TODO: create root constants ?>
				<a href="<?php echo 'details?key=' . $key . '&action=edit'; ?>"><?php echo $_SESSION['copy']['edit']; ?>&nbsp;&raquo;</a>

			<?php
				if(isset($_SESSION['message'])) {
			      echo "<p>" . $_SESSION['message'] . "</p>";
			      unset($_SESSION['message']);
			   }
			?>

				<form>
					<dl>
						<dt><?php echo $_SESSION['copy']['ticket']; ?></dt>
						<dd><?php echo h($request['kp_request']); ?></dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['description']; ?></dt>
						<dd>
							<?php echo h($request['description']); ?>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['requester']; ?></dt>
						<dd>
							<?php echo find_userabbr_by_kp(h($request['source'])); ?>
						</dd>
					</dl>
					<dl<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>>
						<dt><?php echo $_SESSION['copy']['system']; ?></dt>
						<dd>
							<?php echo find_selectiontext_by_kp(h($request['entity'])); ?>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['category']; ?></dt>
						<dd>
							<?php echo find_selectiontext_by_key(h($request['category'])); ?>
						</dd>
					</dl>
                    <dl>
                        <dt><?php echo $_SESSION['copy']['priority']; ?></dt>
                        <dd>
                            <?php echo find_selectiontext_by_key(h($request['priority'])); ?>
                        </dd>
                    </dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['responsible']; ?></dt>
						<dd>
							<?php echo find_userabbr_by_kp(h($request['responsible'])); ?>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['status']; ?></dt>
						<dd>
							<?php echo find_selectiontext_by_key(h($request['status'])); ?>
						</dd>
					</dl>
					<dl>
						<dt><?php echo $_SESSION['copy']['details']; ?></dt>
						<dd style="max-width: 700px;">
							<?php // echo h($request['note']); ?>
							<?php echo nl2br(h($request['note'])); ?>
						</dd>
					</dl>
                    <dl>
                        <dt><?php echo $_SESSION['copy']['followers']; ?></dt>
                        <?php // print_r($request['followers']); ?>
                        <?php $followernames = get_followersNames_by_followerKeys($request['followers']); ?>
                        <dd>
                            <?php echo h($followernames); ?>
                        </dd>
                    </dl>
				</form>


            <footer style="font-size: 0.75em; display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
                <?php echo $_SESSION['copy']['created']; ?>: <?php echo find_userabbr_by_kp(h($request['utl_creation_user_kp'])); ?> (<?php echo h($request['utl_creation_ts']); ?>)
					<?php if(isset($request['utl_modification_user_kp'])){
						echo ' || ' . $_SESSION['copy']['modified'] . ': ' . find_userabbr_by_kp(h($request['utl_modification_user_kp'])) . ' (' . h($request['utl_modification_ts']) . ')';
					} ?>
				</footer>