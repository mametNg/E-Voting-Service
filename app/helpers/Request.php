<?php

/**
* 
*/
use Controller\Controller;

class Request extends Controller
{
	
	function __construct()
	{
		$this->Cookies = (in_array("Cookies", get_declared_classes()) ? new Cookies():$this->helper("Cookies"));
	}

	public function get()
	{
		if (!isset($_POST['data'])) return false;

		$thePostField = $this->RSAdecrypt($this->e($_POST['data']));

		if (!$thePostField) return false;

		$arrayPost = @json_decode($thePostField, true);

		if ($arrayPost === null && json_last_error() !== JSON_ERROR_NONE) return false;

		return $arrayPost;
	}

	public function postServer()
	{
		if (!isset($_SESSION['cip'])) return false;
		return (isset($_SERVER['HTTP_X_ACCESS_TOKEN']) && isset($_SERVER['HTTP_COOKIE']) ? ($this->e($_SERVER['HTTP_X_ACCESS_TOKEN']) == md5(md5($_SESSION['cip'])) ? true:false):false);
	}
}