<?php


class Model
{
	public function __construct()
	{
		$this->db = Database::getInstance();
	}
}