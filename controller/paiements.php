<?php
	$query = "
		SELECT 
			p.*,
			eleves.*,
			c_cat.param_description AS classe_cat,
			me.param_description AS mention,
			c.param_description classe,
			t.param_id, t.param_description AS type,
			m.param_id, m.param_description AS mode
		FROM paiements AS p
		JOIN eleves ON eleves.eleve_id=p.paiement_eleve_fk
		JOIN param_divers AS c ON c.param_id=eleves.eleve_classe_param_fk
		LEFT JOIN param_divers AS c_cat ON eleves.eleve_classe_cat_param_fk=c_cat.param_id
		LEFT JOIN param_divers AS me ON eleves.eleve_classe_mention_param_fk=me.param_id
		LEFT JOIN param_divers AS s ON eleves.eleve_classe_session_param_fk=s.param_id
		JOIN param_divers AS t ON t.param_id=p.paiement_type_paiement_param_fk
		JOIN param_divers AS m ON m.param_id=p.paiement_mode_paiement_param_fk
		WHERE 1
	";
	/***********************************************/
	//		AJAX LISTE DE TOUT LES PAIEMENTS
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		if (isset($_GET['type_recherche'])) {
			$type_recherche = $_GET['type_recherche'];
			if ($type_recherche == 'deperdition') {
				$query .= " AND p.paiement_montant!=p.paiement_total";
			} else if ($type_recherche == 'payer') {
				$query .= " AND p.paiement_montant=p.paiement_total";
			}
		}

		if (isset($_GET['date_du']) && isset($_GET['date_au'])) {
			$date_du = $_GET['date_du'];
			$date_au = $_GET['date_au'];
			if ($date_du != '' || $date_au != '') {
				$query .= " AND p.paiement_date_depot BETWEEN '$date_du' AND '$date_au'";
			}
		}

		$data = $db->get_query($query);
		header('Content-type: application/json');
		echo ('{"data":'. json_encode($data) .'}');
		exit();
	}
	/***********************************************/
	//				EXPORT EN PDF
	/***********************************************/
	if (isset($_GET['pdf']) && $_GET['pdf'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		require_once '../vendor/autoload.php';
		is_login($base_url);
		$db = new database();
		if (isset($_GET['type_recherche'])) {
			$type_recherche = $_GET['type_recherche'];
			if ($type_recherche == 'deperdition') {
				$query .= " AND p.paiement_montant!=p.paiement_total";
			} else if ($type_recherche == 'payer') {
				$query .= " AND p.paiement_montant=p.paiement_total";
			}
		}
		if (isset($_GET['date_du']) && isset($_GET['date_au'])) {
			$date_du = $_GET['date_du'];
			$date_au = $_GET['date_au'];
			if ($date_du != '' || $date_au != '') {
				$query .= " AND p.paiement_date_depot BETWEEN '$date_du' AND '$date_au'";
			}
		}
		$data = $db->get_query($query);
		setlocale(LC_TIME, "fr_FR");
		$content = "";
		$mt_total_total = 0;
		$mt_total_payer = 0;
		$header = "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Reçu</title><style>table {font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #f2f2f2;}</style></head><body><div align='left'><img src='". $base_url ."/dist/img/aceem.png' width='100' height='100'></div><table style='width:100%'><tr><th>Date de dépôt</th><th>Total</th><th>Payer</th><th>Reste</th><th>Type</th><th>Mode</th><th>Matricule</th><th>Nom et prénom</th><th>Classe</th></tr><tr>";
		foreach ($data as $i => $value) {
			$classe = $value['classe'];
			$classe .= $value['classe_cat'] ? ' ' . $value['classe_cat'] : '';
			$classe .= $value['mention'] ? ' ' . $value['mention'] : '';
			$date_depot = strftime("%d / %M / %Y", strtotime($value['paiement_date_depot']));
			$mt_total_total += $value['paiement_total'];
			$mt_total_payer += $value['paiement_montant'];
			$content .= "
				<tr>
					<td>" . $date_depot . "</td>
					<td>" . $value['paiement_total'] . " Ar</td>
					<td>" . $value['paiement_montant'] . " Ar</td>
					<td>" . ($value['paiement_total'] - $value['paiement_montant']) . " Ar</td>
					<td>" . $value['type'] . "</td>
					<td>" . $value['mode'] . "</td>
					<td>" . $value['eleve_matricule'] . "</td>
					<td>" . $value['eleve_nom'] . " ". $value['eleve_prenom'] ."</td>
					<td>". $classe ."</td>
				</tr>
			";
		}
		$content .= "
				<tr>
					<td></td>
					<td>" . $mt_total_total . " Ar</td>
					<td>" . $mt_total_payer . " Ar</td>
					<td>" . ($mt_total_total - $mt_total_payer) . " Ar</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			";
		$footer = "</tr></table><footer><div align='center'>Antananarivo le , </div></footer></body></html>";
		$html = $header . $content . $footer;
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output('liste_paiement.pdf', 'I');
		exit();
	}

	/***********************************************/
	//		AJAX SUPRESSION DU PAIEMENT
	/***********************************************/
	if (isset($_GET['delete'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		if ($db->delete('paiements', ['paiement_id' => $_GET['delete']])) {
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

	$page_title = "Paiements";
	$db = new database();

	$data_paiement = null;
	if (isset($_GET['id'])) {
		$data_paiement = (object) $db->get_query( $query . ' AND paiement_id=' . $_GET['id'])[0];
	}

	$all_eleves = $db->get_query('select eleve_id, eleve_matricule from eleves');
	$all_types = $db->get_query("select param_id, param_description from param_divers where param_table='type_paiement'"); 
	$all_modes = $db->get_query("select param_id, param_description from param_divers where param_table='mode_paiement'");
	$all_classe = $db->get_query("select * from param_divers where param_table='classe'");
	$all_classe_cat = $db->get_query("select * from param_divers where param_table='categorie_classe'");
	$all_mention = $db->get_query("select * from param_divers where param_table='mention'");
	$all_session = $db->get_query("select * from param_divers where param_table='categorie_session'");
	$all_status = $db->get_query("select * from param_divers where param_table='status_paiement'");
	$status_complet_id = $db->get_query("select param_id from param_divers where param_sigle='paiement_complet'")[0]['param_id'];
	$changement_classe_id = $db->get_query("select param_id from param_divers where param_sigle='changement_de_classe'")[0]['param_id'];

	// AU SUBMIT DU FORMULAIRE
	unset($_SESSION['error']);
	if (isset($_POST['submit_paiement'])) {
		$matricule = array_key_exists('matricule', $_POST) ? $_POST['matricule'] : null;
		$montant = array_key_exists('montant', $_POST) ? $_POST['montant'] : null;
		$type_paiement = array_key_exists('type_paiement', $_POST) ? $_POST['type_paiement'] : null;
		$mode_paiement = array_key_exists('mode_paiement', $_POST) ? $_POST['mode_paiement'] : null;
		$description = array_key_exists('description', $_POST) ? $_POST['description'] : null;
		$classe = array_key_exists('classe', $_POST) ? $_POST['classe'] : null;
		$classe_categorie = array_key_exists('classe_categorie', $_POST) ? $_POST['classe_categorie'] : null;
		$classe_mention = array_key_exists('classe_mention', $_POST) ? $_POST['classe_mention'] : null;
		$montant_total = array_key_exists('montant_total', $_POST) ? $_POST['montant_total'] : null;
		$montant_payer = array_key_exists('montant_payer', $_POST) ? $_POST['montant_payer'] : null;
		$status_paiement = array_key_exists('status_paiement', $_POST) ? $_POST['status_paiement'] : null;
		$eleve_id = '';

		foreach ($all_eleves as $i => $eleve) {
			if ($matricule == $eleve['eleve_matricule']) {
				$eleve_id = $eleve['eleve_id'];
			}
		}

		if ($eleve_id == '') {
			$_SESSION['error']['error_matricule'] = "Aucun élève n'a ce n° matricule.";
		}

		if ($status_complet_id == $status_paiement) {
			if ((int) $montant == 0) {
				$_SESSION['error']['error_montant'] = "Veuillez insérer la montant du paiement.";
			}
		} else {
			if ((int) $montant_total == 0) {
				$_SESSION['error']['error_montant_total'] = "Veuillez insérer la montant total du paiement.";
			}
			if ((int) $montant_payer == 0) {
				$_SESSION['error']['error_montant_payer'] = "Veuillez insérer la montant du paiement.";
			}
		}

		$data = [
			'paiement_id' => '',
			'paiement_montant' => $montant,
			'paiement_total' => $montant,
			'paiement_eleve_fk' => $eleve_id,
			'paiement_status_param_fk' => $status_paiement,
			'paiement_type_paiement_param_fk' => $type_paiement,
			'paiement_mode_paiement_param_fk' => $mode_paiement
		];

		if ($status_complet_id != $status_paiement) {
			$data['paiement_montant'] = $montant_payer;
			$data['paiement_total'] = $montant_total;
		}
		
		$data_paiement = (object) $data;
		$data_paiement->eleve_matricule = $matricule;
		$data_paiement->paiement_commentaire = $description;
		$data_paiement->paiement_status_param_fk = $status_paiement;
		
		if (!array_key_exists('error', $_SESSION)) {

			if ($type_paiement == $changement_classe_id) {
				$data_eleve = [
					'eleve_classe_param_fk' => $classe,
					'eleve_classe_cat_param_fk' => $classe_categorie,
					'eleve_classe_mention_param_fk' => $classe_mention
				];
				$db->update('eleves', $data_eleve, ['eleve_id' => $eleve_id]);
			}

			// CREATION
			if (empty($_POST['id'])) {
				$data['paiement_date_depot'] = date("Y-m-d H:i:s");
				if ($db->insert('paiements', $data)) {
					header('location: ./');
				}
			} else { // MODIFICATION
				$data['paiement_id'] = $_POST['id'];
				if ($db->update('paiements', $data, ['paiement_id' => $_POST['id']])) {
					header('location: ./');
				}
			}
		}
	}
