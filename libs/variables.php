<?php
class GVAR {
	public $Rank = array(
		"Civilian",
		"Private",
		"Corporal",
		"Sergeant",
		"Master<br>Sergeant",
		"Sergeant<br>Major",
		"Knight",
		"Knight Lieutenant",
		"Knight Captain",
		"Knight Champion",
		"Lieutenant Com.",
		"Commander",
		"Marshal",
		"Field Marshal",
		"Grand Marshal",
	);

	public $SortOrder = array(
		"DESC",
		"ASC",
	);

	public $SortType_WOE = array(
		"`char_wstats`.`score`",
		"`char_wstats`.`kill_count`",
		"`char_wstats`.`death_count`",
		"`char_wstats`.`top_damage`",
		"`char_wstats`.`damage_done`",
		"`char_wstats`.`damage_received`",
		"`char_wstats`.`emperium_damage`",
		"`char_wstats`.`barricade_damage`",
		"`char_wstats`.`gstone_damage`",
		"`char_wstats`.`guardian_damage`",
		"`char_wstats`.`emperium_kill`",
		"`char_wstats`.`barricade_kill`",
		"`char_wstats`.`gstone_kill`",
		"`char_wstats`.`guardian_kill`",
		"`char_wstats`.`support_skills_used`",
		"`char_wstats`.`wrong_support_skills_used`",
		"`char_wstats`.`healing_done`",
		"`char_wstats`.`wrong_healing_done`",
		"`char_wstats`.`hp_heal_potions`",
		"`char_wstats`.`sp_heal_potions`",
		"`char_wstats`.`yellow_gemstones`",
		"`char_wstats`.`red_gemstones`",
		"`char_wstats`.`blue_gemstones`",
		"`char_wstats`.`zeny_used`",
		"`char_wstats`.`ammo_used`",
		"`char_wstats`.`acid_demostration`",
		"`char_wstats`.`poison_bottles`",
	);
	
	public $SortType_BG = array(
		"`char_bg`.`points`",
		"`char_bg`.`rank_points`",
		"`char`.`bg_gold`",
		"`char`.`bg_silver`",
		"`char`.`bg_bronze`",
		"`char_bg`.`score`",

		"`char_bg`.`win`",
		"`char_bg`.`tie`",
		"`char_bg`.`lost`",
		"`char_bg`.`leader_win`",
		"`char_bg`.`leader_tie`",
		"`char_bg`.`leader_lost`",

		"`char_bg`.`kill_count`",
		"`char_bg`.`death_count`",
		"`char_bg`.`deserter`",

		"`char_bg`.`emperium_kill`",
		"`char_bg`.`barricade_kill`",
		"`char_bg`.`gstone_kill`",
		"`char_bg`.`cq_wins`",
		"`char_bg`.`cq_lost`",

		"`char_bg`.`top_damage`",
		"`char_bg`.`damage_done`",
		"`char_bg`.`damage_received`",
		"`char_bg`.`support_skills_used`",
		"`char_bg`.`wrong_support_skills_used`",
		"`char_bg`.`healing_done`",
		"`char_bg`.`wrong_healing_done`",
		"`char_bg`.`hp_heal_potions`",
		"`char_bg`.`sp_heal_potions`",
		"`char_bg`.`yellow_gemstones`",
		"`char_bg`.`red_gemstones`",
		"`char_bg`.`blue_gemstones`",
		"`char_bg`.`zeny_used`",
		"`char_bg`.`ammo_used`",
		"`char_bg`.`acid_demostration`",
		"`char_bg`.`poison_bottles`",
	);
	
	public $SortType_Castles = array(
		"defensive_score",
		"offensive_score",
		"posesion_time",
		"capture",
		"emperium",
		"treasure",
		"top_eco",
		"top_def",
		"invest_eco",
		"invest_def",
		"zeny_eco",
		"zeny_def",
		"skill_battleorder",
		"skill_regeneration",
		"skill_restore",
		"skill_emergencycall",
		"off_kill",
		"off_death",
		"def_kill",
		"def_death",
		"ext_kill",
		"ext_death",
		"ali_kill",
		"ali_death",
	);


