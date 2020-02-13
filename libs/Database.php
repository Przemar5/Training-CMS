<?php


class Database extends PDO
{
	private static $instance = null;
//	private const BD_TYPE = 'mysql';
//	private const BD_HOST = 'localhost';
//	private const BD_USER = 'root';
//	private const BD_PASS = '';
//	private const BD_NAME = 'projects_mvc_cms';
//	private static $BD_TYPE = 'mysql';
//	private static $BD_HOST = 'localhost';
//	private static $BD_USER = 'root';
//	private static $BD_PASS = '';
//	private static $BD_NAME = 'projects_mvc_cms';
	
	public static function getInstance()
	{
		if (empty(self::$instance)) 
		{
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	public function __construct()
	{
		//echo self::$DB_TYPE;
		$dsn = 'mysql' . ':host=' . 'localhost' . ';dbname=' . 'projects_mvc_cms;';
		
		parent::__construct($dsn, 'root', '');
	}
	
	public function select($table, $values, $where = [], $fetchMode = PDO::FETCH_ASSOC)
	{
		if (!empty($values)) 
		{
			if (gettype($values) === 'string') 
			{
				$valuesList = $values;
			}
			else if (gettype($values) === 'array') 
			{
				$valuesList = implode(', ', $values);
			}
		}
		else 
		{
			$valuesList = "*";
		}
		
		$params = [];
		if (!empty($where)) 
		{
			if (gettype($where) === 'string') 
			{
				$condition = "WHERE " . $where;
			}
			else if (gettype($where) === 'array') 
			{
				$condition = array_map(function($key) {
					return "$key = :$key";
				}, array_keys($where));
				$condition = "WHERE " . implode(' AND ', $condition);
				$params = $where;
			}
		}
		else 
		{
			$condition = "";
		}
		
		$query = "SELECT $valuesList FROM $table $condition";
		$stmt = $this->prepare($query);
		$stmt->execute($params);
		$rows = $stmt->rowCount();
		
		if ($rows > 1) 
		{
			return $stmt->fetchAll($fetchMode);
		}
		else 
		{
			return $stmt->fetch($fetchMode);
		}
	}
	
	public function insert($table, $data)
	{
		$keys = array_keys($data);
		$keysPart = implode(', ', $keys);
		$valuesPart = implode(', ', array_map(
			function($key) {
				return ":$key";
			},
			$keys
		));
		
		$query = "INSERT INTO $table ($keysPart) VALUES ($valuesPart)";
		$stmt = $this->prepare($query);
		$stmt->execute($data);
		$rows = $stmt->rowCount();
		
		return $rows;
	}
	
	public function delete($table, $where)
	{
		$params = [];
		if (!empty($where)) 
		{
			if (gettype($where) === 'string') 
			{
				$condition = "WHERE " . $where;
			}
			else if (gettype($where) === 'array') 
			{
				$condition = array_map(function($key) {
					return "$key = :$key";
				}, array_keys($where));
				$condition = "WHERE " . implode(' AND ', $condition);
				$params = $where;
			}
		}
		else 
		{
			$condition = "";
		}
		
		$query = "DELETE FROM $table $condition LIMIT 1";
		$stmt = $this->prepare($query);
		$stmt->execute($params);
		$rows = $stmt->rowCount();
		
		return $rows;
	}
	
	private function fetchRequest($list, $possibleOutputs, $mode = 'default', $separator = ', ')
	{
		if (!empty($list)) 
		{
			if (gettype($list) === 'string') 
			{
				return $possibleOutputs[0];
			}
			else if (gettype($list) === 'array') 
			{
				if ($mode === 'default') {
					return implode($separator, $list);
				}
			}
		}
		else 
		{
			return $possibleOutputs[2];
		}
	}
}