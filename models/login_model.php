<?php


class Login_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function select($data)
	{
		$sql = 'SELECT * FROM users WHERE login = :login AND password = :password';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($data);
		
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}