<?php
if (!$NRM->getParam(0))
	exit;

$result = $DB->execute('SELECT `blog_id`, `date_create`, `title`, `text_html`, `owner_name`, `date_modify`, `href` FROM `oboro_blog` WHERE `blog_id`=?', [$NRM->getParam(0)]);
if (!$DB->num_rows())
	exit;
$row = $result->fetch();
?>

<div class="row">
	<div class="col-lg-12">
		<h4 class="blog_title"><i class="fa fa-envelope-open" aria-hidden="true"></i> <?php echo $row['title']; ?> 
			<span class="blog_subtitle">Post owner <b><?php echo $row['owner_name']; ?></b>, Creation date <b><?php echo $row['date_create']; ?></b> <i>Powered by Oboro CP &copy;</i></span></h4>
		<div class="blog_post">
			<?php echo stripslashes($row['text_html']); ?>
		</div>
	</div>
</div>