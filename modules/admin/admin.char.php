<?php 
if (!isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99) 
	exit;
?>


<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4">Admin Char's</h4>
		<div class="table-responsive">
			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
				<thead>
					<tr>
						<td>Options</td>
						<td>Account</td>
						<td>User Name</td>
						<td>Char ID</td>
						<td>Char Name</td>
						<td>Class</td>
						<td>Play Time</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$result = $DB->execute("SELECT `char`.`account_id`,`login`.`userid`,`char`.`char_id`,	`char`.`name`, `char`.`class`, `char`.`playtime` FROM `char`INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`");
					while($row = $result->fetch())
					{
						echo '
							<tr>
								<td><a href="?admin.char.edit-'.$row['char_id'].'" class="btn btn-primary">Edit</a></td>	
						';
						foreach ($row as $val)
							echo '<td>'.$val.'</td>';
						echo '</tr>';
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>