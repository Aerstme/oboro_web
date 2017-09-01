<?php
$consult = 
"
	SELECT 
		`login`.`pais`,`char`.`char_id`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `login`.`sex`, `guild`.`name` AS `gname`, `char`.`playtime`, `guild`.`guild_id`, `char`.`online`
	FROM `char`
	LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
	WHERE 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`char`.`playtime` > 0
	ORDER BY 
		`char`.`playtime` DESC
	LIMIT 25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-hand-pointer-o", "Ranking Playtime");
$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'playtime'		=>	'Time',
		'online'		=>	'State'
	), $result
);
$DB->free($result);
echo '</div>';
?>