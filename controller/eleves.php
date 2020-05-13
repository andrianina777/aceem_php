<?php
	$query = "
		SELECT 	e.*,
				c.param_description AS classe,
				c_cat.param_description AS classe_cat,
				m.param_description AS mention,
				s.param_description AS session
		FROM eleves AS e 
		LEFT JOIN param_divers AS c ON e.eleve_classe_param_fk=c.param_id
		LEFT JOIN param_divers AS c_cat ON e.eleve_classe_cat_param_fk=c_cat.param_id
		LEFT JOIN param_divers AS m ON e.eleve_classe_mention_param_fk=m.param_id
		LEFT JOIN param_divers AS s ON e.eleve_classe_session_param_fk=s.param_id
	";
	/***********************************************/
	//		AJAX LISTE DE TOUT LES UTILISATEURS
	/***********************************************/
	if (isset($_GET['list']) && $_GET['list'] == 0) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);
		$db = new database();

		$data = $db->get_query($query);
		header('Content-type: application/json');
		echo ('{"data":'. json_encode($data) .'}');
		exit();
	}


	/***********************************************/
	//		AJAX SUPRESSION D'UN UTILISATEUR
	/***********************************************/
	if (isset($_GET['delete'])) {
		require_once '../config/default.php';
		require_once '../config/database.php';
		require_once '../helpers/auth.php';
		is_login($base_url);

		$db = new database();

		if ($db->delete('eleves', ['eleve_id' => $_GET['delete']])) {
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
	if (isset($_GET['id'])) {
		$data_eleve = (object) $db->get_query( $query .' where e.eleve_id='. $_GET['id'])[0];
	}

	$all_classe = $db->get_query("select * from param_divers where param_table='classe'");
	$all_classe_cat = $db->get_query("select * from param_divers where param_table='categorie_classe'");
	$all_mention = $db->get_query("select * from param_divers where param_table='mention'");
	$all_session = $db->get_query("select * from param_divers where param_table='categorie_session'");
	$all_lieu = $db->get_query("select * from param_divers where param_table='lieu_inscription'");

	// AU SUBMIT DU FORMULAIRE
	unset($_SESSION['error']);
	if (isset($_POST['submit_eleve'])) {
		$nom = array_key_exists('nom', $_POST) ? $_POST['nom'] : null;
		$prenom = array_key_exists('prenom', $_POST) ? $_POST['prenom'] : null;
		$date_naissance = array_key_exists('date_naissance', $_POST) ? $_POST['date_naissance'] : null;
		$matricule = array_key_exists('matricule', $_POST) ? $_POST['matricule'] : null;
		$numero = array_key_exists('numero', $_POST) ? $_POST['numero'] : null;
		$date_inscription = array_key_exists('date_inscription', $_POST) ? $_POST['date_inscription'] : null;
		$classe = array_key_exists('classe', $_POST) ? $_POST['classe'] : null;
		$classe_categorie = array_key_exists('classe_categorie', $_POST) ? $_POST['classe_categorie'] : null;
		$classe_mention = array_key_exists('classe_mention', $_POST) ? $_POST['classe_mention'] : null;
		$session = array_key_exists('session', $_POST) ? $_POST['session'] : null;
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
					'eleve_classe_param_fk' => $classe,
					'eleve_classe_cat_param_fk' => $classe_categorie,
					'eleve_classe_mention_param_fk' => $classe_mention,
					'eleve_classe_session_param_fk' => $session
				];
				if (!array_key_exists('error', $_SESSION)) {
					$doublon = $db->get_query("select count(eleve_id) as doublon from eleves where eleve_matricule='$matricule'")[0]['doublon'];
					// CREATION
					if (empty($_POST['id'])) {
						if ($doublon > 0) {
							$_SESSION['error']['error_matricule'] = "Ce numéro matricule existe déjà.";
							$data_eleve = (object) $data;
						} else {
							if ($eleve_photo) {
								move_uploaded_file($file["tmp_name"], $target_file); // UPLOAD DU FICHIER
							}
							if ($db->insert('eleves', $data)) {
								header('location: ./');
							}
						}
					} else { // MODIFICATION
						$data['eleve_id'] = $_POST['id'];
						$last_picture = $_POST['last_picture'];
						if ($doublon > 1 ) {
							$_SESSION['error']['error_matricule'] = "Ce numéro matricule existe déjà.";
							$data_eleve = (object) $data;
						} else {
							if ($eleve_photo) {
								unlink($upload_dir . 'eleves/' . $last_picture); // SUPRESSION DE L'ANCIEN PHOTO
								move_uploaded_file($file["tmp_name"], $target_file); // UPLOAD DU FUCHIER
							}
							if ($db->update('eleves', $data, ['eleve_id' => $_POST['id']])) {
								header('location: ./');
							}
						}
					}
				} else {
					$data_eleve = (object) $data;
				}
			}
		}
	}
