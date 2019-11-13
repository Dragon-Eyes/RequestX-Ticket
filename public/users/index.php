<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RequestX</title>
    <link rel="canonical" href="https://<?php echo SUBDOMAIN; ?>.requestx.ch/user">
	<link rel="stylesheet" href="../styles/requestx.css">
</head>
<body>
	<p><a href="../index">Tickets&nbsp;&raquo;</a></p>
	<p style="text-align: right"><a href="details?action=new"><?php echo $_SESSION['copy']['userNew']; ?>&nbsp;&plus;</a></p>

	<table>
		<tr>
			<th><?php echo $_SESSION['copy']['nameFirst']; ?></th>
			<th><?php echo $_SESSION['copy']['nameLast']; ?></th>
			<th><?php echo $_SESSION['copy']['nameAbbr']; ?></th>
			<th><?php echo $_SESSION['copy']['username']; ?></th>
			<th><?php echo $_SESSION['copy']['email']; ?></th>
			<th><?php echo $_SESSION['copy']['active']; ?></th>
			<th><?php echo $_SESSION['copy']['note']; ?></th>
		<!--	<th>&nbsp;</th> -->
		</tr>
		
		<?php
			$user_set = find_all_users();
		
			while($user = mysqli_fetch_assoc($user_set)) { ?>
				
				<tr>
					<td><?php echo h($user['name_first']); ?></td>
					<td><?php echo h($user['name_last']); ?></td>
					<td><?php echo h($user['name_abbr']); ?></td>
					<td><?php echo h($user['name_user']); ?></td>
					<td><?php echo h($user['email']); ?></td>
					<td><?php echo h($user['flg_active']); ?></td>
					<td><?php echo h($user['note']); ?></td>
					<td class="borderless"> <!-- TODO: introduce url_for function -->
						<a href="<?php echo 'details?key=' . h(u($user['kp_user'])) . '&action=edit'; ?>"><?php echo $_SESSION['copy']['edit']; ?>&nbsp;&raquo;</a>
					</td>
				</tr>

			<?php }

			mysqli_free_result($user_set); ?>

		
	</table>

<!--    <blockquote>-->
<!--        <a href="../api/index">Rest API &nbsp;&raquo;</a>-->
<!--    </blockquote>-->

</body>
</html>