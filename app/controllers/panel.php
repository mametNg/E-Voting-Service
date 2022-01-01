<?php

/**
* 
*/
use Controller\Controller;

class panel extends Controller
{
	
	function __construct()
	{
		$this->DB = $this->model('db_models');
		$this->config();
		$this->Menu = $this->helper("menu");
	}

	public function index()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "home",
		];

		$data['header']['title'] = "Panel - Dashboard";
		$data['header']['desc'] = "Panel Dashboard";

		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view("panel/body",$data);
		$this->view("templates/panel/footer",$data);
	}

	public function websetting()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "websetting",
			"setting"	=> $this->DB->getAllTB("web_setting"),
			"activation"	=> $this->DB->getAllTB("web_activation"),
		];

		$data['header']['title'] = "Panel - Dashboard";
		$data['header']['desc'] = "Panel Dashboard";

		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view("panel/websetting",$data);
		$this->view("templates/panel/footer",$data);
	}

	public function usermanagement($method=false, $type=false, $param=false)
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "usermanagement",
		];

		$data['header']['title'] = "Panel - User Management";
		$data['header']['desc'] = "Panel Dashboard";

		// Default Open
		$open = "panel/usermanagement";

		if ($this->e($method) == "role") {
			$data['role'] = $this->DB->getAllTB("db_roles");
			$data['header']['title'] = "User Management - Role";
			$open = "panel/user-management/role";
		}

		if ($this->e($method) == "major") {
			$data['major'] = $this->DB->getAllTB("db_class");
			$data['header']['title'] = "User Management - Major";
			$open = "panel/user-management/major";
		}

		if ($this->e($method) == "class") {
			$data['class'] = $this->DB->costumeDB("
				SELECT
				class.class_code AS class_code,
				class.name AS class,
				class.code AS major_code,
				major.name AS major,
				class.role AS role_code,
				role.name AS role
				FROM db_subs_class AS class
				INNER JOIN db_class AS major ON major.code = class.code
				INNER JOIN db_roles AS role ON role.code = class.role
			");
			$data['role'] = $this->DB->getAllTB("db_roles");
			$data['major'] = $this->DB->getAllTB("db_class");
			$data['header']['title'] = "User Management - Class";
			$open = "panel/user-management/class";
		}

		if ($this->e($method) == "users") {
			$data['header']['title'] = "User Management - Users";
			$open = "panel/user-management/users";

			$data['users'] = $this->DB->costumeDB("
				SELECT 
				user.nim,
				user.name,
				role.name AS role,
				sclass.name AS class
				FROM db_users AS user
				INNER JOIN db_subs_class AS sclass ON sclass.class_code = user.class
				INNER JOIN db_roles AS role ON role.code = sclass.role
				ORDER BY role.name, user.class, user.name ASC
			");
			$data['header']['title'] = "User Management - Users";
			$data['role'] = $this->DB->getAllTB("db_roles");
			$data['class'] = $this->DB->costumeDB("
				SELECT DISTINCT
				sclass.role AS role_code,
				role.name AS role,
				sclass.class_code AS class_code,
				sclass.name AS class
				FROM db_subs_class AS sclass
				INNER JOIN db_roles AS role ON role.code = sclass.role
				ORDER BY sclass.role, sclass.name ASC
			");
		}


		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view($open,$data);
		$this->view("templates/panel/footer",$data);
	}

	public function campaign()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "campaign",
			"candidate"	=> $this->DB->costumeDB("
				SELECT candidate.candidate_code, campaign.number, candidate.name, candidate.image, role.name AS role
				FROM db_candidate AS candidate
				INNER JOIN db_campaign AS campaign ON candidate.code = campaign.code
				INNER JOIN db_candidate_role AS role ON candidate.role = role.code
			"),
			"number_candidate"	=> $this->DB->getAllTB("db_campaign"),
			"role_candidate"	=> $this->DB->getAllTB("db_candidate_role"),
		];

		$data['header']['title'] = "Panel - Campaign";
		$data['header']['desc'] = "Campaign";

		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view("panel/campaign",$data);
		$this->view("templates/panel/footer",$data);
	}

	public function stats()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "stats",
			"total_user"=> $this->DB->costumeDB("SELECT COUNT(nim) AS total FROM db_users", true),
			"candidate"	=> $this->array_group(
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
			, 'code'),
			"votes"		=> $this->DB->costumeDB("
				SELECT
				campaign.code AS code,
				campaign.number AS number,
				COUNT(user.take) AS votes
				FROM db_users AS user
				INNER JOIN db_campaign AS campaign ON campaign.code = user.take
				WHERE NOT user.take = ''
				GROUP BY user.take
			"),
		];

		$dataVote = [];

		foreach ($data['candidate'] as $key => $value) {
			$dataVote[$key]['number'] = $value[0]['number']; 
			unset($value[0]['number']);
			unset($value[0]['code']);
			unset($value[1]['number']);
			unset($value[1]['code']);
			$dataVote[$key]['votes'] = 0; 
			$dataVote[$key]['user'] = $value;
		}

		foreach ($dataVote as $userKey => $user) {
			foreach ($data['votes'] as $voteKey => $vote) {
				if ($vote['code'] == $userKey) {
					$dataVote[$userKey]['votes'] = $vote['votes'];
				}
			}
		}

		$data["voting"] = $dataVote;
		$data['header']['title'] = "Panel - Campaign Statistics";
		$data['header']['desc'] = "Panel Dashboard";

		// $this->printJSON($data["voting"]);

		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view("panel/stats",$data);
		$this->view("templates/panel/footer",$data);
	}

	public function login($email=false)
	{
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) header("location: ".$this->base_url('/panel'));


		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->e($email),
		];

		$data['header']['title'] = "Login - Panel";
		$data['header']['desc'] = "Login To Panel Dashboard";

		$this->view("templates/login/panel/header", $data);
		$this->view("login/panel/login", $data);
		$this->view("templates/login/panel/footer", $data);
	}

	public function logout()
	{	
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) unset($_SESSION['email']);
		header("location: ".$this->base_url('/panel/login'));
	}
}