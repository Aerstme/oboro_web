<?php
if ( !isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99 ) 
	exit;

if ($NRM->getParam(0))
	$result = $DB->execute("DELETE FROM `oboro_blog` WHERE `blog_id`=?", [$NRM->getParam(0)]);


$result = $DB->execute("SELECT `blog_id`, `date_create`, `title`, `owner_name`, `date_modify`, `blog_class` FROM `oboro_blog` ORDER BY `blog_id` ASC");
if ($DB->num_rows())
{
	echo 
	'
		<div class="row">
			<div class="col-lg-12">
				<h4 class="oboro_h4"><i class="fa fa-list-ol" aria-hidden="true"></i> Blog Administration</h4>
				<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
				<thead>
					<tr>
						<th>Blog Ident.</th>
						<th>Blog Categ.</th>
						<th>Create Date</th>
						<th>Modify Date</th>
						<th>Title</th>
						<th>Owner</th>
						<th>Administration</th>
					</tr>
				</thead>
				<tbody>
	';
				while ($row = $result->fetch())
				{
					echo 
					'
						<tr>
							<td>'.$row['blog_id'].'</td>
							<td>'.$FNC->GetValueFromVarIndex("blog_categories",$GV, $row['blog_class']).'</td>
							<td>'.$row['date_create'].'</td>
							<td>'.(isset($row['date_modify'])? $row['date_modify'] : "never").'</td>
							<td>'.$row['title'].'</td>
							<td>'.$row['owner_name'].'</td>
							<td>
								<div class="btn-group">
								  <div class="btn-group">
									<a href="?blog.post-'.$row['blog_id'].'" class="btn btn-primary">View</a>
								  </div>
								  <div class="btn-group">
									<a onclick="ModifyBlog('.$row['blog_id'].')" class="btn btn-default">Modify</a>
								  </div>
								  <div class="btn-group">
									<a href="?admin.blog-'.$row['blog_id'].'" class="btn btn-warning">Delete</a>
								  </div>
								</div>
							</td>
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


<form id="form-blog-controller">
	<div class="row">
		<div class="col-lg-12" id="search_text_editor">
			<h4 class="oboro_h4"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Write a new Blog</h4>
			<div class="row nopadding">
				<div class="option-title-row">
					<div class="option-container">
						<div class="row">
							<div class="col-lg-6 nopadding-left">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i> Title</span>
									<input type="text" name="title" class="form-control" placeholder="Title Shown to users">
								</div>
							</div>		
							<div class="col-lg-3 nopadding-left">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i> Author</span>
									<input type="text" name="createdby" class="form-control readonly-class" placeholder="System">
								</div>
							</div>
							<div class="col-lg-3 nopadding-left">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> Date</span>
									<input type="text" name="date" class="form-control readonly-class" value="<?php echo date("Y-m-d"); ?>" readonly>
								</div>
							</div>	
						</div>
						<div class="row" style="padding-top:5px">
							<div class="col-lg-3 nopadding-left">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-wrench" aria-hidden="true"></i> Modifing</span>
									<input type="text" name="modifing" class="form-control readonly-class" value="no" readonly>
								</div>
							</div>
							<div class="col-lg-3 nopadding-left">
								<?php
									echo $FNC->CDD("blog_categories", FALSE, $GV, 0);
								?>
							</div>
							<div class="col-lg-6 nopadding-left">
								<input type="submit" id="post-blog" value="Post or Update blog" class="form-control btn btn-primary">
							</div>	
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div id="editor"></div>
		</div>
	</div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="<?php echo $CONFIG->getConfig('Web') ?>js/prototypes/ckeditor/init.js"></script>
<script>
	initSample();
	$('#form-blog-controller').on('submit', function (e) {
		e.preventDefault();
		var blog_text 		= CKEDITOR.instances.editor.getData(),
			blog_title		= $(this).find('input[name="title"]').val(),
			blog_modify 	= $(this).find('input[name="modifing"]').val(),
			blog_category 	= $(this).find('select[name="blog_categories"]').val(),
			blog_opt 		= "BLOG_CREATE_UPDATE",
			blog_owner 		= $(this).find('input[name="createdby"]').val();
		
		$.post("libs/ajax/functions.php", {blog_text: blog_text, blog_title: blog_title, OPT: blog_opt, blog_modify: blog_modify, blog_category: blog_category, blog_owner: blog_owner }, function (r) {
			if ($.trim(r) !== "ok") {
				$.confirm({
					title: 'Encountered an error!',
					closeIcon: true,
					closeIconClass: 'fa fa-close',
					backgroundDismiss: true,
					content: r,
					autoClose: 'close|5000',
					type: 'red',
					typeAnimated: true,
					buttons: {
						close: function () {
							text: 'Ok'
						}
					}
				});			} else {
				Oboro.alerta("success", "&Eacute;xito", "Blog published");
			}
		});
	});
	
	function ModifyBlog(blog)
	{
		$.post("libs/ajax/functions.php", {OPT: "BLOG_GET_TEXT", blog_id: blog }, function(r) {
			var arr = $.parseJSON(r);
			$('input[name="title"]').val(arr[0]);
			CKEDITOR.instances.editor.setData(arr[1]);
			$('input[name="modifing"]').val(blog);
		});
	}
</script>