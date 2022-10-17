<?php

/**
* Panel Dashobard
*/

use Controller\Controller;

class v2 extends Controller
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
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) $this->printJson($this->invalid(false, 403, "This session already exist!", ["url" => $this->base_url()."/panel"]));

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Email
		if (!isset($params['email']) || empty($params['email'])) $this->printJson($this->invalid(false, 403, "This email cannot be empty!"));

		// Filter Password
		if (!isset($params['password']) || empty($params['password'])) $this->printJson($this->invalid(false, 403, "This password cannot be empty!"));

		// filter valid mail
		if (!$this->filterMail($params['email'])) $this->printJson($this->invalid(false, 403, "Email Isn't valid!"));

		// Get user
		$user = $this->DB->getSelectTB("db_admins", "email", $this->e($params['email']), true);

		// Login Failed
		if (!$user) $this->printJson($this->invalid(false, 403, "This email isn't registered"));

		// Valid password
		if (!password_verify($this->e($params['password']), $this->w3llDecode($user['password']))) $this->printJson($this->invalid(false, 403, "Wrong Password"));

		// Create session login
		$_SESSION['email'] = $this->e($user['email']);

		// Login success
		$response = $this->invalid(true, 200, "Login Success");
		$this->printJson($response);
	}

	public function websetting()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter code
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This code cannot be empty!"));

		// Filter type
		if (!isset($params['type']) || empty($params['type'])) $this->printJson($this->invalid(false, 403, "This type cannot be empty!"));

		// Filter code
		if (strlen($this->e($params['code'])) !== 5) $this->printJson($this->invalid(false, 403, "invalid code data!"));

		// Filter type
		if ($params['type'] !== "on" && $params['type'] !=="off") $this->printJson($this->invalid(false, 403, "invalid type data!"));

		// get web setting
		$wb = $this->DB->getSelectTB("web_setting", "code", $this->e($params['code']), true);

		// valid web setting
		if (!$wb) $this->printJson($this->invalid(false, 403, "This web setting insn't registered!"));

		$dataTable = [
			"status" => ($params['type'] == "on" ? 1:0),
		];

		// update table
		$execute = $this->DB->updateTB("web_setting", $dataTable, "code", $this->e($params['code']));

		// valid update table
		if (!$execute) $this->printJson($this->invalid(false, 403, "Update web setting failed. Please Try!"));

		$this->printJson($this->invalid(true, 200, "Update web setting success."));
	}

	public function newcodeactivation()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter new code
		if (!isset($params['new-code']) || empty($params['new-code'])) $this->printJson($this->invalid(false, 403, "This new code cannot be empty!"));

		// Filter code
		if (strlen($this->e($params['new-code'])) !== 1) $this->printJson($this->invalid(false, 403, "invalid code data!"));

		$dataTable = [
			"code" => strtoupper($this->randString(6)),
			"status" => 0,
		];

		$execute = $this->DB->insertTB("web_activation", $dataTable);

		// valid update table
		if (!$execute) $this->printJson($this->invalid(false, 403, "Create new activation code failed. Please Try!"));

		$this->printJson($this->invalid(true, 200, "Create new activation code success."));
	}

	public function newrole()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// filter valid role name
		if (!$this->filterString($params['role'])) $this->printJson($this->invalid(false, 403, "Role name can only contain characters and spaces!"));

		// new code role
		$code = strtoupper($this->randString(5));
		
		// Get role
		$role = $this->DB->costumeDB("
			SELECT * FROM db_roles WHERE name='".$this->e($params['role'])."' OR code='".$code."'
			");

		// already dataTable
		if ($role) $this->printJson($this->invalid(false, 403, "This role or code role already exist!"));

		// params
		$dataTable = [
			"code" => $code,
			"name" => $this->e(ucwords($params['role'])),
		];

		// insert table
		$insert = $this->DB->insertTB("db_roles", $dataTable);

		// Filter insert table
		if (!$insert) $this->printJson($this->invalid(false, 403, "Connection timeout. Please Try!"));

		// Add new role success
		$response = $this->invalid(true, 200, "Add new role success.");
		$this->printJson($response);
	}

	public function changerole()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter Code Role
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This role code cannot be empty!"));

		// Filter valid role name
		if (!$this->filterString($params['role'])) $this->printJson($this->invalid(false, 403, "Role name can only contain characters and spaces!"));

		// Get Role
		$role = $this->DB->getSelectTB("db_roles", "name", $this->e($params['role']), true);

		// chek name role
		if ($role) $this->printJson($this->invalid(false, 403, "This role already exist!"));
		
		// Get Role
		$roleCode = $this->DB->getSelectTB("db_roles", "code", $this->e($params['code']), true);

		// chek role code
		if (!$roleCode) $this->printJson($this->invalid(false, 403, "This role code isn't registered!"));

		// Params
		$dataTable = [
			"name" => $this->e(ucwords($params['role'])),
		];		

		// Update table
		$updateRole = $this->DB->updateTB("db_roles", $dataTable, "code", $this->e($params['code']));

		// Filter delt table
		if (!$updateRole) $this->printJson($this->invalid(false, 403, "Connection timeout. Please Try!"));

		// change role success
		$response = $this->invalid(true, 200, "Change role success.");
		$this->printJson($response);
	}

	public function deleterole()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));
		
		// Get role
		$role = $this->DB->getSelectTB("db_roles", "code", $this->e(strtoupper($params['role'])), true);

		// valid get role
		if (!$role) $this->printJson($this->invalid(false, 403, "This role isn't registered!"));

		// get class
		$class = $this->DB->getSelectTB("db_class", "role", $this->e(strtoupper($params['role'])), true);

		// valid get class
		if ($class) $this->printJson($this->invalid(false, 403, "Unable to delete role. Make sure not to connect with the class!"));

		// Delte table
		$delt = $this->DB->deltTB("db_roles", "code", $this->e(strtoupper($params['role'])));

		// Filter delt table
		if (!$delt) $this->printJson($this->invalid(false, 403, "Delete role failed. Please Try!"));

		// delete role success
		$response = $this->invalid(true, 200, "Delete role success.");
		$this->printJson($response);
	}

	public function newsince()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['since']) || empty($params['since'])) $this->printJson($this->invalid(false, 403, "This since cannot be empty!"));

		// filter valid role name
		if (!$this->filterNumb($params['since'])) $this->printJson($this->invalid(false, 403, "Role name can only contain numbers!"));

		// new code role
		$code = strtoupper($this->randString(5));
		
		// Get role
		$role = $this->DB->costumeDB("
			SELECT * FROM db_sinces WHERE name='".$this->e($params['since'])."' OR code='".$code."'
			");

		// already dataTable
		if ($role) $this->printJson($this->invalid(false, 403, "This since or code since already exist!"));

		// params
		$dataTable = [
			"code" => $code,
			"name" => $this->e(ucwords($params['since'])),
		];

		// insert table
		$insert = $this->DB->insertTB("db_sinces", $dataTable);

		// Filter insert table
		if (!$insert) $this->printJson($this->invalid(false, 403, "Connection timeout. Please Try!"));

		// Add new role success
		$response = $this->invalid(true, 200, "Add new since success.");
		$this->printJson($response);
	}

	public function changesince()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));
		// Filter Role
		if (!isset($params['since']) || empty($params['since'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter Code Role
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This role code cannot be empty!"));

		// Filter valid role name
		if (!$this->filterNumb($params['since'])) $this->printJson($this->invalid(false, 403, "Role name can only contain characters and spaces!"));

		// Get Role
		$role = $this->DB->getSelectTB("db_sinces", "name", $this->e($params['since']), true);

		// chek name role
		if ($role) $this->printJson($this->invalid(false, 403, "This since already exist!"));
		
		// Get Role
		$roleCode = $this->DB->getSelectTB("db_sinces", "code", $this->e($params['code']), true);

		// chek role code
		if (!$roleCode) $this->printJson($this->invalid(false, 403, "This since code isn't registered!"));

		// Params
		$dataTable = [
			"name" => $this->e(ucwords($params['since'])),
		];		

		// Update table
		$updateRole = $this->DB->updateTB("db_sinces", $dataTable, "code", $this->e($params['code']));

		// Filter delt table
		if (!$updateRole) $this->printJson($this->invalid(false, 403, "Connection timeout. Please Try!"));

		// change role success
		$response = $this->invalid(true, 200, "Change since success.");
		$this->printJson($response);
	}

	public function deletesince()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['since']) || empty($params['since'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));
		
		// Get role
		$role = $this->DB->getSelectTB("db_sinces", "code", $this->e(strtoupper($params['since'])), true);

		// valid get role
		if (!$role) $this->printJson($this->invalid(false, 403, "This role isn't registered!"));

		// get class
		$class = $this->DB->getSelectTB("db_class", "since", $this->e(strtoupper($params['since'])), true);

		// valid get class
		if ($class) $this->printJson($this->invalid(false, 403, "Unable to delete since. Make sure not to connect with the class!"));

		// Delte table
		$delt = $this->DB->deltTB("db_sinces", "code", $this->e(strtoupper($params['since'])));

		// Filter delt table
		if (!$delt) $this->printJson($this->invalid(false, 403, "Delete role failed. Please Try!"));

		// delete role success
		$response = $this->invalid(true, 200, "Delete role success.");
		$this->printJson($response);
	}

	public function newmajor()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// // Filter Major
		if (!isset($params['major']) || empty($params['major'])) $this->printJson($this->invalid(false, 403, "This major cannot be empty!"));

		// filter valid role name
		if (!$this->filterString($params['major'])) $this->printJson($this->invalid(false, 403, "Major name can only contain characters and spaces!"));

		// new code role
		$code = strtoupper($this->randString(5));
		
		// Get major
		$major = $this->DB->costumeDB("
			SELECT * FROM db_major WHERE name='".$this->e($params['major'])."' OR code='".$code."'
			");

		// already dataTable
		if ($major) $this->printJson($this->invalid(false, 403, "This major or code major already exist!"));

		// params
		$dataTable = [
			"code" => $code,
			"name" => $this->e(ucwords($params['major'])),
		];

		// insert table
		$insert = $this->DB->insertTB("db_major", $dataTable);

		// Filter insert table
		if (!$insert) $this->printJson($this->invalid(false, 403, "Add new major failed. Please Try!"));

		// Add new major success
		$response = $this->invalid(true, 200, "Add new major success.");
		$this->printJson($response);
	}

	public function changemajor()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['major']) || empty($params['major'])) $this->printJson($this->invalid(false, 403, "This major cannot be empty!"));

		// Filter Code Role
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This major code cannot be empty!"));

		// Filter valid major name
		if (!$this->filterString($params['major'])) $this->printJson($this->invalid(false, 403, "Major name can only contain characters and spaces!"));

		// Get major
		$role = $this->DB->getSelectTB("db_major", "name", $this->e($params['major']), true);

		// chek name major
		if ($role) $this->printJson($this->invalid(false, 403, "This major already exist!"));
		
		// Get major
		$roleCode = $this->DB->getSelectTB("db_major", "code", $this->e($params['code']), true);

		// chek major code
		if (!$roleCode) $this->printJson($this->invalid(false, 403, "This major code isn't registered!"));

		// Params
		$dataTable = [
			"name" => $this->e(ucwords($params['major'])),
		];		

		// Update table
		$updateRole = $this->DB->updateTB("db_major", $dataTable, "code", $this->e($params['code']));

		// Filter delt table
		if (!$updateRole) $this->printJson($this->invalid(false, 403, "Change major failed. Please Try!"));

		// change major success
		$response = $this->invalid(true, 200, "Change major success.");
		$this->printJson($response);
	}

	public function deletemajor()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter major
		if (!isset($params['major']) || empty($params['major'])) $this->printJson($this->invalid(false, 403, "This major cannot be empty!"));
		
		// Get major
		$major = $this->DB->getSelectTB("db_major", "code", $this->e(strtoupper($params['major'])), true);

		// valid get major
		if (!$major) $this->printJson($this->invalid(false, 403, "This major isn't registered!"));

		// get class
		$class = $this->DB->getSelectTB("db_class", "code", $this->e(strtoupper($params['major'])), true);

		// valid get class
		if ($class) $this->printJson($this->invalid(false, 403, "Unable to delete major. Make sure not to connect with the class!"));

		// Delte table
		$delt = $this->DB->deltTB("db_major", "code", $this->e(strtoupper($params['major'])));

		// Filter delt table
		if (!$delt) $this->printJson($this->invalid(false, 403, "Delete major failed. Please Try!"));

		// delete major success
		$response = $this->invalid(true, 200, "Delete major success.");
		$this->printJson($response);
	}

	public function newuser()
	{
		
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter nim
		if (!isset($params['nim']) || empty($params['nim'])) $this->printJson($this->invalid(false, 403, "This nim cannot be empty!"));

		// Filter name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This name cannot be empty!"));

		// Filter role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter class
		if (!isset($params['class']) || empty($params['class'])) $this->printJson($this->invalid(false, 403, "This class cannot be empty!"));

		// filter valid nim
		if (strlen($this->e($params['nim'])) !== 13) $this->printJson($this->invalid(false, 403, "ID length must be 13 numbers!"));

		// filter valid nim
		if (!$this->filterNumb($params['nim'])) $this->printJson($this->invalid(false, 403, "Nim can only number!"));

		// filter valid name
		if (!$this->filterString($params['name'])) $this->printJson($this->invalid(false, 403, "Name can only contain characters and spaces!"));

		// get user
		$user = $this->DB->getSelectTB("db_users", "nim", $this->e($params['nim']), true);
		// get class and role
		$cls = $this->DB->costumeDB("
			SELECT 
			role.name AS role,
			sclass.name AS class
			FROM db_class AS sclass
			INNER JOIN db_roles AS role ON role.code = sclass.role
			WHERE 
			sclass.class_code='". $this->e($params['class']) ."'
			AND sclass.role='". $this->e($params['role']) ."'
			", true);

		// valid user nim
		if ($user) $this->printJson($this->invalid(false, 403, "This nim already exist!"));
		// valid role and class
		if (!$cls) $this->printJson($this->invalid(false, 403, "This role and class isn't regisred!"));

		$datatable = [
			"nim"		=> $this->e($params['nim']),
			"password"	=> $this->e($this->w3llEncode($this->randNumb(8))),
			"name"		=> $this->e(ucwords(strtolower($params['name']))),
			"class"		=> $this->e(strtoupper($params['class'])),
			"status"	=> 0,
		];

		// Upload database
		$execute = $this->DB->insertTB("db_users", $datatable);

		// valid upload image and database
		if (!$execute) $this->printJson($this->invalid(false, 403, "Add new user failed. Please try!"));
		
		$this->printJson($this->invalid(true, 200, "Add new user success."));	
	}

	public function changeuser()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter nim
		if (!isset($params['nim']) || empty($params['nim'])) $this->printJson($this->invalid(false, 403, "This nim cannot be empty!"));

		// Filter name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This name cannot be empty!"));

		// Filter role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter class
		if (!isset($params['class']) || empty($params['class'])) $this->printJson($this->invalid(false, 403, "This class cannot be empty!"));

		// filter valid nim
		if (strlen($this->e($params['nim'])) !== 13) $this->printJson($this->invalid(false, 403, "ID length must be 13 numbers!"));

		// filter valid nim
		if (!$this->filterNumb($params['nim'])) $this->printJson($this->invalid(false, 403, "Nim can only number!"));

		// filter valid name
		if (!$this->filterString($params['name'])) $this->printJson($this->invalid(false, 403, "Name can only contain characters and spaces!"));

		// get user
		$user = $this->DB->getSelectTB("db_users", "nim", $this->e($params['nim']), true);
		// get class and role
		$cls = $this->DB->costumeDB("
			SELECT 
			role.name AS role,
			sclass.name AS class
			FROM db_class AS sclass
			INNER JOIN db_major AS class ON class.code = sclass.code
			INNER JOIN db_roles AS role ON role.code = sclass.role
			WHERE 
			sclass.class_code='". $this->e($params['class']) ."'
			AND sclass.role='". $this->e($params['role']) ."'
			", true);

		// valid user nim
		if (!$user) $this->printJson($this->invalid(false, 403, "This nim isn't regisred!"));
		// valid role and class
		if (!$cls) $this->printJson($this->invalid(false, 403, "This role and class isn't regisred!"));

		$dataTable = [
			"name"		=> $this->e(ucwords(strtolower($params['name']))),
			"class"		=> $this->e(strtoupper($params['class'])),
		];

		// Upload database
		$execute = $this->DB->updateTB("db_users", $dataTable, "nim", $this->e($params['nim']));

		// valid upload image and database
		if (!$execute) $this->printJson($this->invalid(false, 403, "Change user failed. Please try!"));
		
		$this->printJson($this->invalid(true, 200, "Change user success."));	
	}

	public function deleteuser()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter nim
		if (!isset($params['nim']) || empty($params['nim'])) $this->printJson($this->invalid(false, 403, "This nim cannot be empty!"));

		// filter valid nim
		if (strlen($this->e($params['nim'])) !== 13) $this->printJson($this->invalid(false, 403, "ID length must be 13 numbers!"));

		// filter valid nim
		if (!$this->filterNumb($params['nim'])) $this->printJson($this->invalid(false, 403, "Nim can only number!"));

		// get user
		$user = $this->DB->getSelectTB("db_users", "nim", $this->e($params['nim']), true);

		// valid user nim
		if (!$user) $this->printJson($this->invalid(false, 403, "This nim isn't regisred!"));

		// delete database
		$execute = $this->DB->deltTB("db_users", "nim", $this->e($params['nim']));

		// valid delete database
		if (!$execute) $this->printJson($this->invalid(false, 403, "Delete user failed. Please try!"));
		
		$this->printJson($this->invalid(true, 200, "Delete user success."));	
	}

	public function newclass()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter class
		if (!isset($params['class']) || empty($params['class'])) $this->printJson($this->invalid(false, 403, "This class cannot be empty!"));

		// Filter major
		if (!isset($params['major']) || empty($params['major'])) $this->printJson($this->invalid(false, 403, "This major cannot be empty!"));

		// Filter role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter role
		if (!isset($params['since']) || empty($params['since'])) $this->printJson($this->invalid(false, 403, "This since cannot be empty!"));

		// get class
		$class = $this->DB->getSelectTB("db_class", "name", $this->e(strtoupper($params['class'])));
		// get major
		$major = $this->DB->getSelectTB("db_major", "code", $this->e(strtoupper($params['major'])));
		// get role
		$role = $this->DB->getSelectTB("db_roles", "code", $this->e(strtoupper($params['role'])));
		// get since
		$since = $this->DB->getSelectTB("db_sinces", "code", $this->e(strtoupper($params['since'])));

		// valid class
		if ($class) $this->printJson($this->invalid(false, 403, "This class already exist!"));
		// valid major
		if (!$major) $this->printJson($this->invalid(false, 403, "This major isn't regisred!"));
		// valid role
		if (!$role) $this->printJson($this->invalid(false, 403, "This role isn't regisred!"));
		// valid since
		if (!$since) $this->printJson($this->invalid(false, 403, "This since isn't regisred!"));

		// new code role
		$code = strtoupper($this->randString(5));

		$dataTable = [
			"class_code"	=> $code,
			"code"			=> $this->e(strtoupper($params['major'])),
			"name"			=> $this->e(strtoupper($params['class'])),
			"role"			=> $this->e(strtoupper($params['role'])),
			"since"			=> $this->e(strtoupper($params['since'])),
		];

		// insert table
		$execute = $this->DB->insertTB("db_class", $dataTable);

		// Filter insert table
		if (!$execute) $this->printJson($this->invalid(false, 403, "Add new class failed. Please Try!"));

		// Add new class success
		$response = $this->invalid(true, 200, "Add new class success.");
		$this->printJson($response);
	}

	public function changeclass()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter code
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This class code cannot be empty!"));

		// Filter class
		if (!isset($params['class']) || empty($params['class'])) $this->printJson($this->invalid(false, 403, "This class cannot be empty!"));

		// Filter major
		if (!isset($params['major']) || empty($params['major'])) $this->printJson($this->invalid(false, 403, "This major cannot be empty!"));

		// Filter role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This role cannot be empty!"));

		// Filter since
		if (!isset($params['since']) || empty($params['since'])) $this->printJson($this->invalid(false, 403, "This since cannot be empty!"));
		
		// get class by code
		$class = $this->DB->getSelectTB("db_class", "class_code", $this->e(strtoupper($params['code'])), true);
		// get class by name
		$className = $this->DB->getSelectTB("db_class", "name", $this->e(strtoupper($params['class'])), true);
		// get major
		$major = $this->DB->getSelectTB("db_major", "code", $this->e(strtoupper($params['major'])));
		// get role
		$role = $this->DB->getSelectTB("db_roles", "code", $this->e(strtoupper($params['role'])));
		// get since
		$since = $this->DB->getSelectTB("db_sinces", "code", $this->e(strtoupper($params['since'])));

		// valid class
		if (!$class) $this->printJson($this->invalid(false, 403, "This class already exist!"));
		// valid major
		if (!$major) $this->printJson($this->invalid(false, 403, "This major isn't regisred!"));
		// valid role
		if (!$role) $this->printJson($this->invalid(false, 403, "This role isn't regisred!"));
		// valid since
		if (!$since) $this->printJson($this->invalid(false, 403, "This since isn't regisred!"));

		if ($className && $className['class_code'] !== $class['class_code']) $this->printJson($this->invalid(false, 403, "This class name already exist!"));

		$dataTable = [
			"code"	=> $this->e(strtoupper($params['major'])),
			"name"	=> $this->e(strtoupper($params['class'])),
			"role"	=> $this->e(strtoupper($params['role'])),
			"since"	=> $this->e(strtoupper($params['since'])),
		];

		// update database
		$execute = $this->DB->updateTB("db_class", $dataTable, "class_code", $this->e($params['code']));

		// valid update image and database
		if (!$execute) $this->printJson($this->invalid(false, 403, "Update class failed. Please try!"));
		
		$this->printJson($this->invalid(true, 200, "Update class success."));	
	}

	public function deleteclass()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter class code
		if (!isset($params['class']) || empty($params['class'])) $this->printJson($this->invalid(false, 403, "This class code cannot be empty!"));

		// get class
		$class = $this->DB->getSelectTB("db_class", "class_code", $this->e($params['class']),true);
		// get user
		$user = $this->DB->getSelectTB("db_users", "class", $this->e($params['class']),true);

		// already dataTable
		if (!$class) $this->printJson($this->invalid(false, 403, "This class isn't registered!"));

		// already dataTable
		if ($user) $this->printJson($this->invalid(false, 403, "Unable to delete class. Make sure not to connect with the user!"));

		// Delte table
		$execute = $this->DB->deltTB("db_class", "class_code", $this->e(strtoupper($params['class'])));

		// Filter delt table
		if (!$execute) $this->printJson($this->invalid(false, 403, "Delete class failed. Please Try!"));

		// delete role success
		$response = $this->invalid(true, 200, "Delete class success.");
		$this->printJson($response);
	}

	public function newcandidate()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter candidate number
		if (!isset($params['number']) || empty($params['number'])) $this->printJson($this->invalid(false, 403, "This candidate number cannot be empty!"));

		// Filter candidate name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This candidate name cannot be empty!"));

		// Filter candidate as name
		if (!isset($params['as']) || empty($params['as'])) $this->printJson($this->invalid(false, 403, "This candidate as name cannot be empty!"));

		// Filter valid candidate name
		if (!$this->filterString($params['name'])) $this->printJson($this->invalid(false, 403, "Candidate name can only contain characters and spaces!"));

		// Filter image original avatar candidate
		if (!isset($_FILES['original-avatar']) || empty($_FILES['original-avatar'])) $this->printJson($this->invalid(false, 403, "This original avatar cannot be empty!"));

		// Filter image avatar candidate
		if (!isset($_FILES['avatar']) || empty($_FILES['avatar'])) $this->printJson($this->invalid(false, 403, "This avatar cannot be empty!"));

		// Valid original avatar candidate
		$filterImg = $this->filterImg($_FILES['original-avatar']);
		if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

		// Valid avatar candidate
		$filterImg = $this->filterImg($_FILES['avatar']);
		if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

		// new code role
		$code = strtoupper($this->randString(5));

		// Get candidate
		$candidate = $this->DB->costumeDB("
			SELECT user.name 
			FROM db_candidate AS user
			INNER JOIN db_campaign AS numb ON numb.code = '".$this->e($params['number'])."'
			INNER JOIN db_candidate_role AS role ON role.code = '".$this->e($params['as'])."'
			WHERE user.code='".$this->e($params['number'])."' AND user.role='".$this->e($params['as'])."' AND NOT user.candidate_code='".$code."'
			", true);

		// Get code number campaign
		$userNumb = $this->DB->getSelectTB("db_campaign", "code", $this->e($params['number']), true);
		// Get code role campaign
		$userRole = $this->DB->getSelectTB("db_candidate_role", "code", $this->e($params['as']), true);

		// valid code number campaign
		if (!$userNumb) $this->printJson($this->invalid(false, 403, "Candidate number isn't registered!"));

		// valid code number campaign
		if (!$userRole) $this->printJson($this->invalid(false, 403, "As candidate isn't registered!"));

		// valid Candidate number and As candidate
		if ($candidate) $this->printJson($this->invalid(false, 403, "Candidate number and as candidate already exist!"));

		// Random file name
		$randFilename = $this->randString(50);

		// extract avatar file
		$thumbnail = [
			'size'		=> trim($_FILES['avatar']['size']),
			'tmp'		=> trim($_FILES['avatar']['tmp_name']),
			'pixel'		=> @getimagesize($_FILES['avatar']['tmp_name']),
			'error'		=> trim($_FILES['avatar']['error']),
			'extension'	=> explode(".", trim($_FILES['avatar']['name'])),
		];

		// extract original avatar file
		$original = [
			'size'		=> trim($_FILES['original-avatar']['size']),
			'tmp'		=> trim($_FILES['original-avatar']['tmp_name']),
			'pixel'		=> @getimagesize($_FILES['original-avatar']['tmp_name']),
			'error'		=> trim($_FILES['original-avatar']['error']),
			'extension'	=> explode(".", trim($_FILES['original-avatar']['name'])),
		];

		// image params
		$img = [
			'filename'	=> $randFilename.".".end($original['extension']),
			'pathThumb'	=> "assets/img/candidate/thumbnail/",
			'pathOri'	=> "assets/img/candidate/original/",
		];

		// valid extension
		if (end($thumbnail['extension']) == 'svg' || end($original['extension']) == 'svg') $this->printJson($this->invalid(false, 403, "The file must be an image!"));

		// valid size
		if ($thumbnail['size'] > 6000000 || $original['size'] > 6000000) $this->printJson($this->invalid(false, 403, "Max size 6MB!"));

		// valid pixel
		if ($thumbnail['pixel'][0] > 5000 && $thumbnail['pixel'][1] > 5000 || $original['pixel'][0] > 5000 && $original['pixel'][1] > 5000) $this->printJson($this->invalid(false, 403, "Upload JPG or PNG image. 5000 x 5000 required!"));

		// valid file exist
		if (file_exists($img['pathThumb'] . $img['filename']) || file_exists($img['pathOri'] . $img['filename']) ) $this->printJson($this->invalid(false, 403, "This image already exist!"));

		// params dataTable
		$dataTable = [
			"candidate_code"	=> $code,
			"code"				=> $this->e(strtoupper($params['number'])),
			"name"				=> $this->e(ucwords($params['name'])),
			"image"				=> $img['filename'],
			"role"				=> $this->e(strtoupper($params['as'])),
		];

		// Upload Image
		$upThumb = move_uploaded_file($thumbnail['tmp'], $img['pathThumb'] . $img['filename']);
		$upOri = move_uploaded_file($original['tmp'], $img['pathOri'] . $img['filename']);

		// Upload database
		$execute = $this->DB->insertTB("db_candidate", $dataTable);

		// valid upload image and database
		if (!$upThumb || !$upOri || !$execute) {
			// remove thumbnail
			if (file_exists($img['pathThumb'] . $img['filename'])) unlink($img['pathThumb'] . $img['filename']);
			// remove image original
			if (file_exists($img['pathOri'] . $img['filename'])) unlink($img['pathOri'] . $img['filename']);
			// remove candidate form database
			$this->DB->deltTB("db_candidate", "candidate_code", $dataTable['candidate_code']);

			$this->printJson($this->invalid(false, 403, "Add new candidate failed. Please try!"));
		}
		
		$this->printJson($this->invalid(true, 200, "Add new candidate success."));		
	}

	public function changecandidate()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter candidate number
		if (!isset($params['number']) || empty($params['number'])) $this->printJson($this->invalid(false, 403, "This candidate number cannot be empty!"));

		// Filter candidate name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This candidate name cannot be empty!"));

		// Filter candidate as name
		if (!isset($params['as']) || empty($params['as'])) $this->printJson($this->invalid(false, 403, "This candidate as name cannot be empty!"));

		// Filter candidate as name
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "This candidate code name cannot be empty!"));

		// Filter valid candidate name
		if (!$this->filterString($params['name'])) $this->printJson($this->invalid(false, 403, "Candidate name can only contain characters and spaces!"));
		
		// Get candidate
		$candidate = $this->DB->getSelectTB("db_candidate", "candidate_code", $this->e($params['code']), true);
		// Get code number campaign
		$userNumb = $this->DB->getSelectTB("db_campaign", "code", $this->e($params['number']), true);
		// Get code role campaign
		$userRole = $this->DB->getSelectTB("db_candidate_role", "code", $this->e($params['as']), true);
		// Get candidate as number and role
		$candidateDetails = $this->DB->costumeDB("
			SELECT user.name
			FROM db_candidate AS user
			INNER JOIN db_campaign AS numb ON numb.code = user.code
			INNER JOIN db_candidate_role AS role ON role.code = user.role
			WHERE user.code ='". $this->e($params['number']) ."' 
			AND user.role='". $this->e($params['as']) ."'
			AND NOT user.candidate_code='". $this->e($params['code']) ."'
			", true);

		// valid code number campaign
		if (!$userNumb) $this->printJson($this->invalid(false, 403, "Candidate number isn't registered!"));

		// valid code number campaign
		if (!$userRole) $this->printJson($this->invalid(false, 403, "As candidate isn't registered!"));

		// valid Candidate code
		if (!$candidate) $this->printJson($this->invalid(false, 403, "This candidate isn't registered!"));

		// Valid already candidate
		if ($candidateDetails) $this->printJson($this->invalid(false, 403, "This candidate already exist!"));

		// params dataTable
		$dataTable = [
			"code" => strtoupper($params['number']),
			"name" => ucwords($params['name']),
			"image" => $candidate['image'],
			"role" => strtoupper($params['as']),
		];

		// Change avatar True or false
		if (isset($params['on-image']) && $params['on-image'] == true) {
			// Filter image original avatar candidate
			if (!isset($_FILES['original-avatar']) || empty($_FILES['original-avatar'])) $this->printJson($this->invalid(false, 403, "This original avatar cannot be empty!"));

			// Filter image avatar candidate
			if (!isset($_FILES['avatar']) || empty($_FILES['avatar'])) $this->printJson($this->invalid(false, 403, "This avatar cannot be empty!"));

			// Valid original avatar candidate
			$filterImg = $this->filterImg($_FILES['original-avatar']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Valid avatar candidate
			$filterImg = $this->filterImg($_FILES['avatar']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Random file name
			$randFilename = $this->randString(50);

			// extract avatar file
			$thumbnail = [
				'size'		=> trim($_FILES['avatar']['size']),
				'tmp'		=> trim($_FILES['avatar']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['avatar']['tmp_name']),
				'error'		=> trim($_FILES['avatar']['error']),
				'extension'	=> explode(".", trim($_FILES['avatar']['name'])),
			];

			// extract original avatar file
			$original = [
				'size'		=> trim($_FILES['original-avatar']['size']),
				'tmp'		=> trim($_FILES['original-avatar']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['original-avatar']['tmp_name']),
				'error'		=> trim($_FILES['original-avatar']['error']),
				'extension'	=> explode(".", trim($_FILES['original-avatar']['name'])),
			];

			// image params
			$img = [
				'filename'	=> $randFilename.".".end($original['extension']),
				'pathThumb'	=> "assets/img/candidate/thumbnail/",
				'pathOri'	=> "assets/img/candidate/original/",
			];

			// valid extension
			if (end($thumbnail['extension']) == 'svg' || end($original['extension']) == 'svg') $this->printJson($this->invalid(false, 403, "The file must be an image!"));

			// valid size
			if ($thumbnail['size'] > 6000000 || $original['size'] > 6000000) $this->printJson($this->invalid(false, 403, "Max size 6MB!"));

			// valid pixel
			if ($thumbnail['pixel'][0] > 5000 && $thumbnail['pixel'][1] > 5000 || $original['pixel'][0] > 5000 && $original['pixel'][1] > 5000) $this->printJson($this->invalid(false, 403, "Upload JPG or PNG image. 5000 x 5000 required!"));

			// Upload Image
			$upThumb = move_uploaded_file($thumbnail['tmp'], $img['pathThumb'] . $img['filename']);
			$upOri = move_uploaded_file($original['tmp'], $img['pathOri'] . $img['filename']);

			// valid upload image
			if (!$upThumb || !$upOri) {
				// remove thumbnail
				if (file_exists($img['pathThumb'] . $img['filename'])) unlink($img['pathThumb'] . $img['filename']);
				// remove image original
				if (file_exists($img['pathOri'] . $img['filename'])) unlink($img['pathOri'] . $img['filename']);
			}

			// Remove thumbnail avatar
			if (file_exists($img['pathThumb'] . $candidate['image'])) unlink($img['pathThumb'] . $candidate['image']);
			// Remove original avatar
			if (file_exists($img['pathOri'] . $candidate['image'])) unlink($img['pathOri'] . $candidate['image']);

			$dataTable['image'] = $img['filename'];
		}

		// Update database
		$execute = $this->DB->updateTB("db_candidate", $dataTable, "candidate_code", $this->e($params['code']));

		// valid Update database
		if (!$execute) $this->printJson($this->invalid(false, 403, "Change candidate failed. Please try!"));
		
		$this->printJson($this->invalid(true, 200, "Change candidate success."));	
	}

	public function deletecandidate()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter Role
		if (!isset($params['role']) || empty($params['role'])) $this->printJson($this->invalid(false, 403, "This code candidate cannot be empty!"));

		// get candidate
		$candidate = $this->DB->getSelectTB("db_candidate", "candidate_code", $this->e($params['role']), true);

		if (!$candidate) $this->printJson($this->invalid(false, 403, "This candidate cannot be empty!"));

		if ($candidate['image'] !== "default.jpg") {
			$pathImage = [
				'pathThumb'	=> "assets/img/candidate/thumbnail/",
				'pathOri'	=> "assets/img/candidate/original/",

			];

			// delete image thumbnail
			if (file_exists($pathImage['pathThumb'] . $candidate['image'])) unlink($pathImage['pathThumb'] . $candidate['image']);

			// delete image original
			if (file_exists($pathImage['pathOri'] . $candidate['image'])) unlink($pathImage['pathOri'] . $candidate['image']);
		}

		// Delete datatable
		$delt = $this->DB->deltTB("db_candidate", "candidate_code", $this->e(strtoupper($params['role'])));

		// Filter delete datatable
		if (!$delt) $this->printJson($this->invalid(false, 403, "Delete candidate failed. Please try!"));

		// delete role success
		$this->printJson($this->invalid(true, 200, "Delete candidate success."));
	}

	public function resetvotes()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJSON($this->invalid());

		// get request
		$params = $this->Request->get();

		// valid parameter
		if (!$params) $this->printJson($this->invalid(false, 403, "Access denied!"));

		// Filter reset
		if (!isset($params['reset']) || empty($params['reset'])) $this->printJson($this->invalid(false, 403, "This code cannot be empty!"));
		// Filter reset
		if (strlen($this->e($params['reset'])) !== 1) $this->printJson($this->invalid(false, 403, "invalid reset data!"));

		// update table
		$execute = $this->DB->costumeDB("UPDATE db_users SET status='0'");
		$execute = $this->DB->resetTB("db_votings");

		// valid update table
		// if (!$execute) $this->printJson($this->invalid(false, 403, "Reset votes failed. Please Try!"));

		$this->printJson($this->invalid(true, 200, "Reset votes success."));
	}
}