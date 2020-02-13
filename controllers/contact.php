<?php


class Contact extends Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->view->isContact = true;
	}
	
	public function index()
	{
		$this->view->title = 'Contact us';
		$this->view->render('contact/index');
	}
}