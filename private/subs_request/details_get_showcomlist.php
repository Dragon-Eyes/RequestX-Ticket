	<table>

		<?php

			$comment_set = find_comments_by_requestkp($key);
		
			while($comment = mysqli_fetch_assoc($comment_set)) { ?>
                <?php if(!is_blank($comment['comment'])) { ?>
                    <tr>
                        <td><?php echo find_userabbr_by_kp(h($comment['utl_creation_user_kp'])); ?></td>
                        <td><?php echo nl2br(h($comment['comment'])); ?></td>
                    </tr>
                <?php } ?>
                <?php if(!is_blank($comment['attachment_filename']) && FEATURE_ATTACHMENTS) { ?>
                    <tr>
                        <td><?php echo find_userabbr_by_kp(h($comment['utl_creation_user_kp'])); ?></td>
                        <td><img class="attachment" src="files/<?php echo h($comment['attachment_filename']); ?>"><?php /*echo '<pre>'; echo getimagesize('files/' . $comment['attachment_filename'])[0]; echo '</pre>'; */?></td>
                    </tr>
                <?php } ?>

            <?php }

		?>
	</table>	