<?php  
	include '../config.php';//adcicionar dir principal
	$gestao = "Gestao/";
	if(isset($_GET['tipo']) && isset($_GET['idpessoa'])){
		if($_GET['tipo']==0){
			$sql = "SELECT idpessoa, nome, telefone, email, datanascimento, morada, username, contribuinte	,idfuncionario, administrador, instrutorteorica, instrutorpratica FROM pessoa, funcionario WHERE pessoa.idpessoa=funcionario.pessoa_idpessoa AND pessoa.idpessoa=".$_GET['idpessoa'];			
		}else{
			$sql = "SELECT idpessoa, nome, telefone, email, datanascimento, morada, username, contribuinte, estado_idestado,idaluno, pessoa_idpessoa, funcionario_idfuncionario, datainscricao FROM pessoa, aluno WHERE pessoa.idpessoa=aluno.pessoa_idpessoa AND pessoa.idpessoa=".$_GET['idpessoa'];
		}


		try {
			
			$stmt=$conPdo->query($sql);					
			if($stmt->execute()){						
				if($stmt->rowCount() == 1){							
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					

					echo "<input type='hidden' id='hidden_id' value='".$_GET['idpessoa']."'>";				
				

?>


<center><h2><strong>Edição de Utilizadores</strong></h2></center>
<br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formulario_editar">		
	<div class="container-fluid">
		<div class="col-md-7">
			<div class="form-group">
				<label for="nome">Nome Completo:</label>
				<input type="text" name="nome" id="nome" class="form-control" value="<?php if(isset($row['nome'])) echo $row['nome']; ?>">
				<span class="help-block"><?php echo $txtName_err; ?></span>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<label for="fiscalNumber">Contribuinte:</label>
				<input type="text" name="fiscalNumber" id="fiscalNumber" class="form-control" value="<?php if(isset($row['contribuinte'])) echo $row['contribuinte']; ?>">
				<span id="fiscalNumber_exist"></span>
				<span class="help-block"><?php echo $numFiscalNumber_err; ?></span>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="col-lg-4">	
			<div class="form-group">
				<label for="phone">Telefone:</label>
				<input type="tel" pattern="^\d{9}" title="xxxxxxxxx" name="phone" id="phone" class="form-control" value="<?php if(isset($row['telefone'])) echo $row['telefone']; ?>">
				<span id="phone_exist"></span>
				<span class="help-block"><?php echo $numPhone_err; ?></span>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" class="form-control" value="<?php if(isset($row['email'])) echo $row['email']; ?>">
				<span id="email_exist"></span>
				<span class="help-block"><?php echo $txtEmail_err; ?></span>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="col-lg-4"> 	
			<div class="form-group">
				<label>Data de Nascimento:</label>
				<div class="input-group date" >
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-th"><?php echo $dateBirthday_err; ?></span>
					</div>	
					<input type="date" name="birthDate" id="birthDate" class="form-control" value="<?php if(isset($row['datanascimento'])) echo $row['datanascimento']; ?>">								
				</div>				
			</div>
		</div>
		<div class="col-lg-6">
			<div id ="tipoAluno" class="form-group">				
				<label>Instrutor:</label>
				<div class="input-group">
					<select name="instrutores">
						<?php 
							include '../config.php';
							try {
								$sql = "SELECT nome, idpessoa, idfuncionario, instrutorpratica, pessoa_idpessoa FROM pessoa,funcionario WHERE pessoa.idpessoa=funcionario.pessoa_idpessoa AND instrutorpratica=true AND administrador = FALSE AND activo <> false
					 		ORDER BY nome ASC";
								
								$stmt=$conPdo->query($sql);
								
								if($stmt->execute()){
									if($stmt->rowCount()>0){
										while ($rowAux = $stmt->fetch()) {										
											if($row['funcionario_idfuncionario']==$rowAux['idfuncionario']){
												echo "<option value='".$rowAux['idfuncionario']."' selected> ".$rowAux['nome']."</option>";										
											}else{
												echo "<option value='".$rowAux['idfuncionario']."'> ".$rowAux['nome']."</option>";
											}											
										}
									}
								}

								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								
							} catch (PDOException $e) {
								die("erro".$e->getMessage());
							}

						?>
					</select>
				</div>		
            </div>
        </div>
        <div class="col-lg-6">
			<div id ="progresso" class="form-group">	
				<label>Progresso do Aluno:</label>          		
				
				<div class="input-group">
					<?php 
					
						
							include '../config.php';					
							session_start();
							if($_GET['tipo']==1){
								try {
								$sql = "SELECT idestado, descricao  FROM estado";
								
								$stmt=$conPdo->query($sql);
								
								if($stmt->execute()){
									if($stmt->rowCount()>0){
										echo '<select name="progresso">';
										while ($rowAux = $stmt->fetch()) {
											if($row['estado_idestado'] == $rowAux['idestado']	){
												echo "<option value='".$rowAux['idestado']."' selected> ".$rowAux['descricao']."</option>";
											}else{
												echo "<option value='".$rowAux['idestado']."'> ".$rowAux['descricao']."</option>";
											}
											
										}
									}
								}
								echo "</select>";
								
							} catch (PDOException $e) {
								die("erro".$e->getMessage());
							}
							}
							

						
					
					?>
				</div>	
            </div>
        </div>
        <div class="col-lg-6">
			<div id ="categoria_instrutor" class="form-group">	
				<label>Categorias:</label>          		
				
				<div class="input-group">

					
						<?php 
							include '../config.php';					
							session_start();
							if($_GET['tipo']==0){
								try {
									$sql = "SELECT idcategoria, designacao
											FROM categoria
											WHERE idcategoria NOT IN (
												SELECT idcategoria
												FROM categoria, categoria_func 
												WHERE categoria.idcategoria = categoria_func.categoria_idcategoria AND funcionario_idfuncionario = ".$row['idfuncionario']."
											)";
									
									$stmt=$conPdo->query($sql);
									
									if($stmt->execute()){
										if($stmt->rowCount()>0){
											while ($rowAux = $stmt->fetch()) {
												echo "<input type='checkbox' name='categorias[]' value='".$rowAux['idcategoria']."'>".$rowAux['designacao']." &nbsp";											
											}
										}else{
											echo "Já não tem categorias para associar.";
										}
									}

								
								} catch (PDOException $e) {
									die("erro".$e->getMessage());
								}
							}
							

						?>
					
				</div>	
            </div>
        </div>
        <div class="col-lg-6">

            <div id="tipoInstrutor" class="form-group">
           		<label for="btn1">Funcionário </label>
           		<br>
           		Teórico <input id="teo" type="checkbox" name="teo"  <?php if($row['instrutorteorica'] == 1) echo "checked=checked" ?>> <br>
           		Prático <input id="pra" type="checkbox" name="prat"  <?php if($row['instrutorpratica'] == 1) echo "checked=checked" ?>>     		
			</div>
		</div>			
	</div>
	<div class="container-fluid">
		<div class="col-lg-12">
			<div class="form-group">
				<label>Morada:</label>
				<input type="text" name="address" id="address" class="form-control" id="morada" value="<?php if(isset($row['morada'])) echo $row['morada']; ?>">
				<span class="help-block"><?php echo $txtAddress_err; ?></span>
			</div>
		</div>
	</div>	
	<div class="container-fluid">
		<div class="col-lg-7">
			<div class="form-group">
            	<input type="button" class="btn btn-primary" name="submit" value="Atualizar" id="submit_editar">    <div id="eleminar_div">&nbsp; Deseja eliminar este registo? <input type="checkbox" name="eliminar" id="eliminar">  </div>       
        	</div>
    	</div>	        	
    </div>           
</form>

<?php
	}
			}
		} catch (PDOException $e) {
			die("Erro".$e->getMessage());
		}

	}
	$flag;
	// 0 é funcionario 1 é aluno
	if (isset($_GET['enviar'])) {
		if($_GET['tipo']==0){			
			$sql_second = "UPDATE funcionario SET
			administrador=:administrador,
			instrutorteorica=:instrutorteorica,
			instrutorpratica=:instrutorpratica, 
			activo=:activo	WHERE
			idfuncionario=".$row['idfuncionario'];
			
		$flag = true;

		}
		else{
			$sql_second = "UPDATE aluno SET
			funcionario_idfuncionario=:funcionario_idfuncionario, estado_idestado=:estado_idestado  WHERE
			idaluno=".$row['idaluno'];
			$flag = false;
		}
		try {
			$conPdo->beginTransaction();			
			$sql = "UPDATE pessoa SET 
			nome=:nome ,
			telefone=:telefone,
			email=:email,
			datanascimento=:datanascimento,
			morada=:morada,			
			contribuinte=:contribuinte WHERE
			idpessoa=".$row['idpessoa'];

			
			
			if($stmt = $conPdo->prepare($sql)){

				$stmt->bindParam(':nome', $param_nome, PDO::PARAM_STR);
				$stmt->bindParam(':telefone', $param_telefone, PDO::PARAM_STR);
				$stmt->bindParam(':email', $param_email, PDO::PARAM_STR);
				$stmt->bindParam(':datanascimento', $param_datanascimento, PDO::PARAM_STR);
				$stmt->bindParam(':morada', $param_morada, PDO::PARAM_STR);				
				$stmt->bindParam(':contribuinte', $param_contribuinte, PDO::PARAM_STR);
				
				$param_nome = $_POST['nome'];
				$param_telefone = $_POST['phone'];
				$param_email = $_POST['email'];
				$param_datanascimento = $_POST['birthDate'];
				$param_morada = $_POST['address'];			
				$param_contribuinte = $_POST['fiscalNumber'];

				
			}
			if($stmt_second = $conPdo->prepare($sql_second)){
				if($flag){
					$stmt_second->bindParam(':administrador', $param_administrador, PDO::PARAM_STR);
					$stmt_second->bindParam(':instrutorteorica', $param_instrutorteorica, PDO::PARAM_STR);
					$stmt_second->bindParam(':instrutorpratica', $param_instrutorpratica, PDO::PARAM_STR);
					$stmt_second->bindParam(':activo', $param_activo, PDO::PARAM_STR);			
					$param_administrador = $row['administrador'];
					if($_POST['teo'] == "on"){
						$_POST['teo']=true;
					}else{
						$_POST['teo']=false;
					}
					if($_POST['prat'] == "on"){
						$_POST['prat']=true;
					}else{
						$_POST['prat']=false;
					}
					$param_instrutorteorica = $_POST['teo'];
					$param_instrutorpratica = $_POST['prat'];
					if(isset($_POST['eliminar'])){
						$param_activo = false;
					}
					else{
						$param_activo = true;
					}
				}else{
					$stmt_second->bindParam(':funcionario_idfuncionario', $param_funcionario_idfuncionario, PDO::PARAM_STR);
					$stmt_second->bindParam(':estado_idestado', $param_estado_idestado, PDO::PARAM_STR);
					$param_funcionario_idfuncionario = $_POST['instrutores'];
					$param_estado_idestado = $_POST['progresso'];

				}
			}		

			
			if($stmt->execute() && $stmt_second->execute()){				
				//var_dump($_POST['categorias']);			
				
					if(isset($_POST['categorias'])){
						
						foreach($_POST['categorias'] as $selected){					

							try {
								$sql_3 = "INSERT INTO categoria_func(funcionario_idfuncionario,categoria_idcategoria) VALUES (".$row['idfuncionario'].", ".$selected.")";
								echo "<p>query :".$sql_3." <br>".$selected."</p>";
								$statement = $conPdo->query($sql_3);
								
							} catch (PDOException $e) {
								die("erro".$e->getMessage());
							}
						}						
						
					}else{
						echo "Já não tem mais categorias para associar.";
					}
				
				
				$conPdo->commit();
				//echo "successful";				
				if($flag){
					echo "<script type='text/javascript'>						
							refresh('".$gestao."gestaoFunc.php');					
						</script>";
				}else{
					echo "<script type='text/javascript'>						
							refresh('".$gestao."gestaoAluno.php');					
						</script>";
						
				}
			}


		} catch (PDOException $e) {
			$conPdo->rollBack();
			die("erro".$e->getMessage());
		}
	}
