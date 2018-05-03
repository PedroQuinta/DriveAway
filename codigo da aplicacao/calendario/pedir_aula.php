<?php 
	
	session_start();
	include "../config.php";
	

	if($_GET['tipo'] == "aluno"){
		$id_tipo = filter_input(INPUT_GET, "id_tipo");


		if($_GET['enviar'] == 1){

			try{
				

				$conPdo->beginTransaction();

				$query = "INSERT INTO aula(dia,hora) VALUES ('".$_POST['dia']."','".$_POST['hora'].":00:00')";
				$statement = $conPdo->prepare($query);
				$statement->execute();
				//var_dump($query);

				$id = $conPdo->lastInsertId();
				$query = "INSERT INTO aulapratica(aula_idaula,aluno_idaluno,estadoaula_idestadoaula) VALUES(".$id.",".$id_tipo.",1)";
				$statement = $conPdo->prepare($query);
				$statement->execute();
				$conPdo->commit();
				//var_dump($query);
				echo "<h1>Pedido realizado com sucesso</h1>";
				
				include "../notificacoes/nova_notificacao.php";
				pedidos_notification(1);
				
			}
			catch(PDOException $e){
			$conPdo->rollBack();
				echo "Error: " . $e->getMessage();
				//echo "<h1>hove um erro na realização do pedido</h1>";	
			}
						
		}
		else{
			echo "<form method='POST' action='".$_SERVER['PHP_SELF']."' id='formulario_pedir_aula'>";

			echo "<input type='hidden' name='dia'value='".$_GET['dia']."' readonly >";
			echo "<input type='hidden' name='hora'value='".$_GET['hora']."' readonly >";

			echo "<h1>Pedido de Aula</h1>";
			echo "Pedir aula para o dia <strong>".$_GET['dia']."</strong>, hora <strong>".$_GET['hora'].":00</strong> ?</p>";

			echo "<button type='button' class='btn btn-primary' id='pedir_aula'>Pedir Aula</button>";
				echo " <button class='btn btn-default' data-dismiss='modal'>Close</button>";

			echo "</form>";
		}
	}



	

?>