<?php


class User extends Controller
{
	public function __construct()
	{
		if (Auth::verify('admin')) 
		{
			parent::__construct();
			
			$this->loadModel('user');
			$this->view->isUser = true;
		}
		else 
		{
			header('Location: ' . LOGIN);
		}
	}
	
	public function index()
	{
		$this->view->title = 'Users';
		$this->view->render('user/index');
	}
	
	public function add()
	{
		$this->view->title = 'Add user';
		$this->view->render('user/add');
	}
	
	public function create()
	{
		$data = [
			'login' => $_POST['login'],
			'password' => $_POST['password'],
			'role' => $_POST['role'],
		];
		$form = new Form;
		$rules = [
			'login' => ['between:3,55'],
			'password' => ['between:8,45'],
			'role' => ['in:"default","admin","owner"'],
		];
		
		if ($form->validate($data, $rules))
		{
			$this->model->create($data);
			
			header('Location: ' . DASHBOARD);
		}
		else 
		{
			$_SESSION['errors'] = $form->validator->errors;
			$form->validator->unsetErrors();
			
			header('Location: ' . USER . '/add');
		}
	}
	
	public function edit($id)
	{
		if (is_numeric($id)) 
		{
			$user = $this->model->select($id);
			
			if (!empty($user)) 
			{
				$this->view->title = 'Edit user';
				$this->view->render('user/edit');
			}
		}
	}
	
	public function delete($id)
	{
		if (is_numeric($id))
		{
			$user = $this->model->select($id);
			print_r($user);

			if (!empty($user))
			{
				if ($user['role'] === 'default')
				{
					if ($this->model->delete($id))
					{
						header('Location: ' . DASHBOARD);
					}
				}
				else if ($user['role'] === 'admin')
				{
					if (is_numeric($_SESSION['user_id']))
					{
						$loggedUser = $this->model->select($_SESSION['user_id']);
						
						if ($loggedUser['role'] === 'owner')
						{
							if ($this->model->delete($id))
							{
								header('Location: ' . DASHBOARD);
							}
						}
					}
				}
			}
		}
	}
}