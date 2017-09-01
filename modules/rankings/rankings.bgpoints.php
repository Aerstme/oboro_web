<?php
$consult =	
"
	SELECT  DISTINCT 
		`login`.`pais`,`ch`.`char_id`,`ch`.`name`,`ch`.`online`,`base_level`, `job_level`,`global`.`value`,`login`.`sex`, `ch`.`class`, `guild`.`name` AS `gname`, `guild`.`guild_id`
	FROM ". ($FNC->get_emulator() == EAMOD ? '`global_reg_value`' : '`acc_reg_num`')." AS `global` 
	INNER JOIN `char` AS `ch` ON `ch`.`account_id` = `global`.`account_id` 
	INNER JOIN `login` AS `login` ON `login`.`account_id` = `ch`.`account_id` 
	INNER JOIN `guild` ON `guild`.`guild_id` = `ch`.`guild_id`
	WHERE 
		`global`.`str`='#BGPOINTS'
	AND
		`login`.".$FNC->get_emulator_query()." < 80
	GROUP BY
		`ch`.`account_id` ORDER BY (`global`.`value`+00) 
	DESC
	LIMIT 0, 25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-fighter-jet", "Ranking BG Points");
$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'value'			=>	'Battle Points',
		'online'		=>	'State'
	), $result
);
$DB->free($result);
echo '</div>';
?>
	