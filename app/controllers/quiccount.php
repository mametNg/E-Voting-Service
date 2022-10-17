<?php

/**
* 
*/
use Controller\Controller;

class quiccount extends Controller
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
		
		$data = [
			"header"		=> $this->Menu->header(),
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
			, 'code'),
			"votes"			=> $this->DB->costumeDB("
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
		$data['header']['title'] .= " - Quic Count";
		$data['header']['desc'] = "Live Quic Count";

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

		$this->view("templates/home/header", $data);
		$this->view("home/quiccount", $data);
		$this->view("templates/home/footer", $data);
	}
}