<?php
$consult = 
"
	SELECT `login`.`pais`,`char`.`online`,`char`.`name` AS char_name, `homunculus`.`name` AS hom_name, `homunculus`.`level`, `homunculus`.`class` AS hom_class
	FROM `homunculus` 
	LEFT JOIN `char` ON `char`.`char_id` = `homunculus`.`char_id`
	INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
	ORDER BY 
		`homunculus`.`level` DESC,
		`homunculus`.`exp` DESC 
	LIMIT 25
";

$result = $DB->execute($consult);

$FNC->CreateOboroTitle("fa-exclamation-triangle", "Ranking Homunculus");

$FNC->CreateOboroDataTable(
	array(
		'pais'			=>	'Country',
		'char_name'		=>	'Owner', 
		'hom_name'		=>	'Hom. Name', 
		'level'			=>	'Hom Level',
		'online'		=>	'State'
	), $result
);

$DB->free($result);
echo '</div>';
?>