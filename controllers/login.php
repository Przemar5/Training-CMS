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
				$this->createRememberToken($result['id']);
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
		setcookie('user_id', '', time() - 1, '/');
		setcookie('login', '', time() - 1, '/');
		
		header('Location: ' . INDEX);
	}
	
	private function createRememberToken($id)
	{
		$value = $id;
		Cookie::set('user_id', $value, REMEMBER_ME_COOKIE_EXPIRY);
		$this->model->remember($id);
		$uAgent = $_SERVER['HTTP_USER_AGENT'];
		$uAgent = preg_replace('/(\(.+\))|(\/([.\d]+))/', '', $uAgent);

		$data = [
			'type' => 'cookie',
			'field' => 'remember_me',
			'value' => $value,
			'user_id' => $id,
			'user_agent' => $uAgent,
			'ending_at' => date("Y-m-d H:i:s", time() + REMEMBER_ME_COOKIE_EXPIRY)
		];

		$userTokens = new User_Tokens_Model;
		$userTokens->create($data);
	}
}