<div class="wrapper footer">
	<div class="row">
		<div class="col-xs-3"><div class="oboro"></div></div>
		<div class="col-xs-6">
			<div class="CopyRights">
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia Creative Commons" style="border-width:0; width:60px;" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Dataset" property="dct:title" rel="dct:type">Oboro Control Panel <a href="https://www.facebook.com/notes/oboro-cp/notas-de-la-versi%C3%B3n/216953002051904">Rev. <?php echo $CONFIG->getConfig('Oboro_Version') ?> &copy;</a></span> Contact Page: <a xmlns:cc="http://creativecommons.org/ns#" href="https://www.facebook.com/Oboro-213016095778928/" property="cc:attributionName" rel="cc:attributionURL">J. Isaac V.</a> It is distributed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons License Attribution -NoComercial-ShareAlike 4.0 Internacional</a>.
				</a>
			<?php
				$time = explode(' ', microtime());
				$finish = $time[1] + $time[0];
				$total_time = round(($finish - $start), 4);
				echo 'Page generated in '.$total_time.' seconds.';
			?>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="footer-derecha-adentro">
				<div class="footer-preaty fb"><i class="fa fa-facebook"></i></div>
				<div class="footer-preaty gl"><i class="fa fa-google-plus"></i></div>
				<div class="footer-preaty yt"><i class="fa fa-youtube"></i></div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/bootstrap.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/datatables/dataTables.bootstrap.plugin.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/nicescroll.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/bootstrap-select.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/confirm.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/Oboro.min.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/init.min.js"></script>

