<?php
$data = $CACHE->get('MVPCard', FALSE, 1440);
$total = array();
if (!$data )
{
	$total = array();
	foreach( $GV->Global_MVPCard as $val )
	{

		$consult = 
		"
			SELECT 
				SUM(`INVENTARIO`+`CARRO`+`ALMACEN`+`RENTAALMACEN`+`GUILDSTORAGE`) AS `total` 
				FROM ( 
					SELECT (
						SELECT IFNULL(SUM(`amount`),0) 
						FROM `inventory` 
						WHERE `nameid` = ? OR `card1` = ?
					) AS `INVENTARIO`, 
					(
						SELECT IFNULL(SUM(`amount`),0) 
						FROM `cart_inventory` 
						WHERE `nameid` = ? OR `card1` = ?
					) AS `CARRO`, 
					(
						SELECT IFNULL(SUM(`amount`),0) 
						FROM `storage` 
						WHERE `nameid` = ? OR `card1` = ?
					) AS `ALMACEN`, 
					(
						SELECT IFNULL(SUM(`amount`),0) 
						FROM `rentstorage` 
						WHERE `nameid` = ? OR `card1` = ?
					) AS `RENTAALMACEN`, 
					(
						SELECT IFNULL(SUM(`amount`),0) 
						FROM `guild_storage` 
						WHERE `nameid` = ? OR `card1` = ?
					) AS `GUILDSTORAGE`) 
				AS T 
		";
		$filled_array = array_fill(0,10, $val[0]);
		$result = $DB->execute($consult, $filled_array);
		$row = $result->fetch();
		$DB->free($result);
		array_push($total, [
			'id'	=>	$val[0], 
			'total'	=>	$row['total']
		]);
	}
	$CACHE->put('MVPCard', $total);
	$data = $CACHE->get('MVPCard', FALSE, 1440);
}

echo '
	<div class="row">
		<h4 class="oboro_h4"><i class="fa fa-bar-chart fa-2x" style="vertical-align: middle;"> </i> <span> MVP cards in the server</span></h4>
		<div class="text-align-center">This information updates once at day</div>
		
';
foreach($data as $arr)
{
	echo "
		<div class='col-lg-2'>
			<img class='oboro_mvpimg' src=\"./images/mvpcards/".$arr["id"].".jpg\">
			<div><b>Cuantity</b>: ".$arr["total"]." Cards</div>
		</div>
	";
}
echo "</div>";
?>