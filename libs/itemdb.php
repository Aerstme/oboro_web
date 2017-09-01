<?php
	/*
	 *	ITEMDB Class BY ISAAC
	 * Oboro Control Panel 2.2.0.18 (C)
	 * 
	 * Missing images could be find here: 
	 *  - http://imgs.ratemyserver.net/items/large/5366.gif
	 *  - http://aesir-ragnarok.com/web/data/items/images/5423.png
	 */

class ITEMDB extends Cache {

	public $CurrentPage;
	public $CantidadPaginas;
	public $ItemsPorPagina = 6;
	private $ItemDB = array();
	private $DB = NULL;

	function __construct($DataBase)
	{
		$this->DB = $DataBase;
		$data_cache = $this->get('ItemDB');
		if (!$data_cache)
			$this->generateDB();
	}

	/*
	 * Crea la base de datos a nivel de array
	 * ahora solo implementada en itemdb..
	 * sin embargo es el mismo principio
	 * para mob db...
	 */
	public function generateDB() 
	{
		$CONFIG = new CONFIG;
		$i = 0;
		$ItemDB = array();
		
		$consult = 
		"
			SELECT 
				`id`, `name_japanese`, `description`, `weight`, `attack`, `defence`, `dona`, `range`, `slots`, `weapon_level`
			FROM 
				`item_db`
		";

		$result = $this->DB->execute($consult);
		
		if (empty($result))
			return FALSE;
			
		$data_cache = $this->get('ItemDB');
		if (!$data_cache)
		{
			while ($row = $result->fetch())
			{
				$this->ItemDB[$row['id']] = array (
					'id'				=>	$row['id'], 
					'namej'				=>	$row['name_japanese'],
					'item_description'	=>	html_entity_decode($row['description']),
					'weigth'			=>	$row['weight'],
					'attack'			=>	$row['attack'],
					'defence'			=>	$row['defence'],
					'range'				=>	$row['range'],
					'slots'				=>	$row['slots'],
					'weapon_level'		=>	$row['weapon_level'],
					'precio'			=>	$row['dona']
				);
			}
			$this->DB->free();
			$Data = base64_encode(serialize($this->ItemDB));
			$this->put('ItemDB',$Data);
		}
	}

	/**
	 * Retorna un elemento en una posición
	 * si y solo si este existe.
	 * si no existe retorna 0
	 * si no existe la caché retorna -1
	 **/
	function __GETDB($item_id, $var) 
	{
		$data_cache = $this->get('ItemDB');
		if ( $data_cache )
		{
			$IT_TEMP = $this->decode_arr($this->get('ItemDB'));
			if ( isset($IT_TEMP) && isset($IT_TEMP[$item_id][$var]))
				return $IT_TEMP[$item_id][$var];
			else
				return 0;
		}
		return -1;
	}

	/**
	 * [Panel Admin] => Configure Item DB
	 * funcion: will make an update list of the items(db) 
	 * with the descriptions
	 **/
	function setItemDescription() 
	{
		$CONFIG = new CONFIG;
		if (!($handle = fopen($CONFIG->getConfig("Web")."db/idnum2itemdesctable.txt", "rt")))
			return "Can't open file: idnum2itemdesctable.txt";
		
		$total = '';

		$file = file_get_contents("../../db/idnum2itemdesctable.txt");
		$exp = explode("#",$file);
		foreach ($exp as $poc => $val)
		{
			if (is_numeric($val) && $val > 0)
				$total .= trim(preg_replace('/\s+/', ' ', 'UPDATE `item_db` SET `description`="'.trim($this->ROHEXTOHTML($exp[$poc+1])).'" WHERE `id`='.$val.';')).PHP_EOL;
		}
		
		$total =  file_get_contents('../../db/item_db.sql') . $total;
		file_put_contents('../../db/item_db.sql', $total);
		return 'ok';
	}
	
