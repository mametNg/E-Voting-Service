<?php

/**
* User
*/


use Controller\Controller;

class v1 extends Controller
{
	
	function __construct()
	{
		$this->DB = (in_array("db_models", get_declared_classes()) ? new db_models():$this->model('db_models'));
		$this->config();
		$this->Request = $this->helper("Request"); 
	}

	public function login()
	{
		// Check session login
		if (isset($_SESSION['nim']) && !empty($_SESSION['nim'])) $this->printJson($this->invalid(false, 403, "This session already exist!", ["url" => $this->base_url().""]));

		// get request
		$params = $this->Request->get();

		// Filter NIM
		if (!isset($params['nim']) || empty($params['nim'])) $this->printJson($this->invalid(false, 403, "This id cannot be empty!"));

		// Filter Password
		if (!isset($params['nim']) || empty($params['password'])) $this->printJson($this->invalid(false, 403, "This password cannot be empty!"));

		// Filter Class
		if (!isset($params['as']) || empty($params['as'])) $this->printJson($this->invalid(false, 403, "This login as cannot be empty!"));

		// filter valid nim
		if (strlen($this->e($params['nim'])) !== 13) $this->printJson($this->invalid(false, 403, "ID length must be 13 numbers!"));

		// filter valid nim
		if (!$this->filterNumb($params['nim'])) $this->printJson($this->invalid(false, 403, "ID can only number!"));

		// Select user
		$user = $this->DB->costumeDB("
			SELECT
			user.nim, 
			user.name, 
			user.status, 
			user.password
			FROM db_users AS user
			INNER JOIN db_class AS class ON user.class = class.class_code
			INNER JOIN db_roles AS role ON class.role = role.code
			WHERE TRIM(user.nim)='". $this->e($params['nim']) ."' 
			AND TRIM(class.role)='". $this->e($params['as']) ."'
			", true);

		// Login Failed
		if (!$user) $this->printJson($this->invalid(false, 403, "Invalid id or role!, please try!"));

		// Valid password
		if ($this->e($params['password']) !== $this->w3llDecode($user['password'])) $this->printJson($this->invalid(false, 403, "Wrong Password"));

		// if (!password_verify($this->e($params['password']), $this->w3llDecode($user['password']))) $this->printJson($this->invalid(false, 403, "Wrong Password"));

		// check taking user
		if ($this->e($user['status']) !== "0") $this->printJson($this->invalid(false, 403, "Can't log back in!"));

		// Create session login
		$_SESSION['nim'] = $this->e($user['nim']);

		// Login success
		$response = $this->invalid(true, 200, "Login Success");
		$this->printJson($response);
	}

	public function vote()
	{
		// Check session login
		if (!isset($_SESSION['nim']) || empty($_SESSION['nim'])) $this->printJson($this->invalid(false, 403, "This session already exist!", ["url" => $this->base_url()]));

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Code Role
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This candidate cannot be empty!"));

		// get candidate
		$candidate = $this->DB->costumeDB("
			SELECT cand.name
			FROM db_campaign AS numb
			INNER JOIN db_candidate AS cand ON cand.code = numb.code
			WHERE cand.code='".$this->e($params['code'])."' AND numb.code='".$this->e($params['code'])."'
			");
		
		// GET USER
		$validUser = $this->DB->costumeDB("
			SELECT * FROM db_users WHERE nim='".$_SESSION['nim']."' AND status='0'
		", true);

		// valid get candidate
		if (!$validUser) $this->printJson($this->invalid(false, 403, "You can't vote back in!"));

		// valid get candidate
		if (!$candidate) $this->printJson($this->invalid(false, 403, "This candidate isn't registered!"));

		// parameter
		$dataTable = [
			"status"	=> 1,
		];

		$dataVote = [
			"nim" => $_SESSION['nim'],
			"take"	=> $this->e(strtoupper($params['code'])),
			"created"	=> time(),
		];

		// Update user
		$update = $this->DB->updateTB("db_users", $dataTable, "nim", $_SESSION['nim']);

		// Update user
		$insertVote = $this->DB->insertTB("db_votings", $dataVote);

		// valid update user
		if (!$update || !$insertVote) {
			$dataTable = [
				"status"	=> 0,
			];

			$this->DB->updateTB("db_users", $dataTable, "nim", $_SESSION['nim']);
			$this->DB->deltTB("db_votings", "nim", $_SESSION['nim']);
			$this->printJson($this->invalid(false, 403, "Vote failed. Please Try!"));
		}

		unset($_SESSION['nim']);

		// update success
		$this->printJson($this->invalid(true, 200, "Vote success. You will sign out automatic."));
	}

	public function quiccount()
	{
		$data = $this->DB->costumeDB("
			SELECT
			campaign.code AS code,
			COUNT(voting.take) AS votes
			FROM db_users AS user
			INNER JOIN db_votings AS voting ON voting.nim = user.nim
			INNER JOIN db_campaign AS campaign ON campaign.code = voting.take
			WHERE user.status = '1'
			GROUP BY voting.take
			ORDER BY campaign.code ASC
		");

		$secondData = $this->DB->costumeDB("SELECT code FROM db_candidate GROUP BY code ASC");

		$newArray = [];

		foreach ($secondData as $secondDataKey => $secondDataValue) {
			$new['code'] = $secondDataValue['code'];
			$new['votes'] = 0;
			foreach ($data as $dataKey => $dataValue) {
				if ($secondDataValue['code'] == $dataValue['code']) $new['votes'] = $dataValue['votes'];
			}
			array_push($newArray, $new);
		}
		
		$this->printJson($this->invalid(true, 200, "ok", $newArray));
	}

	public function setpass() 
	{
		$users = $this->DB->costumeDB("
			SELECT * FROM db_users WHERE 
			nim='2110910031118'
		");	

		foreach ($users as $user) {
			echo $this->w3llDecode($user['password'])."<br>";
		}
	}
}