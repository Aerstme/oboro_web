
<div class="row">
	<div class="ranking_pj">
		<h4 class="oboro_h4_2">Top All Ranking</h4>

		<div class="ranking_container">
			<div class="row">

				<?php
					$consult = 
					"
					SELECT 
						`char`.`name`, `login`.`sex`, `guild`.`name` AS gname,`oboro_pvp`.`kill`+00000 as `score`
					FROM `char` 
					INNER JOIN 	`oboro_pvp` ON `char`.`char_id` = `oboro_pvp`.`char_id` 
					INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
					LEFT JOIN `guild` ON `guild`.char_id = `char`.`char_id`
					ORDER BY 
						(`oboro_pvp`.`kill`+000) DESC 
					LIMIT 1
					";
					$result = $DB->execute($consult);
					$row = $result->fetch();
				?>
				<div class="col-xs-4">
					<div class="ranking_char_panel">
						<div class="ranking_title">Best PvP Player</div>
						<div class="ranking_inside">
							<div class="col-xs-4">
								<?php 
								if ( isset($row["class"]) )
									echo "<img src='./images/class/".$row["sex"]."/".$row["class"].".gif' style='width:46px;' />";
								else
									echo "<img src='./images/class/M/0.gif' style='width:46px;' />";
								?>
							</div>
							<div class="col-xs-8">
								<ul class="list-unstyled">
									<li>Name: <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
									<li>Guild: <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
									<li>Score: <?php echo (isset($row["score"]) ? $row["score"] : '-') ?> pts.</li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<?php
					$consult =
					"
						SELECT 
							`char`.`name`, `login`.`sex`, `char`.`class`, `CWS`.`kill_count`, `guild`.`name` AS `gname` 
						FROM `char`
						INNER JOIN `char_wstats` AS `CWS` ON `CWS`.`char_id` = `char`.`char_id`
						INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
						LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
						ORDER BY 
							`CWS`.`kill_count` 
						DESC LIMIT 1		
					";
					$result = $DB->execute($consult);
					$row = $result->fetch();
				?>
				<div class="col-xs-4">
					<div class="ranking_char_panel">
						<div class="ranking_title">Best Woe Player</div>
						<div class="ranking_inside">
							<div class="col-xs-4">
								<?php 
								if ( isset($row["class"]) )
									echo "<img src='./images/class/".$row["sex"]."/".$row["class"].".gif' style='width:46px;' />";
								else
									echo "<img src='./images/class/M/0.gif' style='width:46px;' />";
								?>								</div>
							<div class="col-xs-8">
								<ul class="list-unstyled">
									<li>Name: <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
									<li>Guild: <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
									<li>Score: <?php echo (isset($row["kill_count"]) ? $row["kill_count"] : '0') ?> pts.</li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<?php
					$consult = 
					"
						SELECT 
							`char`.`name`, `login`.`sex`, `char`.`class`, `CWS`.`kill_count`, `guild`.`name` as gname
						FROM `char` 
						INNER JOIN `char_bg` AS `CWS` ON `CWS`.`char_id` = `char`.`char_id` 
						INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
						LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
						ORDER BY 
							`CWS`.`kill_count` DESC 
						LIMIT 1
					";
					$result = $DB->execute($consult);
					$row = $result->fetch();
				?>

				<div class="col-xs-4">
					<div class="ranking_char_panel">
						<div class="ranking_title">Best Bg killer</div>
						<div class="ranking_inside">
							<div class="col-xs-4">
								<?php 
								if ( isset($row["class"]) )
									echo "<img src='./images/class/".$row["sex"]."/".$row["class"].".gif' style='width:46px;' />";
								else
									echo "<img src='./images/class/M/0.gif' style='width:46px;' />";
								?>	
							</div>
							<div class="col-xs-8">
								<ul class="list-unstyled">
									<li>Name: <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
									<li>Guild: <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
									<li>Score: <?php echo (isset($row["kill_count"]) ? $row["kill_count"] : '0') ?> pts.</li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$DB->free($result);
?>