<?php 
	include "../config.php"; 
	if(!$_GET['enviar']){

		$t=0; //tipo de marcar

		if(isset($_GET['dia']) && isset($_GET['hora'])){
			$dia = $_GET['dia'];
			
			$hora = $_GET['hora'].":00";
			$t=0;


		}

		if(isset($_GET['idaula']) && isset($_GET['marcar_cancelar'])){


			$idaula = $_GET['idaula'];
			$marcar_cancelar = $_GET['marcar_cancelar'];


			if($marcar_cancelar == 1){
				//pedido
				$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
				aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
				ea.idestado, ea.descricao as estado,
				al.idaluno , al.pessoa_idpessoa,
				p2.idpessoa, p2.nome as nomeAluno
				FROM aula a, aulapratica aulap, aluno al, pessoa p2, estadoaula ea
				WHERE a.idaula = aulap.aula_idaula AND
				aulap.aluno_idaluno = al.idaluno AND 
				al.pessoa_idpessoa = p2.idpessoa AND
				ea.idestado = aulap.estadoaula_idestadoaula AND
				aulap.aula_idaula = ".$idaula;

				$t=1;

			}
			else{
				//pedido de cancelar
				$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
				f.idfuncionario,f.pessoa_idpessoa,
				p.idpessoa, p.nome,
				c.idcategoria, c.designacao,
				aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
				ea.idestado, ea.descricao as estado,
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
				ea.idestado = aulap.estadoaula_idestadoaula AND
				aulap.aula_idaula = ".$idaula;
				$t=2;
			}				

			$statement = $conPdo->query($sql);
			
			$informacao_aula = $statement->fetch(PDO::FETCH_ASSOC);

			$dia = $informacao_aula['dia'];
			$hora = $informacao_aula['hora'];

		}		
		
	 ?>

	 <!DOCTYPE html>
	 <html>
	 <head>
	 	<title>Marcar Aula</title>
	 </head>
	 <body>

	 	<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="formulario_marcar_aula">

	 		<?php 
	 			if($t==0  || $t ==1){

	 				echo "<input type='hidden' name='idaula' value='".$informacao_aula['idaula']."' readonly >";
	 			
	 					echo '<p><label>Aluno: </label>';
							
								if($t==1){
									echo "<select name='alunos' id='alunos' disabled>";
									echo "<option value='".$informacao_aula['idaluno']."'>".$informacao_aula['idaluno']. " - " .$informacao_aula['nomealuno']. "</option>";
								}
								else{
									echo "<select name='alunos' id='alunos'>";							
								}
								
								
							echo "</select>";
						echo '</p>'; 				

				 
				 	echo "<p>
				 			<label>Categoria: </label>";

				 	echo "<select name='categoria' id='categoria'>";

				 	echo "</select></p>"; 

				 	if($t==1){
				 		echo '<p>
				 			<label>Estado: </label>
				 			<input type="text" name="estado" value="'.$informacao_aula['estado'].' "readonly>

				 		</p>';
				 	}
			 		

			 		 echo '<p>
				 			<label>Dia: </label>';
				 			
				 			echo '<input type="text" name="dia" id="dia" value="'.$dia.'" readonly>
				 		</p>';

				 	echo '<p>
				 			<label>Hora: </label>';
				 			$hora = date('H:i', strtotime($hora));
				 			echo '<input type="text" name="hora" id="hora" value="'.$hora.'" readonly>
				 		</p> ';
			 		
				 	echo '<p>
				 			<label>Funcionario: </label>';
				 			$funcionario = "SELECT  f.idfuncionario,f.pessoa_idpessoa,p.idpessoa, p.nome
										FROM funcionario f, pessoa p
										WHERE f.pessoa_idpessoa = p.idpessoa AND
										f.idfuncionario =".$_GET['id_tipo'];

								$statement = $conPdo->query($funcionario);
						 		$statement->execute();
						 		$func = $statement->fetch();
				 			echo '<input type="text" readonly name="funcionario" id="funcionario" value="'.$func["nome"].'">';
				 			echo "<input type='hidden' id='idfunc' name='idfunc' value='".$func["idfuncionario"]."' readonly>";
				 	echo '</p>';

				 	echo '<p>
				 			<label>Veículo: </label>
				 			<select name="veiculo" id="veiculo">
							</select>		 			
				 		</p>';
			 		
			 		echo '<p>
				 			<label>Matrícula: </label>
				 			<input type="text" name="matricula" id="matricula" value="" readonly>
				 		</p>';

				 	if($t==0){
				 		echo '<p><input type="checkbox" name="exame" id="exame" value="exame">Exame?</p>';
				 		echo "<p id='pExame' style='display : none'>";
				 		echo '<label>Localização</label>
				 			<input type="text" name="localizacao" id="localizacao">';
				 		echo "</p>";
				 	}

	 				echo "<button type='button' class='btn btn-primary' id='marcar_aula'>Marcar Aula</button>";

	 				if($t==1){
	 					echo "<button type='button' class='btn btn-danger' id='rejeitar_pedido'>Rejeitar Pedido</button>";
	 				}


	 			}
	 			else{
	 				echo "<input type='hidden' name='idaula' value='".$informacao_aula['idaula']."' readonly >";
					
					echo "<input type='hidden' name='idestado' value='".$informacao_aula['estadoaula_idestado']."' readonly>";

					echo "<h1>Cancelar Aula Prática</h1>";
					echo "<p>Aluno : ".$informacao_aula['nomealuno']."</p>";
					echo "<p>Categoria : ".$informacao_aula['designacao']."</p>";
					echo "<p>Estado da aula : ".$informacao_aula['estado']."</p>";
					$date = date_create($informacao_aula['dia']);
					echo "<p>Dia : ".date_format($date,'d/m/y')."</p>";
					$hora = date('H:i', strtotime($informacao_aula['hora']));
					echo "<p>Hora : ".$hora."</p>";
					echo "<p>Funcionario : ".$informacao_aula['nome']."</p>";
					echo "<p>Veículo : ".$informacao_aula['marca']." ".$informacao_aula['modelo']."</p>";
					echo "<p>Matrícula : ".$informacao_aula['matricula']."</p>";

	 				echo "<button type='button' class='btn btn-primary' id='rejeitar_pedido'>Cancelar aula</button>";
	 				echo "<button type='button' class='btn btn-danger' id='ignorar_pedido'>Manter aula</button>";
	 			}
	}
	else{

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

		if($_GET['enviar']==1){
			

			
			
			try{				

				$conPdo->beginTransaction();

				$query = "INSERT INTO aula(dia,hora,funcionario_idfuncionario,categoria_idcategoria) VALUES ('".$_POST['dia']."','".$_POST['hora']."',".$_POST['idfunc'].",".$_POST['categoria'].")";
				
				$statement = $conPdo->query($query);
				$statement->execute();
				//var_dump($query);

				$id = $conPdo->lastInsertId();
				$exame;
				$tipo_alerta;
				if(isset($_POST['exame'])){
					$query = "INSERT INTO exame(aula_idaula,aluno_idaluno,veiculo_idveiculo,localizacao) VALUES(".$id.",".$_POST['alunos'].",".$_POST['veiculo'].",'".$_POST['localizacao']."')";
					$exame= "Exame marcado para o dia ".$_POST['dia']." às ".$_POST['hora'];
					$tipo_alerta=2;
					$titulo = "Exame Marcado";
				}else{
					$query = "INSERT INTO aulapratica(aula_idaula,aluno_idaluno,estadoaula_idestadoaula,veiculo_idveiculo) VALUES(".$id.",".$_POST['alunos'].",2,".$_POST['veiculo'].")";
					$exame= "Aula marcada para o dia ".$_POST['dia']." às ".$_POST['hora'];
					$tipo_alerta=1;
					$titulo = "Aula Marcada";
				}
				
				$statement = $conPdo->query($query);
				
				$conPdo->commit();	
				
				MaileNotificacao($_POST['idfunc'], $_POST['alunos'],$titulo ,$exame, $tipo_alerta, $_POST['dia']);
				
				echo "<h1>Aula marcada com sucesso</h1>";
				
			}
			catch(PDOException $e){
			$conPdo->rollBack();
				echo "Error: " . $e->getMessage();					
			}
			

		}
		elseif($_GET['enviar']==2){
			
			if($_SESSION["secretaria"] == true){
				//var_dump($_POST);
				/*
				GESTÃO DE PEDIDOS
				$sql_update = "UPDATE aulapratica
						SET estadoaula_idestadoaula = 4
						WHERE aula_idaula=".$_POST['idaula'];
				$statement = $conPdo->prepare($sql_update);
				$statement->execute();
				*/
				echo "<h1>cancelou a aula</h1>";
			}
		}

		elseif($_GET['enviar']==3){
			//sql de ignorar o pedido ... estado = 2
			if($_SESSION["secretaria"] == true){
				//var_dump($_POST);
				/*
				GESTÃO DE PEDIDOS
				$sql_update = "UPDATE aulapratica
						SET estadoaula_idestadoaula = 2
						WHERE aula_idaula=".$_POST['idaula'];
				$statement = $conPdo->prepare($sql_update);
				$statement->execute();
				*/
				echo "<h1>cancelou a aula</h1>";
			}
		}
	}

	
