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
			user.take, 
			user.status, 
			user.password
			FROM db_users AS user
			INNER JOIN db_subs_class AS class ON user.class = class.class_code
			INNER JOIN db_roles AS role ON class.role = role.code
			WHERE TRIM(user.nim)='". $this->e($params['nim']) ."' 
			AND TRIM(class.role)='". $this->e($params['as']) ."'
			", true);

		// Login Failed
		if (!$user) $this->printJson($this->invalid(false, 403, "Invalid id or role!, please try!"));

		// Valid password
		if (!password_verify($this->e($params['password']), $this->w3llDecode($user['password']))) $this->printJson($this->invalid(false, 403, "Wrong Password"));

		// check taking user
		if ($this->e($user['take']) !== "" || $this->e($user['status']) !== "0") $this->printJson($this->invalid(false, 403, "Can't log back in!"));

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
		
		// valid get candidate
		if (!$candidate) $this->printJson($this->invalid(false, 403, "This candidate isn't registered!"));

		// parameter
		$dataTable = [
			"status"	=> 1,
			"take"	=> $this->e(strtoupper($params['code'])),
		];

		// Update user
		$update = $this->DB->updateTB("db_users", $dataTable, "nim", $_SESSION['nim']);

		// valid update user
		if (!$update) $this->printJson($this->invalid(false, 403, "Vote failed. Please Try!"));

		unset($_SESSION['nim']);

		// update success
		$this->printJson($this->invalid(true, 200, "Vote success. You will sign out automatic."));
	}

	public function quiccount()
	{
		$data = $this->DB->costumeDB("
			SELECT
			campaign.code AS code,
			COUNT(user.take) AS votes
			FROM db_users AS user
			INNER JOIN db_campaign AS campaign ON campaign.code = user.take
			WHERE NOT user.take = ''
			GROUP BY user.take
			");

		$secondData = $this->DB->costumeDB("SELECT code FROM db_candidate GROUP BY code");

		foreach ($secondData as $key => $value) $secondData[$key]['votes'] = 0;

		// if (!$data) $this->printJson($this->invalid(false, 403, "No data!"));
		$this->printJson($this->invalid(true, 200, "ok", ($data ? $data : $secondData)));
	}
}