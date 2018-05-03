<!--
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form method="post" action="<?php// echo $_SERVER['PHP_SELF']; ?>">
		
		<h1>alerta</h1>

		<p>
		<label>descrição</label>
		<input type="text" name="desc">
		</p>

		<p>
		<label>id_tipo</label>
		<input type="text" name="id_tipo">
		</p>

		<hr>
		<p>
		<label>id_pessoa</label>
		<input type="text" name="pessoa">
		</p>

		<p>
		<label>destino</label>
		<input type="text" name="destino">
		</p>

		<input type="submit" name="btn">

	</form>

</body>
</html>

-->


<?php


function new_notification($descricao,$idalerta,$target,$pessoa_idpessoa ){

	
	
	//if($_POST['btn']){

		try{
			include "../config.php";
			//$conn = new PDO("pgsql:host=localhost;dbname=BD", "test", "test");
	        // set the PDO error mode to exception
	        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	         // START TRANSATION
	        $conPdo->beginTransaction();

	        //echo "<p> transaction </p>";
	        $query = "INSERT INTO alerta(descricao,alerta_tipo_idalerta_tipo) VALUES(:descricao,:idalerta)";
			$stmt = $conPdo->prepare($query);
			$stmt->bindParam(':descricao',$descricao);
	        $stmt->bindParam(':idalerta', $idalerta);
	      	
	        $stmt->execute();
	        //echo "<p> exec1 </p>";



	        $id = $conPdo->lastInsertId();
	        //echo "<p> lastID </p>";

	        $query = "INSERT INTO pessoa_alerta(pessoa_idpessoa,alerta_idalerta,destino) VALUES(:pessoa_idpessoa,:alerta_idalerta,:destino)";

			$stmt = $conPdo->prepare($query);
			$stmt->bindParam(':pessoa_idpessoa', $pessoa_idpessoa);
	        $stmt->bindParam(':alerta_idalerta', $id);
	        $stmt->bindParam(':destino',$target );
	        //$stmt->bindParam(':alertavista', false,PDO::PARAM_BOOL);
	        
	        $stmt->execute();
	        //echo "<p> exec2 </p>";

	        
	        $conPdo->commit();

       		//echo "-> Commit feito<br>";
		}
		catch(PDOException $e){
        	// ROLLBACK
        	$conPdo->rollBack();
        	echo "-> Error: " . $e->getMessage()."<br>-> Foi feito rollback à tabela.";
      	}
	//}
}

//new_notification($_POST['desc'], $_POST['id_tipo'],  $_POST['destino'], $_POST['pessoa']);
//

	
	function pedidos_notification($idalerta){

		include "../config.php";
		$stmt = $conPdo->query("UPDATE pessoa_alerta SET alertavista = false WHERE pessoa_idpessoa=1 AND alerta_idalerta = ".$idalerta);
		$stmt->execute();	
	}
?>
