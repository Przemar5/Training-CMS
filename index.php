<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once 'config/config.php';
require_once 'config/paths.php';

require_once 'libs/Database.php';
require_once 'libs/Form.php';
require_once 'libs/Cookie.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';
require_once 'libs/Hash.php';
require_once 'libs/Session.php';

require_once 'utils/Auth.php';
require_once 'utils/helpers.php';
require_once 'utils/Validator.php';

require_once 'models/user_tokens_model.php';


if (Cookie::exists('user_id') && $userId = Cookie::get('user_id') /*&& !Session::exists(USER_ID_SESSION_NAME)*/)
{
	$db = Database::getInstance();
	$result = $db->select('user_tokens', 'id, user_id, ending_at', ['value' => $userId], PDO::FETCH_OBJ);
	$token = (gettype($result) === 'array') ? $result[0] : $result; 
	
	if ($token) 
	{
		if($token->ending_at > date('Y-m-d H-i-s', time()))
		{
			$user = $db->select('users', 'remember_me', ['id' => $token->user_id]);
			
			if ($user['remember_me'] == 1)
			{
				$_SESSION[USER_ID_SESSION_NAME] = $token->user_id;

				Cookie::set('user_id', $token->user_id, REMEMBER_ME_COOKIE_EXPIRY);
			}
		}
		else 
		{
			$userTokens = new User_Tokens_Model;
			$userTokens->deleteBy([
				'field' => 'remember_me',
				'user_id' => $token->user_id,
			]);
		}
	}
}


//$userId = Cookie::get('user_id');
//
//if ($userId /*&& !Session::exists(USER_ID_SESSION_NAME)*/)
//{
//	$db = Database::getInstance();
//	$result = $db->select('users', 'id, login, remember_me', ['id' => $userId]);
//	
//	if ($result['remember_me'] == 1)
//	{
//		$data = [
//			'user_id' => $result['id'],
//			'field' => 'remember_me'
//		];
//		$userTokens = new User_Tokens_Model;
//		$rememberToken = $userTokens->getBy($data)[0];
//		
//		if ($rememberToken['value'] === $result['id'])
//		{
//			$data = [
//				'user_id' => $result['id'],
//				'field' => 'login'
//			];
//			$loginToken = $userTokens->getBy($data)[0];
//			
//			if ($loginToken['value'] === $result['login'])
//			{
//				$_SESSION[USER_ID_SESSION_NAME] = $result['id'];
//				
//				Cookie::set('user_id', $result['id'], REMEMBER_ME_COOKIE_EXPIRY);
//			}
//		}
//	}
//}
//dd($_COOKIE);

$url = isset($_GET['url']) ? $_GET['url'] : null;
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);
$length = sizeof($url);


if ($length === 0 || empty($url[0])) {
	require_once 'controllers/index.php';
	
	$controller = new Index;
	$controller->index();
}
else {
	$requestedFile = 'controllers/' . $url[0] . '.php';
	
	if (is_readable($requestedFile)) {
		require_once $requestedFile;
	
		$controller = new $url[0];
		
		switch ($length) {
			case 1:
				$controller->index();
				break;
			
			case 2:
				$controller->{$url[1]}();
				break;
				
			case 3:
				$controller->{$url[1]}($url[2]);
				break;
		}
	}
	else {
		require_once 'controllers/error.php';
		
		$controller = new PageError;
		$controller->index();
	}
}

