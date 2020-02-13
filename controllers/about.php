<?php


class About extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->view->isAbout = true;
	}
	
	public function index()
	{
		$this->view->title = 'About us';
		$this->view->render('about/index');
	}
}