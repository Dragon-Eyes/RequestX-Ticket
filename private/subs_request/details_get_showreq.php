			<?php
				$key = $_GET['key'];
            $request = find_request_by_kp($key);
            $request['followers'] = get_as_array($request['followers']);

//            echo '<pre>';
//            print_r($request);
//            echo '</pre>';

            // TODO: show checkbox-set for all users
            // TODO: update function for followers

            ?>
	
				<a href="index">Liste&nbsp;&raquo;</a><br>
            <?php // TODO: create root constants ?>
				<a href="<?php echo 'details?key=' . $key . '&action=edit'; ?>">Bearbeiten&nbsp;&raquo;</a>

			<?php
				if(isset($_SESSION['message'])) {
			      echo "<p>" . $_SESSION['message'] . "</p>";
			      unset($_SESSION['message']);
			   }
			?>

				<form>
					<dl>
						<dt>Ticket</dt>
						<dd><?php echo h($request['kp_request']); ?></dd>
					</dl>
					<dl>
						<dt>Beschreibung</dt>
						<dd>
							<?php echo h($request['description']); ?>
						</dd>
					</dl>
					<dl>
						<dt>Anforderung</dt>
						<dd>
							<?php echo find_userabbr_by_kp(h($request['source'])); ?>
						</dd>
					</dl>
					<dl<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>>
						<dt>System</dt>
						<dd>
							<?php echo find_selectiontext_by_kp(h($request['entity'])); ?>
						</dd>
					</dl>
					<dl>
						<dt>Kategorie</dt>
						<dd>
							<?php echo find_selectiontext_by_kp(h($request['category'])); ?>
						</dd>
					</dl>
                    <dl>
                        <dt>Priorität</dt>
                        <dd>
                            <?php echo find_selectiontext_by_kp(h($request['priority'])); ?>
                        </dd>
                    </dl>
					<dl>
						<dt>Umsetzung</dt>
						<dd>
							<?php echo find_userabbr_by_kp(h($request['responsible'])); ?>
						</dd>
					</dl>
					<dl>
						<dt>Status</dt>
						<dd>
							<?php echo find_selectiontext_by_kp(h($request['status'])); ?>
						</dd>
					</dl>
					<dl>
						<dt>Details /<br>Kommentar</dt>
						<dd style="max-width: 700px;">
							<?php // echo h($request['note']); ?>
							<?php echo nl2br(h($request['note'])); ?>
						</dd>
					</dl>
				</form>


            <footer style="font-size: 0.75em; display: block; clear: left; padding: 30px 0 0 165px;" id="operations">
					Angelegt: <?php echo find_userabbr_by_kp(h($request['utl_creation_user_kp'])); ?> (<?php echo h($request['utl_creation_ts']); ?>)
					<?php if(isset($request['utl_modification_user_kp'])){
						echo ' || Zuletzt geändert: ' . find_userabbr_by_kp(h($request['utl_modification_user_kp'])) . ' (' . h($request['utl_modification_ts']) . ')';
					} ?>
				</footer>