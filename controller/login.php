<?php
	require_once '../../config/database.php';
	require_once '../../config/default.php';

	if (isset($_POST['connect'])) {
		$pseudo = array_key_exists('pseudo', $_POST) ? $_POST['pseudo'] : null;
		$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
		$isRemember = array_key_exists('isRemember', $_POST) ? $_POST['isRemember'] : null;

		if ($pseudo && $password) {
			$db = new database();
			$data = $db->get_query("select utilisateur_id, utilisateur_pseudo from utilisateurs where utilisateur_pseudo='$pseudo' and utilisateur_password='$password'");
			if (sizeof($data) > 0) {
				session_start();
				$_SESSION['uid'] = $data[0]['utilisateur_id'];
				$_SESSION['pseudo'] = $data[0]['utilisateur_pseudo'];
				header('location: ../eleves');
			} else {
				header('location: ./');
			}
		}
	}