<?php
/**
* 
*/
namespace App;
use Controller\Controller;

class App extends Controller
{
	protected $controller = 'home';
	protected $method = 'index';
	protected $params = [];

	function __construct()
	{	
		$url = $this->get_url();

		if (file_exists('app/controllers/'.$url[0].'.php')) {
			$this->controller = $url[0];
			unset($url[0]);
		}

    	// controller
		include 'app/controllers/'. $this->controller .'.php';
		$this->controller = new $this->controller;

    	// method
		if (isset($url[1])) {
			if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}

   		// params
		if (!empty($url)) {
			$this->params = array_values($url);
		}

    	// running controller and method + params
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

}