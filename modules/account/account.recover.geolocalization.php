<?php
if ( !empty($_SESSION['GEO_USERID']))
{
	$consult = 'SELECT `question` FROM `login` WHERE `userid`=?';
	$result = $DB->execute($consult, [$_SESSION['GEO_USERID']]);
	$row = $result->fetch();
	if ( $DB->num_rows() && !is_null($row['question']))
	{
		echo '
			<div class="row">
				<div class="col-lg-8 col-lg-center">
					<h4 class="oboro_h4"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Recover Account from Geolocalization</h4>					
					<form class="OBOROBACKWORK">
						<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroNDT">
							<tr>
								<td colspan="2">
									Our System has detected a Localization change in your account.
									If you are not these person, your IP going to be register as a Hack.<br/>
									Also the Administration is already in known of your behabor.
									Please provide us, some information where we can know you are the owner of this account.
								</td>
							</tr>
							<tr>
								<td rowspan="2" style="width:50%;">Answer your question Succesfully, In order to continue to your account.</td>
								<td>'.$FNC->GetValueFromVarIndex("question", $GV, $row['question']).'</td>
							</tr>
							<tr>
								<td>'.$FNC->C_INPUT("text", "", "form-control width_100", "user_question_response", "", "Your Answer").'</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="hidden" name="OPT" value="LOGIN_WITH_GEO">
									<input type="submit" value="Login to your account!" class="btn btn-primary width_100">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		';
	}
	else
		echo 'The geolocalization recover, is\'nt valid for you';
}
?>

