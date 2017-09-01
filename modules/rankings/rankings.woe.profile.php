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
		`char`.`char_id`, `guild`.`guild_id`, char_wstats.score 
		FROM `char` 
		INNER JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` 
		INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
		LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
		WHERE 
			`char_wstats`.`char_id` > '0' 
		AND
			`login`.".$FNC->get_emulator_query()." < 80
		AND 
			`login`.`state` = '0' 
		AND 
			`char`.`char_id` = ?
";
$result = $DB->execute($consult, [$char_id]);
$data = $result->fetch();
$DB->free($result);
$post = $GV->calc_rank($data['score']);

echo "
	<div class='profile_information_char'>
		<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
			<tr>
				". ( $sid > 0 ? '<th colspan="5">Top 20 ' . $skills[$sid] . ' Casters</th>' : '<th colspan="8">Top 10 Casted Skills</th>') ."
			</tr>
";
	
if(empty($sid)) 
{
	echo "
		<tr>
			<th colspan='2'>Skill Name </th>
			<th>T </th>
			<th>Count </th>
			<th colspan='2'>Skill Name </th>
			<th>T </th>
			<th>Count </th>
		</tr>
	";
	
	$consult = 
	"
		SELECT `char_id`, `id`, `count`
		FROM skill_count 
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
					<td><a OnClick="Oboro.SHOWPROFILE('.$data['char_id'].', '.$skill['id'].', false, 1, '.$eid.', 1);"><img src="./images/casters.png" border="0"></a></td>
					<td align="center">' . $skill['count'] . '</td>
					<td width="24"><img src="./img/db/skill_db/' . $skill['id'] . '.bmp"></td>
					<td>' . $skills[$skill['id']] . '</td>
					<td><a OnClick="Oboro.SHOWPROFILE('.$data['char_id'].', '.$skill['id'].', false, 1, '.$eid.', 1);"><img src="./images/casters.png" border="0"></a></td>
					<td align="center">' . $skill['count'] . '</td>
				</tr>
			';
		} 
	}
}
else
{
	echo "
		<tr>
			<th>Pos</th>
			<th>Caster</th>
			<th>Count</th>
			<th>S.P.M</th>
		</tr>
	";
	
	$consult =
	"
		SELECT 
			`char`.`char_id`, `char`.`name`, `skill_count`.`count` 
		FROM `skill_count` 
		INNER JOIN `char` ON `char`.`char_id` = `skill_count`.`char_id` 
		WHERE `skill_count`.`id` = ?
		ORDER BY 
			`skill_count`.`count` DESC 
		LIMIT 10
	";
	$count = 0;
	$result = $DB->execute($consult, [$sid]);
	
	while ($skill = $result->fetch()) 
	{
		$count++;
		echo '
			<tr>
				<td>' . $count . '</td>
				<td>' . $skill['name'] . '</td>
				<td>' . $skill['count'] . '</td>
				<td>' . (intval($skill['count'] / 120)) . '</td>
			</tr>
		';
	}
}
$DB->free($result);

echo "
	</table>
	<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
	<tr>
		<th colspan='8'>
			Kill Log - Last 10 Kills
		</th>
	</tr>
	<tr>
		<th>Guild</th>
		<th>Victim</th> 		
		<th>P</th> 		
		<th>Map</th> 		
		<th colspan='2'>Attack</th> 	
	</tr>
";

$consult =
"
	SELECT 
		`c`.`killer_id`, `c`.`killed_id`, `c`.`killed`, `c`.`killer`, `c`.`map`, `c`.`skill`, `guild`.name, `guild`.guild_id
	FROM char_woe_log AS `c` 
	INNER JOIN `guild_member` ON `guild_member`.`char_id` = c.`killed_id` 
	INNER JOIN `guild` ON `guild`.guild_id = `guild_member`.`guild_id`
	WHERE 
		`c`.`killer_id` = ? 
	ORDER BY 
		`id` DESC
";

$result = $DB->execute($consult, [$char_id]);

while($klog = $result->fetch())
{	
	echo '
		<tr>
			<td><img src="'.$EMB->get_emblem($klog['guild_id']).'" alt="X"> '.$klog['name'].'</td>
			<td>' . $klog['killed'] . '</td>
			<td><a OnClick="Oboro.SHOWPROFILE('.$klog['killed_id'].',false,false,1, '.$eid.', 1);"><img src="./images/viewprofile.png" border="0"></a></td>
			<td>' . $GV->castles[$klog['map']] . '</td>
	';

	if( $klog['skill'] > 0 ) 
	{
		echo '
			<td width="24"><img src="./img/db/skill_db/' . $klog['skill'] . '.bmp"</td>
			<td>' . $skills[$klog['skill']] . '</td>
		';
	} 
	else 
	{
		echo '
			<td width="24"><img src="./img/db/skill_db/107.bmp"</td>
			<td>Melee/Reflect/Effect</td>
		';
	}
	echo '</tr>';
}
$DB->free($result);

echo "
	</table>

	<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
	<tr>
		<th colspan='7'>
			Death Log - Last 10 Deaths
		</th>
	</tr>
	<tr>
		<td>Guild</td> 
		<td>Assassin</td> 
		<td>P</td>
		<td>C</td> 
		<td>Map</td> 
		<td colspan='2'>Attack</td> 
	</tr>
";
	
$consult =
"
	SELECT 
		`c`.`killer_id`, `c`.`killed_id`, `c`.`map`, `c`.`killed`, `c`.`killer`, `c`.`skill`, `guild`.name, `guild`.guild_id
	FROM char_woe_log AS `c` 
	INNER JOIN `guild_member` ON `guild_member`.`char_id` = c.`killer_id` 
	INNER JOIN `guild` ON `guild`.guild_id = `guild_member`.`guild_id`
	WHERE 
		`c`.`killed_id` = ? 
	ORDER BY 
		`id` DESC
";

$result = $DB->execute($consult, [$char_id]);

while($klog = $result->fetch())
{	
	echo '
		<tr>
			<td><img src="'.$EMB->get_emblem($klog['guild_id']).'" alt="X"> '.$klog['name'].'</td>
			<td>' . $klog['killer'] . '</td>
			<td><a OnClick="Oboro.SHOWPROFILE('.$klog['killer_id'].',false,false,1, '.$eid.', 1);"><img src="./images/viewprofile.png" border="0"></a></td>
			<td>' . $GV->castles[$klog['map']] . '</td>
	';	
	if( $klog['skill'] > 0 ) 
	{
		echo '
			<td><img src="./img/db/skill_db/' . $klog['skill'] . '.bmp"</td>
			<td>' . $skills[$klog['skill']] . '</td>
		';
	} 
	else
	{
		echo '
			<td><img src="./img/db/skill_db/107.bmp"</td>
			<td>Melee/Reflect/Effect</td>
		';
	}
	echo '</tr>';
}
$DB->free();
echo "
	</table>
</div><!-- profile_information_char* -->
";
?>