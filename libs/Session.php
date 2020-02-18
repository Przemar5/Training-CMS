<?php


class Session
{
	public static function start()
	{
		session_start();
	}
	
	public static function display($name, $second)
	{
		
	}
	
	public static function displayOnce($names)
	{
		if (!empty($names[0]))
		{
			if (!empty($names[1]))
			{
				if (isset($_SESSION[$names[0]][$names[1]]))
				{
					echo $_SESSION[$names[0]][$names[1]];
					unset($_SESSION[$names[0]][$names[1]]);
				}
			}
			else if (isset($_SESSION[$names[0]]))
			{
				echo $_SESSION[$names[0]];
				unset($_SESSION[$names[0]]);
			}
		}
	}
	
	public static function exists($name)
	{
		return isset($_SESSION[$name]);
	}
}