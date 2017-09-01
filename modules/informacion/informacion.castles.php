<?php
$castles = $_SESSION['castles'];

$consult =
"
	SELECT
		`guild`.`guild_id`, guild.`name` as `gname`, guild.`master`, guild.emblem_data, guild_castle.castle_id, guild_rank.offensive_score, guild_rank.posesion_time, guild_rank.defensive_score
	FROM
			`guild`
		INNER JOIN `guild_castle` ON `guild_castle`.`guild_id` = `guild`.`guild_id`
		INNER JOIN `guild_rank` ON `guild_rank`.`castle_id` = `guild_castle`.`castle_id`
	GROUP BY `guild`.`name`
";

$result= $DB->execute($consult);

$FNC->CreateOboroTitle("fa-fighter-jet", "WoE active castles & Owners");
$FNC->CreateOboroDataTable(
	array(
		'castle_id'		=>	'Castle',
		'emblem_data'	=>	'Emblem',
		'gname'			=>	'Guild Owner',	
		'master' 		=>	'Leader', 
		'offensive_score'	=>	'Offensive Score', 
		'defensive_score'	=>	'Defensive Score', 
		'posesion_time'		=>	'Posetion Time', 
	), $result
);
$DB->free($result);
echo '</div>';
?>