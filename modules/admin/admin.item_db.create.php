<?php
if ( !isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99 ) 
	exit;

if (isset($_POST['opt']))
{
	if (basename($_FILES['files']['name']) === 'item_db.txt' || basename($_FILES['files']['name']) === 'idnum2itemdesctable.txt')
		move_uploaded_file($_FILES['files']['tmp_name'], './db/'.basename($_FILES['files']['name']));
	else 
		echo basename($_FILES['files']['name']) .' isnt a valid file';
}
$steps = 0;
?>

	<div class="row" id="ladder_div">
		<div class="col-lg-12 col-lg-center">
			<h4 class="oboro_h4"><i class="fa fa-flask" aria-hidden="true"></i> Create Your own Item DB</h4>

			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT">
				<thead>
					<tr>
						<th>Follow the steps</th>
						<th>Action</th>
						<th>Exist ?</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan="3">Warning, once you upload a db it will override if other exists: upload_max_filesize on PHP have to be set to 3M ></th>
					<tr>
						<td>1. Upload your item_db.txt</td>
						<td>
							<form method="POST" enctype="multipart/form-data" action="?admin.item_db.create">
								<input type="hidden" name="opt" value="1">
								<div class="btn-group" role="group" aria-label="...">
									<span class="btn btn-default btn-file">
										Browse... <input type="file" accept=".txt"  name="files">
									</span>
									<input type="submit" class="btn btn-primary" value="Upload File">
								</div>
							</form>
						</td>
						<td>
							<?php
								if (file_exists('./db/item_db.txt'))
								{
									echo '<i class="fa fa-check green" aria-hidden="true"></i>';
									$steps++;
								} else
									  echo '<i class="fa fa-times red" aria-hidden="true"></i>';
							?>
						</td>
					</tr>
					<tr>
						<td>2. Upload your idnum2itemdesctable.txt</td>
						<td>							
							<form method="POST" enctype="multipart/form-data" action="?admin.item_db.create">
								<input type="hidden" name="opt" value="1">
								<div class="btn-group" role="group" aria-label="...">
									<span class="btn btn-default btn-file">
										Browse... <input type="file" accept=".txt"  name="files">
									</span>
									<input type="submit" class="btn btn-primary" value="Upload File">
								</div>
							</form>
						</td>
						<td>
							<?php
								if ( file_exists('./db/idnum2itemdesctable.txt'))
								{
									echo '<i class="fa fa-check green" aria-hidden="true"></i>';
									$steps++;
								} else
									echo '<i class="fa fa-times red" aria-hidden="true"></i>';
							?>
						</td>
					</tr>
					<tr>
						<td>3. Convert item_db.txt into SQL</td>
						<td>
							<form class="OBOROBACKWORK">
								<input type="hidden" name="OPT" value="CONVERT_ITEM_DB">
								<input type="submit" class="btn btn-primary" value="Convert Now">
							</form>
						</td>
						<td>
							<?php
							if ( file_exists('./db/item_db.sql') || $steps == 2 )
								echo '<i class="fa fa-check green" aria-hidden="true"></i>';
							else
								echo '<i class="fa fa-times red" aria-hidden="true"></i>';
							?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>