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
			
			default:
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
