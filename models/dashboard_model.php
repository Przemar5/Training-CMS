<?php


class Dashboard_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function listUsers()
	{
		return $this->db->select('users', '*');
	}
}