<?php
/**
 * MODELO REALACIONAL DE SEGURIDAD BASE DE DATOS
 * NANO SOFT (C) OBORO CP 15|11|2k15 - 3o/o3/2k17
 * 	- persistant conection
 *  - Users as instances
 *  - execute as query
 *  - Migración PDO::
 **/
class DATABASE extends CONFIG
{
	protected $PDO = FALSE;
	public $result;
	public $stmt;
	public $EndSQL;

	/**
	* Crea la conexión a la DB al entrar a la página
	* @private
	**/
	public function getConnection() 
	{
		if (!$this->PDO)
		{
			try
			{
				$dns = 'mysql:host='.$this->getConfig('DBHost').';dbname='.$this->getConfig('DBase');
				$this->PDO = new PDO($dns, $this->getConfig('DBUser'), $this->getConfig('DBPswd'));
			} catch (PDOException $e) 
			{
				die('cannot connect to DataBase');
			}
		}
		return $this->PDO;
	}

	/**
	 * Cierra conxiones existentes a la base de datos
	 * al dejar la página
	 * @private
	 **/
	public function __destruct() 
	{
		if ($this->PDO)
			$this->EndSQL();
	}

	/**
	 * [ISAAC] Nanosoft (c) 31/03/2017
	 * Ejecuta de manera rápida y segura una consulta con un conjunto de parámetros;
	 * En donde ya no hay que preocuparse de los injects a su vez esta función genera
	 * lo que Query y MRES hacían en Oboro 3.0 y posterior.
	 * $args = array();
	 * 	- Para enviar parametros a una consulta se utiliza así:
	 *  	$param = [<parametro1>,<parametro2>,<parametro3>,...]
	 *    
	 *    [VAR_DUMP Vars]
	 *    	- $DB->stmt:
	 *     		->affected_rows: INSERT UPDATE DELETE Row(s)
	 *       
	 *      - $DB->result(boolean):
	 *      	will return TRUE if a INSERT/UPDATE/DELETE is without errors in $consult
	 *       	will return FALSE if a INSERT/UPDATE/DELETE have some errors in $consult
	 *     $result:
	 *     		->num_rows: the correct way to know if a SELECT has data(rows);
	 *     	
	 **/
	public function execute($consult, $args = array())
	{
		if ($this->stmt = $this->getConnection()->prepare($consult))
		{  
			$this->stmt->setFetchMode(PDO::FETCH_ASSOC);
			$this->stmt->execute($args);
			
			return $this->stmt;
		}
		else
			return FALSE;
	}

	/**
	 * Destructor de Conexiones abiertas a la DB
	 */
	public function EndSQL()
	{
		$this->PDO = null;
		return;
	}
	
	public function free()
	{
		$this->stmt->closeCursor();
		return;
	}

	public function num_rows()
	{
		$result = $this->execute("SELECT FOUND_ROWS()");
		return (!empty($result) ? $result->fetchColumn() : FALSE);
	}
	
	public function ShowColumns($table) 
	{
		$result = $this->execute("SHOW COLUMNS FROM `".$table."`");
		$storeArray = Array();
		while ($row = $result->fetch(PDO::FETCH_NUM)) 
			$storeArray[] =  $row[0];
		$this->free($result);
		return $storeArray;
	}

}
?>