<?php


class User_Tokens extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create()
	{
		$this->loadModel('User_Tokens');
		
		
	}
}