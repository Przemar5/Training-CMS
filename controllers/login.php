<?php


class Login extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->view->isLogin = true;
	}
	
	public function index()
	{
		$this->view->title = 'Login';
		$this->view->render('login/index');
	}
	
	public function verify()
	{
		$data = [
			'login' => $_POST['login'],
			'password' => $_POST['password'],
		];
		$this->loadModel('Login');
		$result = $this->model->select($data);
		
		if (!empty($result)) 
		{
			if (isset($_POST['remember']) && $_POST['remember'] === 'on')
			{
//				$value = Cookie::generateValue(REMEMBER_ME_COOKIE_VALUE_CONSTANT,
//											   $result['id']);
				$value = $result['id'];
				Cookie::set(REMEMBER_ME_COOKIE_NAME_CONSTANT, 
							$value, 
							REMEMBER_ME_COOKIE_EXPIRY);
				$this->model->remember($result['id']);
				
				$data = [
					'type' => 'cookie',
					'field' => 'remember_me',
					'value' => $value,
					'user_id' => $result['id']
				];
				
				$userTokens = new User_Tokens_Model;
				$userTokens->create($data);
				
				
//				$value = Cookie::generateValue(LOGIN_COOKIE_VALUE_CONSTANT,
//											   $result['id']);
				$value = $result['login'];
				Cookie::set(LOGIN_COOKIE_NAME_CONSTANT, 
							$result['login'], 
							LOGIN_COOKIE_EXPIRY);
				
				$data = [
					'type' => 'cookie',
					'field' => 'login',
					'value' => $value,
					'user_id' => $result['id']
				];
				
				$userTokens->create($data);
			}
			
			$_SESSION[USER_ID_SESSION_NAME] = $result['id'];
			$path = BASE_URL . 'dashboard';
			
			header('Location: ' . $path);
		}
		else 
		{
			$path = BASE_URL . 'login';
			
			header('Location: ' . $path);
		}
	}
	
	public function logout()
	{
		unset($_SESSION[USER_ID_SESSION_NAME]);
		
		header('Location: ' . INDEX);
	}
}