<?php


class User_Tokens_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getBy($data, $fetchType = PDO::FETCH_ASSOC)
	{
		return $this->db->select('user_tokens', '*', $data, $fetchType);
	}
	
	public function create($data)
	{
		return $this->db->insert('user_tokens', $data);
		
		$sql = 'INSERT INTO user_tokens (type, field, value, user_id, added_at, ending_at) ' .
				'VALUES (:type, :field, :value, :user_id, NOW(), :ending_at)';
		$stmt = $this->db->prepare($sql);
		$stmt->execute($data);
		
		return $stmt->rowCount();
	}
	
	public function delete($id)
	{
		return $stmt = $this->db->delete('user_tokens', ['id' => $id], 1);
	}
	
	public function deleteBy($data)
	{
		return $stmt = $this->db->delete('user_tokens', $data, '');
	}
}