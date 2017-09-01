<?php
if ( !isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99 ) 
	exit;
?>

<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4">
			<i class="fa fa-tachometer" aria-hidden="true"></i> Search some MVP Card
		</h4>
		<form id="OBORO_NORMALIZED">
			<div class="text-align-center display-table center">
				<div style="padding-right: 10px;">Search a Mvp Card </div>
				<?php 
					echo $FNC->CDD('mvp', '', $GV, '');
				?>
				<input type="hidden" name="rank" value="admin.search.mvp_card">
				<input type="submit" value="Search" class="btn btn-primary inline_block">
				<div class="clearfix"></div>
			</div>
		</form>
		<div class="text-align-center display-table center">The Select is only the reference, actually isn't procesed as shown</div>
	</div>
</div>

<div class="row" style="margin-top:20px !important;">
	<div class="col-lg-12">
		<div class="panel">
			<div id="ladder_div">
				<?php
					$tables_where_can_be_a_mvp_card = array('inventory','cart_inventory','storage','rentstorage','guild_storage');
					$fields_where_can_be_a_mvp_card = array('nameid', 'card0');
					$consutlas = array();
					$id_card = $NRM->getParam(0) ? $NRM->getParam(0) : 4047;
					foreach($tables_where_can_be_a_mvp_card as $table)
					{
						$select = 'SELECT * FROM `'.$table.'` WHERE';
						foreach($fields_where_can_be_a_mvp_card as $val)
							$select .= '`'.$val.'`= '.$id_card.' OR ';
						$select = trim($select, ', OR ');
						array_push($consutlas, $select);
					}

					foreach($consutlas as $poc => $val)
					{
						?>
						<div class="row">
							<div class="col-lg-12">
								<h4 class="oboro_h4"><i class="fa fa-address-card-o" aria-hidden="true"></i> Studing Table: <?php echo $tables_where_can_be_a_mvp_card[$poc] ?></h4>
								<pre>
<?php echo trim($val); ?>
								</pre>
								<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT">
									<thead>
										<tr>
											<?php
												$fields = $DB->ShowColumns($tables_where_can_be_a_mvp_card[$poc]);
												foreach ($fields as $column)
													echo '<td>'.$column.'</td>';
											?>
										</tr>
									</thead>
									<tbody>
										<?php
											$result = $DB->execute($val);
											if ($val)
											{
												while ( $row = $result->fetch(PDO::FETCH_NUM))
												{
													echo '<tr>';
													foreach ( $row as $data )
														echo '<td>'.$data.'</td>';
													echo '</tr>';
												}
												$DB->free($result);
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					<?php
					}
				?>
			</div>
		</div>
	</div>
</div>