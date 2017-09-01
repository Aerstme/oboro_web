<?php
$consult =
"
	SELECT 
		`char`.`char_id`,`login`.`pais`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`last_map`,`login`.`sex`, `guild`.`name` AS `gname`, `char`.`zeny`, `guild`.`guild_id`, `char`.`online` 
	FROM `char` 
	LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
	WHERE 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0' AND `char`.`zeny` > 100000 
	ORDER BY `zeny` DESC LIMIT 0, 25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-users", "Top millionaire players");

$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class',
		'zeny'			=>	'Zeny',
		'online'		=>	'State',
	), $result
);
$DB->free($result);
echo '</div>';