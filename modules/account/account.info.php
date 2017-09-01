<?php
if (!isset($_SESSION['account_id']) || empty($_SESSION['account_id'])) 
	exit;
	
$consult =
"
	SELECT 
		`login`.`userid`,`login`.`user_pass`,`login`.`email`,`login`.`state`,`login`.`sex`,`login`.`lastlogin`,`login`.`last_ip`, `login`.`pais`
	FROM 
		`login` 
	WHERE 
		`account_id` = ?
";
$result = $DB->execute($consult, [$_SESSION['account_id']]);
$row = $result->fetch();
$DB->free($result);
$jobs = $_SESSION['jobs'];
?>

<div class="row">
	<div class="col-lg-12">
		
		<h4 class="oboro_h4"><i class="fa fa-user-circle" aria-hidden="true"></i> Profile And Character Settings</h4>
	
		<form class="OBOROBACKWORK">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-lg-11 panel-heading-title">
						<i class="fa fa-tasks"></i>  Account Information: Update Your Profile
					</div>
					<div class="col-lg-1 text-align-right">
						<div class="btn btn-default btn-cierra">	
							<i class="fa fa-window-restore" aria-hidden="true"></i>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroNDT">
						<th colspan="4" class="oboro_th">
							<i class="fa fa-pencil-square-o"></i> Basic Settings
						</th>
						<tr>
							<td><i class="fa fa-user"></i> Account</td>
							<td><input name="cuenta" class="form-control" type="text" value="<?php echo $row["userid"] ?>" readonly></td>
							<td><i class="fa fa-venus-mars"></i> Sex</td>
							<td>
								<?php 
									echo $FNC->CDD('sex', $row, $GV, '');
								?>
							</td>
						</tr>
						<tr>
							<td><i class="fa fa-inbox"></i> E-mail</td>
							<td><input  type="text" name="email" class="form-control" value="<?php echo $row["email"] ?>" readonly></td>
							<td><i class="fa fa-slack"></i> Last Int. Prot.</td>
							<td><input name="ip" type="text" class="form-control" value="<?php echo $row['last_ip'] ?>" readonly /></td>
						</tr>
						<tr>
							<td><i class="fa fa-barcode"></i> Last login</td>
							<td><input  name="login" class="form-control" type="text" value="<?php echo $row['lastlogin'] ?>" readonly /></td>
							<td><i class="fa fa-exclamation-triangle"></i> State</td>
							<td><input  type="text" name="ban" class="form-control" maxlength="24" size="23" value="<?php echo ($row['state'] > 0 ? 'Baned': 'Player') ?>" readonly></td>
						</tr>
						<tr>
							<td><i class="fa fa-flag" aria-hidden="true"></i> Country</td>
							<td><img src="./img/db/country_flags/<?php echo $row['pais']?>.png"></td>
							<td><i class="fa fa-flag" aria-hidden="true"></i> Update Country Flag</td>
							<td><?php echo $FNC->CDD('pais', $row, $GV, ''); ?></td>
						</tr>
						<tr>
							<th colspan="4" class="oboro_th">
								<i class="fa fa-pencil-square-o"></i> Change Password n Security Settings
							</th>
						</tr>
						<tr>
						
							<td><input class="form-control" type="password" name="oldpassword" placeholder="Old password"></td>
							<td><input type="password" class="form-control" name="newpassword" placeholder="New password"></td>
							<td><input type="checkbox" name="recoverSec" /> Recover security Code</td>
							<td>
								<input type="hidden" name="OPT" value="ACCOUNTPANEL">
								<input type="submit" class="btn btn-primary" value="Update Information">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
	$consult = "
		SELECT 
			`loginlog`.`time`, `loginlog`.`ip`, `loginlog`.`user`, `loginlog`.`log`, `loginlog`.`mac`
		FROM
			`loginlog`
		INNER JOIN
			`login` ON `login`.`userid` = `loginlog`.`user`
		WHERE
			`login`.`account_id`=?
	";
	$result = $DB->execute($consult, [$_SESSION['account_id']]);
?>

<div class="row">
	<div class="col-lg-12">
		<form class="ipform">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-lg-11 panel-heading-title">
						<i class="fa fa-tasks"></i>  Security Information
					</div>
					<div class="col-lg-1 text-align-right">
						<div class="btn btn-default btn-cierra">	
							<i class="fa fa-window-restore" aria-hidden="true"></i>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body" style="display:none;">
					<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroDT">
					<thead>
						<th>Date</th>
						<th>User</th>
						<th>Int. Prot.</th>
						<th>MAC Addrs.</th>
						<th>Log</th>
					</thead>
					<tbody>
						<?php
							while( $row = $result->fetch())
							{
								echo '
									<tr>
										<td>'.$row["time"].'</td>
										<td>'.$row["userid"].'</td>
										<td>'.$row["ip"].'</td>
										<td>'.$row["mac"].'</td>
										<td>'.$row["log"].'</td>
									</tr>
								';
							}
							$DB->free($result);
						?>
					</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>

