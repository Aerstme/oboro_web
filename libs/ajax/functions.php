<?php
session_start();
include_once('../controller.php');
$error = null;
switch ( $_POST['OPT'] ) {		
	case 'CONVERT_ITEM_DB':
		if ( file_exists('../../db/idnum2itemdesctable.txt') && file_exists('../../db/item_db.txt'))
		{
			if ( $ITEM->setItemDBMain() === 'ok')
			{
				if (file_exists("../../db/item_db.sql")) 
				{
					echo 'error@'.$CONFIG->getConfig('Web').'/modules/admin/admin.item_db.cache_download.php';
					exit;
				}
				else echo 'Can\'t Find the item_db.sql file';
			} else 
				echo $ITEM->setItemDBMain();
		} else 
			echo 'Can\'t find the file idnum2itemdesctable.txt or item_db.txt, did you Upload It?';
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'RECOVERPASS':
		if (empty($_POST['uid']) || empty($_POST['email']))
		{
			echo 'missing fields';
			exit;
		}

		
		$consult = "SELECT `email` FROM `login` WHERE `userid`=? AND `email`=?";
		$result = $DB->execute($consult, [$_POST['uid'], $_POST['email']]);
		if (!$DB->num_rows())
		{
			echo "There is no user with this userid or mail";
			exit;
		}
			
		$row = $result->fetch();
			
		$random = (mt_rand() + mt_rand()) * 3;
		$consult = "UPDATE `login` set `user_pass`=? WHERE `userid`=? AND `email`=?";
		$param = [$FNC->CheckMD5($random),$_POST['uid'], $_POST['email']];
		$DB->execute($consult, $param);

		$email = $row["email"];
		$email .= ',';
		$email .= 'recover@saphirero.noreply.com';
		$asunto = "Oboro CP (C) - Account Password Request";
		$message = " ";
		$message.= "Se ha iniciado la recuperacion de tu cuenta.";
		$message = " ";
		$message.= "\n	Tu nueva contraseña es: ". $random;
		$message.= "\n\n Saludos.";
		$message.= "\n\n Staff SaphireRO.";
		mail($email, $asunto, $message, "From: Oboro CP");
		echo 'ok';
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'LOGIN':
		if (empty($_POST['user']) || empty($_POST['pass']))
		{
			echo 'Missing user or password fields';
			exit;
		}
		
		$consult =
		"
			SELECT 
				`account_id`, `userid`, ".($FNC->get_emulator() == EAMOD ? "`level`" : "`group_id`") .", `user_pass`, `geo_localization` 
			FROM 
				`login` 
			WHERE 
				userid = ? 
			AND 
				`user_pass`= ?
			AND 
				state != 5
		";
		$result = $DB->execute($consult, [$_POST['user'], $FNC->CheckMD5($_POST['pass'])]);
		$row = $result->fetch();
		if (!$row['account_id'])
		{
			echo 'Wrong username or password';
			exit;
		}
		
		if ($CONFIG->getConfig('UseGeoLocalization') == 'yes')
		{
			$GIP = geoip_open('GeoIP.dat',GEOIP_STANDARD);
			$GeoLocalization = geoip_country_name_by_addr($GIP, $FNC->getIP());
	
			if (!empty($GeoLocalization))
				; // continua en error... [Isaac]
			elseif (empty($row['geo_localization']) || $row['geo_localization'] == 'Undefined')
			{
				$consult =
				"
					UPDATE 
						`login`
					SET	
						`geo_localization` = ?
					WHERE 
						`account_id` = ?
				";
				$DB->execute($consult, [(!empty($GeoLocalization) ? $GeoLocalization : "Undefined" ),$row['account_id']]);	
			}
			else if ( geoip_country_name_by_addr($GIP, $FNC->getIP()) != $row['geo_localization'] )
			{
				$consult =
				"
					INSERT INTO `oboro_geo_localization_fail_log`(`ip`, `userid`, `date`, `zone`)
					VALUES (?,?,?,?)
				";
				$DB->execute($consult, [$FNC->getIP(), $_POST['user'], date("Y-m-d H:i:s"), $GeoLocalization]);
				
				if ($result->rowCount())
				{
					$_SESSION['GEO_USERID'] = $_POST['user'];
						echo 'User location: '.geoip_country_name_by_addr($GIP, $FNC->getIP()).'. Authentication fail';
						echo '
							<script type="text/javascript">
								window.location = "'.$CONFIG->getConfig('Web').'?account.recover.geolocalization"
							</script>
						';
						die();
				}
				else
				{
					echo 'Something wrong happened';
					exit;
				}
			}
		}
			
		$_SESSION['account_id']  = $row['account_id'];
		$_SESSION['userid']		 = $row['userid'];
		$_SESSION['GMACCOUNT']   = $row[($FNC->get_emulator() == EAMOD ? "level" : "group_id")];
		$_SESSION['password']	 = $row['user_pass'];
		$_SESSION['ip']			 = $FNC->getIP();
		echo 'ok';
	break;

	/**
	 *
	 *
	 *
	 **/
	case 'REGISTRO':
		if ( empty($_POST['user']) ||
			 empty($_POST['pass']) ||
			 empty($_POST['pass2']) ||
			 empty($_POST['mail']) ||
			 empty($_POST['ip']) || 
			 empty($_POST['sex']) ||
			 empty($_POST['pais']) ||
			 !isset($_POST['question']) ||
			 empty($_POST['question_response'])
		   )
		{
			echo 'Missings fields';
			exit;
		}
		
		if (preg_match('/[^a-zA-Z0-9_]/', $_POST['user'])) 
			$error .=  'Invalid character(s) used in username <br/>';
		if (strlen($_POST['user']) < 4)
			$error .= 'Username is too short (min. 4) <br/>';
		if (strlen($_POST['user']) > 23)
			$error .= 'Username is too long (max. 23) <br/>';
		if (stripos($_POST['pass'], $_POST['user']) !== false)
			$error .= 'Password must not contain Username <br/>';
		if (!ctype_graph($_POST['pass']))
			$error .=  'Invalid character(s) used in password <br/>';
		if(strlen($_POST['pass']) < 8)
			$error .= 'Password is too short (min. 8) <br/>';
		if(strlen($_POST['pass']) > 26)
			$error .= 'Password is too long (max. 23) <br/>';
		if ($_POST['pass'] !== $_POST['pass2'])
			$error .= 'Passwords and confirm do not match <br/>';
		if (preg_match_all('/[A-Z]/', $_POST['pass'], $matches) < 1)
			$error .= 'Passwords must contain at least 1 Upper case <br/>';
		if (preg_match_all('/[a-z]/', $_POST['pass'], $matches) < 1)
			$error .= 'Passwords must contain at least 1 lower case <br/>';
		if (preg_match_all('/[0-9]/', $_POST['pass'], $matches) < 1)
			$error .= 'Passwords must contains at least 1 number <br/>';
		if(preg_match_all('/[^A-Za-z0-9]/', $_POST['pass'], $matches) <	1)
			$error .= 'Passwords must contains at least 1 symbol <br/>';
		if (!preg_match('/^(.+?)@(.+?)$/', $_POST['mail']))
			$error .= 'Invalid e-mail address <br/>';
		if(!in_array(strtoupper($_POST['sex']), array('M', 'F')))
			$error .= 'Invalid gender <br/>';
		if ( strlen($_POST['pais']) != 2)
			$error .= 'Invalid Country<br/>';
		if ( !is_numeric($_POST['question']))
			$error .= 'Invalid Question';
		if ( $_POST['pass'] == $_POST['question_response'] )
			$error .= 'For security reasons your Question and Password cannot be the same';
		if ( strlen($_POST['question_response']) > 23 )
			$error .= 'Question Response too long, only 23 chars per input';
		
		$consult = "SELECT `userid` FROM `login` WHERE `userid`=? LIMIT 1";
		$result = $DB->execute($consult, [$_POST['user']]);
		if ($DB->num_rows())
			$error .= 'User in use';
		
		if (!is_null($error))
		{
			echo $error;
			break;
		}
		
		if ($CONFIG->getConfig('UseGeoLocalization') == 'yes')
			$GIP = geoip_open('GeoIP.dat',GEOIP_STANDARD);
			
		$consult = "
			INSERT INTO `login` (`userid`, `user_pass`, `sex`, `email`, `last_ip`, `pais`, `geo_localization`, `question`, `question_response`) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
		";
		$param = [
			$_POST['user'], 
			$FNC->CheckMD5($_POST['pass']), 
			$_POST['sex'], 
			$_POST['mail'],
			$_POST['ip'], 
			strtolower($_POST['pais']),
			($CONFIG->getConfig('UseGeoLocalization') == 'yes' ? geoip_country_name_by_addr($GIP, $_POST['ip']) : NULL),
			$_POST['question'],
			$_POST['question_response']
		];
		
		$result = $DB->execute($consult, $param);
		
		if ($CONFIG->getConfig('UseGeoLocalization') == 'yes')
			geoip_close($GIP);
		if ($result->rowCount())
		{
			$consult =
			"
				SELECT 
					`account_id`, `userid`, `user_pass`, `geo_localization` FROM `login` 
				WHERE 
					userid =? 
				AND 
					`user_pass`=?
				AND 
					state != '5'
			";
			
			$result = $DB->execute($consult, [$_POST['user'], $FNC->CheckMD5($_POST['pass'])]);
			$row = $result->fetch();
			if (!$DB->num_rows())
			{
				echo 'Wrong username or password';
				exit;
			}

			if ($row)
			{
				$_SESSION['account_id']  = $row['account_id'];
				$_SESSION['userid']		 = $row['userid'];
				$_SESSION['password']	 = $row['user_pass'];
				$_SESSION['ip']			 = $FNC->getIP();
				echo 'ok';
			}
			else 
				echo 'Well the System can\'t login your account, please report it';
		} 
		else
			echo 'something went wrong';
	break;

	/**
	 *
	 *
	 *
	 **/
	case 'CHARPANEL':
		if (!isset($_POST['cid']) || !isset($_POST['slot']) || 	!isset($_POST['nn'])) 
		{
			echo 'Missing fields';
			exit;
		}
		
		$consult = "SELECT `name`, `zeny`, `class`, `char_num`, `last_map`,`partner_id`, `online` FROM `char` WHERE `char_id` = ?";
		$result = $DB->execute($consult, [$_POST['cid']]);

		if (!$DB->num_rows())
		{
			echo 'can not retrive data from char';
			exit;
		}
		
		$row  = $result->fetch();
		$consult = FALSE;
		$error = FALSE;
				
		if ( $_POST['nn'] != $row['name'] ) 
		{
			$consult = "SELECT `name` FROM `char` WHERE `name`=?";
			$result = $DB->execute($consult, [$_POST['nn']]);
			
			if ($DB->num_rows())
				$error = 'User in use. <br/>';
			if(preg_match_all('/[^A-Za-z0-9]/', $_POST['nn'], $matches) >	0)
				$error .= "Incorrect character detected in new name. <br/>";
			if (strlen($_POST['nn']) > 23)
				$error .= "Name too long";
			if (strlen($_POST['nn']) < 4 )
				$error .= 'Name to short <br/>';
		}
			
		if (!empty($error))
		{
			echo $error;
			break;
		} 
			
		$consult = "`name`=?, `char_num`= ?,";
		if (isset($_POST['divorse']))
			$consult .= "`partner_id` = 0, ";
		if (isset($_POST['reset_map']))
			$consult .= "`last_map` = 'prontera', ";
		if (isset($_POST['reset_char']))
			$consult .= "`hair` = 1, `hair_color` = 0, `clothes_color` = 0, ";

		$ALL = 'UPDATE `char` SET '.$consult;
		$ALL = rtrim($ALL, ', ');
		$ALL .= ' WHERE `char_id` = ?';
		$result = $DB->execute($ALL, [$_POST['nn'], $_POST['slot'], $_POST['cid']]);
		
		if ($result->rowCount()) 
		{
			$consult = "INSERT INTO `oboro_nameslog`(`date`,`old_name`,`new_name`)";
			$result = $DB->execute($consult, [date("Y-m-d H:i:s"), $row['name'], $_POST['nn']]);
			if ($DB->num_rows())
				echo 'ok';
			else
				echo 'Log name can\'t be storage, but name has been changed.';
			break;	
		}
		else 
		{
			echo 'Seems to be no changes';
			break;
		}
	break;

	/**
	 *
	 *
	 *
	 **/
	case 'ACCOUNTPANEL':
		if ( 
			isset($_POST['sex']) && 
			isset($_POST['oldpassword']) && 
			isset($_POST['newpassword']) && 
			isset($_POST['pais'])
		) 
		{
			$error = '';
			$consult = "SELECT `userid`,`user_pass`,`email`,`state`,`sex`,`lastlogin`,`last_ip`, `pais` FROM `login` WHERE `account_id` = ?";
			$result = $DB->execute($consult, [$_SESSION['account_id']]);
			if (!$DB->num_rows())
			{
				echo "Something wrong happened";
				exit;
			}
			
			$row = $result->fetch();

			if (!in_array($_POST['sex'], array('F', 'M')))
				$error = 'Invalid Sex. <br/>';
			if (!empty($_POST['newpassword']))
			{
				if (stripos($_POST['newpassword'], $row['userid']) !== false)
					$error .= 'Password must not contain Username <br/>';
				if (!ctype_graph($_POST['newpassword']))
					$error .=  'Invalid character(s) used in password <br/>';
				if(strlen($_POST['newpassword']) < 8)
					$error .= 'Password is too short (min. 8) <br/>';
				if(strlen($_POST['newpassword']) > 26)
					$error .= 'Password is too long (max. 23) <br/>';
				if (preg_match_all('/[A-Z]/', $_POST['newpassword'], $matches) < 1)
					$error .= 'Passwords must contain at least 1 Upper case <br/>';
				if (preg_match_all('/[a-z]/', $_POST['newpassword'], $matches) < 1)
					$error .= 'Passwords must contain at least 1 lower case <br/>';
				if (preg_match_all('/[0-9]/', $_POST['newpassword'], $matches) < 1)
					$error .= 'Passwords must contains at least 1 number <br/>';
				if(preg_match_all('/[^A-Za-z0-9]/', $_POST['newpassword'], $matches) <	1)
					$error .= 'Passwords must contains at least 1 symbol <br/>';
				if ($FNC->CheckMD5($_POST['oldpassword']) != $row['user_pass'])
					$error .= 'Incorrect current password. <br/>';
			}
			
			if ( strlen($_POST['pais']) != 2)
				$error .= 'Pais no valido. <br/>';

			if ( strlen($error) > 0 ) 
			{
				echo $error;
				break;
			}

			if ( empty($_POST['newpassword']))
				$pass = $row['user_pass'];
			else
				$pass = $FNC->CheckMD5($_POST['newpassword']);
				
			$consult = "UPDATE `login` SET `sex`=?, `user_pass`=?, `pais`=? WHERE `account_id`=?";
			$result = $DB->execute($consult, [$_POST['sex'], $pass, strtolower($_POST['pais']), $_SESSION['account_id']]);
				
			if ($result->rowCount())
			{
				if (isset($_POST['recoverSec']))
				{
					$consult =
					"
						SELECT 
							`value` 
						FROM 
							". ($FNC->get_emulator() == EAMOD ? '`global_reg_value`' : '`char_reg_num`')." AS `global`
						WHERE 
							`account_id`=?
						AND 
							`global`.".($FNC->get_emulator() == EAMOD ? '`str`':'`key`')."='#SECURITYCODE'
						LIMIT 1
					";
					$result = $DB->execute($consult, [$_SESSION['account_id']]);
					if ($DB->num_rows())
					{
						$get_sec = $result->fetch();
						mail($row['email'], 'Security Password', 'Your security of the account: '.$row['userid'].' is: '. $get_sec['value']);	
					}
				}
					
				if ( $pass != $row['user_pass'] )
					echo 'okdeslog';
				else
					echo 'ok';
				exit;
			}
			else
			{
				echo 'No changes detected';
				exit;
			}
		}
	break;

	/**
	 *
	 *
	 *
	 **/
	case 'LOGIN_WITH_GEO':
		if (!empty($_POST['user_question_response']) && !empty($_SESSION['GEO_USERID']))
		{
			if(preg_match_all('/[^A-Za-z0-9 ]/', $_POST['user_question_response'], $matches) > 0)
			{
				echo 'Incorrect character detected in Question Response. <br/>';
				break;
			}
			
			$consult = 'SELECT `question_response` FROM `login` WHERE `userid`=?';
			$result = $DB->execute($consult,[$_SESSION['GEO_USERID']]);
			if ($DB->num_rows())
			{
				$row = $result->fetch();
				similar_text(strtolower($row['question_response']), strtolower($_POST['user_question_response']), $similar);
				if ( $similar > 96 )
				{
					$GIP = geoip_open('GeoIP.dat',GEOIP_STANDARD);
					$GeoLocalization = geoip_country_name_by_addr($GIP, $FNC->getIP());
					
					$consult = 'UPDATE `login` SET `geo_localization`=? WHERE `userid`=?';
					$param = [(!empty($GeoLocalization) ? $GeoLocalization : "Undefined" ), $_SESSION['GEO_USERID']];
					$DB->execute($consult, $param);
					geoip_close($GIP);
					
					//el usuario ya había autentificado su cuenta exitosamente...
					//lo que falló fue su localización, no es necesario volver a autentificarlo.
					// con password y login. :) [isaac]
					$consult = 'SELECT `account_id`, `userid`,'.$FNC->get_emulator_query().',`user_pass`  FROM `login` WHERE `userid`=?';
					$result = $DB->execute($consult, [$_SESSION['GEO_USERID']]);
					if ($DB->num_rows())
					{
						$row = $result->fetch();
						$_SESSION['account_id']  = $row['account_id'];
						$_SESSION['userid']		 = $row['userid'];
						$_SESSION['GMACCOUNT']   = $row[($FNC->get_emulator() == EAMOD ? "level" : "group_id")];
						$_SESSION['password']	 = $row['user_pass'];
						$_SESSION['ip']			 = $FNC->getIP();
						echo 'ok';
					} else
						echo 'Something went wrong';
				} else
					echo 'Invalid Answer';
				break;
			} else
				echo 'Something went wrong';
		} else
			echo 'Missing Fields';
	break;
	
	/**
	 *
	 *
	 *
	 **/
	case 'UPDATE_GEO_INFO':
		if (empty($_SESSION['account_id']) || !isset($_POST['question']) || empty($_POST['question_response_update']))
		{
			echo 'Missing Fields';
			exit;
		}
		
		if(preg_match_all('/[^A-Za-z0-9 ]/', $_POST['question_response_update'], $matches) > 0)
		{
			echo 'Incorrect character detected in Question Response. <br/>';
			break;
		}
			
		if ( strlen($_POST['question_response_update']) > 23 )
			$error .= 'Question Response too long (max. 23)';
		
		if ( !is_numeric($_POST['question']))
			$error .= 'Invalid Question';
		
		if (!is_null($error))
		{
			echo $error;
			break;
		}
		
		$GIP = geoip_open('GeoIP.dat',GEOIP_STANDARD);
		$consult = "UPDATE `login` SET `question`=?, `question_response`=? WHERE `account_id`=?";
		$result = $DB->execute($consult, [$_POST['question'], $_POST['question_response_update'], $_SESSION['account_id']]);
		if ($result->rowCount())
			echo 'ok';
		else
			echo 'No changes detected';
	break;
	
	/**
	 *
	 *
	 *
	 **/
	case 'DonationAdminUpdate':
		if (!empty($_POST['item_id']) && isset($_POST['name']) && isset($_POST['desc']) && isset($_POST['dona']))
		{
			$consult = "UPDATE `item_db` SET `name_japanese`= ?, `description`=?, `dona`=? WHERE `id`=?";
			$param = [$_POST['name'],$_POST['desc'],$_POST['dona'],$_POST['item_id']];
			$result = $DB->execute($consult, $param);
			if ($result->rowCount())
			{
				$CACHE->delete('ItemDB');
				echo 'ok';
			} else
				echo 'No changes applied';
		}
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'DonationAdminUpdateImg':
		$fichero_subido = '../../img/db/item_db/large/'.basename($_FILES['image']['name']);
		move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido);
		echo 'ok';
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'BLOG_CREATE_UPDATE':
		if (empty($_POST['blog_title']) || empty($_POST['blog_text']) || !isset($_POST['blog_modify']) || !isset($_POST['blog_category']) || empty($_POST['blog_owner']))
		{
			echo 'missing fields';
			exit;
		}
		
		if (!is_numeric($_POST['blog_modify']))
		{
			$result = $DB->execute("INSERT INTO `oboro_blog`(`date_create`, `title`, `text_html`, `owner_id`, `owner_name`, `blog_class`) VALUES (?,?,?,?,?,?)", [date("Y-m-d"), $_POST['blog_title'], addslashes($_POST['blog_text']), $_SESSION['account_id'], $_POST['blog_owner'], $_POST['blog_category']]);
		
			if ($result->rowCount())
				echo 'ok';
			else
				echo 'something wrong happened';
		}
		else
		{
			$result = $DB->execute("UPDATE `oboro_blog` SET `text_html`=?, `title`=?, `blog_class`=?, `date_modify`=? WHERE `blog_id`=?", [$_POST['blog_text'], $_POST['blog_title'], $_POST['blog_category'],date("Y-m-d"),$_POST['blog_modify']]);
			if ($result->rowCount())
				echo 'ok';
			else
				echo 'something wrong happened';
		}
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'BLOG_GET_TEXT':
		if (!isset($_POST['blog_id']) )
		{
			echo 'missing fields';
			exit;
		}
		
		$row = $DB->execute("SELECT `text_html`, `title`, `blog_class` FROM `oboro_blog` WHERE `blog_id`=?", [$_POST['blog_id']])->fetch();
		$arr = [
			$row['title'],
			$row['text_html'],
			$row['blog_class']
		];
		echo json_encode($arr);
	break;
		
	/**
	 *
	 *
	 *
	 **/
	case 'CREATE_DONATION_ITEM':
		if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id']) || empty($_POST['dona']) || !is_numeric($_POST['dona']))
		{
			echo 'invalid type detected';
			exit;
		}
		
		$result = $DB->execute('UPDATE `item_db` SET `dona`=? WHERE `id`=?', [$_POST['dona'], $_POST['item_id']]);
		if ($result->rowCount())
		{
			//we have to delete the cache.
			$CACHE->delete('ItemDB');
			echo 'ok';
		}
		else
			echo 'item db no existe';
			
	break;
		
	case 'DELETE_DONATION_ITEM':
		if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id']))
		{
			echo 'invalid type detected';
			exit;
		}

		$result = $DB->execute('UPDATE `item_db` SET `dona`=0 WHERE `id`=?', [$_POST['item_id']]);
		if ($result->rowCount())
		{
			//we have to delete the cache.
			$CACHE->delete('ItemDB');
			echo 'ok';
		}
		else
			echo 'item db no existe';
	break;
		
	default:
		echo 'denied';
	break;
}
exit(0);
?>