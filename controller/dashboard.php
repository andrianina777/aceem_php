<?php
	require_once '../../config/default.php';
  	require_once '../../helpers/auth.php';
	/**********************************/
	//		CHECK IF USER IS LOG IN
	is_login($base_url);
	/**********************************/
	require_once '../../config/database.php';

	$page_title = "Tableau de bord";
	$db = new database();
	$in_years = $db->get_query("SELECT SUM(paiement_montant) AS in_years FROM paiements WHERE YEAR(paiement_date_depot)=". date('Y'))[0]['in_years'];
	$in_mounth = $db->get_query("SELECT SUM(paiement_montant) AS in_mounth FROM paiements WHERE MONTH(paiement_date_depot)=". date('n'))[0]['in_mounth'];
	$in_day = $db->get_query("
		SELECT SUM(paiement_montant) AS in_day 
		FROM paiements 
		WHERE paiement_date_depot>= NOW() - INTERVAL 1 DAY
	")[0]['in_day'];
	$deperdition = $db->get_query("SELECT SUM(paiement_total-paiement_montant) AS deperdition FROM paiements")[0]['deperdition'];
	$in_years = format_money($in_years);
	$in_mounth = format_money($in_mounth);
	$in_day = format_money($in_day);
	$deperdition = format_money($deperdition);
