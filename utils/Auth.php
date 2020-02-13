<?php


class Auth
{
	private static $db;
	
	public function __construct()
	{
		//$this->db = new Database;
	}
	
	public static function verify($mode = 'admin')
	{
		$pattern = '/[0-9a-zA-Z _]/';
		
		if (isset($_SESSION['user_id']) && preg_match($pattern, $_SESSION['user_id'])) 
		{
			self::$db = new Database;
			$result = self::$db->select('users', 'role', ['id' => $_SESSION['user_id']]);
			
			if ($result) 
			{
				$role = $result['role'];
				
				if ($mode === 'admin') 
				{
					return $role === 'admin' || $role === 'owner';
				}
				else if ($mode === 'owner') 
				{
					return $role === 'owner';
				}
			}
			else 
			{
				return false;
			}
		}
	}
}