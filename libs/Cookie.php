<?php


class Cookie
{
	public static function generateValue($salt, $value)
	{
		return $salt . $value;
	}
	
	public static function set($name, $value, $expiry)
	{
		return setcookie($name, $value, time() + $expiry, '/');
	}
	
	public static function get($name)
	{
		return $_COOKIE[$name];
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
	}
	
	public static function exists($name)
	{
		return isset($_COOKIE[$name]);
	}
}