	public $castles = array(
		'aldeg_cas01' => 'Neuschwanstein',
		'aldeg_cas02' => 'Hohenschwangau',
		'aldeg_cas03' => 'Nuenberg',
		'aldeg_cas04' => 'Wuerzburg',
		'aldeg_cas05' => 'Rothenburg',

		'gefg_cas01' => 'Repherion',
		'gefg_cas02' => 'Eeyolbriggar',
		'gefg_cas03' => 'Yesnelph',
		'gefg_cas04' => 'Bergel',
		'gefg_cas05' => 'Mersetzdeitz',

		'payg_cas01' => 'Bright Arbor',
		'payg_cas02' => 'Scarlet Palace',
		'payg_cas03' => 'Holy Shadow',
		'payg_cas04' => 'Sacred Altar',
		'payg_cas05' => 'Bamboo Grove Hill',

		'prtg_cas01' => 'Kriemhild',
		'prtg_cas02' => 'Swanhild',
		'prtg_cas03' => 'Fadhgridh',
		'prtg_cas04' => 'Skoegul',
		'prtg_cas05' => 'Gondul',

		'nguild_alde' => 'Earth',
		'nguild_gef' => 'Air',
		'nguild_pay' => 'Water',
		'nguild_prt' => 'Fire',

		'schg_cas01' => 'Himinn',
		'schg_cas02' => 'Andlangr',
		'schg_cas03' => 'Viblainn',
		'schg_cas04' => 'Hljod',
		'schg_cas05' => 'Skidbladnir',

		'arug_cas01' => 'Mardol',
		'arug_cas02' => 'Cyr',
		'arug_cas03' => 'Horn',
		'arug_cas04' => 'Gefn',
		'arug_cas05' => 'Bandis',
	);
	
	public $bgs = array(
		'bat_a01' => 'Tierra George',
		'bat_a02' => '<font color="#4169E1">Tierra EoS</font>',
		'bat_a03' => '<font color="#483D8B">Tierra Bossnia</font>',
		'region_8' => '<font color="#696969">Tierra TI</font>',
		'bat_b01' => 'Flavius',
		'bat_b02' => '<font color="#A0522D">Flavius CTF</font>',
		'bat_b03' => '<font color="#808000">Flavius TDM</font>',
		'bat_b04' => '<font color="#9ACD32">Flavius SC</font>',
		'bat_c01' => 'KvM 5vs5',
		'bat_c02' => 'KvM 5vs5',
		'bat_c03' => 'KvM 12vs12',
		'bat_c04' => 'Duel Arena',
		'schg_cas01' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas03' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas06' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas07' => '<font color="#FFA500">Castle Conquest</font>',
		'schg_cas08' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas06' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas07' => '<font color="#FFA500">Castle Conquest</font>',
		'arug_cas08' => '<font color="#FFA500">Castle Conquest</font>',
		'mocg_cas02' => '<font color="#DDA0DD">Castle Conquest</font>',
		'rush_cas01' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas02' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas03' => '<font color="#DDA0DD">Castle Rush</font>',
		'rush_cas04' => '<font color="#DDA0DD">Castle Rush</font>',
		'arena_01'	 =>	'<font color="#FFA500"> Team vs Team </font>'
	);

	function calc_rank($score) 
	{
		$result = intval($score / 270);
		if( $result > 14 )
			$result = 14;
		else if( $result < 0 )
			$result = 0;
		return $result;
	}
	
	function calc_posesion_time($time)
	{
		$days = intval($time / 86400);
		$time -= $days * 86400;

		$hour = intval($time / 3600);
		$time -= $hour * 3600;

		$minute = intval($time / 60);
		$time -= $minute * 60;

		$second = $time;

		$days = $days > 0 ? $days : 0;
		$hour = $hour > 0 ? $hour : 0;
		$minute = $minute > 0 ? $minute : 0;
		$second = $second > 0 ? $second : 0;

		return sprintf("%02d:%02d:%02d", $hour, $minute, $second);
	}
	
