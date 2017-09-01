<?php
$jobs = $_SESSION['jobs'];
$skills = $_SESSION['skills'];

$Jobs = $NRM->getParam(0) ? $NRM->getParam(0) : 0;
$Ords = $NRM->getParam(1) && is_numeric($NRM->getParam(1)) ? $NRM->getParam(1) : 12;
$Srch = $NRM->getParam(1) ?	$NRM->getParam(1) : FALSE;
?>

<div class="row">
	<h4 class="oboro_h4"><i class="fa fa-line-chart fa-2x" style="vertical-align: middle;"> </i> <span> BG Stadistics</span></h4>
	<table class="table width_100 oboro_table">
		<tr>
			<td>
				<form id="OBORO_NORMALIZED">
					<select name="opt" class="selectpicker" data-live-search="true" data-size="10">
				<option selected value="0">Todos...</option>
				<?php $GV->get_option_value($jobs); ?>
			</select>

					<select name="order" class="selectpicker" data-live-search="true" data-size="10">
				<option selected value="0">Regular Week Points</option>
				<option value="1">Ranked Week Points</option>
				<option value="2">Gold Medals</option>
				<option value="3">Silver Medals</option>
				<option value="4">Bronze Medals</option>
				<option value="5">Offensive</option>
				<option value="6">Game Wins</option>
				<option value="7">Game Tie</option>
				<option value="8">Game Lost</option>
				<option value="9">Leader Game Wins</option>
				<option value="10">Leader Game Tie</option>
				<option value="11">Leader Game Lost</option>
				<option value="12">Kill Counter</option>
				<option value="13">Die Counter</option>
				<option value="14">Deserted Games</option>
				<option value="47">CON - Emperium Kills</option>
				<option value="48">CON - Barricade Kills</option>
				<option value="49">CON - Guarian Stone Kills</option>
				<option value="50">CON - Game Wins</option>
				<option value="51">CON - Game Lost</option>
				<option value="52">Best Damage</option>
				<option value="53">Total Damage Done</option>
				<option value="54">Total Damage Received</option>
				<option value="55">Good Support Skills</option>
				<option value="56">Wrong Support Skills</option>
				<option value="57">Total Good Healing</option>
				<option value="58">Total Wrong Healing</option>
				<option value="59">HP Potions Used</option>
				<option value="60">SP Potions Used</option>
				<option value="61">Yellow Gems Used</option>
				<option value="62">Red Gems Used</option>
				<option value="63">Blue Gems Used</option>
				<option value="64">Zeny Used</option>
				<option value="65">Arrows Used</option>
				<option value="66">Acid Demonstration Casted</option>
				<option value="67">Enchanted Deadly Poison Casted</option>
			</select>

					<input type="hidden" name="rank" value="rankings.bg">
					<input type="submit" value="Search" class="btn btn-primary">
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<form class="inline_block" id="OBORO_NORMALIZED">
					<input type="text" class="form-control inline_block" name="buscar" maxlength="24" size="24" placeholder="Search by Character Name">
					<input type="hidden" name="opt" value="100">
					<input type="hidden" name="rank" value="rankings.bg">
					<input type="submit" class="btn btn-primary inline_block" value="Search">
				</form>
				<form class="inline_block" id="OBORO_NORMALIZED">
					<input type="text" name="buscar" class="form-control inline_block" placeholder="Search by Guild Name" maxlength="24" size="24">
					<input type="hidden" name="opt" value="101">
					<input type="hidden" name="rank" value="rankings.bg">
					<input type="submit" value="Search" class="btn btn-primary inline_block">
				</form>
			</td>
		</tr>
	</table>
