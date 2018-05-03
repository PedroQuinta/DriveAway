<?php
	//verifies if the global variable POST['nome'] is defined, if it is, includes register_final.php
   // this is important because we are not verifying if the form is set by the normal submit button way
 	
	if (isset($_POST['nome'])) {
		include "register_final.php";
	}

?>
<style>
	.help-block{
		color: red;
	}
	#foto_perfil, #foto_atestado{
		width: 100px;
		height: 80px;
		opacity: 0;
		overflow: hidden;
		position: absolute;
		z-index: -1;
	}
	
	#urlFile, #urlFile_2{
		height: 39px;
	}	
</style>
<center><h2><strong>Registo de Utilizadores</strong></h2></center>
<br>
<form action='#' method="post" id="formulario">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="col-md-6">
				<div class="form-group">
					<label for="foto_perfil">Upload de Foto da Pessoa:</label>
					<div class="input-group">
						<span class="input-group-btn">			
							<span class="btn btn-default btn-file">
								<input class="form-group" type="file" name="foto_perfil" id="foto_perfil" value="<?php echo $_POST['foto_perfil']; ?>">
								<label for="foto_perfil">Procurar...</label>	
							</span>
						</span>
						<input id="urlFile" type="text" class="form-control" value="<?php echo $_POST['foto_perfil']; ?>" readonly>						
					</div>
					<span class="help-block"><?php echo $foto_perfil_err; ?></span>		
				</div>
			</div>		
			<div class="col-md-6" id="atestado">
				<div class="form-group">
					<label for="foto_atestado">Upload de Atestado Médico:</label>
					<div class="input-group">
						<span class="input-group-btn">			
							<span class="btn btn-default btn-file">
								<input class="form-group" type="file" name="foto_atestado" id="foto_atestado" value="<?php echo $_POST['foto_atestado']; ?>">
								<label for="foto_atestado">Procurar...</label>	
							</span>
						</span>
						<input id="urlFile_2" type="text" class="form-control" value="<?php echo $_POST['foto_atestado']; ?>" readonly>					
					</div>
					<span class="help-block"><?php echo $atestado_err; ?></span>		
				</div>
			</div>		
		</div>	
		<div class="container-fluid">
			<div class="col-md-7">
				<div class="form-group">
					<label for="nome">Nome Completo:</label>
					<input type="text" id="nome" name="nome" class="form-control" value="<?php echo $_POST['nome']; ?>">
					<span class="help-block"><?php echo $txtName_err; ?></span>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label for="fiscalNumber">Contribuinte:</label>
					<input type="text" id="fiscalNumber" name="fiscalNumber" class="form-control" value="<?php echo $_POST['fiscalNumber']; ?>">
					<span id="fiscalNumber_exist"></span>
					<span class="help-block"><?php echo $numFiscalNumber_err; ?></span>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="col-lg-4">	
				<div class="form-group">
					<label for="phone">Telefone:</label>
					<input type="tel" pattern="^\d{9}" title="xxxxxxxxx" id="phone" name="phone" class="form-control" value="<?php echo $_POST['phone']; ?>">
					<span id="phone_exist"></span>
					<span class="help-block"><?php echo $numPhone_err; ?></span>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" class="form-control" value="<?php echo $_POST['email']; ?>">
					<span id="email_exist"></span>
					<span class="help-block"><?php echo $txtEmail_err; ?></span>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="col-lg-4"> 	
				<div class="form-group">
					<label>Data de Nascimento:</label>				
					<div class="input-group date " >
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>	
						<input type="date" name="birthDate" id="birthDate" class="form-control" value="<?php echo $_POST['birthDate']; ?>">								
					</div>
					<span class="help-block"><?php echo $dateBirthday_err; ?></span>				
				</div>
			</div>
			<div class="col-lg-6">
	            <div id="tipoInstrutor" class="form-group">
	           		<label for="btn1">Funcionário </label>
	           		<br>
	           		Teórico <input id="teo" type="checkbox" name="teo" <?php if (isset($_POST['teo'])) echo "checked"; ?>><br>
	           		Prático <input id="pra" type="checkbox" name="prat" <?php if (isset($_POST['prat'])) echo "checked"; ?>>    		
				</div>
			</div>
			<div class="col-lg-6">
				<div id ="tipoAluno" class="form-group">	
					<label>Data de Inscrição do Aluno:</label>
	           		<div class="input-group date" >           			
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>	
						<input type="date" id="datainsc" name="dataInsc" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>								
					</div>				
	            </div>
	        </div>
	    </div>
	    <div class="container-fluid">   
        	<div class="col-lg-6">
        		<div id ="categoria_instrutor" class="form-group">	
					<label>Categorias:</label>
					<div class="input-group">		
						<?php 
							include '../config.php';					
							session_start();							
							
							try {
							
								$sql = "SELECT *
										FROM categoria";
								$stmt=$conPdo->query($sql);
								
								if($stmt->execute()){
									if($stmt->rowCount()>0){
										while ($row_cat = $stmt->fetch()) {
											echo "<input type='checkbox' name='categorias[]' value='".$row_cat['idcategoria']."'>".$row_cat['designacao']." &nbsp";											
										}
									}else{
										echo "Não tem categorias para associar.";
									}
								}
							
							} catch (PDOException $e) {
								die("erro".$e->getMessage());
							}
							
							

						?>
							
					</div>
				</div>
			</div>
			<div class="col-lg-6" id="funcionarios">		
				<label>Instrutor:</label>
				<div class="input-group">

					<select name="instrutores">
						<?php 
							include '../config.php';
							session_start();
							try {
								$sql = "SELECT nome, idpessoa, idfuncionario, instrutorpratica, pessoa_idpessoa FROM pessoa,funcionario WHERE pessoa.idpessoa=funcionario.pessoa_idpessoa AND instrutorpratica=true AND administrador = FALSE AND activo <> false
							 		ORDER BY nome ASC";

								$stmt = $conPdo->query($sql);

								if ($stmt->execute()) {
									if ($stmt->rowCount() > 0) {
										while ($rowAux = $stmt->fetch()) {
											echo "<option value='" . $rowAux['idfuncionario'] . "'> " . $rowAux['nome'] . "</option>";
										}
									}
								}

								$result = $stmt->fetch(PDO::FETCH_ASSOC);

							} catch (PDOException $e) {
								die("erro" . $e->getMessage());
							}

						?>
					</select>
					
	            </div>
	        </div>        			
		</div>
		<div class="container-fluid">
			<div class="col-lg-12">
				<div class="form-group">
					<label>Morada:</label>
					<input type="text" name="address" id="address" class="form-control" value="<?php echo $_POST['address']; ?>">
					<span class="help-block"><?php echo $txtAddress_err; ?></span>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="col-lg-5">
				<div class="form-group">
					<label>Username:</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo $_POST['username']; ?>">
					<span id="username_exist"></span>
					<span class="help-block"><?php echo $txtUsername_err; ?></span>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="form-group">
					<label>Password:</label>
					<input type="text" name="password" id="password" class="form-control" readonly>
					<span class="help-block"><?php echo $pswPassword_err; ?></span>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="col-lg-3">
				<div class="form-group" id="botoes">
	            	<input type="button" class="btn btn-primary" id="submit" name="submit" value="Enviar">
	            	<input type="button" class="btn btn-default" id="reset" value="Reset"> 

	        	</div>
	    	</div>	        	
	    </div>
    </div>           
