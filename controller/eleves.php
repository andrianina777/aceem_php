<?php
	$query = "SELECT e.* FROM eleves AS e INNER JOIN classes AS c ON e.eleve_id=c.classe_eleve_fk";
	/***********************************************/
	//		AJAX LISTE DE TOUT LES ELEVES
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();
		$query .= " __JOINTURE__ ";
		if (isset($_GET['typeSearch'])) {
			switch ($_GET['typeSearch']) {
				case 'AVEC_DOUBLON':
					$query .= " INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)>1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
				break;
				case 'SANS_DOUBLON':
					$query .= " INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)=1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
					break;
			}	
		}

		$query .= " WHERE 1 ";
		$join = '';

		if (isset($_GET['classe']) && $_GET['classe'] != -1) {
			$join .= " INNER JOIN param_divers AS cp ON cp.param_id=c.classe_param_fk ";
			$query .= " AND c.classe_param_fk=" . $_GET['classe'];
		}
		if (isset($_GET['session']) && $_GET['session'] != -1) {
			$join .= "INNER JOIN param_divers AS sp ON sp.param_id=c.classe_session_param_fk";
			$query .= " AND c.classe_session_param_fk=" . $_GET['session'];
		}
		if (isset($_GET['mention']) && $_GET['mention'] != -1) {
			$join .= "INNER JOIN param_divers AS mp ON mp.param_id=c.classe_mention_param_fk";
			$query .= " AND c.classe_mention_param_fk=" . $_GET['mention'];
		}
		if (isset($_GET['nc']) && $_GET['nc'] != '') {
			$query .= " AND e.eleve_nc LIKE '" . $_GET['nc'] . "%'";
		}
		if (isset($_GET['typeEleve'])) {
		  if ($_GET['typeEleve'] != 'ANCIEN') {
        $query .= " AND e.eleve_date_limite > NOW()";
      } else if ($_GET['typeEleve'] != 'RECENT') {
        $query .= " AND e.eleve_date_limite < CURRENT_DATE()";
      }
    } else {
      $query .= " AND e.eleve_date_limite > NOW()";
    }

		$query = str_replace('__JOINTURE__', $join, $query);
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
  //				GET ELEVE BY
  /***********************************************/
  if (isset($_GET['getOne'])) {
    require_once '../config/default.php';
    require_once '../config/database.php';
    require_once '../helpers/auth.php';
    is_login($base_url);
    $db = new database();
    
    $query .= " WHERE 1 ";
    $join = '';
    
    if (isset($_GET['nc']) && $_GET['nc'] != '') {
      $query .= " AND e.eleve_nc='" . $_GET['nc'] . "'";
    }
    $data = $db->get_query($query);
    header('Content-type: application/json');
    if (sizeof($data) == 1) {
      $data = $data[0];
      $q = "
      SELECT  classes.classe_categorie AS categorie,
          c.param_description AS classe,
          m.param_description AS mention,
          s.param_description AS session
      FROM classes
      LEFT JOIN param_divers AS c ON classes.classe_param_fk=c.param_id
      LEFT JOIN param_divers AS m ON classes.classe_mention_param_fk=m.param_id
      LEFT JOIN param_divers AS s ON classes.classe_session_param_fk=s.param_id
      WHERE classes.classe_eleve_fk={$data['eleve_id']}
    ";
      $classe = $db->get_query($q);
      $reste = $db->get_query("SELECT (SUM(paiement_total) - SUM(paiement_montant)) AS reste FROM paiements WHERE paiement_eleve_fk = {$data['eleve_id']}")[0]['reste'];
      $data['classe'] = $classe;
      $data['reste'] = $reste;
      echo json_encode($data);
    } else {
      echo 'null';
    }
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
		$query .= " __JOINTURE__ ";
		if (isset($_GET['typeSearch'])) {
			switch ($_GET['typeSearch']) {
				case 'AVEC_DOUBLON':
					$query .= " INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)>1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
				break;
				case 'SANS_DOUBLON':
					$query .= " INNER JOIN (SELECT eleve_matricule FROM eleves GROUP BY eleve_matricule HAVING COUNT(eleve_matricule)=1) AS temp ON e.eleve_matricule=temp.eleve_matricule";
					break;
			}	
		}

		$query .= " WHERE 1 ";
		$join = '';

		if (isset($_GET['classe']) && $_GET['classe'] != -1) {
			$join .= " INNER JOIN param_divers AS cp ON cp.param_id=c.classe_param_fk ";
			$query .= " AND c.classe_param_fk=" . $_GET['classe'];
		}
		if (isset($_GET['session']) && $_GET['session'] != -1) {
			$join .= "INNER JOIN param_divers AS sp ON sp.param_id=c.classe_session_param_fk";
			$query .= " AND c.classe_session_param_fk=" . $_GET['session'];
		}
		if (isset($_GET['mention']) && $_GET['mention'] != -1) {
			$join .= "INNER JOIN param_divers AS mp ON mp.param_id=c.classe_mention_param_fk";
			$query .= " AND c.classe_mention_param_fk=" . $_GET['mention'];
		}
		if (isset($_GET['nc']) && $_GET['nc'] != '') {
			$query .= " AND e.eleve_nc='" . $_GET['nc'] . "%'";
		}

		$query = str_replace('__JOINTURE__', $join, $query);
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
		$monthNames = getAllMounth();
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
							    width: 100%;
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
							<h4>Cellule de suivie d'Evaluation</h4>
							Total des " . strtolower($titre) . " : " . sizeof($data) . "
							<br>
							<br>
							
						</div>
						<table>
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
					<td>" . $value['eleve_nom'] . " " . $value['eleve_prenom'] . "</td>
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
			<div align='right'>Antananarivo le , " . date("d") . " $m " . date('Y') . " </div>
		</footer>
		</body>
		</html>";
		$html = $header . $content . $footer;
		// die($html);
        try {
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
            $mpdf->WriteHTML($html);
            $mpdf->Output('liste_eleves.pdf', 'I');
            $mpdf->Close();
        } catch (\Throwable $e) {
            die($e);
        }
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
		$isModif = !empty($_POST['id']);
		$classe_data = json_decode($_POST['classe']);
		$nom = array_key_exists('nom', $_POST) ? $_POST['nom'] : null;
		$prenom = array_key_exists('prenom', $_POST) ? $_POST['prenom'] : null;
		$date_naissance = array_key_exists('date_naissance', $_POST) ? $_POST['date_naissance'] : null;
		$matricule = array_key_exists('matricule', $_POST) ? $_POST['matricule'] : null;
		$numero = array_key_exists('numero', $_POST) ? $_POST['numero'] : null;
		$date_inscription = array_key_exists('date_inscription', $_POST) ? $_POST['date_inscription'] : null;
		$date_limite = array_key_exists('date_limite', $_POST) ? $_POST['date_limite'] : null;
		$adresse = array_key_exists('adresse', $_POST) ? $_POST['adresse'] : null;
		$nc = array_key_exists('nc', $_POST) ? $_POST['nc'] : null;
		$eleve_photo = null;
		
		// UPLOAD DU PHOTO SI IL EXISTE
		if ($_FILES["photo"]['size'] != 0) {
			$file = $_FILES["photo"];
			$target_file = basename($file["name"]);
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$eleve_photo = md5(time()) . '.' . $imageFileType;
			$target_file = $upload_dir . 'eleves/' . $eleve_photo;
			$file_size = getimagesize($file["tmp_name"]);
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$_SESSION['error']['error_photo'] = "Veuillez insérer un fichier image JPG, JPEG, PNG ou GIF.";
			}
		}

		switch (null) {
			case $nom:
				$_SESSION['error']['error_nom'] = "Veuillez insérer un nom.";
			case $prenom:
				$_SESSION['error']['error_prenom'] = "Veuillez insérer un prénom.";
			case $matricule:
				$_SESSION['error']['error_matricule'] = "Veuillez insérer la matricule.";
			case $numero:
				$_SESSION['error']['error_numero'] = "Veuillez insérer un numéro.";
			case $nc:
				$_SESSION['error']['error_nc'] = "Veuillez insérer le NC.";
			
			default:
			$nc_doublon = $db->get_query("SELECT COUNT(*) AS nc_doublon FROM eleves WHERE eleve_nc='$nc'")[0]['nc_doublon'];
			if (!$isModif) {
				if ($nc_doublon > 0) {
					$_SESSION['error']['error_nc'] = "Le NC que vous avez entrer existe déjà";
				}
			} else {
					if ($nc_doublon > 1) {
						$_SESSION['error']['error_nc'] = "Le NC que vous avez entrer existe déjà";
					}
			}
			switch ('') {
				case $date_inscription:
					$_SESSION['error']['error_date_inscription'] = "Veuillez insérer la date d'inscription.";
				case $date_limite:
					$_SESSION['error']['error_date_limite'] = "Veuillez insérer la date de sorti.";
				
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
					'eleve_date_limite' => $date_limite
				];
				if (!array_key_exists('error', $_SESSION)) {
					// CREATION
					if (!$isModif) {
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
						if ($nc_doublon > 1 ) {
							$_SESSION['error']['error_matricule'] = "Ce numéro matricule existe déjà.";
							$data_eleve = (object) $data;
						} else {
							$f = $upload_dir . 'eleves/' . $last_picture;
							if (file_exists($f)) {
								unlink($f); // SUPPRESSION DE L'ANCIEN PHOTO
							}
							if ($eleve_photo) {
								move_uploaded_file($file["tmp_name"], $target_file); // UPLOAD DU FICHIER
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
