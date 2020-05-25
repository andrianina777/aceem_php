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

		$data = $db->get_query('select * from groupes');
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

		if ($db->delete('groupes', ['groupe_id' => $_GET['delete']])) {
			add_history("Suppression groupe ". $_GET['groupe_nom']);
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

	$page_title = "Groupes";
	$db = new database();

	$data_groupe = null;
	$data_menus = [];
	if (isset($_GET['id'])) {
		$data_groupe = (object) $db->get_query('select * from groupes where groupe_id='. $_GET['id'])[0];
		$data_menus = $db->get_query('select * from privileges where privilege_groupe_fk='. $_GET['id']);
	}

	$all_menus = $db->get_query('select * from menus');

	// AU SUBMIT DU FORMULAIRE
	if (isset($_POST['submit_groupe'])) {
		$nom = array_key_exists('nom', $_POST) ? $_POST['nom'] : null;
		$description = array_key_exists('description', $_POST) ? $_POST['description'] : null;

		if ($nom && $description) {
			$data = [
				'groupe_id' => '',
				'groupe_nom' => $nom,
				'groupe_description' => $description,
			];

			// CREATION
			if (empty($_POST['id'])) {
				if ($db->insert('groupes', $data)) {
					add_history("Création groupe ". $data['groupe_nom']);
					$groupe_id = $db->lastInsertId();

					// AJOUT DES PRIVILEGES
					foreach ($all_menus as $key => $menu) {
						$menu_id = $menu['menu_id'];
						$is_active = array_key_exists("menu_$menu_id", $_POST) ? 1 : 0;
						$data_priv = [
							'privilege_id' => '',
							'privilege_menu_fk' => $menu_id,
							'privilege_groupe_fk' => $groupe_id,
							'privilege_is_active' => $is_active
						];
						$db->insert('privileges', $data_priv);
					}

					header('location: ./');
				}
			} else { // MODIFICATION
				$data['groupe_id'] = $_POST['id'];
				$db->update('groupes', $data, ['groupe_id' => $_POST['id']]);
				add_history("Modification groupe ". $data['groupe_nom']);
				// ENLEVER LES ANCIENS PRIVILEGES
				$db->delete('privileges', ['privilege_groupe_fk' => $_POST['id']]);
				// AJOUT DES PRIVILEGES
				foreach ($all_menus as $key => $menu) {
					$menu_id = $menu['menu_id'];
					$is_active = array_key_exists("menu_$menu_id", $_POST) ? 1 : 0;
					$data_priv = [
						'privilege_id' => '',
						'privilege_menu_fk' => $menu_id,
						'privilege_groupe_fk' => $_POST['id'],
						'privilege_is_active' => $is_active
					];
					$db->insert('privileges', $data_priv);
				}

				header('location: ./');
			}
		}
	}
