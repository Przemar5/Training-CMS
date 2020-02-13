<?php


class Form
{
	private $data;
	
	public function __construct()
	{
		//
	}
	
	public function validate($data, $fields)
	{
		$this->data = $data;
		$this->validator = new Validator;
		
		return $this->validator->validateMany($data, $fields);
	}
}