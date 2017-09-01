<?php
/**
 * [Isaac] Oboro Control Panel - NanoSoft (C)
 **/
session_start();
include_once('libs/controller.php');


$PayPal_Hosts 		= ['ipn.sandbox.paypal.com', 'notify.paypal.com'];
$realip				= $_SERVER['REMOTE_ADDR'];

if (empty($_POST['receiver_email']) || empty($_POST['payment_status']) || empty($_POST['mc_currency']) || empty($_POST['mc_gross']) || empty($_POST['payer_email']) || empty($_POST['custom']) || empty($_POST['txn_id']))
	exit;

// PayPal IPN Procces Information 
$receiverMail 		= $_POST['receiver_email']; 	// El E-Mail que recibió el pago para ser comparado con quien tuvo que recibirlo
$status 			= $_POST['payment_status']; 	// El estado del pago Si está completado, prosiga.
$currency 			= $_POST['mc_currency']; 		// EL tipo de cambio o moneda con la que pagó ejemplo USD o EUR
$gross 				= $_POST['mc_gross'];			// La cantidad de plata que envió para ser comprobada
$payerMail 			= $_POST['payer_email']; 		// Email del Player
$accountID 			= $_POST['custom']; 			// User ID
$transactionID 		= $_POST['txn_id'];				// transaction ID

// Override Host IP if necesary
if (isset($_SERVER['HTTP_X_REAL_IP'])) 
	$realip 		= $_SERVER['HTTP_X_REAL_IP'];
elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	$realip 		= $_SERVER['HTTP_X_FORWARDED_FOR'];
elseif (isset($_SERVER['HTTP_CLIENT_IP']))
	$realip 		= $_SERVER['HTTP_CLIENT_IP'];
elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
	$realip		 	= $_SERVER['HTTP_CF_CONNECTING_IP'];

if(!in_array(gethostbyaddr($realip), $PayPal_Hosts))
{
	// May Be is a new paypal IP, Lets give admins the new whitelist ip!
	$consult = 
	"
		INSERT INTO `oboro_paypal_on_failure_ip`(`ipn_paypal_ip`,`account_id`,`transaction_id`,`email_player`,`money`,`date`) 
		VALUES (?,?,?,?,?,?)
	";
	$param = array('iiisis', $realip, $accountID, $transactionID, $payerMail, $gross, date("Y-m-d H:i:s"));
	$result = $DB->execute($consult, $param);
	exit;
}

if($status == 'Completed' && $receiverMail == $CONFIG->__GETCONF('PayPal-Email') && $currency == $CONFIG->__GETCONF('PayPal-Moneda')) 
{
	foreach($CONFIG->PayPal as $paypal)
	{
		if ($gross != $paypal[0])
			continue;
		
		$registro_contable = 
		"
			INSERT INTO `oboro_contable`(`account_id`, `email`, `usd`, `points`) 
			VALUES (?, ?, ?, ?)
		";
		$param = array('isii', $accountID, $payerMail, $gross, $paypal[1]);
		$result = $DB->execute($registro_contable, $param);

		if ($FNC->get_emulator() == EAMOD )
		{
			$consult = 
			"
				INSERT INTO `global_reg_value` (`str`, `value`, `type`, `account_id`) 
				values(?,?,3,?) 
				ON DUPLICATE KEY UPDATE `value`= (`value` + ?)
			";
		}
		else
		{
			$consult = 
			"
				INSERT INTO `acc_reg_num` (`key`, `value`, `account_id`) 
				VALUES(?, ?, ?)
				ON DUPLICATE KEY UPDATE `value`= (`value` + ?)
			";			
		} 
	
		$param = array('siii',$CONFIG->__GETCONF('PayPal-Points'), $paypal[1], $accountID,$paypal[1]);
		$result = $DB->execute($consult);
		break;
	}
}
exit;
?>