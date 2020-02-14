<?php

class Hash
{
	public static function create($algo, $data, $salt)
	{
		$context = hash_init($algo, HASH_HMAC, HASH_KEY);
		hash_update($context, $data);
		
		return hash_final($context);
	}
}