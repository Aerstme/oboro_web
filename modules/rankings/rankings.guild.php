<?php
$FNC->CreateOboroTitle("fa-space-shuttle", "Guild Ranking");
$FNC->CreateOboroForm("castle", "rankings.guild");

if (!$NRM->getParam(0))
{
	$consult = "SELECT `name`, `emblem_data`, `guild_lv`, `exp`, `guild_id`, `average_lv` FROM `guild` ORDER BY `guild_lv` DESC, `exp` DESC LIMIT 25";
	$result = $DB->execute($consult);
	
	$FNC->CreateOboroDataTable(
		array(
			'emblem_data'	=>	'Emblem', 
			'guild_id'		=>	'Guild Name', 
			'guild_lv'		=>	'Level', 
			'exp'			=>	'Experience',
			'average_lv'	=>	'Average Lv.',
		), $result
	);
} 
else
{
	$consult = 
	"
		SELECT 
			`guild_castle`.`castle_id`, `guild_castle`.`economy`, `guild_castle`.`defense`, 
			`guild`.`guild_id`, `guild`.`name`, `guild`.`emblem_data`
		FROM 
			`guild_castle` 
		LEFT JOIN 
			`guild` ON `guild`.`guild_id` = `guild_castle`.`guild_id` 
		WHERE 
			`guild_castle`.`guild_id` > 0 
		ORDER BY 
			`guild_castle`.`castle_id`
	";
	
	$result = $DB->execute($consult);
	$FNC->CreateOboroDataTable(
		array(
			'emblem_data'	=>	'Emblem', 
			'guild_id'		=>	'Guild Name', 
			'castle_id'		=>	'Castle',
			'economy'		=>	'Economy',
			'defense'		=>	'Defense',
		), $result
	);
}
$DB->free();
echo '</div>';
?>