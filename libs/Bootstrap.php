<?php


class Bootstrap
{
	private $_url, 
			$_controllersRoot = 'controllers/',
			$_defaultFile = 'index',
			$_defaultClass = 'Index',
			$_defaultMethod = 'index',
			$_errorFile = 'error',
			$_errorClass = 'PageError';
	
	public function __construct()
	{
		$this->loginFromCookie();
		$this->getUrl();
		$this->execute();
	}
	
	private function loginFromCookie()
	{
		if (Cookie::exists(REMEMBER_ME_COOKIE_NAME_CONSTANT) && $cookieValue = Cookie::get(REMEMBER_ME_COOKIE_NAME_CONSTANT) /*&& !Session::exists(USER_ID_SESSION_NAME)*/)
		{
			$db = Database::getInstance();
			$result = $db->select('user_tokens', 'id, user_id, ending_at', ['value' => $cookieValue], PDO::FETCH_OBJ);
			$token = (gettype($result) === 'array') ? $result[0] : $result; 
			
			if ($token) 
			{
				if($token->ending_at > date('Y-m-d H-i-s', time()))
				{
					$user = $db->select('users', 'remember_me', ['id' => $token->user_id]);

					if ($user['remember_me'] == 1)
					{
						$_SESSION[USER_ID_SESSION_NAME] = $token->user_id;

						Cookie::set(REMEMBER_ME_COOKIE_NAME_CONSTANT, $cookieValue, REMEMBER_ME_COOKIE_EXPIRY);
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
	}
	
	private function getUrl()
	{
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$this->_url = explode('/', $url);
	}

	private function execute()
	{
		$length = sizeof($this->_url);
		
		if ($length === 0 || empty($this->_url[0])) {
			$this->loadDefaultPage();
		}
		else {
			$requestedFile = $this->_controllersRoot . $this->_url[0] . '.php';

			if (is_readable($requestedFile)) {
				require_once $requestedFile;

				$controller = new $this->_url[0];

				switch (true) {
						
					case $length === 1:
						$controller->{$this->_defaultMethod}();
						break;

					case $length === 2:
						$controller->{$this->_url[1]}();
						break;

					case $length > 2:
//						call_user_func_array([$controller, $this->_url[1]], array_slice($this->_url, 2));
						$controller->{$this->_url[1]}($this->_url[2]);
						break;
				}
			}
			else {
				$this->loadErrorPage();
			}
		}
	}
	
	private function loadDefaultPage()
	{
		require_once $this->_controllersRoot . $this->_defaultFile . '.php';

		$controller = new $this->_defaultClass;
		$controller->{$this->_defaultMethod}();
	}
	
	private function loadErrorPage()
	{
		require_once $this->_controllersRoot . $this->_errorFile . '.php';

		$controller = new $this->_errorClass;
		$controller->{$this->_defaultMethod}();
	}
}