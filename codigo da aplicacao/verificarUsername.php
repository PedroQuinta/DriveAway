<?php  

	include "config.php";

	try {
       		//echo "<p>entrou no try que verifica se ja existe pessoa</p>";
           //SQL query
           $querySelect = "SELECT idpessoa FROM pessoa WHERE username=:username";

           //prepares the query with the PDO syntax
           if ($stmt = $conPdo->prepare($querySelect)) {

               //sets up the variables by binding up to the parameters
               $stmt->bindParam(":username", $txtParam_username, PDO::PARAM_STR);

               //parameters
               $txtParam_username = $_GET['username'];

               //tries to execute the statement
               if ($stmt->execute()) {
                   if ($stmt->rowCount()==1) {
                   		$var = $stmt->fetch(); 		

                        echo "Este utilizador já está a ser utilizado.";
                   }else{
                   		echo "Disponível";
                   }

               }else{
                   echo "Erro. Por favor tente mais tarde.";
               }
           }
	            
           		unset($stmt);
    } catch (PDOException $e) {
       die("Erro ao executar a query $querySelect".$e->getMessage());
    }


?>