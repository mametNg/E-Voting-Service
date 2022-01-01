<?php

/**
* 
*/
use Controller\Controller;


class home extends Controller
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
		
		if (!isset($_SESSION['nim']) || empty($_SESSION['nim'])) header("location: ".$this->base_url('/login'));

			$data = [
				"header"		=> $this->Menu->header(),
				"user"			=> $this->DB->getSelectTB("db_users", "nim", $this->e($_SESSION['nim']), true),
				"candidate"		=> $this->array_group(
					$this->DB->costumeDB("
					SELECT 
					campaign.code,
					campaign.number,
					candidate.name, 
					candidate.image, 
					role.name AS role
					FROM db_candidate AS candidate
					INNER JOIN db_campaign AS campaign ON candidate.code = campaign.code
					INNER JOIN db_candidate_role AS role ON candidate.role = role.code
					ORDER BY campaign.number, role.name ASC
					")
				,'number'),
			];
			
			// $this->printJSON($data['candidate']);
			$this->view("templates/home/header", $data);
			// $this->view("templates/home/topbar", $data);
			$this->view("home/home", $data);
			$this->view("templates/home/footer", $data);
		}
	}