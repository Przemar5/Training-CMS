<?php


class Dashboard extends Controller
{
	public function __construct()
	{
		if (Auth::verify('admin')) 
		{
			parent::__construct();
			
			$this->view->isDashboard = true;
		}
		else 
		{
			header('Location: ' . LOGIN);
		}
	}
	
	public function index()
	{
		$this->loadModel('dashboard');
		$this->view->users = $this->model->listUsers();
		$this->view->title = 'Dashboard';
		$this->view->render('dashboard/index');
	}
	
	public function logout()
	{
		unset($_SESSION['user_id']);
		
		header('Location: ' . INDEX);
	}
}