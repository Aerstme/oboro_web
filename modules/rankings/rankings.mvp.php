<?php

$consult = 
"
	SELECT 
		`char`.`char_id`,`login`.`pais`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`,
		`login`.`sex`, `guild`.`name` AS `gname`, `global`.`value`, `char`.`online`, `guild`.`guild_id` 
	FROM ". ($FNC->get_emulator() == EAMOD ? '`global_reg_value`' : '`char_reg_num`')." AS `global`  
	LEFT JOIN `char` ON `char`.`char_id` = `global`.`char_id` 
	LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
	WHERE 
		`global`.`str` = 'MVPRank' 
	AND 
		`global`.`value` > '0' 
	AND 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0' 
	ORDER BY 
		(`global`.`value` + 0) DESC 
	LIMIT 0, 25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-trophy", "Ranking MVP");
$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'value'			=>	'MVP\'s',
		'online'		=>	'State'
	), $result
);
$DB->free($result);
echo '</div>';