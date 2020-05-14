<?php
	/***********************************************/
	//		AJAX LISTE DE TOUT LES UTILISATEURS
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		$data = $db->get_query('select * from utilisateurs');
		header('Content-type: application/json');
		echo ('{"data":'. json_encode($data) .'}');
		exit();
	}


	/***********************************************/
	//		AJAX SUPRESSION D'UN UTILISATEUR
	/***********************************************/
	if (isset($_GET['delete'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);

		$db = new database();

		if ($db->delete('utilisateurs', ['utilisateur_id' => $_GET['delete']])) {
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

	$page_title = "Utilisateurs";
	$db = new database();

	$data_user = null;
	if (isset($_GET['id'])) {
		$data_user = (object) $db->get_query('select * from utilisateurs where utilisateur_id='. $_GET['id'])[0];
	}

	$all_group = $db->get_query('select * from groupes');

	// AU SUBMIT DU FORMULAIRE
	if (isset($_POST['submit_user'])) {
		$nom = array_key_exists('nom', $_POST) ? $_POST['nom'] : null;
		$pseudo = array_key_exists('pseudo', $_POST) ? $_POST['pseudo'] : null;
		$email = array_key_exists('email', $_POST) ? $_POST['email'] : null;
		$groupe = array_key_exists('groupe', $_POST) ? $_POST['groupe'] : null;
		$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;

		if ($nom && $pseudo && $email && $password) {
			$data = [
				'utilisateur_id' => '',
				'utilisateur_nom' => $nom,
				'utilisateur_pseudo' => $pseudo,
				'utilisateur_email' => $email,
				'utilisateur_groupe_fk' => $groupe,
				'utilisateur_password' => md5($token_key_start . $password . $token_key_end),
			];

			// CREATION
			if (empty($_POST['id'])) {
				if ($db->insert('utilisateurs', $data)) {
					header('location: ./');
				}
			} else { // MODIFICATION
				$data['utilisateur_id'] = $_POST['id'];
				if ($db->update('utilisateurs', $data, ['utilisateur_id' => $_POST['id']])) {
					header('location: ./');
				}
			}
		}
	}
