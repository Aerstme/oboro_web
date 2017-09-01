<?php
$FNC->CreateOboroTitle("fa-users", "Global Exp. Ranking");
$FNC->CreateOboroForm("jobs", "rankings.exp");

$consult = 
	"
	SELECT `login`.`pais`,`ch`.`char_id`,`ch`.`name`, `ch`.`class`, `ch`.`online`, `ch`.`base_level`, `ch`.`job_level`, `ch`.`account_id`, `ch`.`last_map`, `guild`.`name` AS `gname`,`login`.`sex`, `guild`.`guild_id` 
	FROM `char` AS `ch`
	LEFT JOIN `login` ON `login`.`account_id` = `ch`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `ch`.`guild_id` 
	WHERE 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0'
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
		$consult .= "AND (`ch`.`class` = ? OR `ch`.`class` = ?)";
		$param = [$NRM->getParam(0), $Peco];
	}
	else
	{
		$consult .= "AND `ch`.`class` = ?";
		$param = [$NRM->getParam(0)];
	}
}

$consult .=
	"
	ORDER BY 
		`ch`.`base_level` DESC, `ch`.`base_exp` DESC, 
		`ch`.`job_level` DESC, `ch`.`job_exp` DESC 
	LIMIT 0, 25
";

$result = $DB->execute($consult, $param);

$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'last_map'		=>	'Last Map',
		'online'		=>	'State'
	), $result
);
$DB->free($result);
echo '</div>';