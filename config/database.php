<?php
include 'default.php';
class database
{
	private $pdo = null;
	private $host = 'localhost';
	private $user = 'root';
	private $dbname = 'aceem_';
	private $password = '';

	function __construct()
	{
		try {
		    $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->password);
		    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
	}

	// REQUÊTE DE SELECTION RAPIDE
	function get_query($sql) // RENVOYE UN TABLEAU
	{
		$stmt = $this->pdo->prepare($sql);
    	$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	// INSERTION DANS LA BASE
  
  /**
   * @param $table_name (string) : nom de la table
   * @param $data (array) : les données a insérée
   * @return int
   */
	function insert($table_name, $data) {
		$cols = [];
		$values = [];
		$i = 0;
		foreach ($data as $key => $value) {
			array_push($cols, $key);
			if ($i > 0) {
				array_push($values, $value);
			}
			$i++;
		}

		$sql = "INSERT INTO `$table_name` (`". join($cols, '`, `') ."`) VALUES (NULL,'". join($values, "', '") ."')";
		return $this->pdo->exec($sql);
	}

	// MODIFICATION DANS LA BASE
  
  /**
   * @param $table_name (string) : nom de la table
   * @param $data (array) : les données a insérée
   * @param $condition (array) : listes des conditions
   * @return bool|int
   */
	function update($table_name, $data, $condition) {
		if (sizeof($condition) == 0) return false;

		$values = [];
		$where = [];

		foreach ($data as $key => $value) {
			array_push($values, "$key = '$value'");
		}

		foreach ($condition as $key => $value) {
			array_push($where, "$key = '$value'");
		}

		$sql = "UPDATE `$table_name` SET ". join($values, ', ') ." WHERE ". join($where, ' AND ');

		return $this->pdo->exec($sql);
	}

	// SUPPRESSION DANS LA BASE
  
  /**
   * @param $table_name : nom de la table
   * @param $condition (array) : listes des conditions
   * @return bool|int
   */
	function delete($table_name, $condition) {
		if (sizeof($condition) == 0) return false;

		$where = [];

		foreach ($condition as $key => $value) {
			array_push($where, "$key = '$value'");
		}

		$sql = "DELETE FROM `$table_name` WHERE ". join($where, ' AND ');
		
		return $this->pdo->exec($sql);
	}
  
  /**
   * @return int : la dernière id insérer
   */
	function lastInsertId() {
		return $this->pdo->lastInsertId();
	}

	function findAllIn($table_name) {
		return $this->get_query("select * from $table_name");
	}
}
