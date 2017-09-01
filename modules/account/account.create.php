<?php
if (isset($_SESSION['account_id'])) 
	exit();
?>

<div class="row">
	<div class="col-lg-8 col-lg-center">
		<h4 class="oboro_h4"><i class="fa fa-user-circle" aria-hidden="true"></i>Sign Up and Play Today!</h4>

		<form class="OBOROBACKWORK">
			<table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroNDT">
				<tr>
					<th colspan="2">Basic Information</th>
				</tr>
				<tr>
					<td colspan="2" class="error_log"></td>
				</tr>
				<tr>
					<td>Login User Name</td>
					<td><?php echo $FNC->C_INPUT('text', '', 'form-control width_100', 'user', '', 'User Name'); ?></td>
				</tr>
				<tr>
					<td>Your In-game password</td>
					<td><?php echo $FNC->C_INPUT('password', '', 'form-control width_100', 'pass', '', 'Safe Password'); ?></td>
				</tr>
				<tr>
					<td>Retype your password</td>
					<td><?php echo $FNC->C_INPUT('password', '', 'form-control width_100', 'pass2', '', 'Retype Password'); ?></td>
				</tr>
				<tr>
					<td>Pleas put a valid e-mail</td>
					<td><?php echo $FNC->C_INPUT('text', '', 'form-control width_100', 'mail', '', 'example@example.com'); ?></td>
				</tr>
				<tr>
					<td>Your Account Sex</td>
					<td><?php echo $FNC->CDD('sex', '', $GV, 0); ?></td>
				</tr>
				<tr>
					<td>Your Account Country</td>
					<td><?php echo $FNC->CDD('pais', '', $GV, 0); ?></td>
				</tr>
				<tr>
					<th colspan="2">Recover Information</th>
				</tr>
				<tr>
					<td>Please choose a Recovery Question</td>
					<td><?php echo $FNC->CDD('question', '', $GV, 0); ?></td>
				</tr>
				<tr>
					<td>Provide a secure answare information! This will prevent Hacks</td>
					<td><?php echo $FNC->C_INPUT('text', '', 'form-control width_100', 'question_response', '', 'Secure Information needed'); ?></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="OPT" value="REGISTRO">
						<input type="hidden" name="ip" value="<?php echo $FNC->getIP() ?>">
						<input type="submit" value="Create Account and start playing today!" class="btn btn-primary width_100">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>