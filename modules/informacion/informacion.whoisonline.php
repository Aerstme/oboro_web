<?php
$jobs = $_SESSION['jobs'];
$consult =
"
	SELECT 
		`char`.`char_id`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`, `login`.`sex`, `login`.`pais`, `guild`.`name` AS `gname`, `char`.`zeny`,
		`guild`.`guild_id`,`char`.`guild_id`, `guild`.`emblem_data` 
	FROM `char` 
	LEFT JOIN 
		`login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN 
		`guild` ON `guild`.`guild_id` = `char`.`guild_id` 
	WHERE 
		`char`.`online` = 1 
	AND 
		`login`.".$FNC->get_emulator_query()." < 80
";

if (!$NRM->getParam(0))
	$consult .= "ORDER BY `char`.`last_map`";
else
	$consult .= "ORDER BY `guild`.`guild_id` DESC";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-users", "Who is Online");
$FNC->CreateOboroForm("online","informacion.whoisonline");

if (!$NRM->getParam(0))
{
$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'last_map'		=>	'Map'
	), $result
);
$DB->free($result);
} 
else 
{
	$last_guild = FALSE;
	echo "
		<div class='col-lg-12'>
	";
	
	while ( $row = $result->fetch() )
	{
		if ( $last_guild != $row['guild_id'] )
		{
			$emblems[$row['guild_id']] = $row['emblem_data'];
			$last_guild = $row['guild_id'];
			echo 
			"
				<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed table-whoisonline' id='OboroNDT'>
				<tr>
					<th><img src='".$EMB->get_emblem($row['guild_id'])."' alt='X'></th>
					<th>
						". ($row['guild_id'] ? 
							"<a href='?rankings.guildprofile-".$row['guild_id']."'>".$row['gname']." Gld</a></th>" :
							"No Guild")."		
					</th>
					<th>Job</th>
					<th>Gender</th>
					<th>Base Level</th>
					<th>Job Level</th>
					<th>Last Seen</th>
			";
		}
		echo
		"
			<tr>
				<td><img src='./img/db/country_flags/".$row['pais'].".png'></td>
				<td>".$row["name"]."</td>
				<td>". $jobs[$row['class']] ."</td>
				<td><img src='./images/".$row['sex'].".gif'></td>
				<td>".$row['base_level'] ."</td>
				<td>".$row['job_level'] ."</td>
				<td>".$row["last_map"]."</td>
			</tr>
		";		
	}
	$DB->free($result);
	echo '</table></div>';
}
if( isset($emblems) )
	$_SESSION['emblems'] = $emblems;
echo '</div>';
?>