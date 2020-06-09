<?php
	$query = "
		SELECT 
			p.*,
			eleves.*,
			t.param_id, t.param_description AS type,
			m.param_id, m.param_description AS mode,
			s.param_description AS status
		FROM paiements AS p
		JOIN eleves ON eleves.eleve_id=p.paiement_eleve_fk
		JOIN param_divers AS t ON t.param_id=p.paiement_type_paiement_param_fk
		JOIN param_divers AS m ON m.param_id=p.paiement_mode_paiement_param_fk
		JOIN param_divers AS s ON s.param_id=p.paiement_status_param_fk
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
			switch ($type_recherche) {
				case 'deperdition':
					$query .= " AND p.paiement_montant!=p.paiement_total";
					break;
				case 'payer':
					$query .= " AND p.paiement_montant=p.paiement_total";
					break;
				case 'non_payer':
					$query = "SELECT p.*, eleves.* FROM paiements AS p RIGHT JOIN eleves ON eleves.eleve_id=p.paiement_eleve_fk WHERE 1 AND p.paiement_id IS NULL";
					break;
			}
		}

		if (isset($_GET['type_paiement']) && $_GET['type_paiement'] != -1) {
			$type_paiement = $_GET['type_paiement'];
			$query .= " AND p.paiement_type_paiement_param_fk=$type_paiement";
		}

		if (isset($_GET['date_du']) && isset($_GET['date_au'])) {
			$date_du = $_GET['date_du'];
			$date_au = $_GET['date_au'];
			if ($date_du != '' || $date_au != '') {
				$query .= " AND p.paiement_date_depot BETWEEN '$date_du' AND '$date_au'";
			}
		}

		if (isset($_GET['paiement_id'])) {
			$query .= " AND p.paiement_id=". $_GET['paiement_id'];
		}

		$data = $db->get_query($query);
		foreach ($data as $i => $paiement) {
			$q = "
				SELECT 	classes.classe_categorie AS categorie,
						c.param_description AS classe,
						m.param_description AS mention,
						s.param_description AS session
				FROM classes
				LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
				LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
				LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
				WHERE classes.classe_eleve_fk={$paiement['eleve_id']}
			";
			$classe = $db->get_query($q);
			$data[$i]['classe'] = $classe;
		}
		header('Content-type: application/json');
		echo ('{"data":'. json_encode($data) .'}');
		exit();
	}
	/***********************************************/
	//				AJAX REQUEST
	/***********************************************/
	if (isset($_GET['q'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();
		$q = $_GET['q'];
		$data = [];
		header('Content-type: application/json');
		echo json_encode($data);
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
		$titre = "ETAT GENERAL";
		
		if (isset($_GET['type_recherche'])) {
			$type_recherche = $_GET['type_recherche'];
			switch ($type_recherche) {
				case 'deperdition':
					$query .= " AND p.paiement_montant!=p.paiement_total";
					break;
				case 'payer':
					$query .= " AND p.paiement_montant=p.paiement_total";
					break;
				case 'non_payer':
					$query = "SELECT p.*, eleves.* FROM paiements AS p RIGHT JOIN eleves ON eleves.eleve_id=p.paiement_eleve_fk WHERE 1 AND p.paiement_id IS NULL";
					break;
			}
		}

		if (isset($_GET['type_paiement']) && $_GET['type_paiement'] != -1) {
			$tp = $_GET['type_paiement'];
			$query .= " AND p.paiement_type_paiement_param_fk=$tp";
			$titre = $db->get_query("SELECT param_description FROM param_divers WHERE param_id=$tp")[0]['param_description'];
		}

		if (isset($_GET['date_du']) && isset($_GET['date_au'])) {
			$date_du = $_GET['date_du'];
			$date_au = $_GET['date_au'];
			if ($date_du != '' || $date_au != '') {
				$query .= " AND p.paiement_date_depot BETWEEN '$date_du' AND '$date_au'";
			}
		}

		$data = $db->get_query($query);

		foreach ($data as $i => $paiement) {
			$q = "
				SELECT 	classes.classe_categorie AS categorie,
						c.param_description AS classe,
						m.param_description AS mention,
						s.param_description AS session
				FROM classes
				LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
				LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
				LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
				WHERE classes.classe_eleve_fk={$paiement['eleve_id']}
			";
			$classe = $db->get_query($q);
			$data[$i]['classe'] = $classe;
		}
		setlocale(LC_TIME, "fr_FR");
		$content = "";
		$mt_total_total = 0;
		$mt_total_payer = 0;
		$monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
		$header = "
			<!DOCTYPE html>
				<html>
					<head>
						<meta charset='utf-8'>
						<title>$titre</title>
						<style>
							th {
								background-color: rgba(153, 153, 153, 0.6);
							}
							td {
								padding-left: 7px;
								padding-right: 7px;
							}
							tr:nth-child(even) {
								background-color: #f2f2f2;
							}
							table{
								font-size: 10px;
								border-collapse: collapse;
							}
							table, th, td {
								border: 1px solid #555 !important;
							}
						</style>
					</head>
					<body>
						<div style='display=flex;'>
							<img style='float:left;' src='../dist/img/aceem.png' width='100' height='100'>
							<div align='center' style='font-size:20px;'> $titre</div>
						</div>
						<table style='width:100%'>
							<tr>
				
								<th>Total</th>
								<th>Payer</th>
								<th>Reste</th>
								<th>Mois</th>

							</tr>
							<tr>
		";
		foreach ($data as $i => $value) {
			$classe = '';
			foreach ($value['classe'] as $c) {
				$cl = $c['classe'];
				$categorie = $c['categorie'] == 0 ? '' : $c['categorie'];
				$mention = $c['mention'];
				$session = $c['session'];
				$classe .= "$cl $categorie $mention ($session)<br>";
			}
			$date_depot = strtotime($value['paiement_date_depot']) ? strftime("%d/%m/ %Y", strtotime($value['paiement_date_depot'])) : '-';
			$mt_total_total += $value['paiement_total'];
			$mt_total_payer += $value['paiement_montant'];
			$reste = $mt_total_total - $mt_total_payer;
			$statut = @$value['status'];
			$content .= "
				<tr>
					<td>" . @$date_depot . "</td>
					<td>" . @$value['paiement_total'] . " Ar</td>
					<td>" . @$value['paiement_montant'] . " Ar</td>
					<td>" . (@$value['paiement_total'] - @$value['paiement_montant']) . " Ar</td>
					<td>" . @$value['type'] . "</td>
					<td>" . @$value['mode'] . "</td>
					<td>" . $value['eleve_matricule'] . "</td>
					<td>" . $value['eleve_nom'] . " ". $value['eleve_prenom'] ."</td>
					<td>". @$value['paiement_nc'] ."</td>
					<td>$classe</td>
					<td>$statut</td>
				</tr>
			";
		}
		$content .= "
				<tfoot>
					<tr>
						<td></td>
						<td>$mt_total_total Ar</td>
						<td> $mt_total_payer Ar</td>
						<td>$reste Ar</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tfoot>
			";
		$nm = date('m')*1 - 1;
		$m = $monthNames[$nm];
		$footer = "
		</table>
		<footer>
			<br>
			<div align='right'>Antananarivo le , ".date("d") ." $m ". date('Y') ." </div>
		</footer>
		</body>
		</html>";
		$html = $header . $content . $footer;
		// die($html);
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output('liste_paiement.pdf', 'I');
		$mpdf->Close();
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

	$page_title = "Etat Général";
	$db = new database();

	$data_paiement = null;
	if (isset($_GET['id'])) {
		$data_paiement = (object) $db->get_query( $query . ' AND paiement_id=' . $_GET['id'])[0];
	}

	$all_eleves = $db->get_query("SELECT eleve_id, eleve_nom, eleve_prenom FROM eleves");
	$all_types = $db->get_query("SELECT param_id, param_description FROM param_divers WHERE param_table='type_paiement'"); 
	$all_modes = $db->get_query("SELECT param_id, param_description FROM param_divers WHERE param_table='mode_paiement'");
	$all_status = $db->get_query("SELECT * FROM param_divers WHERE param_table='status_paiement'");
	$status_complet_id = $db->get_query("SELECT param_id FROM param_divers WHERE param_sigle='paiement_complet'")[0]['param_id'];
	$status_dpcomplet_id = $db->get_query("SELECT param_id FROM param_divers WHERE param_sigle='paiement_dpcomplet'")[0]['param_id'];
	$all_paiement_par = $db->get_query("SELECT param_id, param_description FROM param_divers WHERE param_table='paiement_par'");
	$paiement_tranche_id = $db->get_query("SELECT param_id FROM param_divers WHERE param_sigle='tranche'")[0]['param_id'];
	$last_recu = $db->get_query("SELECT MAX(p.paiement_numero_recu) AS last_recu FROM paiements AS p")[0]['last_recu'];

	// AU SUBMIT DU FORMULAIRE
	unset($_SESSION['error']);
	if (isset($_POST['submit_paiement'])) {
		$matricule = array_key_exists('matricule', $_POST) ? $_POST['matricule'] : null;
		$montant = array_key_exists('montant', $_POST) ? $_POST['montant'] : null;
		$type_paiement = array_key_exists('type_paiement', $_POST) ? $_POST['type_paiement'] : null;
		$mode_paiement = array_key_exists('mode_paiement', $_POST) ? $_POST['mode_paiement'] : null;
		$description = array_key_exists('commentaire', $_POST) ? $_POST['commentaire'] : null;
		$montant_total = array_key_exists('montant_total', $_POST) ? $_POST['montant_total'] : null;
		$montant_payer = array_key_exists('montant_payer', $_POST) ? $_POST['montant_payer'] : null;
		$paiement_par = array_key_exists('paiement_par', $_POST) ? $_POST['paiement_par'] : null;
		$status_paiement = array_key_exists('status_paiement', $_POST) ? $_POST['status_paiement'] : null;
		$numero_recu = array_key_exists('numero_recu', $_POST) ? $_POST['numero_recu'] : null;
		$date_recu = array_key_exists('date_recu', $_POST) ? $_POST['date_recu'] : null;
		$nom_eleve = array_key_exists('nom_eleve', $_POST) ? $_POST['nom_eleve'] : null;
		$num_tranche = array_key_exists('num_tranche', $_POST) ? $_POST['num_tranche'] : null;
		$mois = array_key_exists('mois', $_POST) ? $_POST['mois'] : null;
		$eleve_id = '';

		foreach ($all_eleves as $i => $eleve) {
			if ($nom_eleve == $eleve['eleve_nom']." ". $eleve['eleve_prenom']) {
				$eleve_id = $eleve['eleve_id'];
			}
		}

		if ($date_recu == '') {
			$_SESSION['error']['error_date_recu'] = "Ce champs est obligatoire.";
		}

		if ($eleve_id == '') {
			$_SESSION['error']['error_nom_eleve'] = "Cette élève n'existe pas.";
		}

		if ((int) $numero_recu == 0) {
			$_SESSION['error']['error_numero_recu'] = "Veuillez insérer nombre.";
		}
		if ($status_complet_id == $status_paiement || $status_dpcomplet_id == $status_paiement) {
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
			'paiement_num_tranche' => $num_tranche,
			'paiement_mois' => $mois,
			'paiement_eleve_fk' => $eleve_id,
			'paiement_status_param_fk' => $status_paiement,
			'paiement_par_param_fk' => $status_paiement,
			'paiement_numero_recu' => $numero_recu,
			'paiement_date_recu' => $date_recu,
			'paiement_type_paiement_param_fk' => $type_paiement,
			'paiement_mode_paiement_param_fk' => $mode_paiement
		];

		if ($status_complet_id != $status_paiement && $status_dpcomplet_id != $status_paiement) {
			$data['paiement_montant'] = $montant_payer;
			$data['paiement_total'] = $montant_total;
		}
		
		$data_paiement = (object) $data;
		$data_paiement->eleve_matricule = $matricule;
		$data_paiement->paiement_commentaire = $description;
		$data_paiement->paiement_status_param_fk = $status_paiement;
		
		if (!array_key_exists('error', $_SESSION)) {
			// CREATION
			if (empty($_POST['id'])) {
				$data['paiement_date_depot'] = date("Y-m-d H:i:s");
				if ($db->insert('paiements', $data)) {
					add_history("Création paiement de ". $data['paiement_montant']);
					header('location: ./');
				}
			} else { // MODIFICATION
				$data['paiement_id'] = $_POST['id'];
				$db->update('paiements', $data, ['paiement_id' => $_POST['id']]);
				header('location: ./');
			}
		}
	}