<?php 
if ($CONFIG->getConfig('UseGeoLocalization') == 'yes') 
{
	$consult = "SELECT `geo_localization`, `question`, `question_response` FROM `login` WHERE `account_id`=?";
	$result = $DB->execute($consult, [$_SESSION['account_id']]);
?>	

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-lg-11 panel-heading-title">
						<i class="fa fa-tasks"></i>  Geo-Localization Security Management
					</div>
					<div class="col-lg-1 text-align-right">
						<div class="btn btn-default btn-cierra">	
							<i class="fa fa-window-restore" aria-hidden="true"></i>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body" style="display:none;">
					<form class="OBOROBACKWORK">
						<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroNDT">
							<thead>
								<th>User From</th>
								<th>Question Sec.</th>
								<th>Answer</th>
								<th>Update Security</th>
							</thead>
							<tbody>
								<?php
									if ($DB->num_rows())
									{
										$row = $result->fetch();
										$DB->free($result);
										echo '
											<tr>
												<td>'.$row["geo_localization"].'</td>
												<td>'.$FNC->CDD("question", $row, $GV, $row["question"]).'</td>
												<td>'.$FNC->C_INPUT("text", "", "form-control", "question_response_update", $row["question_response"], "Please input a secure information") .'</td>
												<td>
													<input type="hidden" name="OPT" value="UPDATE_GEO_INFO">
													<input type="submit" value="Update" class="btn btn-primary width_100">
												</td>
											</tr>
										';
									}
								?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	
<?php 
}

$consult = "SELECT `char_id`,`name`, `zeny`, `class`, `char_num`, `last_map`,`partner_id` FROM `char` WHERE `account_id` = ? and `online`=0";
$result = $DB->execute($consult, [$_SESSION['account_id']]);
?>
	
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="col-lg-11 panel-heading-title">
					<i class="fa fa-tasks"></i>  Character Information: Update Char's Settings
				</div>
				<div class="col-lg-1 text-align-right">
					<div class="btn btn-default btn-cierra">	
						<i class="fa fa-window-restore" aria-hidden="true"></i>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed Form_in_table' id="OboroNDT">
				<thead>
					<tr>
						<th style="width:11.2%;">Class</th>
						<th style="width:17%;">Change Name</th>
						<th style="width: 11.2%;">Divorce</th>
						<th style="width:16%;">Slot</th>
						<th style="width:11%;">Current Map</th>
						<th style="width:11%;">Map Crash</th>
						<th style="width:11%;">Char Crash</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$consult="SELECT `char_id`,`char_num` FROM `char` WHERE `account_id`=?";
						$result2 = $DB->execute($consult, [$_SESSION['account_id']]);
						$cid = array();
						$cnum = array();

						while ($row = $result2->fetch()) 
							array_push($cnum, $row["char_num"]);
						$DB->free($result2);	
					
						while ($row = $result->fetch())
						{
							
							echo '
								<tr><td colspan="8" class="nopadding">
									<form class="OBOROBACKWORK">
										<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed Form_in_table" id="OboroNDT">
											<tr>
												<td>'.$jobs[$row["class"]].'</td>
												<td style="width:17%;"><input name="nn" class="form-control" type="text" value="'.$row["name"].'"></td>
												<td>'.($row["partner_id"] > 0 ? '<input type="checkbox" name="divorse" /> Divorse' : 'Single').'</td>
												<td class="fix_selectpicker_width">
													<select name="slot" class="selectpicker">
														  <optgroup label="available fields">			
							';
															for ( $i = 0; $i < 14; $i++ )
															{
																if (in_array($i, $cnum) && $row["char_num"] != $i )
																	continue;
																else
																	echo '<option value="'.$i.'"'.($row["char_num"] == $i ? 'selected':'').'>'.$i;
															}
							echo '
														</optgroup>
													</select>
													<div class="clearfix"></div>
												</td>
												<td>'.$row["last_map"].'</td>
												<td><input type="checkbox" name="reset_map" /> Reset Map</td>
												<td><input type="checkbox" name="reset_char" /> Reset Char</td>
												<td>
													<input type="hidden" name="OPT" value="CHARPANEL">
													<input type="hidden" name="cid" value="'.$row['char_id'].'">
													<input type="submit" class="btn btn-primary" value="Update">
												</td>
											</tr>
										</table>
									</form>
								</td></tr>
							';
						}
						$DB->free($result);
					?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>