<?php


class Controller
{
	public function __construct()
	{
		$this->view = new View;
	}
	
	
	public function loadModel($name)
	{
		$path = 'models/' . $name . '_model.php';
		
		if (file_exists($path)) 
		{
			require_once $path;
			
			$modelName = $name . '_Model';
			$this->model = new $modelName;
		}
	}
	
	
	public function getCurrentUrl()
	{
		return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
	
	public function urlStartsWith($start)
	{
		$len = strlen($start); 
		
    	return (substr($this->getCurrentUrl(), 0, $len) === $start); 
	}
}