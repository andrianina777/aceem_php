<?php
	session_start();
	function is_privileged() {
		$db = new database();

		$uid = array_key_exists('uid', $_SESSION) ? $_SESSION['uid'] : -1;
		$user = $db->get_query("select utilisateur_id from utilisateurs where utilisateur_id=$uid");
		return sizeof($user) != 0;
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