?>

 		<button class='btn btn-default' data-dismiss='modal'>Close</button>
 	</form>

 	<div id="divvv"></div>
	
 		  
	<script type="text/javascript">
		$(document).ready(function($) {
			
		
			
		
		var enviar = '<?php echo (isset($_GET["enviar"])); ?>';

		if(!enviar){

			loadCategoria();
			
			$(document).on('change', '#categoria', function(event) {
				loadVeiculo();
				loadAlunos();
				
			});

			$(document).on('change', '#veiculo', function(event) {
				loadMatricula();
			});

			function loadMatricula(){				
				$("#matricula").val($("#veiculo").find(":selected").data('matricula'));
			}

			function loadVeiculo(){
				$.ajax({
	                url: 'calendario/get_veiculos.php?idcategoria='+$("#categoria").find(":selected").val()+ '&dia='+$("#dia").val()+ "&hora="+$("#hora").val(),
	                type: 'get',
	                dataType: 'json',
	                success: function(response) {
	                	var veiculo = response.veiculo;
	                	console.log(veiculo);
	                	$("#veiculo").empty();

	                	 for(var x=0;x<veiculo.length;x++){
	                	 	$("#veiculo").append('<option data-matricula="'+veiculo[x].matricula+'" value="'+veiculo[x].idveiculo+'">'+veiculo[x].marca+ ' ' +veiculo[x].modelo+ '</option>');
	                	 }

	                	loadMatricula();
	                }
	            });

			}

			function loadAlunos(){
				$.ajax({
	                url: 'calendario/get_alunos.php?idcategoria='+$("#categoria").find(":selected").val()+ '&dia='+$("#dia").val()+ "&hora="+$("#hora").val(),
	                type: 'get',
	                dataType: 'json',
	                success: function(response) {
	                	var alunos = response.alunos;
	                	console.log(response);
	                	$("#alunos").empty();
	                	
	                	 for(var x=0;x<alunos.length;x++){
	                	 	$("#alunos").append('<option value="'+alunos[x].idaluno+'">'+alunos[x].nome+'</option>');
	                	 }
	                	 
	                }
	            });

			}
			

			function loadCategoria(){
				
				$.ajax({
	                url: 'calendario/get_categoria.php?idfunc='+$("#idfunc").val(),
	                type: 'get',
	                dataType: 'json',
	                success: function(response) {
	                	var cate = response.categoria;
	                	console.log(cate);
	                	$("#categoria").empty();

	                	console.log($("#categoria"));

	                	
	                	for(var x=0;x<cate.length;x++){
	                		console.log(cate[x].designacao);	                		
	                	 	$("#categoria").append('<option value="'+cate[x].categoria_idcategoria+'">'+cate[x].designacao+'</option>');	                	 
	                	 }

						loadVeiculo();
						loadAlunos();

	                }
	            });
			}

			$( "#exame" ).change(function() {
				$("#pExame").toggle();
				if($("#exame").is(':checked')){
					$("#marcar_aula").attr("disabled", true);
				}
				else{
					$("#marcar_aula").attr("disabled", false);
				}
			});

			
			$("#localizacao").keyup(function(event) {
				if($(this).val() == "" ){
					$("#marcar_aula").attr("disabled", true);
				}
				else{
					$("#marcar_aula").attr("disabled", false);
				}
			});
			
		}
			 
		});
		
	</script>
 </body>
 </html>