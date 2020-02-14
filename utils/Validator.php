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
				else if ($func === 'regex')
				{
					$result = $this->regex($value, $array[0]);
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
	
	
	private function setValidateMethod($condition, $error)
	{
		if ($condition)
		{
			return true;
		}
		else
		{
			$this->currentError = $error;

			return false;
		}
	}
	
	
	public function required($value)
	{
		$condition = !empty($value);
		$error = "This field is required.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function min($value, $min)
	{
		$condition = strlen($value) >= $min;
		$error = "This field must be $min characters minimum.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function max($value, $max)
	{
		$condition = strlen($value) <= $max;
		$error = "This field must be $max characters maximum.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function between($value, $min, $max)
	{
		$condition = strlen($value) >= $min && strlen($value) <= $max;
		$error = "This field must be between $min and $max characters.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function numeric($value)
	{
		$condition = is_numeric($value);
		$error = "This value must be a number.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function in($value, $list)
	{
		$condition = in_array($value, $list);
		$error = "This value isn't valid.";
		
		return $this->setValidateMethod($condition, $error);
	}
	
	
	public function regex($value, $pattern)
	{
		$condition = preg_match('/^'.$pattern.'$/', $value);
		$error = "This value isn't valid.";
		
		return $this->setValidateMethod($condition, $error);
	}
}