<?php
if (!isset($_SESSION['account_id']))
{
	echo 'denied';
	exit;	
}

?>
	<div class="row">
		<div class="col-lg-12">
			<h4 class="oboro_h4"><i class="fa fa-users fa-2x" style="vertical-align: middle;"> </i> <span>Donation System</span></h4>
			<div class="panel panel-default">
				<div class="panel-heading">How to donate</div>
				<div class="panel-body">
					<ol>
						<li>You need a valid creditcard <b>or</b> a PayPal account with a required amount of money.</li>
						<li>Choose how many points you want buy.</li>
						<li>Click on the donate/buy button.</li>
						<li>Make a transaction on PayPal.</li>
						<li>After the transaction points will be automatically added to your account.</li>
						<li>Go to Item shop and use your points.</li>
					</ol>
				</div>
			</div>

			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT">
				<thead>
					<th>Points</th>
					<th>Money</th>
					<th>Button</th>
				</thead>
				<tbody>
					<?php
						foreach($CONFIG->PayPal as $poc => $paypal)
						{
							echo '
								<tr>
									<td>' . $paypal[1] . ' dona points </td>
									<td>'. $paypal[0] . ' ' .$CONFIG->getConfig('PayPal-Moneda'). '</td>
									<td>
										<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
											<input type="hidden" name="cmd" value="_donations">
											<input type="hidden" name="business" value="'.$CONFIG->getConfig('PayPal-Email').'">
											<input type="hidden" name="custom" value="'.$_SESSION['account_id'].'">
											<input type="hidden" name="item_name" value="Donacion a Servidor Gratuito de Ragnarok Online">
											<input type="hidden" name="amount" value="' . $paypal[0] . '">
											<input type="hidden" name="currency_code" value="'.$CONFIG->getConfig('PayPal-Moneda').'">
											<input type="hidden" name="no_note" value="0">
											<input type="hidden" name="no_shipping" value="1">
											<input type="hidden" name="notify_url" value="'.$CONFIG->getConfig('Web').'paypal_report.php">
											<input type="hidden" name="return" value="'.$CONFIG->getConfig('Web').'">
											<input type="hidden" name="rm" value="0">
											<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
										</form>
									</td>
								</tr>
							';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>