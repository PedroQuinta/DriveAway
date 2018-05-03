<?php
	header('content-type: application/json; charset=utf-8');
	include "../config.php";
	
	//$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=BD;','postgres', 'postgres');

	session_start();
	


	if(isset($_SESSION['idpessoa'])){

		try {
			$query ="SELECT pa.pessoa_idpessoa,pa.alerta_idalerta,pa.alertavista,pa.destino,
				a.idalerta, a.descricao, a.alerta_tipo_idalerta_tipo,
				at.idalerta_tipo, at.nome
				 FROM pessoa_alerta pa , alerta a, alerta_tipo at
				WHERE pa.alertavista = false AND 
				pa.alerta_idalerta = a.idalerta AND
				a.alerta_tipo_idalerta_tipo = at.idalerta_tipo AND
				pa.pessoa_idpessoa = ".$_SESSION['idpessoa'] . " ORDER BY pa.alerta_idalerta ASC";

				
			$statement = $conPdo->query($query);
			

			$json['notificacoes'] = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			
			echo json_encode($json);
		} catch (PDOException $e) {
			die("erro".$e->getMessage());
		}
		

					/*
					echo "idalerta: ".$row_info['idalerta'] ;
					echo "<br>descricao: ".$row_info['descricao'] ;
					echo "<br>visto: " .$row['alertavista'];
					*/
					/*
					echo "<a href='#' id='".$row['alerta_idalerta']."' data-url='alterar_estado_notificacao.php?id_estado=" .$row['alerta_idalerta']. "&target=" .$row_info['target']. "' >" .$row_info['descricao']. "</a>";

					echo "<br>" .$_SESSION['root']."/".$row_info['target']. "<br>" ;
					//.$_SESSION['root']."/"

				
				echo "</p>";
				*/
				
			
		
	}


?>