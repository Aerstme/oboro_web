<?php
$jobs = $_SESSION['jobs'];
$skills = $_SESSION['skills'];

$Jobs = $NRM->getParam(0) ? $NRM->getParam(0) : 0;
$Ords = $NRM->getParam(1) && is_numeric($NRM->getParam(1)) ? $NRM->getParam(1) : 0;
$Srch = $NRM->getParam(1) ?	$NRM->getParam(1) : FALSE;
?>

<div class="row">
	<h4 class="oboro_h4"><i class="fa fa-line-chart fa-2x" style="vertical-align: middle;"> </i> <span> WOE Stadistics</span></h4>

	<table class="table width_100 oboro_table">
		<tr>
			<td>
				<form id="OBORO_NORMALIZED">
					<select name="opt" class="selectpicker" data-live-search="true" data-size="10">
				<option selected value="0">Todos...</option>
				<?php $GV->get_option_value($jobs); ?>
			</select>

					<select name="order" class="selectpicker" data-live-search="true" data-size="10">
				<option selected value="0">Ofensiva</option>
				<option value="1">Kills</option>
				<option value="2">Deaths</option>
				<option value="3">Best Damage</option>
				<option value="4">Total Damage Done</option>
				<option value="5">Total Damage Received</option>
				<option value="6">Emperium Damage</option>
				<option value="7">Barricade Damage</option>
				<option value="8">Guardian Stone Damage</option>
				<option value="9">Guardian Damage</option>
				<option value="10">Emperium Kills</option>
				<option value="11">Barricade Kills</option>
				<option value="12">Guardian Stone Kills</option>
				<option value="13">Guardian Kills</option>
				<option value="14">Good Support Skills</option>
				<option value="15">Wrong Support Skills</option>
				<option value="16">Total Good Healing</option>
				<option value="17">Total Wrong Healing</option>
				<option value="18">HP Potions Used</option>
				<option value="19">SP Potions Used</option>
				<option value="20">Yellow Gems Used</option>
				<option value="21">Red Gems Used</option>
				<option value="22">Blue Gems Used</option>
				<option value="23">Zeny Used</option>
				<option value="24">Arrows Used</option>
				<option value="25">Acid Demonstration Casted</option>
				<option value="26">Enchanted Deadly Poison Casted</option>
			</select>

					<input type="hidden" name="rank" value="rankings.woe">
					<input type="submit" value="Search" class="btn btn-primary">
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<form class="inline_block" id="OBORO_NORMALIZED">
					<input type="text" class="form-control inline_block" name="buscar" maxlength="24" size="24" placeholder="Search by Character Name">
					<input type="hidden" name="opt" value="100">
					<input type="hidden" name="rank" value="rankings.woe">
					<input type="submit" class="btn btn-primary inline_block" value="Search">
				</form>
				<form class="inline_block" id="OBORO_NORMALIZED">
					<input type="text" name="buscar" class="form-control inline_block" placeholder="Search by Guild Name" maxlength="24" size="24">
					<input type="hidden" name="opt" value="101">
					<input type="hidden" name="rank" value="rankings.woe">
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
		`char`.`char_id`, `char`.`name`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`playtime`, `char`.`max_hp`, `char`.`max_sp`, `char`.`str`, 
		`char`.`int`, `char`.`vit`, `char`.`dex`, `char`.`agi`, `char`.`luk`, `login`.`sex`, `guild`.`name` AS `gname`, `guild`.`guild_id`, 
		`char_wstats`.`score`, `char_wstats`.`kill_count`, `char_wstats`.`death_count`, `char_wstats`.`top_damage`, `char_wstats`.`damage_done`, `char_wstats`.`damage_received`,
		`char_wstats`.`emperium_damage`, `char_wstats`.`guardian_damage`, `char_wstats`.`barricade_damage`, `char_wstats`.`gstone_damage`, `char_wstats`.`emperium_kill`,
		`char_wstats`.`guardian_kill`, `char_wstats`.`barricade_kill`, `char_wstats`.`gstone_kill`, `char_wstats`.`sp_heal_potions`, `char_wstats`.`hp_heal_potions`,
		`char_wstats`.`yellow_gemstones`, `char_wstats`.`red_gemstones`, `char_wstats`.`blue_gemstones`, `char_wstats`.`poison_bottles`, `char_wstats`.`acid_demostration`,
		`char_wstats`.`acid_demostration_fail`, `char_wstats`.`support_skills_used`, `char_wstats`.`healing_done`, `char_wstats`.`ammo_used`,
		`char_wstats`.`wrong_support_skills_used`, `char_wstats`.`wrong_healing_done`, `char_wstats`.`sp_used`, `char_wstats`.`zeny_used`, `char_wstats`.`spiritb_used`
	FROM 
		`char` 
	INNER JOIN
		`char_wstats` ON `char_wstats`.`char_id` = `char`.`char_id` 
	INNER JOIN
		`login` ON `login`.`account_id` = `char`.`account_id` 
	INNER JOIN
		`guild` ON `guild`.`guild_id` = `char`.`guild_id` 
	WHERE 
		`char_wstats`.`char_id` > '0' 
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
	ORDER BY ".$GV->SortType_WOE[$Ords]." DESC
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
								<li><b><img src='./images/viewprofile.png' border='0' ><a OnClick='Oboro.SHOWPROFILE(<?php echo $row['char_id'] ?>,false,false,1,<?php echo $count ?>);'> More Information</a></b></li>
								<li><b><img src='./images/viewprofile.png' border='0' ><a href="?account.profile-<?php echo $row['char_id']; ?>-1"> View Profile</a></b></li>
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
				<div id='dinamically_load_ranking_<?php echo $count ?>'></div>
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
$DB->free();

?>
	</div>