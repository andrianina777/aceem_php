<?php
	/***********************************************/
	//		AJAX LISTE DE TOUT LES PARAMETRAGES
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		$data = $db->get_query('select * from param_divers');
		header('Content-type: application/json');
		echo ('{"data":'. json_encode($data) .'}');
		exit();
	}


	/***********************************************/
	//		AJAX SUPRESSION DU PARAMETRE
	/***********************************************/
	if (isset($_GET['delete'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		if ($db->delete('param_divers', ['param_id' => $_GET['delete']])) {
			header('Content-type: application/json');
			echo ('{ "status": "success" }');
		} else {
			header('Content-type: application/json');
			echo ('{ "status": "error" }');
		}
		exit();
	}

	/***********************************************/
	//				ACTION PAR DEFAUT
	/***********************************************/	
	//		CHECK IF USER IS LOG IN
	require_once '../../config/default.php';
  	require_once '../../helpers/auth.php';
	/**********************************/
	//		CHECK IF USER IS LOG IN
	is_login($base_url);
	/**********************************/
	
	require_once '../../config/database.php';

	$page_title = "Paramètrages";
	$db = new database();

	$data_param = null;
	if (isset($_GET['id'])) {
		$data_param = (object) $db->get_query('select * from param_divers where param_id='. $_GET['id'])[0];
	}

	// AU SUBMIT DU FORMULAIRE
	if (isset($_POST['submit_param'])) {
		$param_table = $_POST['table'];
		$param_sigle = $_POST['sigle'];
		$param_valeur = $_POST['valeur'];
		$param_description = $_POST['description'];
		$param_ordre = $_POST['ordre'];

		$data = [
			'param_id' => '',
			'param_table' => $param_table,
			'param_sigle' => $param_sigle,
			'param_valeur' => $param_valeur,
			'param_description' => $param_description,
			'param_ordre' => $param_ordre,
		];

		// CREATION
		if (empty($_POST['id'])) {
			if ($db->insert('param_divers', $data)) {
				header('location: ./');
			}
		} else { // MODIFICATION
			$data['param_id'] = $_POST['id'];
			if ($db->update('param_divers', $data, ['param_id' => $_POST['id']])) {
				header('location: ./');
			}
		}
	}
