<?php
if (!isset($_SESSION['GMACCOUNT']) || $_SESSION['GMACCOUNT'] < 99)
	exit;
?>

<div class="row">
	<div style="margin-top: -10px;">
		<div class="admin-menu">
			<ul>
                <li><a href="?admin.management-0">Dashboard</a></li>
				<li><a href="?admin.management-1">Accounts</a></li>
				<li><a href="?admin.management-2">Characters</a></li>
				<li>
					<a>Configure Item DB</a>
					<ul>
						<li><a href="?admin.management-3">Add Item DB</a></li>
						<li><a href="?admin.management-4">Config. Donation Shop</a></li>
					</ul>
				</li>
				<li><a href="?admin.management-5">Blog Management</a></li>
				<li><a href="?admin.management-6">PickLog</a></li>
			</ul>
		</div>
	</div>
</div>


<?php
	if (($opt = $NRM->getParam(0)) >= 0)
	{
		$module = FALSE;
		switch($opt)
		{
            case 0:
                $module = "dashboard";
            break;
			case 1:
				$module = "account";
			break;
			
			case 2:
				$module = "char";
			break;
				
			case 3:
				$module = "item_db.create";
			break;
				
			case 4:
				$module = "donationshop";
			break;
				
			case 5:
				$module = "blog";
			break;
				
			case 6:
				$module = "picklog";
			break;
		}
		if (isset($module))
			include_once("admin.".$module.".php");
	}
?>