<?php

/**
* 
*/
use Controller\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

		if ($this->e($method) == "since") {
			$data['since'] = $this->DB->getAllTB("db_sinces");
			$data['header']['title'] = "User Management - since";
			$open = "panel/user-management/since";
		}

		if ($this->e($method) == "major") {
			$data['major'] = $this->DB->getAllTB("db_major");
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
				role.name AS role,
				since.name AS since
				FROM db_class AS class
				INNER JOIN db_major AS major ON major.code = class.code
				INNER JOIN db_roles AS role ON role.code = class.role
				INNER JOIN db_sinces AS since ON since.code = class.since
			");
			$data['role'] = $this->DB->getAllTB("db_roles");
			$data['major'] = $this->DB->getAllTB("db_major");
			$data['since'] = $this->DB->costumeDB("SELECT * FROM db_sinces ORDER BY name ASC");
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
				sclass.name AS class,
				since.name AS since
				FROM db_users AS user
				INNER JOIN db_class AS sclass ON sclass.class_code = user.class
				INNER JOIN db_roles AS role ON role.code = sclass.role
				INNER JOIN db_sinces AS since ON since.code = sclass.since
				ORDER BY role.name, user.class, user.name ASC
			");
			$data['header']['title'] = "User Management - Users";
			$data['role'] = $this->DB->getAllTB("db_roles");
			$data['since'] = $this->DB->getAllTB("db_sinces");
			$data['class'] = $this->DB->costumeDB("
				SELECT DISTINCT
				sclass.role AS role_code,
				role.name AS role,
				sclass.class_code AS class_code,
				sclass.name AS class
				FROM db_class AS sclass
				INNER JOIN db_roles AS role ON role.code = sclass.role
				ORDER BY sclass.role, sclass.name ASC
			");
			$data['class_count'] = $this->DB->costumeDB("
				SELECT
				class.name AS name,
				class.class_code AS code,
				COUNT(user.class) AS total
				FROM db_users AS user
				INNER JOIN db_class AS class
				ON user.class = class.class_code
				INNER JOIN db_sinces AS since
				ON class.since = since.code
				GROUP BY class.name, user.class
				ORDER BY since.name ASC
			");
		}


		$this->view("templates/panel/header",$data);
		$this->view("templates/panel/topbar",$data);
		$this->view("templates/panel/sidebar",$data);
		$this->view($open,$data);
		$this->view("templates/panel/footer",$data);
	}

	public function report($method=false, $type=false, $params=false)
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/panel/login'));

		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->DB->getSelectTB("db_admins", "email", $this->e($_SESSION['email']), true),
			"active"	=> "report",
		];

		$data['header']['title'] = "Panel - Report";
		$data['header']['desc'] = "Panel Dashboard";

		// Default Open
		$open = "panel/report";

		// USER REPORT
		if ($this->e($method) == "users") {
			// ALL USER REPORT
			if ($this->e(strtolower($type)) == "all-users") {
				$data['header']['title'] = "Report - All Users";
				$data['users'] = $this->DB->costumeDB("
					SELECT
					user.nim AS nim,
					user.name AS name,
					class.name AS class
					FROM db_users AS user
					INNER JOIN db_class AS class
					ON class.class_code = user.class
					INNER JOIN db_roles AS role
					ON class.role = role.code
					INNER JOIN db_sinces AS since
					ON since.code = class.since
					ORDER BY since.name, class.name, user.name ASC
				");

				if ($data['users']) {

					if (isset($_POST['export']) && $this->e(strtolower($_POST['export'])) == "excel") {

						ob_start();

						$filename = "Report All Users";

						$spreadsheet = new Spreadsheet();
						$spreadsheet->getProperties()->setCreator("Mamet Nugraha")->setLastModifiedBy("Mamet Nugraha")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
						$sheet = $spreadsheet->getActiveSheet();
						$sheet->setCellValue('A1', $filename);
						$sheet->setCellValue('A3', "  NO  ");
						$sheet->setCellValue('B3', "NIPD");
						$sheet->setCellValue('C3', "Name");
						$sheet->setCellValue('D3', "Class");
						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A4:D'.(count($data['users'])+3))->applyFromArray($styleArray);
						$spreadsheet->getActiveSheet()->mergeCells('A1:D2');
						$styleArray = [
							'borders' => [
								'outline' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D'.(count($data['users'])+3))->applyFromArray($styleArray);

						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->applyFromArray($styleArray);

						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



						for ($i=0; $i < count($data['users']); $i++) { 
							$sheet->setCellValue('A'.($i+4), ($i+1));
						}

						$arrayData = $data['users'];
						$spreadsheet->getActiveSheet()->fromArray($arrayData, NULL, 'B4');
						
						$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						

						$writer = new Xlsx($spreadsheet);

						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
						header('Cache-Control: max-age=0');

						ob_end_clean();

						$writer->save('php://output');
						die;
					}

					$open = "panel/report/users/all-users";
				}

				if (!$data['users']) {
					$type = false;
				}
			}

			// ROLE REPORT
			if ($this->e(strtolower($type)) == "role") {
				$data['header']['title'] = "Report - Users Role";
				$data['users'] = $this->DB->costumeDB("
					SELECT
					user.nim AS nim,
					user.name AS name,
					class.name AS class,
					role.name AS role
					FROM db_users AS user
					INNER JOIN db_class AS class
					ON class.class_code = user.class
					INNER JOIN db_roles AS role
					ON class.role = role.code
					INNER JOIN db_sinces AS since
					ON since.code = class.since
					WHERE class.role = '". $this->e($params) ."'
					ORDER BY since.name, class.name, user.name ASC
				");


				if ($data['users']) {

					if (isset($_POST['export']) && $this->e(strtolower($_POST['export'])) == "excel") {

						ob_start();

						$filename = strtoupper($data['users'][0]['role']);

						$spreadsheet = new Spreadsheet();
						$spreadsheet->getProperties()->setCreator("Mamet Nugraha")->setLastModifiedBy("Mamet Nugraha")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
						$sheet = $spreadsheet->getActiveSheet();
						$sheet->setCellValue('A1', $filename);
						$sheet->setCellValue('A3', "  NO  ");
						$sheet->setCellValue('B3', "NIPD");
						$sheet->setCellValue('C3', "Name");
						$sheet->setCellValue('D3', "Class");
						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A4:D'.(count($data['users'])+3))->applyFromArray($styleArray);
						$spreadsheet->getActiveSheet()->mergeCells('A1:D2');
						$styleArray = [
							'borders' => [
								'outline' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D'.(count($data['users'])+3))->applyFromArray($styleArray);

						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->applyFromArray($styleArray);

						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



						for ($i=0; $i < count($data['users']); $i++) { 
							$sheet->setCellValue('A'.($i+4), ($i+1));
							unset($data['users'][$i]['role']);
						}

						$arrayData = $data['users'];
						$spreadsheet->getActiveSheet()->fromArray($arrayData, NULL, 'B4');
						
						$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						

						$writer = new Xlsx($spreadsheet);

						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
						header('Cache-Control: max-age=0');

						ob_end_clean();

						$writer->save('php://output');
						die;
					}

					$open = "panel/report/users/role";
				}

				if (!$data['users']) {
					$type = false;
				}
			}

			// CLASS REPORT
			if ($this->e(strtolower($type)) == "class") {

				$data['header']['title'] = "Report - Users Class";
				$data['users'] = $this->DB->costumeDB("
					SELECT
					user.nim AS nim,
					user.name AS name,
					class.name AS class
					FROM db_users AS user
					INNER JOIN db_class AS class
					ON class.class_code = user.class
					WHERE class.class_code = '". $this->e($params) ."'
					ORDER BY user.name ASC
				");

				if ($data['users']) {

					// if (isset($_POST['export']) && $this->e(strtolower($_POST['export'])) == "pdf") {
					// 	echo "PDF"; die;
					// }

					if (isset($_POST['export']) && $this->e(strtolower($_POST['export'])) == "excel") {

						ob_start();

						$filename = strtoupper($data['users'][0]['class']);

						$spreadsheet = new Spreadsheet();
						$spreadsheet->getProperties()->setCreator("Mamet Nugraha")->setLastModifiedBy("Mamet Nugraha")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
						$sheet = $spreadsheet->getActiveSheet();
						$sheet->setCellValue('A1', $filename);
						$sheet->setCellValue('A3', "  NO  ");
						$sheet->setCellValue('B3', "NIPD");
						$sheet->setCellValue('C3', "Name");
						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A4:C'.(count($data['users'])+3))->applyFromArray($styleArray);
						$spreadsheet->getActiveSheet()->mergeCells('A1:C2');
						$styleArray = [
							'borders' => [
								'outline' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:C'.(count($data['users'])+3))->applyFromArray($styleArray);

						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:C3')->applyFromArray($styleArray);

						$spreadsheet->getActiveSheet()->getStyle('A1:C3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A1:C3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



						for ($i=0; $i < count($data['users']); $i++) { 
							$sheet->setCellValue('A'.($i+4), ($i+1));
							unset($data['users'][$i]['class']);
						}

						$arrayData = $data['users'];
						$spreadsheet->getActiveSheet()->fromArray($arrayData, NULL, 'B4');
						
						$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						

						$writer = new Xlsx($spreadsheet);

						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
						header('Cache-Control: max-age=0');

						ob_end_clean();

						$writer->save('php://output');
						die;
					}

					$open = "panel/report/users/class";
				}

				if (!$data['users']) {
					$type = false;
				}
			}

			// SINCE REPORT
			if ($this->e(strtolower($type)) == "since") {
				$data['header']['title'] = "Report - Users Since";
				$data['users'] = $this->DB->costumeDB("
					SELECT
					user.nim AS nim,
					user.name AS name,
					class.name AS class,
					since.name AS since
					FROM db_users AS user
					INNER JOIN db_class AS class
					ON class.class_code = user.class
					INNER JOIN db_sinces AS since
					ON since.code = class.since
					WHERE since.code = '". $this->e($params) ."'
					ORDER BY class.name, user.name ASC
				");

				if ($data['users']) {

					if (isset($_POST['export']) && $this->e(strtolower($_POST['export'])) == "excel") {

						ob_start();

						$filename = "User Since ".strtoupper($data['users'][0]['since']);

						$spreadsheet = new Spreadsheet();
						$spreadsheet->getProperties()->setCreator("Mamet Nugraha")->setLastModifiedBy("Mamet Nugraha")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
						$sheet = $spreadsheet->getActiveSheet();
						$sheet->setCellValue('A1', $filename);
						$sheet->setCellValue('A3', "  NO  ");
						$sheet->setCellValue('B3', "NIPD");
						$sheet->setCellValue('C3', "Name");
						$sheet->setCellValue('D3', "Class");
						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A4:D'.(count($data['users'])+3))->applyFromArray($styleArray);
						$spreadsheet->getActiveSheet()->mergeCells('A1:D2');
						$styleArray = [
							'borders' => [
								'outline' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D'.(count($data['users'])+3))->applyFromArray($styleArray);

						$styleArray = [
							'borders' => [
								'allBorders' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
									'color' => ['argb' => '#000'],
								],
							],
						];
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->applyFromArray($styleArray);

						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A1:D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



						for ($i=0; $i < count($data['users']); $i++) { 
							$sheet->setCellValue('A'.($i+4), ($i+1));
							unset($data['users'][$i]['since']);
						}

						$arrayData = $data['users'];
						$spreadsheet->getActiveSheet()->fromArray($arrayData, NULL, 'B4');
						
						$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						$spreadsheet->getActiveSheet()->getStyle('A4:B'.(count($data['users'])+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
						

						$writer = new Xlsx($spreadsheet);

						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
						header('Cache-Control: max-age=0');

						ob_end_clean();

						$writer->save('php://output');
						die;
					}

					$open = "panel/report/users/since";
				}

				if (!$data['users']) {
					$type = false;
				}
			}

			// DEFAULT
			if (!$this->e(strtolower($type))) {
				$data['header']['title'] = "Report - Users";
				$data['users'] = $this->DB->costumeDB("
					SELECT 
					user.nim,
					user.name,
					role.name AS role,
					sclass.name AS class,
					since.name AS since
					FROM db_users AS user
					INNER JOIN db_class AS sclass ON sclass.class_code = user.class
					INNER JOIN db_roles AS role ON role.code = sclass.role
					INNER JOIN db_sinces AS since ON since.code = sclass.since
					ORDER BY role.name, user.class, user.name ASC
					");
				$data['header']['title'] = "User Management - Users";
				$data['role'] = $this->DB->getAllTB("db_roles");
				$data['since'] = $this->DB->costumeDB("SELECT * FROM db_sinces ORDER BY name ASC");
				$data['class'] = $this->DB->costumeDB("
					SELECT 
					class.class_code AS code,
					class.name AS name
					FROM db_class AS class
					INNER JOIN db_sinces AS since ON class.since = since.code
					ORDER BY since.name ASC
					");
				$open = "panel/report/users";
			}
		}

		// VOTING REPORT
		if ($this->e($method) == "voting") {
			// DEFAULT
			if (!$this->e(strtolower($type))) {
				$data['header']['title'] = "Report - Voting";
				$data['vote'] = [
					"vote" => $this->DB->costumeDB("SELECT COUNT(status) AS total FROM db_users WHERE status=1", true),
					"notvote" => $this->DB->costumeDB("SELECT COUNT(status) AS total FROM db_users WHERE status=0", true),
					"must" => $this->DB->costumeDB("SELECT COUNT(status) AS total FROM db_users", true),
				];
				$data["candidate"] = $this->array_group(
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
					, 'code');
				$data["votes"] = $this->DB->costumeDB("
					SELECT
					campaign.code AS code,
					campaign.number AS number,
					COUNT(user.take) AS votes
					FROM db_users AS user
					INNER JOIN db_campaign AS campaign ON campaign.code = user.take
					WHERE NOT user.take = ''
					GROUP BY user.take
					");
				$data["total_user"] =  $this->DB->costumeDB("SELECT COUNT(nim) AS total FROM db_users", true);
				$data['role'] = $this->DB->getAllTB("db_roles");
				$data['since'] = $this->DB->costumeDB("SELECT * FROM db_sinces ORDER BY name ASC");
				$data['class'] = $this->DB->costumeDB("
					SELECT 
					class.class_code AS code,
					class.name AS name
					FROM db_class AS class
					INNER JOIN db_sinces AS since ON class.since = since.code
					ORDER BY since.name ASC
					");
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

				// $this->printJSON($data['vote']);
				$open = "panel/report/voting";
			}
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