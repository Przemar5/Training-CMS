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
		$this->view->user = $this->model->select($_SESSION[USER_ID_SESSION_NAME]);
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
			'login' => ['required', 'between:3,55', 'regex:[0-9a-zA-Z _\-\.]+'],
			'password' => ['required', 'between:8,45', 'regex:[0-9a-zA-Z _\-\.]+'],
			'role' => ['required', 'in:"default","admin","owner"'],
		];
		
		if ($form->validate($data, $rules))
		{
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
			$this->model->create($data);
			
			header('Location: ' . DASHBOARD);
		}
		else 
		{
			$_SESSION['user_errors'] = $form->validator->errors;
			$form->validator->unsetErrors();
			
			header('Location: ' . USER . '/add');
		}
	}
	
	public function edit($id)
	{
		if (is_numeric($id) && $user = $this->model->select($id)) 
		{
			if (Auth::hasPermission($user) || Auth::samePerson($user['id']))
			{
				$this->view->title = 'Edit user';
				$this->view->user = $user;
				$this->view->render('user/edit');
			}
		}
	}
	
	public function update($id)
	{
		if (is_numeric($id) && $user = $this->model->select($id))
		{
			if (Auth::hasPermission($user) || Auth::samePerson($user['id']))
			{
				$data = [
					'login' => $_POST['login'],
					'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
					'role' => $_POST['role'],
				];
				$form = new Form;
				$rules = [
					'login' => ['required', 'between:3,55', 'regex:[0-9a-zA-Z _\-\.]+'],
					'password' => ['required', 'between:8,45', 'regex:[0-9a-zA-Z _\-\.]+'],
					'role' => ['required', 'in:"default","admin","owner"'],
				];
				
				if ($form->validate($data, $rules))
				{
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
					$this->model->update($id, $data);

					header('Location: ' . DASHBOARD);
				}
				else 
				{
					$_SESSION['user_errors'] = $form->validator->errors;
					$form->validator->unsetErrors();

					header('Location: ' . USER . '/edit/' . $id);
				}
			}
		}
	}
	
	public function delete($id)
	{
		if (is_numeric($id) && $user = $this->model->select($id))
		{
			if (Auth::hasPermission($user))
			{
				if ($this->model->delete($id) === 1)
				{
					header('Location: ' . DASHBOARD);
				}
			}
			else if (Auth::samePerson($user['id']))
			{
				if ($this->model->delete($id) === 1)
				{
					unset($_SESSION['user_id']);
					header('Location: ' . LOGIN);
				}
			}
		}
	}
}