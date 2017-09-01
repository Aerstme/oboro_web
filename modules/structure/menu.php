<?php
DEFINE ('USER_MENU', 0);
DEFINE ('ALL_MENU', -2);
DEFINE ('GMS_MENU', 99);

$mainmenu = array(
	array("Forum",		ALL_MENU,		"/foro/",					0),
	array("Rankings",	ALL_MENU,		0,							0),
	array("Information",ALL_MENU,		0,							0),
	array("Item DB",	ALL_MENU,		"itemdb.form",				0),
	array("Vote",		USER_MENU,		"vote.points",				0),
	array("Donate",		USER_MENU,		0,							0),
	array("Admin",		GMS_MENU,		"admin.management",			0)
);

//$submenu("nombre"				"ubicacion",				$mainmenu);
$submenu = array(
	// Rankings
	array("WoE",				"rankings.woe",						1),
	array("BG",					"rankings.bg",						1),
	array("PVP",				"rankings.pvp",						1),
	array("Exp",				"rankings.exp",						1),
	array("Guild",				"rankings.guild",					1),
	array("Zeny",				"rankings.zeny",					1),
	array("Hom",				"rankings.homunculus",				1),
	array("MVP",				"rankings.mvp",						1),
	array("PK",					"rankings.pk",				    	1),
	array("TK",					"rankings.tk",						1),
	array("Forja",				"rankings.forge",					1),
	array("Potion",				"rankings.potion",					1),
	array("Playtime",			"rankings.playtime",				1),
	array("Cash",				"rankings.cash",					1),
	array("BG Points",			"rankings.bgpoints",				1),

	// Información
	array("Name Changes",		"informacion.nameschange",			2),
	array("Who is online",		"informacion.whoisonline",			2),
	array("Families",			"informacion.family",				2),
	array("WOE Active Castles",	"informacion.castles",				2),
	array("MVP Cards",			"informacion.mvpcard",				2),
	array("Guild Pack",			"informacion.guildpack",			2),
	
	// Donations
	array("Make a donation",	"donation.info",					5),
	array("Donation Shop",		"donation.shop",					5),
);

echo '<ul class="OboroMenuContainer">';

foreach($mainmenu as $i => $menu )
{
	if( 
		$menu[1] == ALL_MENU || 
		(!empty($_SESSION['account_id']) && $menu[1] == USER_MENU ) ||
		(!empty($_SESSION['GMACCOUNT']) && $_SESSION['GMACCOUNT'] >= GMS_MENU && $menu[1] == GMS_MENU)  
	)
	{
		if (isset($head))
		echo '<span class="beuty-divider">&#8226</span>';
		
		$head = 1;
		
		if ( !empty($menu[2]))
		{
			if ( $menu[2][0] != "/")
				echo '<li><a class="OboroMenu" href="?'.$menu[2].'">'.$menu[0].'</a></li>';
			else
				echo '<li><a class="OboroMenu" href="'.$menu[2].'">'.$menu[0].'</a></li>';
		}
		else 
		{
			echo '
				<li class="OboroMenuShowSubMenu"><a class="OboroMenu">'.$menu[0]. '</a>
					<table class="OboroSubMenu">
						<tr>
							<td colspan="2" class="Fake-menu-td"></td>
						</tr>
			';
			
			$submenu_count = 0;
			foreach($submenu as $j => $MenuSec)
			{
				if ( $MenuSec[2] != $i )
					continue;
				
				if (empty($submenu_count))
					echo '<tr>';
				
				if ( isset($submenu[$j+1][2]) && $submenu[$j+1][2] == $i )
					echo '<td><a href="?'.$MenuSec[1].'">'.$MenuSec[0].'</a></td>';
				else
					echo '<td colspan="2"><a href="?'.$MenuSec[1].'">'.$MenuSec[0].'</a></td>';
				
				if ($submenu_count == 1)
				{
					echo '</tr>';
					$submenu_count = 0;
				} else
					$submenu_count++;
			}
			echo '<tr><td colspan="2" class="Fake-menu-td-final"></td></tr></table></li>';
		}
	}
}
echo '</ul>';
?>