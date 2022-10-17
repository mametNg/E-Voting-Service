<?php

/**
* 
*/
use Controller\Controller;

class menu extends Controller
{
	
	function __construct()
	{	
		$this->config();
		$this->DB = (in_array("db_models", get_declared_classes()) ? new db_models():$this->model("db_models"));
	}

	public function lates_ua($value=100)
	{
		return $this->DB->costumeDB("SELECT * FROM ua ORDER BY RAND() LIMIT ". $value);
	}

	public function openMenu()
	{
		return $this->DB->getAllTB("menu");
	}

	public function header()
	{
		$header = $this->DB->getSelectTB("header", "id", 1, true);
		$result = [
			"title"	=> $header['title'],
			"img_title"		=> $this->base_url("/assets/img/brand/".$header['icon']),
			"desc"			=> $header['description'],
		];

		return $result;
	}

	public function maintenance()
	{
		$data = [
			"header"	=> $this->header(),
		];

		$data['header']['title'] = "Maintenance";
		$data['header']['desc'] = "Website is under maintenance. Try again later.";

		$this->view("templates/login/home/header", $data);
		$this->view("addons/maintenance", $data);
		$this->view("templates/login/home/footer", $data);
		exit();
	}
}