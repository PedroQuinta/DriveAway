<?php
 $gestao = "Gestao/";  
//verificar se foi clicado em gestao de funcionarios ou alunos
	try{
		// obter o ID dos dados inseridos			
		$id = $conPdo->lastInsertId();
		$stmt = $conPdo->prepare("INSERT INTO aluno (pessoa_idpessoa, funcionario_idfuncionario, datainscricao, estado_idestado)
			VALUES (:pessoa_idpessoa, :funcionario_idfuncionario, :datainscricao, 1)");
        $stmt->bindParam(':pessoa_idpessoa', $pessoa_idpessoa);
        $stmt->bindParam(':funcionario_idfuncionario', $funcionario_idfuncionario);
        $stmt->bindParam(':datainscricao', $datainscricao);
        
        $pessoa_idpessoa = $id;
        $funcionario_idfuncionario = $_POST['instrutores'];
        $today = date("Y-m-d");
        $datainscricao = $today;       	
        $pessoa_idpessoa = $id;
		$stmt->execute();

		$idaluno = $conPdo->lastInsertId();

		
		if(isset($_POST['categorias']) && !empty($_POST['categorias'])){
			foreach ($_POST['categorias'] as $selected) {
				$stmt = $conPdo->query("INSERT INTO categoria_aluno(categoria_idcategoria,aluno_idaluno) VALUES (".$selected.",".$idaluno.")");
			}
		}
		
		$conPdo->commit();
		include "../mailer.php";
		$endreco = array($_POST['email']);
		 sendmail($endreco,"Bem vindo ao Drive Away","<h1>bem vindo</h1><p>username: ".$_POST['username']." <br> password : ".$_POST['password']."</p>");
		echo "

					<script>
						
						refresh('".$gestao."gestaoAluno.php');
						
					</script> 

				";
	}catch(PDOException $e){
		$conPdo->rollBack();
		echo "-> Error: " . $e->getMessage()."<br>-> Foi feito rollback à tabela pessoa - aluno.";

	}
?>