<?php 
if ( !isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99 ) 
	exit;
?>


<div class="row">
	<div class="col-lg-12">
	<h4 class="oboro_h4">Admin Accounts</h4>
		<div class="table-responsive">
		<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
			<thead>
				<tr>
					<td>Options</td>
					<td>Account</td>
					<td>User ID</td>
					<td>Password</td>
					<td>E-Mail</td>
					<td>State</td>
					<td>Last IP</td>
					<td>Last Mac</td>
					<td>Allow DL BG</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $DB->execute("SELECT `account_id`, `userid`, `user_pass`, `email`, `state`, `last_ip`, `last_mac`, `BG_DLALLOW` FROM `login`");
					while($row = $result->fetch())
					{
						echo '
							<tr>
								<td><a href="?admin.account.edit-'.$row['account_id'].'" class="btn btn-primary">Edit</a></td>	
						';
							foreach ($row as $val)
								echo '<td>'.$val.'</td>';
						echo '</tr>';
					}
					$DB->free($result);
				?>
			</tbody>
		</table>
		</div>
	</div>
</div>