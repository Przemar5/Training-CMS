<?php


class Auth
{
	private static $db;
	
	public function __construct()
	{
		//$this->db = new Database;
	}
	
	private static function getDb()
	{
		if (empty(self::$db)) {
			self::$db = new Database;
		}
		
		return self::$db;
	}
	
	public static function verify($mode = 'admin')
	{
		$pattern = '/[0-9a-zA-Z _]/';
		
		if (isset($_SESSION[USER_ID_SESSION_NAME]) && preg_match($pattern, $_SESSION[USER_ID_SESSION_NAME])) 
		{
			$db = self::getDb();
			$result = $db->select('users', 'role', ['id' => $_SESSION[USER_ID_SESSION_NAME]]);
			
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
	
	public static function samePerson($id)
	{
		if (isset($_SESSION[USER_ID_SESSION_NAME]) && is_numeric($_SESSION[USER_ID_SESSION_NAME]))
		{
			$db = self::getDb();
			$loggedPerson = $db->select('users', 'id', ['id' => $_SESSION[USER_ID_SESSION_NAME]]);
			
			if ($loggedPerson['id'] === $id)
			{
				return true;
			}
		}
	}
	
	public static function hasPermission($user)
	{
		if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']))
		{
			$db = self::getDb();
			$loggedPerson = $db->select('users', 'role', ['id' => $_SESSION['user_id']]);
			
			if (!empty($loggedPerson))
			{
				if ($user['role'] === 'default' ||
				   ($user['role'] === 'admin' && $loggedPerson['role'] === 'owner'))
				{
					return true;
				}
			}
		}
	}
}