</form>
	
	
<script type="text/javascript">
	//variavel onde guarda o valor da super array variavel get['tipo']
	var get = <?php echo $_GET['tipo'];?>;
	

	$(document).ready(function(){
		function randomChar() {
			var text = "";
			var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
			for (var i = 0; i < 7; i++)
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			return text;
		}
		
		$('#password').val(randomChar());		
		
		function reset(){
			$('#formulario').find('input, select, checkbox').not("#password, input[type=button], #datainsc").val('');
		}
		$("#reset").click(function(event) {
			reset();
		});

		$("#username,#phone,#fiscalNumber,#email").keypress(function(event) {		

			if(event.which === 32){
				event.preventDefault();
			}
		});

		$("#phone,#fiscalNumber").keypress(function(e) {
	      if( (e.which < 48 || e.which >57) && e.which!= 127 && e.which!= 8){
	        e.preventDefault();
	      }
	    });

		$("#username").keyup(function(){
			if($(this).val()!=""){
				$.ajax({
				  type: "GET",
				  url: "validacoes/verificarUsername.php?username="+$(this).val(),		  
				  success: function(data){
				  	console.log(data);
				  	$("#username_exist").html(data);
				  }			  
				});	
			}else{
				$("#username_exist").html("");
			}			
		});

		$("#phone").keyup(function(){
			if($(this).val()!=""){
				if($(this).val().length != 9){
					$("#phone_exist").html("A caixa tem de ter 9 digitos");
				}else{
					$.ajax({
					  type: "GET",
					  url: "validacoes/verificarPhone.php?phone="+$(this).val(),		  
					  success: function(data){
					  	console.log(data);
					  	$("#phone_exist").html(data);
					  }			  
					});	
				}
			}else{
				$("#phone_exist").html("");
			}			
		});

		$("#fiscalNumber").keyup(function(){
			if($(this).val()!=""){
				if($(this).val().length != 9){
					$("#fiscalNumber_exist").html("A caixa tem de ter 9 digitos");
				}else{
					$.ajax({
					  type: "GET",
					  url: "validacoes/verificarFiscalNumber.php?fiscalNumber="+$(this).val(),		  
					  success: function(data){
					  	console.log(data);
					  	$("#fiscalNumber_exist").html(data);
					  }			  
					});
				}	
			}else{
				$("#fiscalNumber_exist").html("");
			}			
		});

		$("#email").keyup(function(){
			if($(this).val()!=""){
				$.ajax({
				  type: "GET",
				  url: "validacoes/verificarEmail.php?email="+$(this).val(),		  
				  success: function(data){
				  	console.log(data);
				  	$("#email_exist").html(data);
				  }			  
				});
					
			}else{
				$("#email_exist").html("");
			}			
		});


		var filename;	
		$('#foto_perfil').change(function(e){
            filename = e.target.files[0].name;
            $("#urlFile").val(filename);
        });
		var filename_2;
		$('#foto_atestado').change(function(e){
             filename_2 = e.target.files[0].name;
            $("#urlFile_2").val(filename_2);
        });
		
		// verifica que tipo de botão foi clicado. Se de alunos se de funciorarios
		if(get==0){
			$("#tipoAluno").hide();	
			$("#atestado").hide();
			$("#funcionarios").hide();		
			$("#submit").click(function(event) {
				if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!="" && $("#username").val()!="" && $("#password").val()!="" && $("#username_exist").html()=="Disponível" && $("#phone_exist").html()=="Disponível"&& $("#fiscalNumber_exist").html()=="Disponível" && $("#email_exist").html()=="Disponível"){

				var form = $("#formulario")[0];
						
				var formData = new FormData(form);
				
			
				$("#submit").attr("disabled", true);
				$.ajax({
				  type: "POST",
				  url: "Gestao/register_final_html.php?tipo=0",
				  data: formData,
				  contentType: false,
				  processData: false,
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

			$("#submit").click(function(event) {
				if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!="" && $("#username").val()!="" && $("#password").val()!="" && $("#username_exist").html()=="Disponível" && $("#phone_exist").html()=="Disponível"&& $("#fiscalNumber_exist").html()=="Disponível" && $("#email_exist").html()=="Disponível"){

				var form = $("#formulario")[0];
				//console.log(form);				
				var formData = new FormData(form);
				
				//console.log(formData);
				$("#submit").attr("disabled", true);
				$.ajax({
				  type: "POST",
				  url: "Gestao/register_final_html.php?tipo=1",
				  data: formData,
				  contentType: false,
				  processData: false,
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

			$("#submit").click(function(){
				var checked = $("input[type=checkbox]:checked").length;
				if(checked==0){
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
