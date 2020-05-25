<?php
	if (isset($_GET['logout']) && $_GET['logout']==1) {
		session_start();
		session_unset();
		session_destroy();
	}
	require_once '../../config/database.php';
	require_once '../../config/default.php';
	session_start();
	unset($_SESSION['error_loggin']);
	if (isset($_POST['connect'])) {
		$pseudo = array_key_exists('pseudo', $_POST) ? $_POST['pseudo'] : null;
		$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
		$isRemember = array_key_exists('isRemember', $_POST) ? $_POST['isRemember'] : null;
		if ($pseudo && $password) {
			$db = new database();
			$password = md5($token_key_start . $password . $token_key_end); 
			$data = $db->get_query("select utilisateur_id, utilisateur_pseudo from utilisateurs where utilisateur_pseudo='$pseudo' and utilisateur_password='$password'");
			if (sizeof($data) > 0) {
				$_SESSION['uid'] = $data[0]['utilisateur_id'];
				$_SESSION['pseudo'] = $data[0]['utilisateur_pseudo'];
				unset($_SESSION['error_loggin']);
				header('location: ../../');
			} else {
				$_SESSION['error_loggin'] = "Pseudo ou mot de passe invalide!";
			}
		}
	}