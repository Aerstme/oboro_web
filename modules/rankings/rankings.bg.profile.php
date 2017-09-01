<?php
session_start();
include_once('../../libs/controller.php');

$jobs = $_SESSION['jobs'];
$skills = $_SESSION['skills'];
if( !isset($_POST['cid']) || !is_numeric($_POST['cid']) ) 
	exit;

$char_id = $_POST['cid'];

if(isset($_POST['tid']) && is_numeric($_POST['tid']))
	$tar_id = $_POST['tid'];
else
	$tar_id = 0;

if(isset($_POST['sid']) && is_numeric($_POST['sid']))
	$sid = $_POST['sid'];
else
	$sid = 0;

if(isset($_POST['eid']) && is_numeric($_POST['eid']))
	$eid = $_POST['eid'];
else
	$eid = 0;

$consult = 
"
	SELECT 
		`ch`.`char_id`, `guild`.`guild_id`, char_bg.points, char_bg.deserter, char_bg.score
	FROM `char` AS `ch`
	INNER JOIN `char_bg` ON `char_bg`.`char_id` = `ch`.`char_id` 
	INNER JOIN `login` ON `login`.`account_id` = `ch`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `ch`.`guild_id` 
	WHERE 
		`char_bg`.`char_id` > '0' 
	AND	
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0' 
	AND 
		`ch`.`char_id` = ?
";
$result = $DB->execute($consult, [$char_id]);
$data = $result->fetch();
$DB->free($result);

$post = $GV->calc_rank($data['score']);

echo "
	<div class='profile_information_char'>
		<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
			<tr>
				". ( $sid > 0 ? '<th colspan="10">Top 20 ' . $skills[$sid] . ' Casters</th>' : '<th colspan="8">Top 10 Casted Skills</th>') ."
			</tr>
";

