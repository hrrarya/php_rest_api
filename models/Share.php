<?php 
	
class Share{

	private $pdo;
	private $stmt;

	function __construct()
	{
		try{

		$this->pdo= new PDO('mysql:host='.HOST.';dbname='.NAME,USER,PASS);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo 'Connection Failed '. $e->getMessage();
		}
	}

	function __destruct()
	{
		if($this->pdo !== null) {$this->pdo=null;}
		if($this->stmt !== null) {$this->stmt=null;}
	}

	function read(){
		$query = "SELECT * FROM share";
		$this->stmt = $this->pdo->prepare($query);
		$this->stmt->execute();


		return $this->stmt;
	}
}
 ?>
