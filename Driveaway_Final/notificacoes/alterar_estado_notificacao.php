<?php
	/*
	echo $_GET['id_estado'];
	echo "<br>";
	echo $_GET['target'];
	*/

	include "../config.php";
	
    try {
        $query = "UPDATE pessoa_alerta SET alertavista=TRUE WHERE alerta_idalerta=".$_GET['id_estado'];

        $statement = $conPdo->query($query);
        $statement->execute();
    } catch (PDOException $e) {
        die("erro".$e->getMessage());
    }
	

	
	
?>
<!DOCTYPE html>
<html>
<head>
	
</head>
<body>

	<!--Import jQuery before materialize.js-->
    <!-- <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> -->


	
	<!-- carrega a pagina no conteinar -->
    <script type="text/javascript">
    	
    	//$("#alertas").load("alertas.php");

    	$("#conteudo").load("<?php echo $_GET['target']?>");
    	
    </script>

</body>
</html>