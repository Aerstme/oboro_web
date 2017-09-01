<?php
if ( !isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99 || !$NRM->getParam(0))
	exit;


if (!empty($_POST['update'])) 
{
	$error = '';
	$consult = "UPDATE `char` SET ";
	foreach($_POST as $poc => $val)
	{
		if (in_array($poc,array("id_load", "http", "update", "account_id", "undefined")))
			continue;
		else
			$consult .= ' `'.$poc.'`= \''.$val.'\', ';
	}
	$consult = rtrim($consult, ', ');
	$consult .= " WHERE `char_id` = ". $NRM->getParam(0);
	$result = $DB->execute($consult);
	if (!$result->rowCount())
		$error ='No changes applied';
}

$arr = $DB->ShowColumns('char');
if (!empty($error))
	echo '<div id="hideOboroAlert" class="alert alert-danger"><strong>Error!</strong> ' .$error. '.</div>';
else if (isset($_POST['update']) && empty($error))
	echo '<div id="hideOboroAlert" class="alert alert-success"><strong>&Eacute;xito!</strong> Usuario modificado exitosamente</div>'
?>


<div class="row" id="ladder_div">
	<div class="col-lg-12">
		<h4 class="oboro_h4"><i class="fa fa-cogs fa-2x" style="vertical-align: middle;"> </i> <span> Admin Char's</span></h4>
		<form method="post" action="?admin.char.edit-<?php echo $NRM->getParam(0); ?>">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-lg-10">
						<div class="panel-heading-title">
							<i class="fa fa-fighter-jet" aria-hidden="true"></i> Editing Char ID: <?php echo $NRM->getParam(0) ?>
							<input type="hidden" name="update" value="1">
						</div>
					</div>
					<div class="col-lg-2">
						<input type="submit" class="btn btn-primary float-right" value="Update">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id='OboroNDT'>
						<?php
							$cont = 0;
							$result = $DB->execute('SELECT * FROM `char` WHERE `char_id`='.$NRM->getParam(0));
							$row = $result->fetch();
							foreach($arr as $poc => $val)
							{		
								if ( $cont == 0 )
									echo '<tr>';
								
								if ( $val === 'char_num')
									continue;
								
								echo '<td>'.$val.'</td>';
								echo '<td>'.$FNC->CDD($val, $row, $GV, $row[$val] ).'</td>';

								if ( $cont == 3 )
								{
									echo '</tr>';
									$cont = 0;
								} else 
									$cont++;
							}
						?>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>