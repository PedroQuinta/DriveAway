<?php  

    //Connection to the database with parameters and using PDO
	try {
		$conPdo = new PDO("pgsql:host=estga-dev.clients.ua.pt; dbname=ppsi-2017-gr1","ppsi-2017-gr1","Y!=KjPxxw79wT*y!");
		$conPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		die("Erro: Não se conseguiu efetuar a ligação à base de dados.".$e->getMessage());
	}
?>