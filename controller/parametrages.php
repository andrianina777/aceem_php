<?php
	require_once '../../config/database.php';
	require_once '../../config/default.php';
	$page_title = "Paramètrages";
	$db = new database();
	
	$list_eleve = $db->get_query('select * from utilisateurs');