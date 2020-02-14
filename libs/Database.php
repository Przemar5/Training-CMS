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
		$dsn = 'mysql' . ':host=' . 'localhost' . ';dbname=' . 'projects_mvc_cms;';
		
		parent::__construct($dsn, 'root', '');
	}
	
	
	public function select($table, $values, $where = [], $fetchMode = PDO::FETCH_ASSOC)
	{
		$valuesList = $this->getCondition($values, "", "*");
		
		$params = (gettype($where) === 'array') ? $where : [];
		$condition = $this->getCondition($where, "WHERE ");
		
		$query = "SELECT $valuesList FROM $table $condition";
		$stmt = $this->sendQuery($query, $params);
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
		$closure = function($e) {
			return ":$e";
		};
		
		$valuesPart = $this->listValues($keys, ", ", $closure);
		
		$query = "INSERT INTO $table ($keysPart) VALUES ($valuesPart)";
		$stmt = $this->sendQuery($query, $data);
		$rows = $stmt->rowCount();
		
		return $rows;
	}
	
	
	public function update($table, $data, $where)
	{
		if (count($data))
		{
			$closure = function($key) {
				return "$key = :$key";
			};
			$values = $this->listValues(array_keys($data), ", ", $closure);
			$params = $data;
			
			if (gettype($where) === 'array')
			{
				$params = array_merge($params, $where);
			}
			$condition = $this->getCondition($where, "WHERE ");
			
			$query = "UPDATE $table SET $values $condition";
			$stmt = $this->sendQuery($query, $params);
			$rows = $stmt->rowCount();
			
			return $rows;
		}
	}
	
	
	public function delete($table, $where)
	{
		$params = (gettype($where) === 'array') ? $where : [];
		$condition = $this->getCondition($where, "WHERE ");
		
		$query = "DELETE FROM $table $condition LIMIT 1";
		$stmt = $this->sendQuery($query, $params);
		$rows = $stmt->rowCount();
		
		return $rows;
	}
	
	
	private function sendQuery($query, $params)
	{
		$stmt = $this->prepare($query);
		$stmt->execute($params);
		
		return $stmt;
	}
	
	
	private function listValues($values, $separator = ", ", $closure)
	{
		if (empty($closure))
		{
			$closure = function($a) {	return $a;	};
		}
		
		return implode($separator, array_map($closure, $values));
	}
	
	
	private function getCondition($where, $start = "", $alternative = "")
	{
		if (!empty($where)) 
		{
			if (gettype($where) === 'string') 
			{
				return $start . $where;
			}
			else if (gettype($where) === 'array') 
			{
				$closure = function($key) {		return "$key = :$key";		};
				$string = $this->listValues(array_keys($where), " AND ", $closure);
				
				return $start . $string;
			}
		}
		else
		{
			return $alternative;
		}
	}
}