?>
	
<script type="text/javascript">
	//variavel onde guarda o valor da super array variavel get['tipo']
	var get = <?php echo $_GET['tipo'];?>;

	$(document).ready(function(){	

		//faz desaparecer a imagem do registo quando se clica no botão reset
		$('#reset').click(function() {
			$("#img-upload").remove();
		});

		$("#phone,#fiscalNumber,#email").keypress(function(event) {		

			if(event.which === 32){
				event.preventDefault();
			}
		});
		$("#phone,#fiscalNumber").keypress(function(e) {
	      if( (e.which < 48 || e.which >57) && e.which!= 127 && e.which!= 8){
	        e.preventDefault();
	      }
	    });

		$("#phone").keyup(function(){
			if($(this).val()!="" && $(this).val().length == 9){
				$("#phone_exist").html("");
			}else{
				$("#phone_exist").html("A caixa tem de ter 9 digitos");
			}			
		});

		$("#fiscalNumber").keyup(function(){
			if($(this).val()!="" && $(this).val().length == 9){
				$("#fiscalNumber_exist").html("");
			}else{
				$("#fiscalNumber_exist").html("A caixa tem de ter 9 digitos");
			}			
		});

		

		// verifica que tipo de botão foi clicado. Se de alunos se de funciorarios
		if(get==0){
			$("#tipoAluno").hide();
			$("#progresso").hide();

			$("#submit_editar").click(function(event) {
				if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!="" && $("#phone_exist").html()==""&& $("#fiscalNumber_exist").html()=="" ){
					$.ajax({
				  type: "POST",
				  url: "Gestao/editar_final.php?tipo=0&enviar=1&idpessoa="+$("#hidden_id").val(),
				  data: $("#formulario_editar").serialize(),
				  success: function(data){
				  	$("#subConteudo").html(data);
				  }
			  
				});
				}else{
					alert("Preencha todos os campos.");
				}	
			});


		}else{
			$("#tipoInstrutor").hide();	
			$("#categoria_instrutor").hide();
			$("#eleminar_div").hide();

			$("#submit_editar").click(function(event) {
					if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!="" && $("#phone_exist").html()==""&& $("#fiscalNumber_exist").html()==""){
				$.ajax({
				  type: "POST",
				  url: "Gestao/editar_final.php?tipo=1&enviar=1&idpessoa="+$("#hidden_id").val(),
				  data: $("#formulario_editar").serialize(),
				  success: function(data){
				  	$("#subConteudo").html(data);
				  }
			  
				});
			}else{
				alert("Preencha todos os campos.");
			}
			});
		}


		//código para garantir que quando é para adicionar um registo do funcionario ele tem que 
		//selecionar pelo menos uma checkbox
		if($("#tipoInstrutor").is(":visible")){	
			
			$("input[type=submit]").click(function(){
				var checked = $("input[type=checkbox]:checked").length;
				if(!checked){
					$("#tipoInstrutor").append("<span class='help-block'>Tem de selecionar pelo menos uma das caixas.</span>");
				}
			});
		}
		
		var date = new Date();
		date.setFullYear( date.getFullYear() - 16 );
		var menos16 = date.getFullYear() +"-"+ (date.getMonth()+1) + '-' + date.getDate()  ;
		$("#birthDate").attr('max', menos16);
			

	});
	
</script>
