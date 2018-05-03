<?php 
	include "../config.php"; 
	session_start();
	
	
	$idaula = $_GET['idaula'];
	$dados = $_GET['dados'];
	
	function MaileNotificacao($idfunc,$idaluno,$titulo,$mensagem,$tipo_alerta,$dia){
			include "../config.php";
			
			
			$sql = "SELECT al.pessoa_idpessoa, p.nome, p.email 
							FROM aluno al, pessoa p 
							WHERE al.pessoa_idpessoa = p.idpessoa 
							AND idaluno=".$idaluno;
					$statement = $conPdo->query($sql);
					$rowaluno = $statement->fetch();					

			$sql = "SELECT f.pessoa_idpessoa , p.nome, p.email 
					FROM funcionario f, pessoa p 
					WHERE f.pessoa_idpessoa = p.idpessoa 
					AND idfuncionario=".$idfunc;
			$statement = $conPdo->query($sql);
			$rowfunc = $statement->fetch();
			
			
			
			//include __DIR__ . "/notificacoes/nova_notificacao.php";
			include "../notificacoes/nova_notificacao.php";
			//$redirect = $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/calendario.php";
			$date = date_create_from_format('d/m/y',$dia);
						
			$redirect = "calendario/calendario.php?dia=". date_format($date,'y/m/d');
			
			
			new_notification($mensagem,$tipo_alerta,$redirect,$rowaluno['pessoa_idpessoa']);
			new_notification($mensagem,$tipo_alerta,$redirect,$rowfunc['pessoa_idpessoa']);
			include "../mailer.php";
			$endreco = array($rowaluno['email'] , $rowfunc['email']);
			//include $_SERVER['DOCUMENT_ROOT'] . dirname(dirname($_SERVER['PHP_SELF']))."/mailer.php";
			sendmail($endreco,$titulo, $mensagem);
		}



	if($_GET['enviar'] == 1){
		
		try{
			$sql_update = "UPDATE aulapratica
						SET observacao = '".$_POST['observacao']."'
						WHERE aula_idaula=".$_POST['idaula'];
			$statement = $conPdo->prepare($sql_update);
			$statement->execute();
			echo "<h1>Aula atualizada com sucesso!</h1>";
		}
		catch(PDOException $e){
			$conPdo->rollBack();
			echo "Error: " . $e->getMessage();
			
		}
		;
		
		
		
	}

	elseif($_GET['enviar'] == 2){
		
		
		if($_SESSION["secretaria"] == true){
			
			
			$sql_update = "UPDATE aulapratica
						SET estadoaula_idestadoaula = 4
						WHERE aula_idaula=".$_POST['idaula'];
			//reutilizar no aceitar pedido_cancelar e no rejeitar_pedido_aula
			//click dos buttões
			$statement = $conPdo->prepare($sql_update);
			$statement->execute();
			$date = date_create($_POST['dia']);
			MaileNotificacao($_POST['idfunc'],$_POST['idaluno'],"Aula Desmarcada","Aula do dia ".date_format($date,'d/m/y')." às ".$_POST['hora']." foi cancelada.", 1, $_POST['dia']);
			echo "<h1>Cancelou a aula</h1>";

		}else{
			$flag = false; // para os pedidos
			if($_POST['idestado'] == 1){
				$sql_update = "UPDATE aulapratica
							SET estadoaula_idestadoaula = 4
							WHERE aula_idaula=".$_POST['idaula'];
			}
			else{
				$sql_update = "UPDATE aulapratica
							SET estadoaula_idestadoaula = 3
							WHERE aula_idaula=".$_POST['idaula'];
				$flag = true;
			}
			$statement = $conPdo->prepare($sql_update);
			$statement->execute();
			echo "<h1>Cancelou a aula</h1>";
			if($flag){
				include "../notificacoes/nova_notificacao.php";
				pedidos_notification(2); 
			}
		}
		
		
		
		
		
	}

	elseif($_GET['enviar'] == 3){
		
		if($_SESSION["secretaria"] == true){
			try{
				$conPdo->beginTransaction();
				$sql_cancelar = "DELETE FROM exame
								WHERE aula_idaula=".$_POST['idaula'];
				$statement = $conPdo->query($sql_cancelar);

				$sql_cancelar = "DELETE FROM aula
								WHERE idaula=".$_POST['idaula'];
				$statement = $conPdo->query($sql_cancelar);

				$conPdo->commit();

				$date = date_create($_POST['dia']);
				
				MaileNotificacao($_POST['idfunc'],$_POST['idaluno'],"Exame Cancelado.","O seu exame do dia ".date_format($date,'d/m/y')." às ".$_POST['hora']." foi cancelado", 2, $_POST['dia']);
				echo "<h1>Cancelou o Exame</h1>";
			}
			catch(PDOException $e){
			$conPdo->rollBack();
				echo "Error: " . $e->getMessage();
				
			}
			
		}
		
	}




	else{
		//so dados


		if($dados == 0){
				//aulas praticas
				$sql_aulas = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
				f.idfuncionario,f.pessoa_idpessoa,
				p.idpessoa, p.nome,
				c.idcategoria, c.designacao,
				aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
				ea.idestadoaula, ea.descricao as estado,
				v.idveiculo, v.marca, v.modelo, v.matricula,
				al.idaluno , al.pessoa_idpessoa,
				p2.idpessoa, p2.nome as nomeAluno
				FROM aula a, funcionario f, pessoa p, categoria c, aulapratica aulap, veiculo v, aluno al, pessoa p2, estadoaula ea
				WHERE a.categoria_idcategoria = c.idcategoria AND
				a.funcionario_idfuncionario = f.idfuncionario AND
				f.pessoa_idpessoa = p.idpessoa AND
				a.idaula = aulap.aula_idaula AND
				ea.idestadoaula = aulap.estadoaula_idestadoaula AND
				aulap.veiculo_idveiculo = v.idveiculo AND
				aulap.aluno_idaluno = al.idaluno AND 
				al.pessoa_idpessoa = p2.idpessoa AND
				aulap.estadoaula_idestadoaula = 2";

				
			}
			elseif($dados == 1){
				//aulas com pedidos de aulas
				//so alunos podem fazer pedidos de aulas
				$sql_aulas = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
				aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
				ea.idestadoaula, ea.descricao as estado,
				al.idaluno , al.pessoa_idpessoa,
				p2.idpessoa, p2.nome as nomeAluno
				FROM aula a, aulapratica aulap, aluno al, pessoa p2, estadoaula ea
				WHERE a.idaula = aulap.aula_idaula AND
				aulap.aluno_idaluno = al.idaluno AND
				aulap.estadoaula_idestadoaula = ea.idestadoaula AND 
				al.pessoa_idpessoa = p2.idpessoa AND
				aulap.estadoaula_idestadoaula = 1";
				

			}

			elseif($dados == 2){
				//aulas com pedido de cancelar
				//aunos e instrotores podem cancelar aulas
				$sql_aulas = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
					f.idfuncionario,f.pessoa_idpessoa,
					p.idpessoa, p.nome,
					c.idcategoria, c.designacao,
					aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
					ea.idestadoaula, ea.descricao as estado,
					v.idveiculo, v.marca, v.modelo, v.matricula,
					al.idaluno , al.pessoa_idpessoa,
					p2.idpessoa, p2.nome as nomeAluno
					FROM aula a, funcionario f, pessoa p, categoria c, aulapratica aulap, veiculo v, aluno al, pessoa p2, estadoaula ea
					WHERE a.categoria_idcategoria = c.idcategoria AND
					a.funcionario_idfuncionario = f.idfuncionario AND
					f.pessoa_idpessoa = p.idpessoa AND
					a.idaula = aulap.aula_idaula AND
					aulap.veiculo_idveiculo = v.idveiculo AND
					aulap.aluno_idaluno = al.idaluno AND 
					al.pessoa_idpessoa = p2.idpessoa AND
					ea.idestadoaula = aulap.estadoaula_idestadoaula AND
					aulap.estadoaula_idestadoaula = 3";

					

			}

			elseif($dados == 3){
				//exames marcados
				$sql_aulas = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
						f.idfuncionario,f.pessoa_idpessoa,
						p.idpessoa, p.nome,
						c.idcategoria, c.designacao,
						e.idexame, e.aula_idaula, e.veiculo_idveiculo, e.aluno_idaluno,e.localizacao,
						v.idveiculo, v.marca, v.modelo, v.matricula,
						al.idaluno , al.pessoa_idpessoa,
						p2.idpessoa, p2.nome as nomeAluno
					FROM aula a, funcionario f, pessoa p, categoria c, exame e, veiculo v, aluno al, pessoa p2
					WHERE a.categoria_idcategoria = c.idcategoria AND
						a.funcionario_idfuncionario = f.idfuncionario AND
						f.pessoa_idpessoa = p.idpessoa AND
						a.idaula = e.aula_idaula AND
						e.veiculo_idveiculo = v.idveiculo AND
						e.aluno_idaluno = al.idaluno AND 
						al.pessoa_idpessoa = p2.idpessoa";

					
			}

			elseif($dados == 4){
				//aulas teoricas
				$sql_aulas = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria, 
						f.idfuncionario,f.pessoa_idpessoa,
						p.idpessoa, p.nome,
						c.idcategoria, c.designacao,
						aulat.aula_idaula, aulat.modulo_idmodulo,
						m.idmodulo, m.descricao
					FROM aula a, funcionario f, pessoa p, categoria c, aulateorica aulat, modulo m
					WHERE m.idmodulo = aulat.modulo_idmodulo AND
						aulat.aula_idaula = a.idaula AND 
						a.categoria_idcategoria = c.idcategoria AND
						a.funcionario_idfuncionario = f.idfuncionario AND
						f.pessoa_idpessoa = p.idpessoa";
			}

			$sql_aulas .= " AND a.idaula = " . $idaula;	
			



		$statement = $conPdo->query($sql_aulas);

		$infos = $statement->fetch(PDO::FETCH_ASSOC);




		//scretaria tem controlo total dos estados das aulas

		echo "<form method='POST' action='".$_SERVER['PHP_SELF']."' id='formulario_aula'>";
		echo "<input type='hidden' name='idaula' value='".$idaula."' readonly >";
		echo "<input type='hidden' name='dados' value='".$dados."' readonly >";
		
		
		if($dados== 0 || $dados == 1 || $dados == 2){
			//aulas
			
			
			echo "<input type='hidden' name='idestado' value='".$infos['estadoaula_idestadoaula']."' readonly>";

			echo "<h1>Aula prática</h1>";
			echo "<p>Aluno : ".$infos['nomealuno']."</p>";
			echo "<p>Categoria : ".$infos['designacao']."</p>";
			echo "<p>Estado da aula : ".$infos['estado']."</p>";
			$date = date_create($infos['dia']);
			echo "<p>Dia : ".date_format($date,'d/m/y')."</p>";
			$hora = date('H:i', strtotime($infos['hora']));
			echo "<p>Hora : ".$hora."</p>";
			echo "<p>Funcionário : ".$infos['nome']."</p>";
			echo "<p>Veículo : ".$infos['marca']." ".$infos['modelo']."</p>";
			echo "<p>Matrícula : ".$infos['matricula']."</p>";

			if($_SESSION['tipo'] != "aluno" && $dados == 0){
				echo "<p>Observações :</p><p><textarea name='observacao' rows='4' cols='30' style='resize: none;'>".$infos['observacao']."</textarea><p>";
				echo "<button type='button' class='btn btn-primary' id='update_aula'>Atualizar</button>";
			}
			else{
				echo "<p>Observações :</p><p><textarea readonly nome='observacao' rows='4' cols='30' style='resize: none;'>".$infos['observacao']."</textarea><p>";
			}
			
			if($dados == 0 || $dados == 1){
				if($dados == 0){
					echo "<input type='hidden' name='idaluno' value='".$infos['idaluno']."' readonly>";
					echo "<input type='hidden' name='idfunc' value='".$infos['idfuncionario']."' readonly>";
					echo "<input type='hidden' name='dia' value='".$infos['dia']."' readonly>";
					$hora = date('H:i', strtotime($infos['hora']));
					echo "<input type='hidden' name='hora' value='".$hora."' readonly>";
					
				}
				echo"<button type='button' class='btn btn-danger' id='cancelar_aula'>Cancelar Aula</button>";
			}
		}
		elseif($dados == 3){
			echo "<h1>Exame</h1>";
			echo "<p>Aluno : ".$infos['nomealuno']."</p>";
			echo "<p>Categoria : ".$infos['designacao']."</p>";
			$date = date_create($infos['dia']);
			echo "<p>Dia : ".date_format($date,'d/m/y')."</p>";
			$hora = date('H:i', strtotime($infos['hora']));
			echo "<p>Hora : ".$hora."</p>";
			echo "<p>Funcionário : ".$infos['nome']."</p>";
			echo "<p>Veículo : ".$infos['marca']." ".$infos['modelo']."</p>";
			echo "<p>Matrícula : ".$infos['matricula']."</p>";
			echo "<p>Localização : ".$infos['localizacao']."</p>";
			echo "<h3 style='color:red'>Não se esqueça dos seus documentos!</h3>";

			echo "<input type='hidden' name='idaluno' value='".$infos['idaluno']."' readonly>";
			echo "<input type='hidden' name='idfunc' value='".$infos['idfuncionario']."' readonly>";
			echo "<input type='hidden' name='dia' value='".$infos['dia']."' readonly>";
			echo "<input type='hidden' name='hora' value='".$hora."' readonly>";


			echo"<button type='button' class='btn btn-danger' id='cancelar_exame'>Cancelar Exame</button>";

		}
		elseif($dados == 4){
			//teoricas
			//var_dump($infos);
			echo "<h1>Aula teorica</h1>";

			$date = date_create($infos['dia']);
			echo "<p>Dia : ".date_format($date,'d/m/y')."</p>";
			$hora = date('H:i', strtotime($infos['hora']));
			echo "<p>Hora : ".$hora."</p>";
			echo "<p>Categoria : ".$infos['designacao']."</p>";
			echo "<p>Funcionário : ".$infos['nome']."</p>";
			echo "<p>Módulo : ".$infos['descricao']."</p>";
		}

		echo " <button class='btn btn-default' data-dismiss='modal'>Close</button>";

		echo "</form>";
		
	}
?>
