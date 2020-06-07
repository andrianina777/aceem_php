<?php
	$query = "SELECT e.* FROM eleves AS e";
	/***********************************************/
	//		AJAX LISTE DE TOUT LES ELEVES
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();
		if (isset($_GET['type_recherche'])) {
			switch ($_GET['type_recherche']) {
				case 'AVEC_DOUBLON':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)>1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
				break;
				case 'SANS_DOUBLON':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)=1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
					break;
			}	
		}

		if (isset($_GET['filtrer_par']) && isset($_GET['param'])) {
			switch ($_GET['filtrer_par']) {
				case 'CLASSE':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_param_fk WHERE c.classe_param_fk=" . $_GET['param'];
					break;
				case 'SESSION':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_session_param_fk WHERE c.classe_session_param_fk=" . $_GET['param'];
					break;
				case 'MENTION':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_mention_param_fk WHERE c.classe_mention_param_fk=" . $_GET['param'];
					break;
				case 'NC':
					$query = "SELECT e.* FROM eleves AS e WHERE e.eleve_nc='" . $_GET['param'] . "'";
					break;
			}
		}

		$data = $db->get_query($query);
		foreach ($data as $i => $eleve) {
			$q = "
				SELECT  classes.classe_categorie AS categorie,
						c.param_description AS classe,
						m.param_description AS mention,
						s.param_description AS session
				FROM classes
				LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
				LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
				LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
				WHERE classes.classe_eleve_fk={$eleve['eleve_id']}
			";

			$classe = $db->get_query($q);
			$data[$i]['classe'] = $classe;
		}
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
		$titre = "ELEVES";
		is_login($base_url);
		$db = new database();
		if (isset($_GET['type_recherche'])) {
			switch ($_GET['type_recherche']) {
				case 'AVEC_DOUBLON':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)>1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
				break;
				case 'SANS_DOUBLON':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)=1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
					break;
			}	
		}

		if (isset($_GET['filtrer_par']) && isset($_GET['param'])) {
			switch ($_GET['filtrer_par']) {
				case 'CLASSE':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_param_fk WHERE c.classe_param_fk=" . $_GET['param'];
					$c = $db->get_query("SELECT param_description AS classe FROM param_divers WHERE param_id=" . $_GET['param'])[0]['classe'];
					$titre = "ELEVES EN CLASSE $c";
					break;
				case 'SESSION':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_session_param_fk WHERE c.classe_session_param_fk=" . $_GET['param'];
					$c = $db->get_query("SELECT param_description AS session FROM param_divers WHERE param_id=" . $_GET['param'])[0]['session'];
					$titre = "ELEVES SESSION $c";
					break;
				case 'MENTION':
					$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk INNER JOIN param_divers AS p ON p.param_id=c.classe_mention_param_fk WHERE c.classe_mention_param_fk=" . $_GET['param'];
					$c = $db->get_query("SELECT param_description AS mention FROM param_divers WHERE param_id=" . $_GET['param'])[0]['mention'];
					$titre = "ELEVES MENTION $c";
					break;
				case 'NC':
					$query = "SELECT e.* FROM eleves AS e WHERE e.eleve_nc='" . $_GET['param'] . "'";
					$titre = "ELEVES NC " . $_GET['param'];
					break;
			}
		}

		$data = $db->get_query($query);
		foreach ($data as $i => $eleve) {
			$q = "
				SELECT  classes.classe_categorie AS categorie,
						c.param_description AS classe,
						m.param_description AS mention,
						s.param_description AS session
				FROM classes
				LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
				LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
				LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
				WHERE classes.classe_eleve_fk={$eleve['eleve_id']}
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
						<title>LISTE DES $titre</title>
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
							<div align='center' style='font-size:20px;'>LISTE DES $titre</div>
						</div>
						<table style='width:100%'>
							<tr>
								<th>Date d'inscription</th>
								<th>Matricule</th>
								<th>Nom et prénom</th>
								<th>NC</th>
								<th>Classe</th>
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
			$date_inscription = strftime("%d/%m/%Y", strtotime($value['eleve_date_inscription']));
			$content .= "
				<tr>
					<td>" . $date_inscription . "</td>
					<td>" . $value['eleve_matricule'] . "</td>
					<td>" . $value['eleve_nom'] . " " . $value['eleve_prenom'] ."</td>
					<td>" . $value['eleve_nc'] . "</td>
					<td>" . $classe . "</td>
				</tr>
			";
		}
		$nm = date('m')*1 - 1;
		$m = $monthNames[$nm];
		$footer = "
		</table>
		<footer>
			<br>
			<br>
			Total des " . strtolower($titre) . " : " . sizeof($data) . "
			<br>
			<br>
			<br>
			<div align='right'>Antananarivo le , " . date("d") . " $m " . date('Y') . " </div>
		</footer>
		</body>
		</html>";
		$html = $header . $content . $footer;
		// die($html);
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output('liste_eleves.pdf', 'I');
		$mpdf->Close();
		exit();
	}


	/***********************************************/
	//		AJAX SUPPRESSION D'UN ELEVE
	/***********************************************/
	if (isset($_GET['delete'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);

		$db = new database();

		if ($db->delete('eleves', ['eleve_id' => $_GET['delete']])) {
			$file = $upload_dir . 'eleves/' . $_GET['eleve_photo'];
			if (file_exists($file)) {
				unlink($file);
			}
			add_history("Suppression élèves ". $_GET['eleve_nom']);
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

	$error = '';

	$page_title = "Élèves";
	$db = new database();

	$data_eleve = null;
	$classe_list = [];
	$classe_all_data = '';
	if (isset($_GET['id'])) {
		$eleve_id = $_GET['id'];
		$data_eleve = (object) $db->get_query( $query .' where e.eleve_id='. $eleve_id)[0];
		$q = "
			SELECT 	classes.classe_categorie AS categorie,
					c.param_description AS classe,
					m.param_description AS mention,
					s.param_description AS session,
					classes.classe_id AS id	
			FROM classes
			LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
			LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
			LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
			WHERE classes.classe_eleve_fk=$eleve_id
		";
		$classe_list = $db->get_query($q);
		$c = $db->get_query("SELECT classe_id AS id, classe_param_fk, classe_categorie, classe_mention_param_fk, classe_session_param_fk FROM classes WHERE classe_eleve_fk=$eleve_id");
		$classe_all_data = json_encode($c);
	}

	$all_classe = $db->get_query("select * from param_divers where param_table='classe' order by param_ordre");
	$all_classe_cat = $db->get_query("select * from param_divers where param_table='categorie_classe'");
	$all_mention = $db->get_query("select * from param_divers where param_table='mention'");
	$all_session = $db->get_query("select * from param_divers where param_table='categorie_session'");

	// AU SUBMIT DU FORMULAIRE
	unset($_SESSION['error']);
	if (isset($_POST['submit_eleve'])) {
		$classe_data = json_decode($_POST['classe']);
		$nom = array_key_exists('nom', $_POST) ? $_POST['nom'] : null;
		$prenom = array_key_exists('prenom', $_POST) ? $_POST['prenom'] : null;
		$date_naissance = array_key_exists('date_naissance', $_POST) ? $_POST['date_naissance'] : null;
		$matricule = array_key_exists('matricule', $_POST) ? $_POST['matricule'] : null;
		$numero = array_key_exists('numero', $_POST) ? $_POST['numero'] : null;
		$date_inscription = array_key_exists('date_inscription', $_POST) ? $_POST['date_inscription'] : null;
		$adresse = array_key_exists('adresse', $_POST) ? $_POST['adresse'] : null;
		$nc = array_key_exists('nc', $_POST) ? $_POST['nc'] : null;
		$eleve_photo = null;

		// UPLOAD DU PHOTO SI IL EXISTE
		if ($_FILES["photo"]['size'] != 0) {
			$file = $_FILES["photo"];
			$target_file = basename($file["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$eleve_photo = md5(time()) . '.' . $imageFileType;
			$target_file = $upload_dir . 'eleves/' . $eleve_photo;
			$file_size = getimagesize($file["tmp_name"]);
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$_SESSION['error']['error_photo'] = "Veuillez inserer un fichier image JPG, JPEG, PNG ou GIF.";
			}
		}

		switch (null) {
			case $nom:
				$_SESSION['error']['error_nom'] = "Veuillez inserer un nom.";
			case $prenom:
				$_SESSION['error']['error_prenom'] = "Veuillez inserer un prénom.";
			case $matricule:
				$_SESSION['error']['error_matricule'] = "Veuillez inserer la matricule.";
			case $numero:
				$_SESSION['error']['error_numero'] = "Veuillez inserer un numero.";
			case $adresse:
				$_SESSION['error']['error_adresse'] = "Veuillez inserer un adresse.";
			case $nc:
				$_SESSION['error']['error_nc'] = "Veuillez inserer le NC.";
			
			default:
			$nc_doublon = $db->get_query("SELECT COUNT(*) AS nc_doublon FROM eleves WHERE eleve_nc='$nc'")[0]['nc_doublon'];
			if ($nc_doublon > 0) {
				$_SESSION['error']['error_nc'] = "Le NC que vous avez entrer existe déjà";
			}
			switch ('') {
				case $date_naissance:
					$_SESSION['error']['error_date_naissance'] = "Veuillez inserer la date de naissance.";
				case $date_inscription:
					$_SESSION['error']['error_date_inscription'] = "Veuillez inserer la date d'inscription.";
				
				default:
				$data = [
					'eleve_id' => '',
					'eleve_nom' => $nom,
					'eleve_prenom' => $prenom,
					'eleve_matricule' => $matricule,
					'eleve_numero' => $numero,
					'eleve_photo' => $eleve_photo ? $eleve_photo : '-',
					'eleve_adresse' => $adresse,
					'eleve_nc' => $nc,
					'eleve_date_naissance' => $date_naissance,
					'eleve_date_inscription' => $date_inscription,
				];
				if (!array_key_exists('error', $_SESSION)) {
					// CREATION
					if (empty($_POST['id'])) {
						if ($eleve_photo) {
							move_uploaded_file($file["tmp_name"], $target_file); // UPLOAD DU FICHIER
						}
						if ($db->insert('eleves', $data)) {
							$eleve_id = $db->lastInsertId();
							add_history("Création élèves ". $data['eleve_nom']);
							foreach ($classe_data as $i => $classe) {
								$c = [
									'classe_id' => null,
									'classe_categorie' => $classe->classe_categorie,
									'classe_param_fk' => $classe->classe_param_fk,
									'classe_mention_param_fk' => $classe->classe_mention_param_fk,
									'classe_session_param_fk' => $classe->classe_session_param_fk,
									'classe_eleve_fk' => $eleve_id
								];
								$db->insert('classes', $c);
							}
							header('location: ./');
						}
					} else { // MODIFICATION
						$data['eleve_id'] = $_POST['id'];
						$last_picture = $_POST['last_picture'];
						if ($doublon > 1 ) {
							$_SESSION['error']['error_matricule'] = "Ce numéro matricule existe déjà.";
							$data_eleve = (object) $data;
						} else {
							$f = $upload_dir . 'eleves/' . $last_picture;
							if (file_exists($f)) {
								unlink($f); // SUPRESSION DE L'ANCIEN PHOTO
							}
							if ($eleve_photo) {
								move_uploaded_file($file["tmp_name"], $target_file); // UPLOAD DU FUCHIER
							}
							$db->delete('classes', ['classe_eleve_fk' => $data['eleve_id']]);
							foreach ($classe_data as $i => $classe) {
								$c = [
									'classe_id' => null,
									'classe_categorie' => $classe->classe_categorie,
									'classe_param_fk' => $classe->classe_param_fk,
									'classe_mention_param_fk' => $classe->classe_mention_param_fk,
									'classe_session_param_fk' => $classe->classe_session_param_fk,
									'classe_eleve_fk' => $data['eleve_id']
								];
								$db->insert('classes', $c);
							}
							$db->update('eleves', $data, ['eleve_id' => $_POST['id']]);
							add_history("Modification élèves ".$data['eleve_nom']);
							header('location: ./');
						}
					}
				} else {
					$data_eleve = (object) $data;
				}
			}
		}
	}
