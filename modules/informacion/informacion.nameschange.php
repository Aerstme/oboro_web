<?php
$consult = "SELECT `date`, `old_name`, `new_name` FROM `oboro_nameslog` WHERE `old_name` <> `new_name` ORDER BY `date` desc LIMIT 25";
$result = $DB->execute($consult);
$FNC->CreateOboroTitle("fa-random", "Log name changes");

$FNC->CreateOboroDataTable(
	array(
		'date'			=>	'Date',
		'old_name'		=>	'Old name', 
		'new_name'		=>	'New name', 
	), $result
);

$DB->free($result);
echo '</div>';
?>