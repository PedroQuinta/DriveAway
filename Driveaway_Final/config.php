<?php  

    //Connection to the database with parameters and using PDO
	try {
		$conPdo = new PDO("pgsql:host=localhost; dbname=apresentacao","test","test");
		$conPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		die("Erro: Não se conseguiu efetuar a ligação à base de dados.".$e->getMessage());
	}
?>