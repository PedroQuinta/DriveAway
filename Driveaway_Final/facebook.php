<?php  
	session_start();
	include "config.php";
	echo "entrou aqui";
	if(isset($_GET['facebook_operation'])){

		if($_GET['facebook_operation']==1){
			try {
				$sql = "UPDATE pessoa SET 
						facebook_id=:facebook_id WHERE idpessoa=".$_SESSION['idpessoa'];

				$result = $conPdo->prepare($sql);

				$result->bindParam(':facebook_id', $param_facebook, PDO::PARAM_STR);

				$param_facebook = $_GET['response_id'];

				$result->execute();

			} catch (PDOException $e) {
				die($e->getMessage());
			}
			
		}else{
			
			try {
				//echo "entrou no try certo";
				$sql_fb = "SELECT * FROM pessoa WHERE facebook_id=".$_GET['response_id'];

				$resultado = $conPdo->query($sql_fb);	

				if($resultado->rowCount()==1){
					$row_fb = $resultado->fetch();
					try {
						$sql_fb_aux = "SELECT * FROM funcionario WHERE pessoa_idpessoa=".$row_fb['idpessoa'];
						$resultado_aux = $conPdo->query($sql_fb_aux);
						if ($resultado_aux->rowCount()==1) {
							$row_func = $resultado_aux->fetch();
							$_SESSION['tipo']="funcionario";
							$_SESSION['nome']=$row_fb['nome'];
							$_SESSION["secretaria"]=$row_func["administrador"];
	                        $_SESSION["instrutorTeorica"]=$row_func["instrutorteorica"];
	                        $_SESSION["instrutorPratica"]=$row_func["instrutorpratica"];
	                        $_SESSION['idpessoa'] = $row_fb['idpessoa'];

						}else{
							$_SESSION['tipo']="aluno";
							$_SESSION['nome']=$row_fb['nome'];

						}
					} catch (PDOException $e) {
						die($e->getMessage());
					}
				}				
				
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}

?>