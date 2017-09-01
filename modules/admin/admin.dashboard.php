<?php
if (!isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99)
	exit;

    $ErrorInBlog = NULL;
    $ErrorInContable = NULL;
    $ErrorInGeoLocalization = NULL;
    $ErrorInNamesLog = NULL;
    $ErrorInPayPalFailure = NULL;
    $ErrorInPvP = NULL;
    $ErrorInVotePoints = NULL;
    $ErrrorInLogin = NULL;

    $consult = "SELECT blog_id, date_create, title, text_html, blog_class, owner_id, owner_name, date_modify, href, pinned FROM oboro_blog LIMIT 1";
    $result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInBlog = $DB->stmt->errorInfo()[2];

	$consult = "SELECT transaction_id, account_id, email, usd, points FROM oboro_contable LIMIT 1";
    $result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInContable = $DB->stmt->errorInfo()[2];

    $consult = "SELECT id_log, ip, userid, date, zone FROM oboro_geo_localization_fail_log";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInGeoLocalization = $DB->stmt->errorInfo()[2];

    $consult = "SELECT id, date, old_name, new_name FROM oboro_nameslog";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInNamesLog = $DB->stmt->errorInfo()[2];

    $consult = "SELECT consecutivo, ipn_paypal_ip, account_id, transaction_id, email_player, money, date FROM oboro_paypal_on_failure_ip";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInPayPalFailure = $DB->stmt->errorInfo()[2];

    $consult = "SELECT char_id, `kill`, dead FROM oboro_pvp";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInPvP = $DB->stmt->errorInfo()[2];

    $consult = "SELECT accpanelid, date, account_id, ip, panel_id FROM oboro_vote_points";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrorInVotePoints = $DB->stmt->errorInfo()[2];

    $consult = "SELECT pais, last_mac, last_hwid, geo_localization, question, question_response FROM login";
	$result = $DB->execute($consult);
    if ($DB->stmt->errorInfo()[1] != "0000")
        $ErrrorInLogin = $DB->stmt->errorInfo()[2];

function GetErrorFormat($error)
{
	if (is_null($error))
		return '<i class="fa fa-check green"></i>';
	else
		return $error;
}
?>

<div class="row">
    <div class="col-lg-12">
       <h4 class="oboro_h4"><i class="fa fa-cog fa-2x" style="vertical-align: middle;"> </i> <span>Oboro Data Base: Tables Integrity Check</span></h4>
        <table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT">
			<thead>
           		<th>Information</th>
				<th>Table</th>
           		<th>Analice</th>
			</thead>
           <tbody>
				<tr>
					<td>Oboro Blog (used for notices)</td>
					<td>oboro_blog</td>
					<td><?php echo GetErrorFormat($ErrorInBlog) ?></td>
				</tr>
				<tr>
					<td>Oboro Contable (Succesfull Donations)</td>
					<td>oboro_contable</td>
					<td><?php echo GetErrorFormat($ErrorInContable) ?></td>
				</tr>
				<tr>
					<td>GeoLocalization (User have been hacked)</td>
					<td>oboro_geo_localization_fail_log</td>
					<td><?php echo GetErrorFormat($ErrorInGeoLocalization) ?></td>
				</tr>
				<tr>
					<td>Names Log</td>
					<td>oboro_nameslog</td>
					<td><?php echo GetErrorFormat($ErrorInNamesLog) ?></td>
				</tr>
				<tr>
					<td>Paypal Failur IP (detect new PP Ip's)</td>
					<td>oboro_paypal_on_failure_ip</td>
					<td><?php echo GetErrorFormat($ErrorInPayPalFailure) ?></td>
				</tr>
				<tr>
					<td>Player vs Player</td>
					<td>oboro_pvp</td>
					<td><?php echo GetErrorFormat($ErrorInPvP) ?></td>
				</tr>
				<tr>
					<td>Vote 4 Points</td>
					<td>oboro_vote_points</td>
					<td><?php echo GetErrorFormat($ErrorInVotePoints) ?></td>
				</tr>
				<tr>
					<td>Login (Adaptations)</td>
					<td>login</td>
					<td><?php echo GetErrorFormat($ErrrorInLogin) ?></td>
				</tr>
			</tbody>
        </table>
    </div>
</div>

