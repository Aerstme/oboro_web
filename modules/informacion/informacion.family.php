<?php
$consult = "
	SELECT 
		`F`.`name` AS `padre`, `F`.`class` AS `fclass`, `F`.`base_level` AS `flevel`, `F`.`job_level` AS `fjob`, 
		`M`.`name` AS `madre`, `M`.`class` AS `mclass`, `M`.`base_level` AS `mlevel`, `M`.`job_level` AS `mjob`, 
		`S`.`name` AS `hijo`,  `S`.`class` AS `sclass`, `S`.`base_level` AS `slevel`, `S`.`job_level` AS `sjob` 
	FROM `char` `S` 
	JOIN `char` `F` ON `F`.`char_id` = `S`.`father` 
	JOIN `char` `M` ON `M`.`char_id` = `S`.`mother`
";
$result = $DB->execute($consult);
$FNC->CreateOboroTitle("fa-users", "Families");

$FNC->CreateOboroDataTable(
	array(
		'padre'			=>	'Father',
		'fclass'		=>	'Father Job', 
		'madre'			=>	'Mother', 
		'mclass'		=>	'Mother Job', 
		'hijo'			=>	'Son',
		'sclass'		=>	'Son Job'
	), $result
);
$DB->free($result);
echo '</div>';
?>