	function setItemDBMain() 
	{
		$CONFIG = new CONFIG;
		if (!($handle = fopen($CONFIG->getConfig("Web")."db/item_db.txt", "rt")))
			return "Can't open file: item_db.txt";
		
		//we neeed to convert first the item_db as SQL....
		$GetFile = file_get_contents('../../db/item_db.txt');
		$lines = array();
		$lines = explode("\n", $GetFile);
		$total = "
DROP TABLE IF EXISTS `item_db`;
CREATE TABLE `item_db` (
  `id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name_english` varchar(50) NULL DEFAULT '',
  `name_japanese` varchar(50) NULL DEFAULT '',
  `type` tinyint(2) unsigned NULL DEFAULT '0',
  `price_buy` mediumint(10) unsigned DEFAULT NULL,
  `price_sell` mediumint(10) unsigned DEFAULT NULL,
  `weight` smallint(5) unsigned NULL DEFAULT '0',
  `attack` smallint(3) unsigned DEFAULT NULL,
  `defence` tinyint(3) unsigned DEFAULT NULL,
  `range` tinyint(2) unsigned DEFAULT NULL,
  `slots` tinyint(2) unsigned DEFAULT NULL,
  `equip_jobs` int(12) unsigned DEFAULT NULL,
  `equip_upper` tinyint(8) unsigned DEFAULT NULL,
  `equip_genders` tinyint(2) unsigned DEFAULT NULL,
  `equip_locations` smallint(4) unsigned DEFAULT NULL,
  `weapon_level` tinyint(2) unsigned DEFAULT NULL,
  `equip_level` tinyint(3) unsigned DEFAULT NULL,
  `refineable` tinyint(1) unsigned DEFAULT NULL,
  `view` smallint(3) unsigned DEFAULT NULL,
  `script` text,
  `equip_script` text,
  `unequip_script` text,
  `dona` int(11) NOT NULL DEFAULT '0',
  `description` varchar(1024) DEFAULT NULL,
  `dona_pack_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

";

		for ( $i = 0; $i < count($lines); $i++ )
		{
			$line_arg = explode(",", $lines[$i]);
			$script	= explode("{", $lines[$i]);

			$arr = array();
			foreach($line_arg as $poc => $val)
			{
				$commented = FALSE;

				if ($poc == 0)
				{
					$item_id = $line_arg[0];
					if (empty($item_id) || !is_numeric($item_id[0]))
					{
						$commented = TRUE;
						break;
					} else
						array_push($arr, "'".$item_id."'");
				}
				else
				{
					if ($val == "")
						array_push($arr, "NULL");
					else
					{
						array_push($arr, "'".str_replace("'","\'", $val)."'");
					}
				}
			}	
			if (!$commented)
			{
				$consult = "REPLACE INTO `item_db` VALUES(";
				foreach($arr as $poc => $val)
				{
					if ( $poc <= 18)
						$consult .= $val.", ";
				}

				$script = str_replace("}","", $script[1]);
				$script = preg_replace('!/\*.*?\*/!s', '', $script);

																	//dona's system
				$consult .= "'".rtrim($script,", ") ."', NULL, NULL, '0', NULL, '0'";

				$consult = rtrim($consult, ", ");
				$consult .= ");\n";
				$total .= $consult;
			}
		}
		file_put_contents('../../db/item_db.sql', $total);
		return $this->setItemDescription();
	}
	
	//isaac manipulador de hex.
	function ROHEXTOHTML($hextohtml) 
	{
		$Contador = explode(" ",$hextohtml);

		$HTML = str_replace("^000000","</span><br/>",$hextohtml);			

		for ( $i = 0; $i <= sizeof($Contador); $i++ ) {
			$GETCOLOR = substr($HTML,(strpos($HTML,"^") + 1),6);
			$HTML = str_replace("^".$GETCOLOR ,"<span style='color:#".$GETCOLOR."'>",$HTML);
		}

		//$HTML = str_replace(".",".<br/>",$HTML);
		//$HTML = str_replace("<br/>.<br/>",".<br/>",$HTML);
		$HTML = str_replace("</span><br/>]","</span>]",$HTML);
		$HTML = str_replace("</span><br/>,","</span>,",$HTML);
		$HTML = str_replace("</span><br/> and","</span>,",$HTML);
		$HTML = str_replace("</span><br/> by","</span>,",$HTML);
		$HTML = str_replace("</span><br/>.","</span>,",$HTML);
		$HTML = str_replace(" Class :","<br/>Class:",$HTML);
		$HTML = preg_replace('!/\*.*?\*/!s', '', $HTML);

		// Make lighter colors ???? isaac 17/01/2016...
		$HTML = str_replace("#880000","rgb(233, 90, 90)",$HTML);
		$HTML = str_replace("#777777","rgb(26, 162, 109)",$HTML);
		$HTML = str_replace("'","\'", $HTML);
		$HTML = str_replace('"','\"', $HTML);
		$HTML = htmlentities($HTML, ENT_COMPAT, 'utf-8');
		return trim((preg_replace('/\s+/', ' ', $HTML)));
	}
}

?>