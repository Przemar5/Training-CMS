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
	
	public function remember($id)
	{
		$sql = 'UPDATE users SET remember_me = 1 WHERE id = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(['id' => $id]);
		
		return $stmt->rowCount();
	}
}