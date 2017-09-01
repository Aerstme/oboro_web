<div class="row">
	<div class="col-lg-4 col-sm-12" id="fix-bootstrap-padding-oboro">
		<div class="col-lg-12 col-xs-4 nopadding">
			<div class="panel-woe">
				<div class="oboro-woe-panel-body">
					<div class="oboro-woe-panel-body-in">
						<table class="width_100 center">
							<?php
								foreach($CONFIG->WOESCHDL as $poc => $arr )
								{
									echo '<tr>';
										foreach ($arr as $val )
											echo '<td>'.$val.'</td>';
									echo '</tr>';
								}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="quick_links col-lg-12 col-xs-8 nopadding">
			<div class="col-lg-12 col-xs-6 nopadding">
				<a href="<?php echo $CONFIG->getConfig('link_descargas'); ?>" target="_blank">
					<div class="oboro_links oboro_descargas"></div>
				</a>
			</div>
			<div class="col-lg-12 col-xs-6 nopadding">
				<a href="#informacion.guildpack">
					<div class="oboro_links oboro_guildpack"></div>
				</a>
			</div>
			<div class="col-lg-12 col-xs-6 nopadding">
				<a href="<?php echo $CONFIG->getConfig('link_svinfo'); ?>" target="_blank">
					<div class="oboro_links oboro_svinfo"></div>
				</a>
			</div>
			<div class="col-lg-12 col-xs-6 nopadding">
				<a href="<?php echo $CONFIG->getConfig('link_svinfo'); ?>" target="_blank">
					<div class="oboro_links oboro_guides"></div>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-lg-8 col-sm-12">
		<div id="ytplayer_fix">
			<iframe id="ytplayer" height="350" src="<?php echo $CONFIG->getConfig('Web') ?>/modules/home/isaac.yt.video.php" frameborder="0" align="center"></iframe>
		</div>

		<div class="server_info">
			<ul class="nav nav-tabs">
				<li role="presentation" class="active"><a data-roll="latestnews">Latest News</a></li>
				<li role="presentation"><a data-roll="svinfo">Server Information</a></li>
			</ul>
			<div class="tab-content">
				<div id="latestnews" class="tab-pane fade in active">
					<?php
						$result = $DB->execute("SELECT `blog_id`, `date_create`, `title`, `owner_name`, `date_modify` FROM `oboro_blog` ORDER BY `blog_id` ASC");
						if ($DB->num_rows())
						{
							echo 
							'
								<div class="row">
									<div class="col-lg-12 nopadding">
										<h4 class="oboro_h4"><i class="fa fa-list-ol" aria-hidden="true"></i> Latest news</h4>
										<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT3">
										<thead>
											<tr>
												<th>Type</th>
												<th>Created</th>
												<th>Modified</th>
												<th>Title</th>
												<th>Owner</th>
												<th>Read</th>
											</tr>
										</thead>
										<tbody>
								';
								while ($row = $result->fetch())
								{
									echo 
									'
										<tr>
											<td><div class="img_blog" style="'.$FNC->getBlogType($row['blog_id']).'"></div></td>
											<td>'.$row['date_create'].'</td>
											<td>'.(isset($row['date_modify'])? $row['date_modify'] : "never").'</td>
											<td>'.$row['title'].'</td>
											<td>'.$row['owner_name'].'</td>
											<td>
												<div class="btn-group">
												  <div class="btn-group">
													<a href="?blog.post-'.$row['blog_id'].'" class="btn btn-primary">View</a>
												  </div>
												</div>
											</td>
										</tr>
									';
								}
								echo '
											</tbody>
										</table>
									</div>
								</div>
								';
						}
					?>
				</div>
				<div id="svinfo" class="tab-pane fade">
					<!-- tomado de la DB del IPB, por eso su mala estructura -->
					<p style="text-align:center;">
						<img alt="Your Logo.png" src="#" />
					</p>

					<p style="text-align:center;">
						<strong>Mid rates private server</strong>
						<br/> Somos un servidor privado de <strong>Ragnarök Online </strong>en el cual podrás jugar de forma totalmente gratuita. Con apertura en diciembre del 2016, <strong>xRO</strong> vuelve renovándose con una nueva edición en la cual esperamos que lo pasen genial con nosotros y disfruten de nuestro servidor.
						<br/>
						<img alt="brScVhV.png" src="http://i.imgur.com/brScVhV.png" />
						<br/>
					</p>

					<ul>
						<li>Pre-Renewal</li>
						<li>NO 3° Jobs</li>
						<li>Rates: 250x/250x/100x</li>
						<li>Max Lvl. 99/70</li>
						<li>Battleground 2.0</li>
						<li>War of Emperium 2.0</li>
						<li>Card: 1%</li>
						<li>MVP Card: 0.01%</li>
						<li>Max ASPD 190</li>
						<li>Harmony Shield</li>
						<li>Anti-Cheats system</li>
						<li>Emulador rAthena</li>
						<li>Control Panel OBORO</li>
						<li>Guild Pack rental system - MAX CAP GUILD 30.</li>
						<li>Soporte: Español / English</li>
						<li>Localización del Servidor: Los Angeles, USA.</li>
						<li>Horario del servidor: New York GMT -5.</li>
						<li>xROcita costumes items</li>
						<li>Salas especiales (hats, consumibles, etc)</li>
						<li>Bloody branch Quest</li>
						<li>Donaciones directas por control panel</li>
						<li>Eventos de GM con premios exclusivos</li>
						<li>Warper con niveles y Healer</li>
						<li>Rental NPC</li>
						<li>Job Master</li>
						<li>Estilista</li>
						<li>Etc...</li>
					</ul>

					<p style="text-align:center;"><span style="font-size:24px;">Enjoy<strong><em>!</em></strong></span></p>
				</div>
			</div>
		</div>
	</div>
</div>