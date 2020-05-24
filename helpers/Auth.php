<?php
	session_start();
	function is_privileged($menu) {
		$db = new database();
		$uid = array_key_exists('uid', $_SESSION) ? $_SESSION['uid'] : -1;
		$query = "
			SELECT p.privilege_is_active
			FROM privileges AS p
			JOIN menus AS m ON m.menu_id=p.privilege_menu_fk
			JOIN groupes AS g ON g.groupe_id=p.privilege_groupe_fk
			JOIN utilisateurs AS u ON u.utilisateur_groupe_fk=g.groupe_id
			WHERE u.utilisateur_id=$uid AND m.menu_nom='$menu'
		";
		$user = $db->get_query($query);
		if (empty($user)) {
			unset($_SESSION['uid']);
			unset($_SESSION['pseudo']);
		}
		$result = $user[0]['privilege_is_active'];
		return $result == 1;
	}

	function get_user() {
		$db = new database();

		$uid = array_key_exists('uid', $_SESSION) ? $_SESSION['uid'] : -1;
		$user = $db->get_query("select * from utilisateurs where utilisateur_id=$uid");
		if (sizeof($user) > 0) {
			return (object) $user[0];
		} else {
			return false;
		}
	}

	function is_login($base_url) {
		if (array_key_exists('uid', $_SESSION)) {
			return true;
		} else {
			header("location: $base_url/pages/login");
			exit();
		}
	}
	
	function add_history($description) {
		$db = new database();
		$data = [
			'historique_id' => '',
			'historique_description' => $description,
			'historique_utilisateur' => $_SESSION['pseudo']
		];
		$db->insert('historiques', $data);
	}

	function format_money($number) {
		return number_format($number, 0, ',', ' '). " Ar";
	}