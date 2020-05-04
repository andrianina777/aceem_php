<?php
include 'default.php';
class database
{
	private $pdo = null;
	private $host = 'localhost';
	private $user = 'root';
	private $dbname = 'aceem';
	private $password = '';

	function __construct()
	{
		try {
		    $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
		    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
	}

	function get_query($sql)
	{
		$stmt = $this->pdo->prepare($sql);
    	$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}
}
