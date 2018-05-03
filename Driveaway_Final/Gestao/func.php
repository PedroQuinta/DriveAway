<?php 

	$gestao = "Gestao/"; 
//verificar se foi clicado em gestao de funcionarios ou alunos

	if(isset($_POST['teo'])){
		$teorico = true;
	}else{
		$teorico = false;
	}


	if(isset($_POST['prat'])){
		$pratico = true;
	}else{
		$pratico = false;
	}

	try{
		// obter o ID dos dados inseridos			
		$id = $conPdo->lastInsertId();
		$stmt = $conPdo->prepare("INSERT INTO funcionario ( instrutorteorica, instrutorpratica, pessoa_idpessoa, activo)
			VALUES (:instrutorteorica, :instrutorpratica, :pessoa_idpessoa, true)");
       
        $stmt->bindParam(':instrutorteorica', $instrutorteorica);
        $stmt->bindParam(':instrutorpratica', $instrutorpratica);
        $stmt->bindParam(':pessoa_idpessoa', $pessoa_idpessoa);
        $instrutorteorica = $teorico;
        $instrutorpratica = $pratico;
        $pessoa_idpessoa = $id;
		$stmt->execute();
		

		$idfunc = $conPdo->lastInsertId();	

		if(isset($_POST['categorias']) && !empty($_POST['categorias'])){
			foreach ($_POST['categorias'] as $selected) {
				$stmt = $conPdo->query("INSERT INTO categoria_func(funcionario_idfuncionario, categoria_idcategoria) VALUES (".$idfunc.",".$selected.")");
			}
		}
		
		$conPdo->commit();

		include "../mailer.php";
		$endreco = array($_POST['email']);
		 sendmail($endreco,"Bem vindo ao Drive Away","<h1>bem vindo</h1><p>username: ".$_POST['username']." <br> password : ".$_POST['password']."</p>");

		echo "

					<script type='text/javascript'>
						
						refresh('".$gestao."gestaoFunc.php');
						
					</script> 

				";

	}catch(PDOException $e){
		$conPdo->rollBack();
		echo "-> Error: " . $e->getMessage()."<br>-> Foi feito rollback à tabela pessoa - funcionario.";
	
	}
?>