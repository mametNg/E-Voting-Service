<?php

/**
* 
*/
use Controller\Controller;

class activation extends Controller
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
		if ($activation['status'] == 0) header("location: ".$this->base_url('/login'));

		if (isset($_SESSION['activation']) && !empty($_SESSION['activation'])) header("location: ".$this->base_url('/login'));

			$data = [
				"header"	=> $this->Menu->header(),
				"status"	=> "",
			];

			$data['header']['title'] = "Activation";
			$data['header']['desc'] = "Activation";
			
			if (isset($_POST['code']) && !empty($_POST['code'])) {
				$activation = $this->DB->costumeDB("
					SELECT * FROM web_activation 
					WHERE code='".$this->e($_POST['code'])."' AND status='0'
				",true);
				if ($activation) {

					$dataTable = [
						"status" => 1,
					];

					$this->DB->updateTB("web_activation", $dataTable, "code", $this->e($_POST['code']));

					$_SESSION['activation'] = $this->e($_POST['code']);
					header("location: ".$this->base_url('/login'));
					die;
				} else {
					$data['status'] = "Wrong activation code!";
				}
			}

			$this->view("templates/home/header", $data);
			$this->view("home/activation", $data);
			$this->view("templates/home/footer", $data);
	}
}