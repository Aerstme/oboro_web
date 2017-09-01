<?php
include_once('../../libs/php_init.php');
if (file_exists('../../libs/config.php'))
{
	echo 'Well you have a config.php file, please delete it to go through your installer.';
	exit;
}

if (!empty($_POST['opt']))
{
	
	if (
		!empty($_POST['web']) &&
		!empty($_POST['dbhost']) &&
		!empty($_POST['dbase']) &&
		!empty($_POST['dbuser']) &&
		!empty($_POST['dbpswd']) &&
		!empty($_POST['emulator'])
	) {
	
$tmp = "<?php 
	class CONFIG {
		protected \$CONFIG = array();

		/**
		 * Constructor de la configuración
		 * @private
		 **/
		function __construct() 
		{
			unset(\$this->CONFIG);
			\$this->CONFIG = array (
				// Web Configuration
				'title'				=> '".( !empty($_POST['title']) ? $_POST['title'] : 'Oboro')."',
				'Web'				=>	'".$_POST['web']."',
				'DBarray'			=>	'".( !empty($_POST['dbarray']) ? $_POST['dbarray'] : 'no')."',
				
				// Configuration Of the Game Server
				'Emulator'			=>	'".$_POST['emulator']."',
				
				// When Someone votes, what gives the CP?
				'OnVotePoints'		=>	'".(!empty($_POST['OnVotePoints']) ? $_POST['OnVotePoints'] : '#CASHPOINTS')."',
				
				
				// Configuration Of MySQL RO Server
				'DBHost'			=> 	'".$_POST['dbhost']."',
				'DBase'				=> 	'".$_POST['dbase']."',
				'DBUser'			=>	'".$_POST['dbuser']."',
				'DBPswd'			=>	'".$_POST['dbpswd']."',
				'UseMD5'			=>	'".( !empty($_POST['usemd5']) ? $_POST['usemd5'] : 'no')."',

				// Configuration Of Ports
				'Login'				=>	".( !empty($_POST['login']) ? $_POST['login'] : '6900' ).",
				'Char'				=>	".( !empty($_POST['char']) ? $_POST['char'] : '6121').",
				'Map'				=>	".( !empty($_POST['map']) ? $_POST['map'] : '5121').",

				//Some Usefull links to use
				'link_descargas'	=> '".( !empty($_POST['link_descargas']) ? $_POST['link_descargas'] : '#')."',
				'link_guildpack'	=> '".( !empty($_POST['link_guildpack']) ? $_POST['link_guildpack'] : '#')."',
				'link_svinfo'		=> '".( !empty($_POST['link_svinfo']) ? $_POST['link_svinfo'] : '#')."',
				
				//GeoLocalización Oboro - Highly recommended for hacking
				'UseGeoLocalization'=> '".( isset($_POST['UseGeoLocalization']) ? $_POST['UseGeoLocalization'] : 'yes')."',
				
				//PayPal Configuration
				'PayPal-Email'		=> '".(isset($_POST['paypalmail']) ? $_POST['paypalmail'] : 'tuserverro@hotmail.com')."',
				'PayPal-Moneda'		=> 'USD',
				'PayPal-Points'		=> '".(isset($_POST['paypalpoints']) ? $_POST['paypalpoints'] : '#DONAPOINTS')."',
				
				//Oboro Control Panel Revision Version
				'Oboro_Version'		=>	'4.2.0.0',
				'Time_Zone'			=> '".( isset($_POST['select_timezone']) ? $_POST['select_timezone'] : 'America/Los_Angeles')."'

			);
		}
		
		//USD		=> 	Points
		public \$PayPal = array(
			array(5,	300),
			array(10,	650),
			array(15,	1350),
			array(25,	3000),
			array(50,	6000),
			array(100,	13050)
		);

		public \$WOESCHDL = array(
			array('".(isset($_POST['woe1_day']) ? $_POST['woe1_day'] : 'undefined')."',	'".( isset($_POST['woe1_type']) ? $_POST['woe1_type'] : '2.0') ."',	'".( isset($_POST['woe1_start']) ? $_POST['woe1_start'] : '00:00')."', '".( isset($_POST['woe1_end']) ? $_POST['woe1_end'] : '01:00')."'),
			array('".(isset($_POST['woe2_day']) ? $_POST['woe2_day'] : 'undefined')."',	'".( isset($_POST['woe2_type']) ? $_POST['woe2_type'] : '2.0') ."',	'".( isset($_POST['woe2_start']) ? $_POST['woe2_start'] : '00:00')."', '".( isset($_POST['woe2_end']) ? $_POST['woe2_end'] : '01:00')."'),
			array('".(isset($_POST['woe3_day']) ? $_POST['woe3_day'] : 'undefined')."',	'".( isset($_POST['woe3_type']) ? $_POST['woe3_type'] : '2.0') ."',	'".( isset($_POST['woe3_start']) ? $_POST['woe3_start'] : '00:00')."', '".( isset($_POST['woe3_end']) ? $_POST['woe3_end'] : '01:00')."'),
		);

		public \$VOTEPOINTS = array (
			// Vote 4 Points 
			// SOLO MODIFICAR EL ID
			// Si ocupas soporte para como saber tu link directo a votación puedes pedirlo en @OboroCP FB
			array(1,	'Top Ro Hispano',		'".( !empty($_POST['top_ro_hispano']) ? $_POST['top_ro_hispano'] : '#')."', 10),
			array(2,	'Ragna Top',		 	'".( !empty($_POST['ragna_top']) ? $_POST['ragna_top'] : '#')."',	10)
		);

		/**
		 * Devuelve el parametro de configuracion
		 * @private
		 */
		public function getConfig(\$var) 
		{ 
			return (isset(\$this->CONFIG[\$var]) ? \$this->CONFIG[\$var] : 0 ); 
		}
	}
?>
";
		echo 'loading...<br/>';
		file_put_contents('../../libs/config.php', $tmp);
		echo '...';
		echo 'Ok! It\'s done, if all information is ok, Oboro CP Will be shown in: '.$_POST['web'] .'. Otherwise you should come and configure again.';
		exit;
	}
	$missing = 1;
}
?>


<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../img/favicon.ico">

		<title>Oboro Contro Panel &copy; By Isaac (c)</title>

		<!-- Bootstrap core CSS -->
		<link href="../../css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<link href="../../css/dataTables.bootstrap.css" rel="stylesheet">

		<link rel="stylesheet" href="../../css/oboro.css">

		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,600,400italic,600italic,700,800,700italic,800italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600italic,600,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet"> 
	</head>
	<body>
		<div class="logo"></div>

		<div class="wrapper">
			<div class="row">
				<h4 class="oboro_h4_install"><i class="fa fa-fighter-jet fa-2x" style="vertical-align: middle;"> </i> <span>Welcome to Oboro Control Panel Installer</span></h4>
				<form action="installer.php" method="post">
					<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT" style="background:#fff;">
						<thead>
						<?php
							if (!empty($missing))
							{
								echo '
									<tr style="background:red;">
										<th colspan="3">The installer has detected: Missing Obligatory Fields</th>
									</tr>
								';
							}
						?>
							<tr>
								<th>Guide</th>
								<th>Example</th>
								<th style="width:30%;">Inputs</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th colspan="3">Web Configuration</th>
							</tr>
							<tr>
								<td>Control Panel Title: Will be displayed in the top side of the web</td>
								<td>Example RO</td> 
								<td><input type="text" name="title" class="form-control" placeholder="Example RO (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Oboro Control Panel Link. <b>please use the last "/"</b></td>
								<td>http://ejemplo.com/</td> 
								<td>
									<?php
										$uri_split = explode("/",dirname($_SERVER['REQUEST_URI']));
										if (sizeof($uri_split) > 3)
										{
											$uri = '';
											foreach($uri_split as $poc => $val)
											{
												if ( $poc <= (sizeof($uri_split) - 3) )
													$uri .= $val.'/';
											}
											$try_get_server_link = $_SERVER['HTTP_HOST'].''.$uri;
										} else
											$try_get_server_link = $_SERVER['HTTP_HOST'] .'/';
									?>
									<input type="text" name="web" class="form-control" placeholder="http://myserver.com (OBLIGATORY FIELD)" value="http://<?php echo $try_get_server_link ?>">
								</td>
							</tr>
							<tr>
								<td>Server Emulator</td>
								<td> - </td> 
								<td>
									<select class="form-control" name="emulator">
										<option value="eamod">eAmod</option>
										<option value="ramod">rAmod</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>When someone <b>votes</b>, what gives the CP?</td>
								<td> #VOTEPOINTS/#CASHPOINTS </td> 
								<td>
									<select class="form-control" name="OnVotePoints">
										<option value="#VOTEPOINTS">Vote Points</option>
										<option value="#CASHPOINTS">Cash Points</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Date Zone: Must Be equal to Server</td>
								<td> WoE Status will work with this </td>
								<td>
									<?php
										if (function_exists("timezone_identifiers_list"))
										{
											$arr_timez_id_lst3 = DateTimeZone::listIdentifiers();
											echo '<select name="select_timezone" class="form-control">';
											foreach( $arr_timez_id_lst3 as $timz3)
											{
												if ($timz3 == 'America/Los_Angles')
													echo '<option value="' . $timz3 . '" selected>' . $timz3 . '</option>';
												else
													echo '<option value="' . $timz3 . '">' . $timz3 . '</option>';
											}
											echo '</select>';
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Geolocalization: Use it as secure acces from other location in control panel</td>
								<td>Anti-hack: Highly recommended</td>
								<td>
									<select class="form-control" name="UseGeoLocalization">
										<option value="no">No</option>
										<option value="yes">Yes</option>
									</select>								
								</td>
							</tr>
							<tr>
								<th colspan="3">Data Base Configuration</th>
							</tr>
							<tr>
								<td>Data Base Host: The IP of the Ragnarok Server </td>
								<td>129.84.45.32</td> 
								<td><input type="text" name="dbhost" class="form-control" placeholder="X.X.X.X (OBLIGATORY FIELD)"></td>
							</tr>
							<tr>
								<td>Main Data Base: Where the tables of the server are located</td>
								<td>server_db</td> 
								<td><input type="text" name="dbase" class="form-control" placeholder="server_database (OBLIGATORY FIELD)"></td>
							</tr>
							<tr>
								<td>User Data Base: root by default, not recomended</td>
								<td> - </td> 
								<td><input type="text" name="dbuser" class="form-control" placeholder="User DB (OBLIGATORY FIELD)"></td>
							</tr>
							<tr>
								<td>Data Base Password: the User DB's Password</td>
								<td>Ws2847jfcS</td> 
								<td><input type="text" name="dbpswd" class="form-control" placeholder="DB Password (OBLIGATORY FIELD)"></td>
							</tr>
							<tr>
								<td>Test Data Base Connection</td>
								<td>Press Button</td>
								<td><input type="button" value="test Connection" id="test-con" class="btn btn-primary width_100"></td>
							</tr>
							<tr>
								<td>Login Port: Use the server's port by default</td>
								<td>6900</td> 
								<td><input type="text" name="login" class="form-control" placeholder="6900 (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Chart Port: Use the server's port by default</td>
								<td>5121</td> 
								<td><input type="text" name="char" class="form-control" placeholder="5121 (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Map Port: Use the server's port by default</td>
								<td>6121</td> 
								<td><input type="text" name="map" class="form-control" placeholder="6121 (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Use MD5 in passwords: If your server enrcrypt's password</td>
								<td> - </td> 
								<td>
									<select class="form-control" name="usemd5">
										<option value="no">No</option>
										<option value="yes">Yes</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Item DB As Session Array: Would You like to have an item db?</td>
								<td> - </td> 
								<td>
									<select class="form-control" name="dbarray">
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
								</td>
							</tr>
							<tr>
								<th colspan="3">Another Server Configuration</th>
							</tr>
							<tr>
								<td>Download Link</td>
								<td>http://forum.svro.com/link.php</td> 
								<td><input type="text" name="link_descargas" class="form-control" placeholder="Post Link (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Guild Pack Link</td>
								<td>http://forum.svro.com/link.php</td> 
								<td><input type="text" name="link_guildpack" class="form-control" placeholder="Post Link (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<td>Server Info Link</td>
								<td>http://forum.svro.com/link.php</td> 
								<td><input type="text" name="link_svinfo" class="form-control" placeholder="Post Link (OPTIONAL FIELD)"></td>
							</tr>
							<tr>
								<th colspan="3">WOE Configuration</th>
							</tr>
							<tr>
								<td>Day/Edition/Start/Finish</td>
								<td>Sundat 2.0 16:00 17:00</td>
								<td>
									<select class="form-control woe_control" name="woe1_day">
										<option value="Sunday">Sunday</option>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday">Friday</option>
										<option value="Saturday" selected>Saturday</option>
									</select>
									<select class="form-control woe_control" name="woe3_type">
										<option value="WoE2.0" selected>Woe 2.0</option>
										<option value="WoE1.0">Woe 1.0</option>
										<option value="BabyWoe">Baby Woe</option>
										<option value="Ancient">WoE Ancient</option>
									</select>
									<select class="form-control woe_control" name="woe1_start">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00" selected>16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00">18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
									<select class="form-control woe_control" name="woe1_end">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00">16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00" selected>18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Day/Edition/Start/Finish</td>
								<td>Sundat 2.0 16:00 17:00</td>
								<td>
									<select class="form-control woe_control" name="woe2_day">
										<option value="Sunday" selected>Sunday</option>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday">Friday</option>
										<option value="Saturday">Saturday</option>
									</select>
									<select class="form-control woe_control" name="woe3_type">
										<option value="WoE2.0" selected>Woe 2.0</option>
										<option value="WoE1.0">Woe 1.0</option>
										<option value="BabyWoe">Baby Woe</option>
										<option value="Ancient">WoE Ancient</option>
									</select>
									<select class="form-control woe_control" name="woe2_start">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00" selected>16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00">18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
									<select class="form-control woe_control" name="woe2_end">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00">16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00" selected>18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Day/Edition/Start/Finish</td>
								<td>Sundat 2.0 16:00 17:00</td>
								<td>
									<select class="form-control woe_control" name="woe3_day">
										<option value="Sunday" selected>Sunday</option>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday">Friday</option>
										<option value="Saturday">Saturday</option>
									</select>
									<select class="form-control woe_control" name="woe3_type">
										<option value="WoE2.0" selected>Woe 2.0</option>
										<option value="WoE1.0">Woe 1.0</option>
										<option value="BabyWoe">Baby Woe</option>
										<option value="Ancient">WoE Ancient</option>
									</select>
									<select class="form-control woe_control" name="woe3_start">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00" selected>16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00">18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
									<select class="form-control woe_control" name="woe3_end">
										<option value="00:00">00:00</option>
										<option value="01:00">01:00</option>
										<option value="02:00">02:00</option>
										<option value="03:00">03:00</option>
										<option value="04:00">04:00</option>
										<option value="05:00">05:00</option>
										<option value="06:00">06:00</option>
										<option value="07:00">07:00</option>
										<option value="08:00">08:00</option>
										<option value="09:00">09:00</option>
										<option value="10:00">10:00</option>
										<option value="11:00">11:00</option>
										<option value="12:00">12:00</option>
										<option value="13:00">13:00</option>
										<option value="14:00">14:00</option>
										<option value="15:00">15:00</option>
										<option value="16:00">16:00</option>
										<option value="17:00">17:00</option>
										<option value="18:00" selected>18:00</option>
										<option value="19:00">19:00</option>
										<option value="20:00">20:00</option>
										<option value="21:00">21:00</option>
										<option value="22:00">22:00</option>
										<option value="23:00">23:00</option>
									</select>
								</td>
							</tr>
							<tr>
								<th colspan="3">Oboro Vote Panel Configuration</th>
							</tr>
							<tr>
								<td>Top Ro Hispano</td>
								<td>If you are unsure which is your Link. Make a Support Tiquet</td>
								<td><input type="text" name="top_ro_hispano" class="form-control" value="http://toprohispano.com/vote/index.php?id=112"></td>
							</tr>
							<tr>
								<td>Ragna Top</td>
								<td>If you are unsure which is your Link. Make a Support Tiquet</td>
								<td><input type="text" name="ragna_top" class="form-control" value="http://ragnatop.org/index.php?a=in&u=TanisRO&sid=f7Bnjh6tfSOu4F81wrHp12A2wSAtjC4r"></td>
							</tr>
							
							<tr>
								<td colspan="3">Pay Pal Configuration File
								</td>
							</tr>
							<tr>
								<td>PayPal E-Mail</td>
								<td>Where the donations goes</td>
								<td><input type="text" name="paypalmail" class="form-control" value="youremailpaypal@a.com"></td>
							</tr>
							<tr>
								<td>PayPal Server Points</td>
								<td>#CASHPOINTS / #DONAPOINTS / etc.</td>
								<td><input type="text" name="paypalpoints" class="form-control" value="#DONAPOINTS"></td>
							</tr>
							<tr>
								<th colspan="3">
									<input type="hidden" name="opt" value="1">
									<input type="submit" value="Create Config File" class="btn btn-primary width_100">
								</th>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script>
			$(document).on('ready', function () {
				$('#test-con').on('click', function() {
					var dbhost = $(this).parent().parent().parent().find(':input[name="dbhost"]').val();
					var dbase = $(this).parent().parent().parent().find(':input[name="dbase"]').val();
					var dbuser = $(this).parent().parent().parent().find(':input[name="dbuser"]').val();
					var dbpswd = $(this).parent().parent().parent().find(':input[name="dbpswd"]').val();
					$(this).prop('disabled',true).val('Loading... Please wait');
					var that = this;
					$.post('test_conn.php', {DBHOST: dbhost, DBASE: dbase, DBUSER: dbuser, DBPSWD: dbpswd}, function (r){
						alert(r);
						$(that).prop('disabled',false).val('test Connection');
					});
				});
			});
		</script>
	</body>
</html>