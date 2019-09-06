	<table>

		<?php

			$comment_set = find_comments_by_requestkp($key);
		
			while($comment = mysqli_fetch_assoc($comment_set)) { ?>
				
				<tr>
					<td><?php echo find_userabbr_by_kp(h($comment['utl_creation_user_kp'])); ?></td>
					<td><?php echo nl2br(h($comment['comment'])); ?></td>
				</tr>

			<?php }

		?>
	</table>	