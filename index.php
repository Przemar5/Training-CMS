<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once 'config/paths.php';

require_once 'libs/Database.php';
require_once 'libs/Form.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

require_once 'utils/Auth.php';
require_once 'utils/Validator.php';

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
	
	if (file_exists($requestedFile)) {
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
		echo '404 Page not found.';
	}
}

//
//$requestedFile = 'controllers/' . $url[0] . '.php';
//
//if (file_exists($requestedFile)) {
//	require_once $requestedFile;
//	
//	$controller = new $url[0];
//	
//	if (isset($url[1])) {
//		$controller->{$url[1]}();
//	}
//	else {
//		$controller->index();
//	}
//}

