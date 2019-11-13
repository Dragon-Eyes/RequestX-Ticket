<?php

   /**
    * @author Christoph <christoph@dragoneyes.org> 2019-02-21
    * @change 
    *
    * @todo ensure injection prevention
    */

    require_once ('../private/initialize.php');
    require_login();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RequestX - <?php echo PROJECT; ?></title>
    <link rel="canonical" href="https://<?php echo SUBDOMAIN; ?>.requestx.ch">
	<link rel="stylesheet" href="styles/requestx.css">

    <link rel="shortcut icon" href="/assets/ReqX_Ticket.ico?v=1.0">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/assets/ReqX_Ticket.ico?v=1.0">
    <link rel="icon" type="image/png" sizes="196x196" href="/assets/ReqX_Ticket-192.png?v=1.0">
    <link rel="icon" type="image/png" sizes="160x160" href="/assets/ReqX_Ticket-160.png?v=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/ReqX_Ticket-96.png?v=1.0">
    <link rel="icon" type="image/png" sizes="64x64" href="/assets/ReqX_Ticket-64.png?v=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/ReqX_Ticket-32.png?v=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/ReqX_Ticket-16.png?v=1.0">
    <link rel="apple-touch-icon" href="/assets/ReqX_Ticket-57.png?v=1.0">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/ReqX_Ticket-114.png?v=1.0">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/ReqX_Ticket-72.png?v=1.0">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/ReqX_Ticket-144.png?v=1.0">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/ReqX_Ticket-60.png?v=1.0">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/ReqX_Ticket-120.png?v=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/ReqX_Ticket-76.png?v=1.0">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/ReqX_Ticket-152.png?v=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/ReqX_Ticket-180.png?v=1.0">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/assets/ReqX_Ticket-144.png?v=1.0">

</head>
<body>

    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // set filter array in session
            if ($_POST['statusWarten']) {
                $_SESSION['filter_requeststatus'][1] = true;
            } else {
                $_SESSION['filter_requeststatus'][1] = false;
            }
            if ($_POST['statusOffen']) {
                $_SESSION['filter_requeststatus'][2] = true;
            } else {
                $_SESSION['filter_requeststatus'][2] = false;
            }
            if ($_POST['statusInarbeit']) {
                $_SESSION['filter_requeststatus'][3] = true;
            } else {
                $_SESSION['filter_requeststatus'][3] = false;
            }
            if ($_POST['statusErledigt']) {
                $_SESSION['filter_requeststatus'][4] = true;
            } else {
                $_SESSION['filter_requeststatus'][4] = false;
            }
            if ($_POST['statusGeloescht']) {
                $_SESSION['filter_requeststatus'][28] = true;
            } else {
                $_SESSION['filter_requeststatus'][28] = false;
            }
        }
    ?>

    <div class="headerrow">
        <div>
            <p class="headerelement"><?php echo $_SESSION['copy']['user']; ?>: <?php echo $_SESSION['name_user'] ?></p>
            <p id="filterbutton" style="display: inherit" onclick="showFilter()"><?php echo $_SESSION['copy']['filter']; ?>&nbsp;&raquo;</p>
            <form id="filterdetails" style="display: none;" action="index" method="post">Status:
                <input type="checkbox" name="statusWarten" value="1" <?php if($_SESSION['filter_requeststatus'][1]) {echo 'checked';} ?>> warten
                <input type="checkbox" name="statusOffen" value="1" <?php if($_SESSION['filter_requeststatus'][2]) {echo 'checked';} ?>> offen
                <input type="checkbox" name="statusInarbeit" value="1" <?php if($_SESSION['filter_requeststatus'][3]) {echo 'checked';} ?>> in Arbeit
                <input type="checkbox" name="statusErledigt" value="1" <?php if($_SESSION['filter_requeststatus'][4]) {echo 'checked';} ?>> erledigt
                <input type="checkbox" name="statusGeloescht" value="1" <?php if($_SESSION['filter_requeststatus'][28]) {echo 'checked';} ?>> gelöscht
                <input type="submit" value="filtern">
            </form>
            <p><a href="details?action=new"><?php echo $_SESSION['copy']['ticketNew']; ?>&nbsp;&plus;</a></p>
        </div>

        <div>
            <p style="text-align: right"><a href="https://<?php echo SUBDOMAIN; ?>.requestx.ch/logout"><?php echo $_SESSION['copy']['logout']; ?>&nbsp;&raquo;</a></p>
            <p><a href="users/index"><?php echo $_SESSION['copy']['usermanagement']; ?>&nbsp;&raquo;</a></p>
        </div>
    </div>

    <p id="title">Request X - <?php echo PROJECT; ?></p>


	<table id="reqtable">
		<tr>
			<th class="center" onClick="sortTableNumber(0)"><?php echo $_SESSION['copy']['ticket']; ?></th>
			<th onClick="sortTableText(1)"><?php echo $_SESSION['copy']['description']; ?></th>
			<th onClick="sortTableText(2)"><?php echo $_SESSION['copy']['requester']; ?></th>
			<th<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?> onClick="sortTableText(3)"><?php echo $_SESSION['copy']['system']; ?></th>
			<th class="hidden">KategoriePos</th>
			<th onClick="sortTableNumber(4)"><?php echo $_SESSION['copy']['category']; ?></th>
            <th class="hidden">PrioPos</th>
            <th onClick="sortTableNumber(6)"><?php echo $_SESSION['copy']['priority']; ?></th>
			<th onClick="sortTableText(8)"><?php echo $_SESSION['copy']['responsible']; ?></th>
			<th class="hidden">StatusPos</th>
			<th onClick="sortTableNumber(9)"><?php echo $_SESSION['copy']['status']; ?></th>
			<th onClick="sortTableText(11)"><?php echo $_SESSION['copy']['details']; ?></th>
		<!--	<th>&nbsp;</th> -->
		</tr>
		
		<?php
