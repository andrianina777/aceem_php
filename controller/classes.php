<?php
	require_once '../../config/database.php';
	require_once '../../config/default.php';
	$page_title = "Liste des classes";
	$db = new database();
	
	$list_eleve = $db->get_query('select * from utilisateurs');