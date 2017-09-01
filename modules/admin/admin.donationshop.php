<?php
if (!isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99)
	exit;

$consult = "SELECT `dona`, `description` FROM `item_db` LIMIT 10";
$result = $DB->execute($consult);
$row = $result->fetch();
if (!$row)
{
	echo 'No presenta una Item DB disponible o v&aacute;lida para el correcto funcionamiento y configuraci&oacute;n de Oboro Control Panel (c), Puede hacer <a href="?admin.item_db.create">click aqu&iacute; para configurar una</a>';
	exit;
}
?>

<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4"><i class="fa fa-refresh" aria-hidden="true"></i> Create or Delete a New Donation Item</h4>
		<div class="row">
			<div class="col-lg-6 nopadding-left">
				<form class="OBOROBACKWORK">
					<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" style="text-align:center;">
						<thead>
							<tr>
								<th>Item Id.</th>
								<th style="width:150px;">Donation Points</th>
								<th>Update</th>
							</tr>
						</thead>
						<tbody>
							<tr id="get_row_donation_create">
								<td><input type="text" name="item_id" class="form-control" placeholder="New Donation item (item_id)"></td>
								<td>
									<div class="input-group">
										<input type="text" class="form-control" name="dona" value="00">
										<span class="input-group-addon">.00 DP</span>
									</div>
								</td>
								<td>
									<input name="OPT" type="hidden" value="CREATE_DONATION_ITEM">
									<input class="btn btn-primary" type="submit" value="Create New Item">
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="col-lg-6 nopadding-right">
				<form class="OBOROBACKWORK">
					<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" style="text-align:center;">
						<thead>
							<tr>
								<th>Item Id.</th>
								<th>Update</th>
							</tr>
						</thead>
						<tbody>
							<tr id="get_row_donation_create">
								<td><input type="text" name="item_id" class="form-control" placeholder="Item ID to be deleted from Donation Shop"></td>
								<td>
									<input name="OPT" type="hidden" value="DELETE_DONATION_ITEM">
									<input class="btn btn-danger" type="submit" value="Delete from Donation Shop">
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>

		<h4 class="oboro_h4"><i class="fa fa-cogs" aria-hidden="true"></i> Update Donation Items</h4>

		<div class="table-responsive">
			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" style="text-align:center;">
				<thead>
					<tr>
						<th>Item Id.</th>
						<th style="width:140px;">Name</th>
						<th>description (HTML Struct Needed)</th>
						<th style="width:135px;">Donation Points</th>
						<th>Picture</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>
					<?php
				$result = $DB->execute("SELECT `id`, `name_japanese`, `description`, `dona` FROM `item_db` WHERE `dona` > 0");
				while($row = $result->fetch())
				{
					echo 
					'
						<tr id="get_row_donation_'.$row['id'].'">
							<td>'.$row['id'].'</td>
							<td><input type="text" name="name" class="form-control" value="'.$row['name_japanese'].'"></td>
							<td><textarea class="form-control" name="description" rows="6" cols="40">'.html_entity_decode($row['description']).'</textarea></td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control" name="dona" value="'.$row['dona'].'">
									 <span class="input-group-addon">.00 DP</span>
								</div>
							</td>
							<td>
								<img src="./img/db/item_db/large/'.$row['id'].'.png" alt="No tiene"><br/>
								<label class="btn btn-default btn-file">
									<span>Browse</span> <input type="file" accept=".png" id="fileInput" name="files" style="display: none;">
								</label>
							</td>
							<td><input class="btn btn-success" id="get_btn_donation_'.$row['id'].'" type="button" value="Update"></td>
						</tr>
					';
				}
				$DB->free($result);
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>