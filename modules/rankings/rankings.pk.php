<?php
$consult = 
"
	SELECT 
		`char`.`char_id`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,`char`.`last_map`, `char_pk`.`score`,
		`char_pk`.`kill_count`, `char_pk`.`death_count`, `guild`.`name` AS `gname`, `login`.`sex`, `guild`.`guild_id` 
	FROM `char_pk` 
	LEFT JOIN `char` ON `char`.`char_id` = `char_pk`.`char_id` 
	LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
	WHERE 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0' 
	AND 
		`char_pk`.`score` > 0 
";

if ($NRM->getParam(0))
{
	switch($NRM->getParam(0)) 
	{
		case 7:		$Peco = 13;		break;
		case 14:	$Peco = 21;		break;
		case 4008:	$Peco = 4014;	break;
		case 4015:	$Peco = 4022;	break;
		case 4030:	$Peco = 4036;	break;
		case 4037:	$Peco = 4044;	break;
		case 4047:	$Peco = 4048;	break;	
	}

	if (!empty($Peco))
	{
		$consult .= "AND (`char`.`class` = ? OR `char`.`class` = ?)";
		$param = [$NRM->getParam(0), $Peco];
	}
	else if (!empty($option))
	{
		$consult .= "AND `char`.`class` = ?";
		$param = [$NRM->getParam(0)];
	}
}

$consult .=
"
	ORDER BY 
		`char_pk`.`score` DESC,
		`char`.`base_level` DESC,
		`char`.`base_exp` DESC,
		`char`.`job_level` DESC,
		`char`.`job_exp` DESC 
	LIMIT 0, 25 
";

$result = $DB->execute($consult, $param);

$FNC->CreateOboroTitle("fa-users", "Ranking Player Killer");
$FNC->CreateOboroForm("jobs", "rankings.pk");

$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class',
		'score'			=>	'Range',
		'kill_count'	=>	'Kills',
		'death_count'	=>	'Deaths',
		'online'		=>	'State',
		'last_map'		=>	'Last Map'
	), $result
);
$DB->free($result);
echo '</div>';
?>