	function get_option_value($jobs) 
	{
		for( $i = 1; $i <= 26; $i++ ) 
		{
			switch( $i ) 
			{
				case 13:
				case 21:
				case 22:
				case 26:
					continue;
				default:
					echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}

		for( $i = 4001; $i <= 4022; $i++ ) 
		{
			switch( $i ) 
			{
				case 4014:
				case 4022:
					continue;
				default:
					echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}

		for( $i = 4023; $i <= 4049; $i++ ) 
		{
			switch( $i ) 
			{
				case 4036:
				case 4044:
				case 4048:
					continue;
				default:
					echo "<option value=\"$i\">$jobs[$i]</option>";
			}
		}
	}
	
	public $Global_Genero = array (
		array ("M", "Masculino"),
		array ("F", "Femenino")
	);
	
	public $Global_questions = array (
		array(0, 'What is your real FULL name'),
		array(1, 'Which is your Favorite Soccer team'),
		array(2, 'Who was your favorite teacher'),
		array(3, 'Who is/was your first love name'),
		array(4, 'Provide some security code, that you will remember / no passoword')
	);
	
	public $Global_Jobs = array (
		array (0, 'Novice'), 
		array (1, 'Swordman'), 
		array (2,'Magician'), 
		array (3,'Archer'), 
		array (4,'Acolyte'), 
		array (5,'Merchant'), 
		array (6,'Thief'), 
		array (7,'Knight'), 
		array (8,'Priest'), 
		array (9,'Wizard'), 
		array (10,'Blacksmith'), 
		array (11,'Hunter'), 
		array (12,'Assassin'), 
		array (13,'Knight'), 
		array (14,'Crusader'), 
		array (15,'Monk'), 
		array (16,'Sage'), 
		array (17,'Rogue'), 
		array (18,'Alchemist'), 
		array (19,'Bard'), 
		array (20,'Dancer'), 
		array (21,'Crusader'), 
		array (22,'Super_Novice'), 
		array (23,'Wedding_Class'), 
		array (24,'Gunslinger'), 
		array (25,'Ninja'),
		array (26,'Santa_Costume'), 

		array (4001,'Novice_High'),	
		array (4002,'Swordsman_High'),	
		array (4003,'Mage_High'),	
		array (4004,'Archer_High'),	
		array (4005,'Acolyte_High'),	
		array (4006,'Merchant_High'),	
		array (4007,'Thief_High'),	
		array (4008,'Lord_Knight'),	
		array (4009,'High_Priest'),	
		array (4010,'High_Wizard'),	
		array (4011,'Whitesmith'),	
		array (4012,'Sniper'),	
		array (4013,'Assassin_Cross'),	
		array (4014,'Lord_Knight'),	
		array (4015,'Paladin'),	
		array (4016,'Champion'),	
		array (4017,'Professor'),
		array (4018,'Stalker'),	
		array (4019,'Creator'),	
		array (4020,'Clown'),	
		array (4021,'Gypsy'),	
		array (4022,'Paladin'),	

		array (4023,'Baby_Novice'),	
		array (4024,'Baby_Swordman'),	
		array (4025,'Baby_Magician'),	
		array (4026,'Baby_Archer'),	
		array (4027,'Baby_Acolyte'),	
		array (4028,'Baby_Merchant'),	
		array (4029,'Baby_Thief'),	
		array (4030,'Baby_Knight'),	
		array (4031,'Baby_Priest'),	
		array (4032,'Baby_Wizard'),	
		array (4033,'Baby_Blacksmith'),	
		array (4034,'Baby_Hunter'),	
		array (4035,'Baby_Assassin'),	
		array (4036,'Baby_Knight'),	
		array (4037,'Baby_Crusader'),	
		array (4038,'Baby_Monk'),	
		array (4039,'Baby_Sage'),	
		array (4040,'Baby_Rogue'),	
		array (4041,'Baby_Alchemist'),	
		array (4042,'Baby_Bard'),	
		array (4043,'Baby_Dancer'),	
		array (4044,'Baby_Crusader'),	
		array (4045,'Baby_Super_Novice'),	
		
		array (4046,'Taekwon'),	
		array (4047,'Star_Gladiator'),	
		array (4048,'Star_Gladiator'),	
		array (4049,'Soul_Linker')
	);
	
	public $Global_MVPCard = array (
		array (4047, 'Ghostring Card'),
		array (4054, 'Angeling Card'),
		array (4121, 'Phreeoni Card'),
		array (4123, 'Eddga Card'),
		array (4128, 'Golden Thief Bug Card'),
		array (4131, 'Moonlight Flower Card'),
		array (4132, 'Mistress Card'),
		array (4134, 'Dracula Card'),
		array (4135, 'Orc Lord Card'),
		array (4137, 'Drake Card'),
		array (4142, 'Doppelganger Card'),
		array (4143, 'Orc Hero Card'),
		array (4144, 'Osiris Card'),
		array (4146, 'Maya Card'),
		array (4147, 'Baphomet Card'),
		array (4148, 'Pharaoh Card'),
		array (4168, 'Dark Lord Card'),
		array (4174, 'Deviling Card'),
		array (4198, 'Maya Purple Card'),
		array (4236, 'Amon Ra Card'),
		array (4263, 'Samurai Spector Card'),
		array (4276, 'Lord of The Dead Card'),
		array (4302, 'Tao Gunka Card'),
		array (4305, 'Turtle General Card'),
		array (4318, 'Stormy Knight Card'),
		array (4324, 'Hatii Card'),
		array (4330, 'Evil Snake Lord Card'),
		array (4342, 'RSX-0806 Card'),
		array (4352, 'General Egnigem Cenia Card'),
		array (4357, 'Lord Knight Card'),
		array (4359, 'Assassin Cross Card'),
		array (4361, 'MasterSmith Card'),
		array (4363, 'High Priest Card'),
		array (4367, 'Sniper Card'),
		array (4372, 'White Lady Card'),
		array (4374, 'Vesper Card'),
		array (4376, 'Lady Tanee Card'),
		array (4386, 'Detardeurus Card'),
		array (4399, 'Memory of Thanatos Card'),
		array (4403, 'Kiel-D-01 Card'),
		array (4407, 'Randgris Card'),
		array (4419, 'Ktullanux Card'),
		array (4425, 'Atroce Card'),
		array (4430, 'Ifrit Card'),
		array (4441, 'Fallen Bishop Hibram Card')
	);

	
	public $Global_BlogCategory = array (
		array (0, 'Noticies'),
		array (1, 'Events'),
		array (2, 'Change Log'),
		array (3, 'Pinned')
	);
	
	public $Global_pais = array (
		array ('0', 'Selecciona tu Pais'),
		array ('AF', 'Afganist&aacute;n'),
		array ('AL', 'Albania'),
		array ('DE', 'Alemania'),
		array ('AD', 'Andorra'),
		array ('AO', 'Angola'),
		array ('AI', 'Anguila'),
		array ('AQ', 'Ant&aacute;rtida'),
		array ('AG', 'Antigua y Barbuda'),
		array ('SA', 'Arabia Saud&iacute;'),
		array ('DZ', 'Argelia'),
		array ('AR', 'Argentina'),
		array ('AM', 'Armenia'),
		array ('AW', 'Aruba'),
		array ('AU', 'Australia'),
		array ('AT', 'Austria'),
		array ('AZ', 'Azerbaiy&aacute;n'),
		array ('BS', 'Bahamas'),
		array ('BH', 'Bahr&aacute;in'),
		array ('BD', 'Bangladesh'),
		array ('BB', 'Barbados'),
		array ('BE', 'B&eacute;lgica'),
		array ('BZ', 'Belice'),
		array ('BJ', 'Ben&iacute;n'),
		array ('BM', 'Bermudas'),
		array ('BY', 'Bielorrusia'),
		array ('BO', 'Bolivia'),
		array ('BA', 'Bosnia y Hercegovina'),
		array ('BW', 'Botsuana'),
		array ('BR', 'Brasil'),
		array ('BN', 'Brun&eacute;i'),
		array ('BG', 'Bulgaria'),
		array ('BF', 'Burkina Faso'),
		array ('BI', 'Burundi'),
		array ('BT', 'But&aacute;n'),
		array ('CV', 'Cabo Verde'),
		array ('KH', 'Camboya'),
		array ('CM', 'Camer&uacute;n'),
		array ('CA', 'Canad&aacute;'),
		array ('TD', 'Chad'),
		array ('CL', 'Chile'),
		array ('CN', 'China'),
		array ('CY', 'Chipre'),
		array ('VA', 'Ciudad del Vaticano'),
		array ('CO', 'Colombia'),
		array ('KM', 'Comoras'),
		array ('CG', 'Congo'),
		array ('CD', 'Congo, Rep&uacute;blica Democr&aacute;tica del'),
		array ('KP', 'Corea del Norte'),
		array ('KR', 'Corea del Sur'),
		array ('CI', 'Costa de Marfil'),
		array ('CR', 'Costa Rica'),
		array ('HR', 'Croacia'),
		array ('CU', 'Cuba'),
		array ('DK', 'Dinamarca'),
		array ('DM', 'Dominica'),
		array ('EC', 'Ecuador'),
		array ('EG', 'Egipto'),
		array ('SV', 'El Salvador'),
		array ('AE', 'Emiratos &Aacute;rabes Unidos'),
		array ('ER', 'Eritrea'),
		array ('SK', 'Eslovaquia'),
		array ('SI', 'Eslovenia'),
		array ('ES', 'Espa&ntilde;a'),
		array ('US', 'Estados Unidos'),
		array ('EE', 'Estonia'),
		array ('ET', 'Etiop&iacute;a'),
		array ('PH', 'Filipinas'),
		array ('FI', 'Finlandia'),
		array ('FJ', 'Fiyi'),
		array ('FR', 'Francia'),
		array ('GA', 'Gab&oacute;n'),
		array ('GM', 'Gambia'),
		array ('GE', 'Georgia'),
		array ('GH', 'Ghana'),
		array ('GI', 'Gibraltar'),
		array ('GD', 'Granada'),
		array ('GR', 'Grecia'),
		array ('GL', 'Groenlandia'),
		array ('GP', 'Guadalupe'),
		array ('GU', 'Guam'),
		array ('GT', 'Guatemala'),
		array ('GF', 'Guayana Francesa'),
		array ('GG', 'Guernsey'),
		array ('GN', 'Guinea'),
		array ('GW', 'Guinea-Bissau'),
		array ('GQ', 'Guinea Ecuatorial'),
		array ('GY', 'Guyana'),
		array ('HT', 'Hait&iacute;'),
		array ('HN', 'Honduras'),
		array ('HK', 'Hong Kong'),
		array ('HU', 'Hungr&iacute;a'),
		array ('IN', 'India'),
		array ('ID', 'Indonesia'),
		array ('IR', 'Ir&aacute;n'),
		array ('IQ', 'Iraq'),
		array ('IE', 'Irlanda'),
		array ('BV', 'Isla Bouvet'),
		array ('CX', 'Isla Christmas'),
		array ('IM', 'Isla de Man'),
		array ('IS', 'Islandia'),
		array ('NF', 'Isla Norfolk'),
		array ('AX', 'Islas Aland'),
		array ('KY', 'Islas Caim&aacute;n'),
		array ('CC', 'Islas Cocos'),
		array ('CK', 'Islas Cook'),
		array ('FO', 'Islas Feroe'),
		array ('GS', 'Islas Georgia del Sur y Sandwich del Sur'),
		array ('HM', 'Islas Heard y McDonald'),
		array ('FK', 'Islas Malvinas'),
		array ('MP', 'Islas Mariana del Norte'),
		array ('MH', 'Islas Marshall'),
		array ('UM', 'Islas menores alejadas de los Estados Unidos'),
		array ('PN', 'Islas Pitcairn'),
		array ('SB', 'Islas Salom&oacute;n'),
		array ('SJ', 'Islas Svalbard y Jan Mayen'),
		array ('TC', 'Islas Turcas y Caicos'),
		array ('VI', 'Islas V&iacute;rgenes, EE.UU.'),
		array ('VG', 'Islas V&iacute;rgenes Brit&aacute;nicas'),
		array ('IL', 'Israel'),
		array ('IT', 'Italia'),
		array ('JM', 'Jamaica'),
		array ('JP', 'Jap&oacute;n'),
		array ('JE', 'Jersey'),
		array ('JO', 'Jordania'),
		array ('KZ', 'Kazajist&aacute;n'),
		array ('KE', 'Kenia'),
		array ('KG', 'Kirguizist&aacute;n'),
		array ('KI', 'Kiribati'),
		array ('KW', 'Kuwait'),
		array ('LA', 'Laos'),
		array ('LS', 'Lesoto'),
		array ('LV', 'Letonia'),
		array ('LB', 'L&iacute;bano'),
		array ('LR', 'Liberia'),
		array ('LY', 'Libia'),
		array ('LI', 'Liechtenstein'),
		array ('LT', 'Lituania'),
		array ('LU', 'Luxemburgo'),
		array ('MO', 'Macao'),
		array ('MK', 'Macedonia'),
		array ('MG', 'Madagascar'),
		array ('MY', 'Malasia'),
		array ('MW', 'Malaui'),
		array ('MV', 'Maldivas'),
		array ('ML', 'Mali'),
		array ('MT', 'Malta'),
		array ('MA', 'Marruecos'),
		array ('MQ', 'Martinica'),
		array ('MU', 'Mauricio'),
		array ('MR', 'Mauritania'),
		array ('YT', 'Mayotte'),
		array ('MX', 'M&eacute;xico'),
		array ('FM', 'Micronesia'),
		array ('MD', 'Moldavia'),
		array ('MC', 'M&oacute;naco'),
		array ('MN', 'Mongolia'),
		array ('ME', 'Montenegro'),
		array ('MS', 'Montserrat'),
		array ('MZ', 'Mozambique'),
		array ('MM', 'Myanmar'),
		array ('NA', 'Namibia'),
		array ('NR', 'Nauru'),
		array ('NP', 'Nepal'),
		array ('NI', 'Nicaragua'),
		array ('NE', 'N&iacute;ger'),
		array ('NG', 'Nigeria'),
		array ('NU', 'Niue'),
		array ('NO', 'Noruega'),
		array ('NC', 'Nueva Caledonia'),
		array ('NZ', 'Nueva Zelanda'),
		array ('OM', 'Om&aacute;n'),
		array ('NL', 'Pa&iacute;ses Bajos'),
		array ('PK', 'Pakist&aacute;n'),
		array ('PW', 'Palaos'),
		array ('PA', 'Panam&aacute;'),
		array ('PG', 'Pap&uacute;a-Nueva Guinea'),
		array ('PY', 'Paraguay'),
		array ('PE', 'Per&uacute;'),
		array ('PF', 'Polinesia Francesa'),
		array ('PL', 'Polonia'),
		array ('PT', 'Portugal'),
		array ('PR', 'Puerto Rico'),
		array ('QA', 'Qatar'),
		array ('GB', 'Reino Unido'),
		array ('CF', 'Rep&uacute;blica Centroafricana'),
		array ('CZ', 'Rep&uacute;blica Checa'),
		array ('DO', 'Rep&uacute;blica Dominicana'),
		array ('RE', 'Reuni&oacute;n'),
		array ('RW', 'Ruanda'),
		array ('RO', 'Rumania'),
		array ('RU', 'Rusia'),
		array ('EH', 'S&aacute;hara Occidental'),
		array ('WS', 'Samoa'),
		array ('AS', 'Samoa americana'),
		array ('KN', 'San Crist&oacute;bal y Nieves'),
		array ('SM', 'San Marino'),
		array ('PM', 'San Pedro y Miquel&oacute;n'),
		array ('SH', 'Santa Elena'),
		array ('LC', 'Santa Luc&iacute;a'),
		array ('ST', 'Santo Tom&eacute; y Pr&iacute;ncipe'),
		array ('VC', 'San Vicente y las Granadinas'),
		array ('SN', 'Senegal'),
		array ('RS', 'Serbia'),
		array ('CS', 'Serbia y Montenegro'),
		array ('SC', 'Seychelles'),
		array ('SL', 'Sierra Leona'),
		array ('SG', 'Singapur'),
		array ('SY', 'Siria'),
		array ('SO', 'Somalia'),
		array ('LK', 'Sri Lanka'),
		array ('SZ', 'Suazilandia'),
		array ('ZA', 'Sud&aacute;frica'),
		array ('SD', 'Sud&aacute;n'),
		array ('SE', 'Suecia'),
		array ('CH', 'Suiza'),
		array ('SR', 'Surinam'),
		array ('TH', 'Tailandia'),
		array ('TW', 'Taiw&aacute;n'),
		array ('TZ', 'Tanzania'),
		array ('TJ', 'Tayikist&aacute;n'),
		array ('IO', 'Territorio Brit&aacute;nico del Oc&eacute;ano &Iacute;ndico'),
		array ('PS', 'Territorio Palestino'),
		array ('TF', 'Territorios Australes Franceses'),
		array ('TL', 'Timor Oriental'),
		array ('TG', 'Togo'),
		array ('TK', 'Tokelau'),
		array ('TO', 'Tonga'),
		array ('TT', 'Trinidad y Tobago'),
		array ('TN', 'T&uacute;nez'),
		array ('TM', 'Turkmenist&aacute;n'),
		array ('TR', 'Turqu&iacute;a'),
		array ('TV', 'Tuvalu'),
		array ('UA', 'Ucrania'),
		array ('UG', 'Uganda'),
		array ('UY', 'Uruguay'),
		array ('UZ', 'Uzbekist&aacute;n'),
		array ('VU', 'Vanuatu'),
		array ('VE', 'Venezuela'),
		array ('VN', 'Vietnam'),
		array ('WF', 'Wallis y Futuna'),
		array ('YE', 'Yemen'),
		array ('DJ', 'Yibuti'),
		array ('ZM', 'Zambia'),
		array ('ZW', 'Zimbabue'),
	);
}

?>