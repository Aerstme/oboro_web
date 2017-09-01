<div class="server_status">
	<div class="row">
		<div class="col-xs-6">
			<ul class="ServerStatus">
				<li style="color:#0bafb5;"> Server Status<i>!</i> </li>
				<li><i class="fa <?php echo $FNC->ServerStatus(); ?>"></i></li>
				<li>Time: <span id="getTime"><?php echo $FNC->GetTime(); ?></span></li>
				<li>WoE: <?php echo $FNC->getWoeStatus(); ?></li>
				<li>Peak: <span id="getPick"><?php echo $FNC->getUserOnline(1); ?></span></li>
			</ul>
		</div>
		<div class="col-xs-1 user_online_text nopadding">
			User Online
		</div>
		<div class="col-xs-5 nopadding" align="right">
			<ul class="oboro_login_ul">
				<?php if (empty($_SESSION['account_id'])) { ?>
					<li>
						<a id="ShowLoginForm">Existing user? Sign in</a>
						<form class="OBOROBACKWORK" id="oboro_login_style">
							<table>
								<tr>
									<td class="login_title">Sign In</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="user" class="form-control oboro_input" placeholder="Username" tabindex=1>
									</td>
								</tr>
								<tr>	
									<td>
										<input type="password" name="pass" class="form-control oboro_input" placeholder="Password" tabindex=2>
									</td>
								</tr>
								<tr>
									<td>
										<input type="submit" class="width_100 btn margarette" value="Log In" tabindex=3>
									</td>
								</tr>
								<tr><td class="forgot_oboro"><a href="?account.recover">Forgot your password?</a></td></tr>
							</table>
							<input type="hidden" name="OPT" value="LOGIN">
						</form>
					</li>
					<li><a class="btn margarette" href="?account.create">Sign Up</a></li>
				<?php } else { ?>
					<li class="ShowMyAccount"><span class="ShowMyAccountSpan">My Account</span>
						<ul class="ShowMyAccountUl">
							<li>
								<div class="login_title">Information </div>
								<div><strong>User Name:</strong> <?php echo $_SESSION['userid'] ?></div>
								<div>
									<strong>Prot.</strong>
									<?php
										if ($CONFIG->getConfig('UseGeoLocalization') == 'yes') 
										{
											$GIP = geoip_open('./libs/ajax/GeoIP.dat',GEOIP_STANDARD);
											echo geoip_country_name_by_addr($GIP, $_SESSION['ip']);
											geoip_close($GIP);
										}
							  			else
											echo $_SESSION['ip'];
									?>
								</div>
							</li>
							<li><a href="?account.info">Edit Settings</a></li>
							<li><a href="index.php?session_destroy=true">Destroy session</a></li>
						</ul>
					</li>
						
				<?php } ?>
			</ul>
		</div>
		<div id="user_online"><a href="?informacion.whoisonline" style="color:inherit;"><?php echo $FNC->getUserOnline(0); ?></a></div>
	</div>
</div>