<?php
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
		$titre = "ÉTAT GÉNÉRAL";

		$years = getValueOfKey('year', $db->get_query("SELECT YEAR(paiement_date_depot) AS year FROM paiements"));
		$data = [];
		for ($month=1; $month <= 12; $month++) { 
			foreach ($years as $year) {
				$data["$year"]["$month"] = $db->get_query("SELECT SUM(paiement_total) AS total, SUM(paiement_total-paiement_montant) AS reste FROM paiements WHERE YEAR(paiement_date_depot)=$year AND MONTH(paiement_date_depot)=$month")[0];
			}
		}
		$allMounth = getAllMounth();
		
		setlocale(LC_TIME, "fr_FR");
		$content = "";
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
								text-align: right;
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
		";
		$content .= "<thead><tr><th></th>";
		foreach ($allMounth as $mounth) {
			$content .= "<th>$mounth</th>";
		}
		$content .= "<th>Total</th></tr></thead><tbody>";
		foreach ($data as $k => $v) {
			$content .= "<tr><td>$k</td>";
			$totalT = 0;
			$totalR = 0;
			for ($month=1; $month <= 12; $month++){
				$total = format_money($v[$month]['total']);
				$reste = format_money($v[$month]['reste']);
				$totalT += $v[$month]['total'];
				$totalR += $v[$month]['reste'];
				$reste = $reste == 0 ? "0 Ar":"<strong>- $reste</strong>";
				$content .= "<td>$total<br>$reste</td>";
			}
			$totalR = $totalR == 0 ? "0 Ar":"<strong>- " . format_money($totalR) . "</strong>";
			$content .= "<td>" . format_money($totalT) . "<br>$totalR</td></tr>";
		}
		$monthNames = getAllMounth();
		$nm = date('m')*1 - 1;
		$m = $monthNames[$nm];
		$footer = "
		</tbody>
		</table>
		<footer>
			<br>
			<div align='right'>Antananarivo le , ".date("d") ." $m ". date('Y') ." </div>
		</footer>
		</body>
		</html>";
		$html = $header . $content . $footer;
		// die($html);
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
		$mpdf->WriteHTML($html);
		$mpdf->Output('liste_paiement.pdf', 'I');
		$mpdf->Close();
		exit();
	}

	/***********************************************/
	//				ACTION PAR DEFAUT
	/***********************************************/	
	require_once '../../config/default.php';
  	require_once '../../helpers/auth.php';
	is_login($base_url);
	require_once '../../config/database.php';

	$page_title = "Etat Général";
	$db = new database();

	$years = getValueOfKey('year', $db->get_query("SELECT YEAR(paiement_date_depot) AS year FROM paiements"));
	$data = [];
	for ($month=1; $month <= 12; $month++) { 
		foreach ($years as $year) {
			$data["$year"]["$month"] = $db->get_query("SELECT SUM(paiement_total) AS total, SUM(paiement_total-paiement_montant) AS reste FROM paiements WHERE YEAR(paiement_date_depot)=$year AND MONTH(paiement_date_depot)=$month")[0];
		}
	}
	$allMounth = getAllMounth();