<?php
$ITEM_TRANSFER_GUILD = array(
	2357,3,2421,1,2375,1,2433,4,2374,2,
	2702,1,2423,1,5451,2,5518,2,2554,4,
	1228,2,5293,3,5225,4,30161,1,5409,
	1,4429,2
);

$ITEM_TRANSFER_PERSONAL = array(
	2115,1,5170,1,2424,1,2528,1,2202,1,
	2701,2,4334,1,4133,1,4064,2,4044,1,
	4141,1,4105,1,4381,1,4097,1,4058,1,
	4045,1,4439,1,7828,500,7829,500,
	2624,2, 14545,5
);

?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4"><i class="fa fa-users fa-2x" style="vertical-align: middle;"> </i> <span>Guild Pack +26</span></h4>
		<ul>
			<li> Click el nombre del item para ver la desciprci&oacute;n del mismo(beta)</li>
			<li> El GP no est&aacute; escrito en roca a&uacute;n puede tener variaciones en las siguientes horas </li>
			<li> El GP fue pensado en todo momento para un mid rates balanceado </li>
			<li> Habr&aacute; un guild pack para guild chicas, o en formaci&oacute;n, y un gp chico para guilds MVPs, pronto</li>
			<li> Pueden seguir la discuci&oacute;n del GP <a href="http://oborocp.net/foro/index.php?/topic/26-guild-pack/"> Clickeando aqu&iacute;</a></li>
		</ul><br/>

		<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Item</th>
					<th>Cantidad</th>
					<th>Imagen</th>
					<th>Item</th>
					<th>Cantidad</th>
				</tr>	
			</thead>
			<tbody>
				<?php
					for ( $i = 0; $i < sizeof($ITEM_TRANSFER_GUILD); $i+=4 )
					{
						echo "
							<tr>
								<td><img style='width: 30px; border-radius: 100px;' src='./img/db/item_db/large/".$ITEM_TRANSFER_GUILD[$i].".png' /></td>
								<td>".$ITEM->__GETDB($ITEM_TRANSFER_GUILD[$i],'namej')."</td>
								<td>". $ITEM_TRANSFER_GUILD[$i + 1]."</td>
								<td><img style='width: 30px; border-radius: 100px;' src='./img/db/item_db/large/".$ITEM_TRANSFER_GUILD[$i+2].".png' /></td>
								<td>".$ITEM->__GETDB($ITEM_TRANSFER_GUILD[$i+2],'namej')."</td>
								<td>". $ITEM_TRANSFER_GUILD[$i + 3]."</td>
							</tr>
						";
					}
				?>
			</tbody>
		</table>
		Y 90.000 Cash Points para la compra de lowers, o equipo faltante a gusto
		<h4 class="oboro_h4"><i class="fa fa-users fa-2x" style="vertical-align: middle;"> </i> <span>Personal Pack</span></h4>
		<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Item</th>
					<th>Cantidad</th>
					<th>Imagen</th>
					<th>Item</th>
					<th>Cantidad</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ( $i = 0; $i < sizeof($ITEM_TRANSFER_PERSONAL); $i+=4 )
				{
					if ( isset($ITEM_TRANSFER_PERSONAL[$i]) && isset($ITEM_TRANSFER_PERSONAL[$i+1]) )
					{
						echo "
							<tr>
								<td><img style='width: 30px; border-radius: 100px;' src='./img/db/item_db/large/".$ITEM_TRANSFER_PERSONAL[$i].".png' /></td>
								<td>".$ITEM->__GETDB($ITEM_TRANSFER_PERSONAL[$i],'namej')."</td>
								<td>". $ITEM_TRANSFER_PERSONAL[$i + 1]."</td>
						";
					}
					if ( isset($ITEM_TRANSFER_PERSONAL[$i+2]) && isset($ITEM_TRANSFER_PERSONAL[$i+3]) )
					{
						echo "
								<td><img style='width: 30px; border-radius: 100px;' src='./img/db/item_db/large/".$ITEM_TRANSFER_PERSONAL[$i+2].".png' /></td>
								<td>".$ITEM->__GETDB($ITEM_TRANSFER_PERSONAL[$i+2],'namej')."</td>
								<td>". $ITEM_TRANSFER_PERSONAL[$i + 3]."</td>
							</tr>
						";
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