</div>
<div id="ladder_div">
<?php
$consult =
"
	SELECT 
		`char`.char_id, `char`.`name`, `char`.class, `char`.base_level, `char`.job_level, `char`.playtime, `char`.max_hp, `char`.max_sp, `char`.str, `char`.`int`, `char`.vit,
		`char`.dex, `char`.agi, `char`.luk, `char`.bg_gold, `char`.bg_silver, `char`.bg_bronze, login.sex, guild.`name` AS gname, guild.guild_id, char_bg.top_damage,
		char_bg.damage_done, char_bg.damage_received, char_bg.emperium_kill, char_bg.barricade_kill, char_bg.gstone_kill, char_bg.win, char_bg.lost, char_bg.tie,
		char_bg.leader_win, char_bg.leader_lost, char_bg.leader_tie, char_bg.score, char_bg.sp_heal_potions, char_bg.hp_heal_potions, char_bg.yellow_gemstones, 
		char_bg.red_gemstones, char_bg.poison_bottles, char_bg.blue_gemstones, char_bg.acid_demostration, char_bg.acid_demostration_fail, char_bg.support_skills_used, 
		char_bg.healing_done, char_bg.wrong_support_skills_used, char_bg.wrong_healing_done, char_bg.sp_used, char_bg.zeny_used, char_bg.spiritb_used, char_bg.ammo_used, 
		char_bg.rank_points, char_bg.rank_games, char_bg.cq_wins, char_bg.cq_lost, char_bg.kill_count, char_bg.death_count, char_bg.points, char_bg.deserter
	FROM 
		`char`
	INNER JOIN `char_bg` ON `char_bg`.`char_id` = `char`.`char_id` 
	INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
	LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id`
	WHERE 
		`char_bg`.`char_id` > '0' 
	AND	
		`login`.".$FNC->get_emulator_query()." < 80
	AND 
		`login`.`state` = '0'
";

if ($Jobs == 100)
{
	$consult .= "AND `char`.`name` LIKE ?";
	$param =  [urldecode(trim($Srch))];
}
else if ($Jobs ==  101)
{
	$consult .= "AND `guild`.`name` LIKE ?";
	$param = [urldecode(trim($Srch))];
}
else
{
	switch($Jobs)
	{
		case 7:		$Peco = 13;		break;
		case 14:	$Peco = 21;		break;
		case 4008:	$Peco = 4014;	break;
		case 4015:	$Peco = 4022;	break;
		case 4030:	$Peco = 4036;	break;
		case 4037:	$Peco = 4044;	break;
		case 4047:	$Peco = 4048;	break;	
	}

	if (!empty($Peco))
	{
		$consult .= "AND (`char`.`class` = ? OR `char`.`class` = ?)";
		$param = [$Jobs, $Peco];
	}
	else if ($Jobs)
	{
		$consult .= "AND `char`.`class` = ? ";
		$param = [$Jobs];
	}
}
$consult .=
"
	ORDER BY ".$GV->SortType_BG[$Ords]." DESC
	LIMIT 0, 15 
";

$while = $DB->execute($consult, $param);
$count = 0;

if (!$while)
	exit;

while($row = $while->fetch()) 
{
	$count++;
	$post = $GV->calc_rank($row['score']);
	$sex_img = $row['sex'] . "/" . $row['class'];

?>
<div class='row'>
	<div class='col-lg-12'>
		<div class='panel panel-default'>
			<div class='panel-body woe-panel-body'>
				<div class='rank_container>'>
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

								<li><img src='./images/viewprofile.png' border='0' ><a OnClick='Oboro.SHOWPROFILE(<?php echo $row['char_id'] ?>,false,false,0,<?php echo $count ?>);'> More Information</a></li>
								<li><img src='./images/viewprofile.png' border='0' ><a href="?account.profile-<?php echo $row['char_id']; ?>-2"> Share Ranking</a></li>
							</ul>
						</div>
					</div>
					<!-- COL-LG-4 -->

					<div class='oboro-col-xs-8 nopadding'>
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
					<!-- col-lg-8-->
					<div class="clearfix"></div>
					<div id="dinamically_load_ranking_<?php echo $count ?>"></div>
				</div>
				<!-- rank_normal_hide -->
			</div>
			<!-- panelbody -->
		</div>
		<!-- panel -->
	</div>
	<!-- col-lg-12-->
</div>
<!-- row -->
<?php
}
$DB->free();
?>
	</div>