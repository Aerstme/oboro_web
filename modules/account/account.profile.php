<?php
$jobs = $_SESSION['jobs'];

if (!$NRM->getParam(0))
	exit;

$consult = 
"
	SELECT 
		`char`.`name`,`char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`,`guild`.`name` AS `gname`, `guild`.`guild_id`, `login`.`pais` 
	FROM 
		`char`
	LEFT JOIN
		`guild` ON `guild`.`guild_id` = `char`.`guild_id`
	INNER JOIN
		`login` ON `login`.`account_id` = `char`.`account_id`
	WHERE 
		`char`.`char_id`=?
";

$result = $DB->execute($consult, [$NRM->getParam(0)]);

if (!$DB->num_rows())
	exit;

$row = $result->fetch();
?>

<div class="row">
	<div class="col-lg-12">
		<div id="profile-image">
			<div class="row">
				<div class="col-lg-8">
					<div class="profile-name">
						<?php echo $row['name'] . ' ' . ($row['online']?'<span class="fix-on online">Online</span>':'<span class="fix-on offline">Offline</span>'); ?></div>
					<div class="profile-job">Class:
						<?php echo $jobs[$row['class']] . ' (' . $row['base_level'] . '/' . $row['job_level'] . ')'; ?>
					</div>
					<div class="profile-guild">Guild:
						<?php echo (!empty($row['gname']) ? '<a href="?rankings.guildprofile-'.$row['guild_id'].'">' . $row['gname'] . '</a>' : 'None') ?></div>
					<div class="btn-group profile-btns" role="group" aria-label="...">
						<a href="?account.profile-<?php echo $NRM->getParam(0); ?>-0" class="btn btn-default"><i class="fa fa-home" aria-hidden="true"></i></a>
						<a href="?account.profile-<?php echo $NRM->getParam(0); ?>-1" class="btn btn-default">War Of Emperium Profile</a>
						<a href="?account.profile-<?php echo $NRM->getParam(0); ?>-2" class="btn btn-default">Battleground Profile</a>
						<a class="btn btn-default">Player Vs Player Statistics</a>
					</div>
				</div>
				<div class="col-lg-4"></div>
			</div>
		</div>
		<div id="ladder_div">
			<?php
	//woe profile
	if ($NRM->getParam(1) && $NRM->getParam(1) == 1)
	{
		$begin = 1;
		$consult =
		"
			SELECT 
				`char`.`char_id`, `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`,
				`char`.`str`, `char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `login`.`sex`, `guild`.`name` AS `gname`, `guild`.`guild_id`,
				`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`, `char_wstats`.`top_damage`, `char_wstats`.`damage_done`, 
				`char_wstats`.`damage_received`,`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, 
				`char_wstats`.`gstone_damage`, `char_wstats`.`emperium_kill`,`char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`,`char_wstats`.`gstone_kill`,
				`char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`,`char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, 
				`char_wstats`.`blue_gemstones`, `char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`,`char_wstats`.`acid_demostration_fail`, 
				`char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,`char_wstats`.`wrong_support_skills_used`,
				`char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
			FROM `char` 
			INNER JOIN `char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` 
			INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
			INNER JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
			WHERE 
				`char_wstats`.`char_id` > '0' 
			AND	
				`login`.".$FNC->get_emulator_query()." < 80
			AND 
				`login`.`state` = '0'
			AND 
				`char`.`char_id`=?
		";

		$while = $DB->execute($consult, [$NRM->getParam(0)]);
		$row = $while->fetch();
		if ($DB->num_rows())
		{
			$post = $GV->calc_rank($row['score']);
			$sex_img = $row['sex'] . "/" . $row['class'];
		?>

				<div class='row'>
					<div>
						<div class='panel panel-default'>
							<div class='panel-body woe-panel-body'>
								<div class='rank_container'>
									<div class='oboro-col-xs-4 nopadding'>
										<div class="user_class_img" style='background:url(./images/class/<?php echo $sex_img ?>.png'>
											<div class="character_emblem_info">
												<img src="<?php echo $EMB->get_emblem($row['guild_id']) ?>" alt='X'>
											</div>
											<ul class="list-unstyled character_information_image">
												<li>Guild:
													<?php echo ( $row['gname'] == '' ? '- No guild -' : $row['gname'] ) ?>
												</li>
												<li>Name: <strong> <?php echo $row['name'] ?> </strong></li>
												<li><b>Job: </b>
													<?php echo $jobs[$row['class']] ?>
												</li>
												<li><b>HP / SP </b>
													<font color='#FF0000'>
														<?php echo $row['max_hp'] ?>
													</font> /
													<font color='#00aeff'>
														<?php echo $row['max_sp'] ?>
													</font>
												</li>
												<li><b><img src='./images/viewprofile.png' border='0' ><a OnClick='Oboro.SHOWPROFILE(<?php echo $row['char_id'] ?>,false,false,1,1);'> More Information</a></b></li>
											</ul>
										</div>
									</div>
									<!-- COL-LG-4 -->

									<div class='oboro-col-xs-8 nopadding'>
										<div class="row">
											<div class="col-md-6 col-xs-6 nopadding" style="padding-right:5px !important;">
												<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
													<tr>
														<th colspan='2'>General Standings</th>
													</tr>
													<tr>
														<td>kills</td>
														<td>
															<?php echo (isset($row['kill_count']) ? $row['kill_count']:'0') ?>
														</td>
													</tr>
													<tr>
														<td>Death</td>
														<td>
															<?php echo (isset($row['death_count']) ? $row['death_count']:'0') ?>
														</td>
													</tr>
													<tr>
														<td>Score</td>
														<td>
															<?php echo (isset($row['score']) ? $row['score']:'0') ?>
														</td>
													</tr>
												</table>
											</div>
											<div class="col-md-6 col-xs-6 nopadding" style="padding-left:5px !important;">
												<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
													<tr>
														<th colspan='2'>Damage vs Player</th>
													</tr>
													<tr>
														<td>Best</td>
														<td>
															<?php echo (isset($row['top_damage'])?$row['top_damage']:'0') ?>
														</td>
													</tr>
													<tr>
														<td>Done</td>
														<td>
															<?php echo (isset($row['damage_done'])?$row['damage_done']:'0') ?>
														</td>
													</tr>
													<tr>
														<td>Recv</td>
														<td>
															<?php echo (isset($row['damage_received'])?$row['damage_received']:'0') ?>
														</td>
													</tr>
												</table>
											</div>
										</div>
										<div class="row">
											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th colspan='5'>Structures</th>
												</tr>
												<tr>
													<th>Option</th>
													<th>Emperium</th>
													<th>Barricade</th>
													<th>G.Stone</th>
													<th>Guardian</th>
												</tr>
												<tr>
													<td>Damage vs Structs</td>
													<td>
														<?php echo (isset($row['emperium_damage'])?$row['emperium_damage']:'0')?>
													</td>
													<td>
														<?php echo (isset($row['barricade_damage'])?$row['barricade_damage']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['gstone_damage'])?$row['gstone_damage']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['guardian_damage'])?$row['guardian_damage']:'0') ?>
													</td>
												</tr>
												<tr>
													<td>Eliminated Structures</td>
													<td>
														<?php echo (isset($row['emperium_kill'])?$row['emperium_kill']:'0')?>
													</td>
													<td>
														<?php echo (isset($row['barricade_kill'])?$row['barricade_kill']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['gstone_kill'])?$row['gstone_kill']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['guardian_kill'])?$row['guardian_kill']:'0') ?>
													</td>
												</tr>
											</table>
											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th>Option</th>
													<th>Support Skills</th>
													<th>Total Healing</th>
												</tr>
												<tr>
													<td>Correct</td>
													<td>
														<?php echo (isset($row['support_skills_used'])?$row['support_skills_used']:'0')?>
													</td>
													<td>
														<?php echo (isset($row['healing_done'])?$row['healing_done']:'0')?>
													</td>
												</tr>
												<tr>
													<td>Erroneo</td>
													<td>
														<?php echo (isset($row['wrong_support_skills_used'])?$row['wrong_support_skills_used']:'0')?>
													</td>
													<td>
														<?php echo (isset($row['wrong_healing_done'])?$row['wrong_healing_done']:'0')?>
													</td>
												</tr>
											</table>
											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th colspan='5'>Usable Items</th>
												</tr>
												<tr>
													<td><img src='./img/db/item_db/small/522.png' />HP :
														<?php echo (isset($row['hp_heal_potions'])?$row['hp_heal_potions']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/526.png' />SP :
														<?php echo (isset($row['sp_heal_potions'])?$row['sp_heal_potions']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/715.png' />Gems :
														<?php echo (isset($row['yellow_gemstones'])?$row['yellow_gemstones']:'0') ?> </td>
													<td><img src='./img/db/item_db/small/716.png' />Gems :
														<?php echo (isset($row['red_gemstones'])?$row['red_gemstones']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/717.png' />Gems :
														<?php echo (isset($row['blue_gemstones'])?$row['blue_gemstones']:'0') ?>
													</td>
												</tr>
												<tr>
													<td colspan='2'><img src='./img/db/item_db/small/676.png'>Total zeny :
														<?php echo (isset($row['zeny_used'])?$row['zeny_used']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/1752.png'>Arrow :
														<?php echo (isset($row['ammo_used'])?$row['ammo_used']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/7136.png'>Bottle :
														<?php echo (isset($row['acid_demostration'])?$row['acid_demostration']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/678.png'>Bottle :
														<?php echo (isset($row['poison_bottles'])?$row['poison_bottles']:'0') ?>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<!-- COL-LG-8 -->
									<div class="clearfix"></div>
								</div>
								<!-- rank_normal_hide -->
								<div id='dinamically_load_ranking_1'></div>
							</div>
							<!-- panel-body -->
						</div>
						<!-- panel panel-default -->
					</div>
					<!-- col-lg-12 -->
				</div>
				<!-- row -->
				<?php
			} 
			else
			{	
				echo 'this Character has not WOE Information to provide';
			}
		}
		else if ($NRM->getParam(1) && $NRM->getParam(1) == 2)
		{
			$consult =
			"
				SELECT 
					ch.char_id, ch.`name`, ch.class, ch.base_level, ch.job_level, ch.playtime, ch.max_hp, ch.max_sp, ch.str, ch.`int`, ch.vit, ch.dex, ch.agi, ch.luk,
					ch.bg_gold, ch.bg_silver, ch.bg_bronze, login.sex, guild.`name` AS gname, guild.guild_id, char_bg.top_damage, char_bg.damage_done, 
					char_bg.damage_received, char_bg.emperium_kill, char_bg.barricade_kill, char_bg.gstone_kill, char_bg.win, char_bg.lost, char_bg.tie,
					char_bg.leader_win, char_bg.leader_lost, char_bg.leader_tie, char_bg.score, char_bg.sp_heal_potions, char_bg.hp_heal_potions, char_bg.yellow_gemstones,
					char_bg.red_gemstones, char_bg.poison_bottles, char_bg.blue_gemstones, char_bg.acid_demostration, char_bg.acid_demostration_fail,
					char_bg.support_skills_used, char_bg.healing_done, char_bg.wrong_support_skills_used, char_bg.wrong_healing_done, char_bg.sp_used, char_bg.zeny_used,
					char_bg.spiritb_used, char_bg.ammo_used, char_bg.rank_points, char_bg.rank_games, char_bg.cq_wins, char_bg.cq_lost, char_bg.kill_count,
					char_bg.death_count, char_bg.points, char_bg.deserter
				FROM 
					`char` AS `ch` 
				INNER JOIN 
					`char_bg` ON `char_bg`.`char_id` = `ch`.`char_id` 
				INNER JOIN 
					`login` ON `login`.`account_id` = `ch`.`account_id`
				LEFT JOIN 
					`guild` ON `guild`.`guild_id` = `ch`.`guild_id`
				WHERE 
					`char_bg`.`char_id` > '0' 
				AND	
					`login`.".$FNC->get_emulator_query()." < 80
				AND 
					`login`.`state` = '0'
				AND
					`ch`.`char_id`=?
			";

			$while = $DB->execute($consult, [$NRM->getParam(0)]);
			$row = $while->fetch();
			if ($DB->num_rows())
			{
				$post = $GV->calc_rank($row['score']);
				$sex_img = $row['sex'] . "/" . $row['class'];

		?>
					<div class='row'>
						<div class='panel panel-default'>
							<div class='panel-body woe-panel-body'>
								<div class='rank_container'>
									<div class='oboro-col-xs-4 nopadding'>
										<div class="user_class_img" style='background:url(./images/class/<?php echo $sex_img ?>.png'>
											<div class="character_emblem_info">
												<img src="<?php echo $EMB->get_emblem($row['guild_id']) ?>" alt='X'>
											</div>
											<ul class="list-unstyled character_information_image bg_cii">
												<li>Guild:
													<?php echo ( $row['gname'] == '' ? '- No guild -' : $row['gname'] ) ?>
												</li>
												<li>Name: <strong> <?php echo $row['name'] ?> </strong></li>
												<li>Job:
													<?php echo $jobs[$row['class']] ?>
												</li>
												<li>W. Reg. Points:
													<?php echo (isset($row['points'])?$row['points']:'0') ?>
												</li>
												<li>Ranked Points:
													<?php echo (isset($row['rank_points'])?$row['rank_points']:'0') ?>
												</li>
												<li>Elo. Rank:
													<?php echo (isset($row['score'])?$row['score']:'0') ?>
												</li>

												<li><img src='./images/viewprofile.png' border='0'><a OnClick='Oboro.SHOWPROFILE(<?php echo $row[' char_id '] ?>,false,false,0,<?php echo $count ?>);'> More Information</a></li>
											</ul>
										</div>
									</div>
									<!-- COL-LG-4 -->

									<div class='oboro-col-xs-8 nopadding'>
										<div class="row">
											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th>Option</th>
													<th>Won</th>
													<th>Tie</th>
													<th>lost</th>
												</tr>
												<tr>
													<td>Total</td>
													<td>
														<?php echo (isset($row['win'])?$row['win']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['tie'])?$row['tie']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['lost'])?$row['lost']:'0') ?>
													</td>
												</tr>
												<tr>
													<td>As Team L.</td>
													<td>
														<?php echo (isset($row['leader_win'])?$row['leader_win']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['leader_tie'])?$row['leader_tie']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['leader_lost'])?$row['leader_lost']:'0') ?>
													</td>
												</tr>
											</table>

											<div class="row">
												<div class="col-md-4 col-xs-4 nopadding" style="padding-right:5px !important;">
													<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
														<tr>
															<th colspan='2'>General Standings</th>
														</tr>
														<tr>
															<td>kills</td>
															<td>
																<?php echo (isset($row['kill_count'])?$row['kill_count']:'0') ?>
															</td>
														</tr>
														<tr>
															<td>Death</td>
															<td>
																<?php echo (isset($row['death_count'])?$row['death_count']:'0') ?>
															</td>
														</tr>
														<tr>
															<td>Quits</td>
															<td>
																<?php echo (isset($row['deserter'])?$row['deserter']:'0') ?>
															</td>
														</tr>
													</table>
												</div>

												<div class="col-md-4 col-xs-4 nopadding" style="padding-right:5px !important;">
													<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
														<tr>
															<th colspan='2'>Damage</th>
														</tr>
														<tr>
															<td>Top</td>
															<td>
																<?php echo (isset($row['top_damage'])?$row['top_damage']:'0') ?>
															</td>
														</tr>
														<tr>
															<td>Done</td>
															<td>
																<?php echo (isset($row['damage_done'])?$row['damage_done']:'0') ?>
															</td>
														</tr>
														<tr>
															<td>Recv</td>
															<td>
																<?php echo (isset($row['damage_received'])?$row['damage_received']:'0') ?>
															</td>
														</tr>
													</table>
												</div>

												<div class="col-md-4 col-xs-4 nopadding">
													<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
														<tr>
															<th colspan="3">Supp Skills</th>
														</tr>
														<tr>
															<td>Option</td>
															<td>Support</td>
															<td>Heal</td>
														</tr>
														<tr>
															<td>Correct</td>
															<td>
																<?php echo (isset($row['support_skills_used'])?$row['support_skills_used']:'0') ?>
															</td>
															<td>
																<?php echo (isset($row['healing_done'])?$row['healing_done']:'0') ?>
															</td>
														</tr>
														<tr>
															<td>Erroneo</td>
															<td>
																<?php echo (isset($row['wrong_support_skills_used'])?$row['wrong_support_skills_used']:'0') ?>
															</td>
															<td>
																<?php echo (isset($row['wrong_healing_done'])?$row['wrong_healing_done']:'0') ?>
															</td>
														</tr>
													</table>
												</div>
											</div>

											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th colspan='4'>Castle Conquest</th>
												</tr>
												<tr>
													<td>Emperium</td>
													<td>Barricade</td>
													<td>G.Stone</td>
													<td>Results</td>
												</tr>
												<tr>
													<td>
														<?php echo (isset($row['emperium_kill'])?$row['emperium_kill']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['barricade_kill'])?$row['barricade_kill']:'0') ?>
													</td>
													<td>
														<?php echo (isset($row['gstone_kill'])?$row['gstone_kill']:'0') ?>
													</td>
													<td>
														<font color='#1c92cf'><b>W</b></font>
														<?php echo (isset($row['cq_wins'])?$row['cq_wins']:'0') ?>
														<font color='#1c92cf'><b>T</b></font> 0
														<font color='#1c92cf'><b>L</b></font>
														<?php echo (isset($row['cq_lost'])?$row['cq_lost']:'0') ?>
													</td>
												</tr>
											</table>

											<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed'>
												<tr>
													<th colspan='5'>Usable Items</th>
												</tr>
												<tr>
													<td><img src='./img/db/item_db/small/522.png' />HP :
														<?php echo (isset($row['hp_heal_potions'])?$row['hp_heal_potions']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/522.png' />SP :
														<?php echo (isset($row['sp_heal_potions'])?$row['sp_heal_potions']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/715.png' />Gems :
														<?php echo (isset($row['yellow_gemstones'])?$row['yellow_gemstones']:'0') ?> </td>
													<td><img src='./img/db/item_db/small/716.png' />Gems :
														<?php echo (isset($row['red_gemstones'])?$row['red_gemstones']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/717.png' />Gems :
														<?php echo (isset($row['blue_gemstones'])?$row['blue_gemstones']:'0') ?>
													</td>
												</tr>
												<tr>
													<td colspan='2'><img src='./img/db/item_db/small/676.png'>Total zeny :
														<?php echo (isset($row['zeny_used'])?$row['zeny_used']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/1752.png'>Arrow :
														<?php echo (isset($row['ammo_used'])?$row['ammo_used']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/7136.png'>Bottle :
														<?php echo (isset($row['acid_demostration'])?$row['acid_demostration']:'0') ?>
													</td>
													<td><img src='./img/db/item_db/small/678.png'>Bottle :
														<?php echo (isset($row['poison_bottles'])?$row['poison_bottles']:'0') ?>
													</td>
												</tr>
											</table>
										</div>
										<!--row-->
									</div>
									<!-- col-lg-8-->
									<div class="clearfix"></div>
									<div id="dinamically_load_ranking_1"></div>
								</div>
								<!-- rank_normal_hide -->
							</div>
							<!-- panelbody -->
						</div>
						<!-- panel -->
					</div>
					<!-- row -->
					<?php
			}
			else
			{
				echo 'this Character has not BG Information to provide';
			}
		}
		$DB->free();
	?>
		</div>
	</div>
</div>