//			$request_set = find_all_requests();
            $request_set = find_requests_by_status();

			while($request = mysqli_fetch_assoc($request_set)) { ?>
				
				<tr>
					<td class="center"><?php echo $request['kp_request']; ?></td>
					<td><?php echo h($request['description']); ?></td>
					<td><?php echo find_userabbr_by_kp(h($request['source'])); ?></td>
					<td<?php if(!FEATURE_ENTITIES) {echo ' class="hidden"';} ?>><?php echo find_selectiontext_by_kp(h($request['entity'])); ?></td>
					<td class="hidden"><?php echo find_selectionposition_by_kp(h($request['category'])); ?></td>
					<td<?php if($request['status'] == 2 && $request['category'] == 5 && $request['priority'] == 32) {echo ' class="alarm"';} ?>><?php echo find_selectiontext_by_key(h($request['category'])); ?></td>
                    <td class="hidden"><?php echo find_selectionposition_by_kp(h($request['priority'])); ?></td>

                    <td
                        <?php if($request['status'] == 2 || $request['status'] == 3) {echo ' class="priority' . $request['priority'] . '"';} ?>
                    >
                        <?php echo find_selectiontext_by_key(h($request['priority'])); ?>
                    </td>

                    <td><?php echo find_userabbr_by_kp(h($request['responsible'])); ?></td>
					<td class="hidden"><?php echo find_selectionposition_by_kp(h($request['status'])); ?></td>
					<td<?php echo ' class="status' . $request['status'] . '"'; ?>><?php echo find_selectiontext_by_key(h($request['status']));?></td>
					<td><?php echo h($request['note']); ?></td>
					<td class="borderless"> <!-- TODO: introduce url_for function -->
						<a href="<?php echo 'details?key=' . h(u($request['kp_request'])) . '&action=show'; ?>"><?php echo $_SESSION['copy']['details']; ?>&nbsp;&raquo;</a>
					</td>
				</tr>

			<?php }
		
			mysqli_free_result($request_set); ?>
				
		
	</table>

	<script>

        function showFilter() {
            // hide button
            document.getElementById("filterbutton").style.display = "none";
            // show details
            document.getElementById("filterdetails").style.display = "block";
        }
	
		function sortTableText(n) {
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("reqtable");
			switching = true;
			// Set the sorting direction to ascending:
			dir = "asc";
			/* Make a loop that will continue until
			no switching has been done: */
			while (switching) {
				// Start by saying: no switching is done:
				switching = false;
				rows = table.rows;
				/* Loop through all table rows (except the
				first, which contains table headers): */
				for (i = 1; i < (rows.length - 1); i++) {
					// Start by saying there should be no switching:
					shouldSwitch = false;
					/* Get the two elements you want to compare,
					one from current row and one from the next: */
					x = rows[i].getElementsByTagName("TD")[n];
					y = rows[i + 1].getElementsByTagName("TD")[n];
					/* Check if the two rows should switch place,
					based on the direction, asc or desc: */
					if (dir == "asc") {
						if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					} else if (dir == "desc") {
						if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					}
				}
				if (shouldSwitch) {
					/* If a switch has been marked, make the switch
					and mark that a switch has been done: */
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					// Each time a switch is done, increase this count by 1:
					switchcount ++;
				} else {
					/* If no switching has been done AND the direction is "asc",
					set the direction to "desc" and run the while loop again. */
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}
	
		function sortTableNumber(n) {
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("reqtable");
			switching = true;
			// Set the sorting direction to ascending:
			dir = "asc";
			/* Make a loop that will continue until
			no switching has been done: */
			while (switching) {
				// Start by saying: no switching is done:
				switching = false;
				rows = table.rows;
				/* Loop through all table rows (except the
				first, which contains table headers): */
				for (i = 1; i < (rows.length - 1); i++) {
					// Start by saying there should be no switching:
					shouldSwitch = false;
					/* Get the two elements you want to compare,
					one from current row and one from the next: */
					x = rows[i].getElementsByTagName("TD")[n];
					y = rows[i + 1].getElementsByTagName("TD")[n];
					/* Check if the two rows should switch place,
					based on the direction, asc or desc: */
					if (dir == "asc") {
						if (Number(x.innerHTML) > Number(y.innerHTML)) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					} else if (dir == "desc") {
						if (Number(x.innerHTML) < Number(y.innerHTML)) {
							// If so, mark as a switch and break the loop:
							shouldSwitch = true;
							break;
						}
					}
				}
				if (shouldSwitch) {
					/* If a switch has been marked, make the switch
					and mark that a switch has been done: */
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					// Each time a switch is done, increase this count by 1:
					switchcount ++;
				} else {
					/* If no switching has been done AND the direction is "asc",
					set the direction to "desc" and run the while loop again. */
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}

	</script>
</body>
</html>