if(empty($sid)) 
{
	echo 
	"
		<tr>
			<th colspan='2'>Skill Name</th>
			<th>T</th>
			<th>Count</th>
			<th colspan='2'>Skill Name</th>
			<th>T</th>
			<th>Count</th>
		</tr>
	";
	
	$consult =
	"
		SELECT `char_id`, `id`, `count`
		FROM bg_skill_count 
		WHERE char_id = ? 
		ORDER BY `count`
		DESC LIMIT 10
	";
	$result = $DB->execute($consult, [$char_id]);
	
	for( $i = 0; $i < 5; $i++ ) 
	{
		if($skill = $result->fetch()) 
		{
			echo '
				<tr>
					<td width="24"><img src="./img/db/skill_db/' . $skill['id'] . '.bmp"></td>
						<td>' . $skills[$skill['id']] . '</td>
					<td><a OnClick="Oboro.SHOWPROFILE('.$data['char_id'].', '.$skill['id'].', false, 0, '.$eid.', 1);"><img src="./images/casters.png" border="0"></a></td>
					<td align="center">' . $skill['count'] . '</td>
					<td width="24"><img src="./img/db/skill_db/' . $skill['id'] . '.bmp"></td>
					<td>' . $skills[$skill['id']] . '</td>
					<td><a OnClick="Oboro.SHOWPROFILE('.$data['char_id'].', '.$skill['id'].', false, 0, '.$eid.', 1);"><img src="./images/casters.png" border="0"></a></td>
					<td align="center">' . $skill['count'] . '</td>
				</tr>
			';
		} 
	}
}
else
{
	echo '
		<tr>
			<th>Pos</th>
			<th>Caster</th>
			<th>Count</th>
			<th>Wins</th>
			<th>Tie</th>
			<th>Lost</th>
			<th>Total</th>
			<th>Rate</th>
			<th>Quit</th>
		</tr>
	';
	
	$consult =
	"
		SELECT `char`.`char_id`, `char`.`name`, `bg_skill_count`.`id`,`bg_skill_count`.`count`, 
		`char_bg`.`win`, `char_bg`.`lost`, `char_bg`.`tie`, `char_bg`.`deserter` 
		FROM `bg_skill_count`
		INNER JOIN `char` ON `char`.`char_id` = `bg_skill_count`.`char_id` 
		INNER JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` 
		WHERE `bg_skill_count`.`id` = ?
		ORDER BY `bg_skill_count`.`count` 
		DESC LIMIT 20
	";

	$result = $DB->execute($consult, [$sid]);

	$count = 0;
	while($skill = $result->fetch())
	{
		$count++;
		$total = $skill['win'] + $skill['tie'] + $skill['lost'];
		echo '
			<tr>
				<td>' . ($char_id == $skill['char_id'] ? '<b>' . $count . '</b>' : $count) . '</td>
				<td>' . ($char_id == $skill['char_id'] ? '<b>' . $skill['name'] . '</b>' : $skill['name']) . '</td>
				<td>' . $skill['count'] . '</td>
				<td>' . $skill['win'] . '</td>
				<td>' . $skill['tie'] . '</td>
				<td>' . $skill['lost'] . '</td>
				<td>' . $total . '</td>
				<td>' . ($total > 0 ? intval($skill['count'] / $total) : "--") . '</td>
				<td>' . $skill['deserter'] . '</td>
			</tr>
		';
	}
} 
$DB->free($result);

echo 
"
	</table>
		<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
		<tr>
			<th colspan='7'>
				".($tar_id ? 'Kill Log - Comparative' : 'Kill Log - Last 10 Kills')."
			</th>
		</tr>
		<tr>
			<th>Date/Time</th>
			<th>P</th>
			<th>Victim</th>
			<th>Map</th>
			<th colspan='2'>Attack</th>
		</tr>
";

$consult = 
"
	SELECT c.*,g.name,g.guild_id 
	FROM char_bg_log AS c 
	INNER JOIN guild_member AS gm ON gm.char_id = c.killed_id 
	INNER JOIN guild AS g ON g.guild_id = gm.guild_id 
	WHERE killer_id = ?
	ORDER BY `id` DESC
	LIMIT 10
";

$result = $DB->execute($consult, [$char_id]);
while($klog = $result->fetch())
{
	echo '
		<tr>
			<td>' . $klog['time'] . '</td>
			<td><a OnClick="Oboro.SHOWPROFILE('.$klog['killer_id'].',false,false,0, '.$eid.', 1);"><img src="./images/viewprofile.png" border="0"></a></td>
			<td>' . $klog['killed'] . '</td>
			<td>' . $GV->bgs[$klog['map']] . '</td>
	';
	
	if( $klog['skill'] > 0 ) 
	{
		echo '
			<td><img src="./img/db/skill_db/' . $klog['skill'] . '.bmp" alt="X" /></td>
			<td>' . $skills[$klog['skill']] . '</td>
		';
	} 
	else 
	{
		echo '
			<td width="24"><img src="./img/db/skill_db/107.bmp" /></td>
			<td>Melee/Reflect/Effect</td>
		';
	}
		echo '</tr>';
}
$DB->free($result);
echo 
"
	</table>
		<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
		<tr>
			<th colspan='7'>
				".	($tar_id ? "Death Log - Comparative" : "Death Log - Last 10 Deaths"	) ."
			</th>
		</tr>
		<tr>
			<th>Date/Time</th>
			<th>P</th>
			<th>Assassin</th>	
			<th>Map</th>
			<th colspan='2'>Attack</th>
		</tr>
";

$consult = "SELECT * FROM char_bg_log WHERE killed_id = ? ORDER BY `id` DESC LIMIT 10";
$result = $DB->execute($consult, [$char_id]);
while($klog = $result->fetch()) 
{
	echo '
		<tr>
			<td>' . $klog['time'] . '</td>
			<td><a OnClick="Oboro.SHOWPROFILE('.$klog['killed_id'].',false,false,0, '.$eid.', 1);"><img src="./images/viewprofile.png" border="0"></a></td>
			<td><a OnClick="Oboro.SHOWPROFILE('. $klog['killed_id'] .',false,'.$klog['killer_id'].',0, '.$eid.', 1);"><img src="./images/compare.png" border="0"></a></td>
			<td>' . $klog['killer'] . '</td>
			<td>' . $GV->bgs[$klog['map']] . '</td>
	';
	if( $klog['skill'] > 0 ) 
	{
		echo '
			<td width="24"><img src="./img/db/skill_db/' . $klog['skill'] . '.bmp" /></td>
			<td>' . $skills[$klog['skill']] . '</td>
		';
	} 
	else 
	{
		echo '
			<td width="24"><img src="./img/db/skill_db/107.bmp" /> </td>
			<td>Melee/Reflect/Effect</td>
		';
	}
	echo ' </tr> ';
}
$DB->free();
echo '</table></div>';
?>