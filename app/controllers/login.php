<?php

/**
* 
*/
use Controller\Controller;


class login extends Controller
{
	
	function __construct()
	{
		$this->DB = $this->model('db_models');
		$this->config();
		$this->Menu = $this->helper("menu");
	}

	public function index()
	{	

		$maintenance = $this->DB->getSelectTB("web_setting", "code", "HKAJD", true);
		if ($maintenance['status'] == 1) {
			$this->Menu->maintenance();
		}
		
		$activation = $this->DB->getSelectTB("web_setting", "code", "BKJFW", true);

		if ($activation['status'] == 1) {
			if (!isset($_SESSION['activation']) || empty($_SESSION['activation'])) {
				header("location: ".$this->base_url('/activation'));
				die;
			}
		}
		
		if (isset($_SESSION['nim']) && !empty($_SESSION['nim'])) header("location: ".$this->base_url());

		$data = [
			"header"	=> $this->Menu->header(),
			"role"		=> $this->DB->getAllTB("db_roles"),
			"class"		=> $this->array_group(
				$this->DB->costumeDB("
					SELECT DISTINCT
					user.role AS role_code,
					role.name AS role,
					user.class AS class_code,
					sclass.name AS class_name,
					class.name AS major
					FROM db_users AS user
					INNER JOIN db_roles AS role ON user.role = role.code
					INNER JOIN db_subs_class AS sclass ON user.class = sclass.class_code
					INNER JOIN db_class AS class ON sclass.code = class.code
				")
			,'role_code'),
		];

		$this->view("templates/login/home/header", $data);
		$this->view("login/home/login", $data);
		$this->view("templates/login/home/footer", $data);
	}
}