<?php


class Validator
{
	public $errors = [];
	public $currentError = null;
	public $currentField = null;
	public $currentValue = null;
	
	public function __construct()
	{
		//
	}
	
	
	public function validateMany($data, $rules)
	{
		if (count($data))
		{
			$valid = true;
			
			foreach ($data as $key => $value)
			{
				if (array_key_exists($key, $rules))
				{
					if (!$this->validate($value, $rules[$key]))
					{
						$valid = false;
						$this->errors[$key] = $this->currentError;
					}
				}
			}
			
			return $valid;
		}
	}
	
	
	public function validate($value, $rules)
	{
		if (count($rules))
		{
			foreach ($rules as $rule)
			{
				$array = preg_split('/(:|,)/', $rule);
				$func = array_shift($array);
				
				if ($func === 'in')
				{
					$array = array_map(function($e) {
						return preg_replace('/(\"|\')/', '', $e);
					}, $array);
					$result = $this->{$func}($value, $array);
				}
				else 
				{
					array_unshift($array, $value);

					$result = call_user_func_array(
						[$this, $func], 
						$array
					);
				}

				if (!$result)
				{
					return false;
				}
			}
		}
		
		return true;
	}
	
	
	public function unsetErrors()
	{
		unset($this->currentError);
		unset($this->errors);
	}
	
	
	public function min($value, $min, $type = 'string')
	{
		if ($type === 'string')
		{
			if (strlen($value) >= $min) 
			{
				return true;
			}
			else
			{
				$this->currentError = "This field must be $min characters minimum.";
				
				return false;
			}
		}
		else if ($type === 'integer' || $type === 'double')
		{
			if ($value >= $min)
			{
				return true;
			}
			else
			{
				$this->currentError = "This value must be not not lesser than $min.";
				
				return false;
			}
		}
	}
	
	
	public function max($value, $max, $type = 'string')
	{
		if ($type === 'string')
		{
			if (strlen($value) <= $max) 
			{
				return true;
			}
			else
			{
				$this->currentError = "This field must be $max characters maximum.";
				
				return false;
			}
		}
		else if ($type === 'integer' || $type === 'double')
		{
			if ($value <= $max)
			{
				return true;
			}
			else
			{
				$this->currentError = "This value must be not greater than $max.";
				
				return false;
			}
		}
	}
	
	
	public function between($value, $min, $max, $type = 'string')
	{
		if ($type === 'string')
		{
			if (strlen($value) >= $min && strlen($value) <= $max) 
			{
				return true;
			}
			else
			{
				$this->currentError = "This field must be between $min and $max characters.";
				
				return false;
			}
		}
		else if ($type === 'integer' || $type === 'double')
		{
			if ($value >= $min && $value <= $max)
			{
				return true;
			}
			else
			{
				$this->currentError = "This value must be between $min and $max.";
				
				return false;
			}
		}
	}
	
	
	public function numeric($value)
	{
		if (is_numeric($value))
		{
			return true;
		}
		else
		{
			$this->currentError = "This value must be a number.";

			return false;
		}
	}
	
	
	public function in($value, $list)
	{
		if (in_array($value, $list))
		{
			return true;
		}
		else
		{
			$this->currentError = "This value isn\'t valid.";

			return false;
		}
	}
}