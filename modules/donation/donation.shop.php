<?php
if (!isset($_SESSION['account_id']) || empty($CONFIG->getConfig('DBarray')))
{
	echo 'Debes estar logeado O bien el sistema se encuentra desactivado';
	exit;
}

$data_cache = $ITEM->get('ItemDB');
if ( !$data_cache )
{
	'Cache Not found';
	exit;
}
	
$IT_TEMP = $ITEM->decode_arr($ITEM->get('ItemDB'));
?>

<div class="row">
	<div class="col-lg-12">
		<div class="dona-box-puntos-disponibles">
		<?php
			$consult = 
			"
				SELECT 
					`value` 
				FROM 
					".
						($FNC->get_emulator() == EAMOD ? 
						 	"`global_reg_value` WHERE `str`='".$CONFIG->getConfig('PayPal-Points')."'" :
						 	"`acc_reg_num` WHERE `key`='".$CONFIG->getConfig('PayPal-Points')."'"
						)
					."
				AND 
					account_id = ?
			";
			$result = $DB->execute($consult, [$_SESSION['account_id']]);
			echo 
			'
				<div class="row">
					<div class="col-lg-12">
						<div class="dona-box-dp-container">
			';
			
			if ($row = $result->fetch())
				echo 'You have: &pound; <span id="get-donation-points">'.$row['value'] .'</span>,00 Donation Points';
			else
				echo 'You don\'t have Donation Points';
			
			$DB->free($result);
			echo 
			'
						</div>
					</div>
				</div>
			';
		?>
		</div>
		<div class="row">
		<?php		
			$i = 0;
			foreach ($IT_TEMP as $item_id => $valor)
			{
				if (empty($valor['precio']))
					continue;

				echo '
					<div class="col-lg-6">
						<div class="panel panel-default">
							<div class="panel-heading">'.$valor['namej'].' [ '.$valor['slots'].' ]</div>
								<div class="panel-body dona-panel-body nopadding">
									<div class="col-xs-3 nopadding inherit-height dona-box-border-right">
										<div class="dona-box-img-adentro" style="background: #FFF url(\'./img/db/item_db/large/'.$item_id.'.png\') no-repeat scroll center center / cover; width:75px; height:100px; transform: translate(25%, 25%); position: relative;"></div>
									</div>
									<div class="col-xs-9 nopadding">
										<div class="dona-box-description">'.$valor['item_description'].'</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-footer panel-footer-donation">
									<div class="col-xs-4">
										<div class="donation_value">'.$FNC->moneyformat($valor['precio']).',00 DPs.</div>
									</div>
									<div class="col-xs-8 text-align-right">
										<form class="dona-box-on-buy" data-dona-id="'.$item_id.'">
											<div class="input-group">
												<span class="input-group-addon"><input type="checkbox" class="dona-box-checkbox" name="confirma-compra" /> Confirm</span> 
												<input type="submit" name="sub" class="dona-box-comprar btn btn-primary"'. 
													(
														($row['value'] > $valor['precio']) ? 
															'value="Buy Now"' :
															'value="Can\'t Buy" disabled'
													).
												'>
											</div>
										</form>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div><!-- panel -->
					';
				$i++;
			}
		?>
		<div class="clear"></div>
		</div>			
	</div>
</div>