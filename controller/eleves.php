<?php
	include "config/database.php";
	$page_title = "Liste des élèves";
	$db = new database();
	
	$list_eleve = $db->get_query('select * from utilisateurs');