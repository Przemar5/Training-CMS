<?php


class PageError extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->view->title = 'Page not found';
		$this->view->render('error/index');
	}
}