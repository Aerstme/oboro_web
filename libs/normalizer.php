<?php
class OBORO_NORMALIZER 
{
	private $safe_module = 'modules/home/home.motd.php';
	private $safe_parameter = FALSE;
	public $array_parameter = FALSE;
	
	/**
	 * Responsability function of the security of the Request URL
	 * $this->array_parameter can handle multiples params(-) if the module accept it (RequiereMultipleParams)
	 * @param  string $return[Module or Parameter] 
	 * @return string & Boolean if Module always return a valid module.
	 *                                                    if Parameter will return FALSE if hasn't or Array if multiple.
	 */
	public function CleanURL($return) 
	{
		$GET = (!empty(explode("?", $_SERVER['REQUEST_URI'])[1]) ? explode("?", $_SERVER['REQUEST_URI'])[1] : FALSE);
		if (empty($GET))
		{
			if ($return == 'Module')
				return $this->safe_module;
			else
				return 0;
		}
		$normalized = rawurlencode(preg_replace('/[^-A-Za-z0-9_. ]/', '', stripslashes(urldecode($GET))));
		
		// just more security...
		if (self::strposa($normalized,['SELECT','UPDATE', 'INSERT', 'DELETE', 'DROP', 'WHERE', '1=1']))
		{
			if ($return == 'Module')
				return $this->safe_module;
			else
				return 0;
		}
		
		$tmpArr = [];
		switch($return)
		{
			case 'Module':
				$module = explode("-",$normalized)[0];
				if (file_exists('modules/' . explode(".",$module)[0] . "/" . $module .".php")) 
					return 'modules/' . explode(".",$module)[0] . "/" . $module .".php";
				else
					return $this->safe_module;			
			break;
				
			case 'Parameter':
				foreach (($PARAMS = explode("-",$normalized)) as $poc => $val)
				{
					if ($poc == 0)
						continue; // depreciate module..
					array_push($tmpArr, $val);
				}
				return $tmpArr;
			break;	
		}
	}
	
	static function strposa($haystack, $needle, $offset=0) 
	{
		if(!is_array($needle)) $needle = array($needle);
		foreach($needle as $query) {
			if(strpos($haystack, $query, $offset) !== false) 
				return true;
		}
		return false;
	}
	
	/**
	 * Module's CleanURL Inicializator
	 * @return A valid or standart Module
	 */
	public function getModule()
	{
		return $this->CleanURL('Module');
	}
	
	/**
	 * Parameter's CleanURL Inicializator
	 * @return A valid or standart Parameter
	 */
	public function getParam($poc)
	{
		if (!empty($this->array_parameter))
			return isset($this->array_parameter[$poc]) ? $this->array_parameter[$poc] : FALSE;
		return FALSE;
	}
	
	/**
	 * Return securelly the Module Sting, detecting and deleting posibles Injects(SQL, XSS)
	 */
	public function IncludeModule()
	{
		$this->array_parameter = $this->CleanURL('Parameter');
		return $this->getModule();
	}	
}
?>
