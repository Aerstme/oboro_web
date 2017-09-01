<?php
session_start();
if (isset($_GET['session_destroy']) && $_GET['session_destroy'] == 'true')
{
	session_destroy();
	header('Location: index.php');
}

if (!file_exists('libs/config.php'))
{
	header('Location: modules/install/installer.php');
	exit;
}

require_once('libs/controller.php');

$time = explode(' ', microtime());
$start = $time[1] + $time[0];
?>

	<!DOCTYPE html>
	<html lang="en">
	<?php include_once('modules/structure/header.php'); ?>

	<body>
		<div class="loader">
			<img src="img/ajax_loading.gif" alt="Loading...">
		</div>
		<div class="wrapper">
			<?php include_once('modules/structure/sv_status.php'); ?>
			<div class="logo">
				<a href="<?php echo $CONFIG->getConfig('Web'); ?>"><img src="img/oboro_logo.png"></a>
			</div>
			<div class="menu">
				<?php include_once('modules/structure/menu.php'); ?>
			</div>
			<div id="main_div">
				<?php
				include_once($NRM->IncludeModule());
				?>
			</div>
			<?php include_once('modules/structure/ranking.footer.php'); ?>
		</div>
		<?php include_once('modules/structure/footer.php'); ?>
	</body>

	</html>