<?php
	require_once '../../config/default.php';
  	require_once '../../helpers/auth.php';
	/**********************************/
	//		CHECK IF USER IS LOG IN
	is_login($base_url);
	/**********************************/

	require_once '../../config/database.php';

	$page_title = "Liste des classes";
	$db = new database();
	
	$list_eleve = $db->get_query('select * from utilisateurs');