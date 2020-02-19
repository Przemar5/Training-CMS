<?php

class Hash
{
	public static function create($data, $algorithm = PASSWORD_DEFAULT, $options = ['cost' => 10])
	{
		return password_hash($data, $algorithm, $options);
	}
}