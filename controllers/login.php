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
			$_SESSION['user_id'] = $result['id'];
			$path = BASE_URL . 'dashboard';
			
			header('Location: ' . $path);
		}
		else 
		{
			$path = BASE_URL . 'login';
			
			header('Location: ' . $path);
		}
	}
}