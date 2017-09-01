<?php
if (!isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99)
	exit;
?>

<div class="row">
	<h4 class="oboro_h4"><i class="fa fa-line-chart fa-2x" style="vertical-align: middle;"> </i> <span>Picklog Management</span></h4>
	<table class="table width_100 oboro_table">
		<tr>
			<td>
				<form id="OBORO_NORMALIZED">
					<input type="text" class="form-control inline_block" name="name" maxlength="24" size="24" placeholder="Search with Char name">
					<input type="text" class="form-control inline_block" name="account_id" placeholder="Search with account id">
					<input type="text" class="form-control inline_block" name="item_id" placeholder="Search with Item id">
					<input type="text" class="form-control inline_block" name="map" placeholder="Search with Map Name">
					<input type="hidden" name="opt" value="001">
					<input type="hidden" name="rank" value="admin.picklog">
					<input type="submit" class="btn btn-primary inline_block" value="Search">
				</form>
			</td>
		</tr>
	</table>
</div>

<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
<thead>
	<tr>
		<th>Date</th>
		<th>Account Id</th>
		<th>Char Id</th>
		<th>Name</th>
		<th>Type</th>
		<th>Item Id</th>
		<th>Amount</th>
		<th>Refine</th>
		<th>Card 0</th>
		<th>Card 1</th>
		<th>Card 2</th>
		<th>Card 3</th>
		<th>Map</th>
	</tr>
</thead>
<tbody>
	</tbody></table>
<?php
	$consult = 
	"
		SELECT 
			`time`, `account_id`, `char_id`, `name`, `type`, `nameid`, `amount`, `refine`, `card0`,`card1`,`card2`,`card3`,`map`
		FROM
			`picklog`
		WHERE
			1=1
	";
	
	if ($NRM->getParam(1))
	{
	 	$consult .= " AND `name`=?";
		$param = [$NRM->getParam(1)];
	}
	
	if ($NRM->getParam(2))
	{
		$consult .= " AND `account_id`=?";
		array_push($param, $NRM->getParam(2));
	}

	if ($NRM->getParam(3))
	{
		$consult .= " AND `nameid`=?";
		array_push($param, $NRM->getParam(3));
	}

	if ($NRM->getParam(4))
	{
		$consult .= " AND `map`=?";
		array_push($param, $NRM->getParam(4));
	}

$consult .= " AND `map`=?";

	$result = $DB->execute($consult, $param);
?>
