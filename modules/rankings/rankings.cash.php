
<?php
$consult = 
"
	SELECT 
		`login`.`pais`,`char`.`char_id`,`char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `login`.`sex`, `global`.`str`, `global`.`value` AS `CashPoints`, `char`.`online` 
	FROM `char` 
	LEFT JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
	LEFT JOIN ".($FNC->get_emulator() == EAMOD ? '`global_reg_value`' : '`acc_reg_num`')." AS `global` ON `global`.`account_id` = `char`.`account_id` 
	WHERE 
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0' 
	AND 
		(`global`.`value` > '0') 
	AND 
		(`global`.`str` = '#CASHPOINTS') 
	GROUP BY 
		`login`.`account_id` 
	ORDER BY 
		`CashPoints`+0 DESC 
	LIMIT 0,25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-money", "Ranking Cash");
$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',	
		'sex' 			=>	'Gender', 
		'name'			=>	'Name', 
		'gname'			=>	'Guild Name', 
		'class'			=>	'Job Class', 
		'base_level'	=>	'Base Lv.',
		'job_level'		=>	'Job Lv.',
		'CashPoints'	=>	'Cashpoints',
		'online'		=>	'State'
	), $result
);
$DB->free($result);
echo '</div>';
?>