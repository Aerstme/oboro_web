<?php
$consult = 
"
	SELECT 
		`login`.`pais`,`oboro_pvp`.`char_id`, `oboro_pvp`.`kill`, `oboro_pvp`.`dead`, `char`.`name`, `char`.`class`, `login`.`sex`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,`char`.`char_id`
	FROM `oboro_pvp` 
	INNER JOIN `char` ON `char`.`char_id` = `oboro_pvp`.`char_id` 
	INNER JOIN `login` ON `char`.`account_id` = `login`.`account_id`
	WHERE
		`login`.".$FNC->get_emulator_query()." < 80
";

if ($NRM->getParam(0))
{
	$consult .= "AND `char`.`class` = ? ";
	$param = [$NRM->getParam(0)];
}

$consult .=	"ORDER BY `oboro_pvp`.`kill` DESC LIMIT 50";
$result = $DB->execute($consult, $param);

$FNC->CreateOboroTitle("fa-fighter-jet", "Player vs Player Challenge");
$FNC->CreateOboroForm("jobs", "rankings.pvp");

$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'kill'			=>	'Battle Kills',
		'dead'			=>	'Deaths',
		'online'		=>	'State'
	), $result
);
$DB->free();
echo '</div>';
?>