<?php

/**
* 
*/
use Controller\Controller;

class auth extends Controller
{
	
	function __construct()
	{
		$this->DB = $this->model('db_models');
		$this->config();
	}

	public function api($apis=false, $method=false, $option=false)
	{
		if (!file_exists('app/api/'.$this->e($apis).'.php')) $this->printJson($this->invalid());

		$api = $this->authApi($this->e($apis));

		if (in_array($this->e($method), get_class_methods($api)) == false) $this->printJson($this->invalid());

		$api->$method($option);
	}
}