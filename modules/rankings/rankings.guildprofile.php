<?php
$jobs = $_SESSION['jobs'];
$ally = 'none'; 
$allyflag ='';
$enemy = 'none'; 
$enemyflag ='';

if(!$NRM->getParam(0)) 
	exit;

$consult = 
"
	SELECT `guild`.`guild_id`,`guild`.`name`, `guild`.`master`, `guild`.`guild_lv`, `guild`.`max_member`, `guild`.`average_lv`, `guild`.`exp`, `guild`.`next_exp`,`char`.`class`, `char`.`base_level`, `char`.`job_level` 
	FROM `guild` 
	INNER JOIN `char` ON `guild`.`char_id` = `char`.`char_id` 
	WHERE `guild`.`guild_id` = ?
";

if (!($result = $DB->execute($consult, [$NRM->getParam(0)])))
{
	echo 'Unavailable Guild Information';
	exit;
}

$row = $result->fetch();

$consult =
	"
	SELECT `guild`.`guild_id`, `guild`.`name`, `guild_alliance`.`opposition`
	FROM `guild_alliance` 
	INNER JOIN `guild` ON `guild`.`guild_id` = `guild_alliance`.`alliance_id` 
	WHERE `guild_alliance`.`guild_id` = ?
	ORDER BY `guild_alliance`.`opposition` LIMIT 1
";

$result = $DB->execute($consult, [$NRM->getParam(0)]);
$count = $result->fetchColumn();

if( $count ) 
{
	while($row_ally = $result->fetch())
	{
		if( $row_ally['opposition'] == 0 ) 
		{
			$allyflags .= '<img src="'.$EMB->get_emblem($row_ally['guild_id']).'" alt="X">';
			$ally .= $row_ally['name'] . ' ';
		} 
		else 
		{
			$allyflags .= '<img src="'.$EMB->get_emblem($row_ally['guild_id']).'" alt="X">';
			$enemy .= $row_ally['name'].' ';
		}
	}
	$DB->free($result);
}

$consult = "SELECT count(1) AS `total` FROM `char` where guild_id=?";
$result = $DB->execute($consult, [$NRM->getParam(0)]);
$all_members = $result->fetch()['total'];

?>

<div class="row">
	<h4 class="oboro_h6"><i class="fa fa-users" style="vertical-align: middle;"> </i> <span>Guild: <?php echo $row['name'] ?></span></h4>
	<div class='col-lg-12'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<i class="fa fa-pencil-square-o"></i> Basic Guild Information
			</div>
			<div class='panel-body'>

				<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed">
					<tr>
						<th>Emblem</th>
						<th>Guild Leader</th>
						<th>G. Level</th>
						<th>Members</th>
						<th>Avergage Lv.</th>
						<th>Enemy</th>
						<th>Ally</th>
						<th>Experience</th>
					</tr>
					<tr>
						<td><img src="<?php echo $EMB->get_emblem($row['guild_id']) ?>" alt='none'></td>
						<td><?php echo $row['master'] . ' [ ' . $jobs[$row['class']] . ' ' . $row['base_level'] . '/' . $row['job_level'] . ' ]' ?></td>
						<td><?php echo $row['guild_lv'] ?></td>
						<td>[ <?php echo $all_members.' / '.$row['max_member'] ?> ]</td>
						<td><?php echo $row['average_lv'] ?></td>
						<td><?php echo $enemy ?></td>
						<td><?php echo $ally ?></td>
						<td><?php echo $FNC->moneyformat($row['exp']) ?></td>

					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
$consult =
"
	SELECT 
		`char`.`name`, `char`.`char_id`, `char`.`class`, `char`.`base_level`, `char`.`job_level`, `char`.`online`, `login`.`sex`, DATEDIFF(NOW(),`login`.`lastlogin`) AS `last_online`, `login`.`pais` 
	FROM `char` 
	INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
	WHERE `char`.`guild_id` = ?
	ORDER BY `char`.`class`
";
		$result = $DB->execute($consult, [$NRM->getParam(0)]);
?>

<div class="row">
	<div class='col-lg-12'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<i class="fa fa-pencil-square-o"></i>  Guild Members
			</div>
			<div class='panel-body'>
				<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
					<thead>
						<tr>
							<th>Gender</th>
							<th>Memb. Name</th>
							<th>Country</th>
							<th>Class</th>
							<th>Base / Job Level</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = 0;
							$online = 0;

							while($row = $result->fetch())
							{
								$count++;
						?>
								<tr>
									<td><img src="./images/<?php echo $row['sex'] ?>.gif"></td>
									<td><?php echo '<a href="?account.profile-'.$row['char_id'].'-0">'.$row['name'].'</a>'; ?></td>
									<td><img src='./img/db/country_flags/<?php echo $row['pais'] ?>.png'></td>
									<td><?php echo $jobs[$row['class']] ?></td>
									<td><?php echo $row['base_level'] . '/' . $row['job_level'] ?></td>
									<td><?php echo ($row['online']?'<span class="online">Online</span>':$row['last_online'] . ' dias inactivo') ?></td>
								</tr>
								
						<?php
								if( $row['online'] )
									$online++;
							}

							$asistencia = round((($online/$count)*100),2) . ' %';

						?>
						<tr>
							<td><b>Total de Miembros</b></td>
							<td><?php echo $count ?></td>
							<td><b>Miembros Activos</b></td>
							<td><?php echo $online ?></td>
							<td>Asistencia</td>
							<td><?php $asistencia ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
if( isset($emblems) )
	$_SESSION['emblems'] = $emblems;
?>