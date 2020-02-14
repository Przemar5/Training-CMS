<?php


class User_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function select($id)
	{
		return $this->db->select('users', '*', "id = $id");
	}
	
	public function create($data)
	{
		return $this->db->insert('users', $data);
	}
	
	public function update($id, $data)
	{
		return $this->db->update('users', $data, "id = $id");
	}
	
	public function delete($id)
	{
		return $this->db->delete('users', "id = $id");
	}
}