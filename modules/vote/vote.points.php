<?php
if (!isset($_SESSION['account_id'])) 
	exit;

$error = array();
$continue = FALSE;

if ($NRM->getParam(0))
{
    $continue = TRUE;
    if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]) || !empty($_SERVER['HTTP_CLIENT_IP']) || !empty($_SERVER['HTTP_X_FORWARDED']))
		$error[0] = "Unable to Vote through proxy";
    else
    {
	
        $consult =
        "
            SELECT `date` AS `diff` FROM `oboro_vote_points`
            WHERE 
                `account_id`=?
            AND
                `panel_id`=?
        ";
        $result = $DB->execute($consult, [$_SESSION['account_id'], $NRM->getParam(0)]);

        if ($DB->num_rows())
        {
            $row = $result->fetch();
            $date = new Datetime($row['diff']);
            $now = new Datetime(date("Y-m-d H:i:s"));
            $diff = $now->diff($date);
            $hours = $diff->h;
            $days  = $diff->days;
            if ($hours < 12 && $days < 1)
            {
                $continue = FALSE;
                $error[0] = $days. "::You can vote again in: " . (11-$hours) . " hours and " . (60 - $diff->i) . " minutes";
            }
        }

         if ($continue)
         {
             $consult = 
             "
                 INSERT INTO `oboro_vote_points`(`vote_id`,`account_id`,`date`,`ip`, `panel_id`) 
                 VALUES (?,?,?,?,?)
                 ON DUPLICATE KEY UPDATE `date`=?
             ";

             $result = $DB->execute($consult, [
                 $_SESSION['account_id'] . $NRM->getParam(0), 
                 $_SESSION['account_id'], 
                 date("Y-m-d H:i:s"), 
                 $_SESSION['ip'], 
                 $NRM->getParam(0),
                 date("Y-m-d H:i:s")
             ]);

             if ($result)
             {
                 if ($FNC->get_emulator() == EAMOD )
                 {
                     $consult = 
                     " 
                         INSERT INTO `global_reg_value` (`str`, `value`, `type`, `account_id`) 
                         VALUES(?, ?, 2, ?) 
                         ON DUPLICATE KEY UPDATE `value`= (`value` + ?)
                     ";
                 }
                 else
                 {
                     $consult = 
                     "
                         INSERT INTO `acc_reg_num` (`key`, `value`, `account_id`) 
                         VALUES(?,?,?) 
                         ON DUPLICATE KEY UPDATE `value`= (`value` + ?)
                     ";
                 }

                 $param = [
                    $CONFIG->getConfig('OnVotePoints'), 
                    $CONFIG->VOTEPOINTS[($NRM->getParam(0) - 1)][3], 
                    $_SESSION['account_id'],
                    $CONFIG->VOTEPOINTS[($NRM->getParam(0) - 1)][3]
                ];

                $result = $DB->execute($consult, $param);

                if ($result)
                {
                    echo '<script>Oboro.alerta("success", "&Eacute;xito", "Vote Points Updated");</script>';
                    $link = "
                        <script>
                            window.location.href = '".$CONFIG->VOTEPOINTS[($NRM->getParam(0) - 1)][2]."'; 
                        </script>
                    ";
                    echo $link;
                }
                else
                    $error[] = "Something wrong happened";
            }
        }
    }
}
?>

<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4"><i class="fa fa-user-secret" aria-hidden="true"></i> Vote for Cash Points</h4>
		<?php
			if (!empty($error[0]))
			{
				echo '<div class="alert alert-danger">';
					foreach($error as $poc => $val)
						echo '<b>Error:</b> '. $val . '<br/>';
				echo '</div>';
			}
		?>
		
		<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroNDT">
			<thead>
				<tr>
					<th>Server ID</th>
					<th>Server</th>
					<th>Points</th>
					<th>Button</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($CONFIG->VOTEPOINTS as $poc => $val)
				{
					echo '
						<tr>
							<td>'.$val[0].'</td>
							<td>'.$val[1].'</td>
							<td>'.$val[3].' Cash Poins</td>
							<td>	
								<a href="?vote.points-'.$val[0].'" class="btn btn-primary">Vote Now</a>
							</td>
						</tr>
					';
				}
				?>
				<tr>
					<td colspan="4">You can vote every 12 hours</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>