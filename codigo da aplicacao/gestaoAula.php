<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>gestao de funcionarios</title>
	<style type="text/css">
		#lista{
			float: left;
			width: 250px;
			height: 500px;			
			margin-right: 15px;
			margin-left: 5px;
			overflow-y: scroll;			
		}
		table{
			margin-top: 50px;			
		}
		#subConteudo{
			float: left;			 
			width: 850px;
			margin-left: 50px;
			

		}
		.btn-success{
			margin-left: 5px;
		}		
		.navbar-inverse{
			margin-bottom: 0px !important;
		}
					
	</style>
</head>
<body>		
	<div id="lista" class="container">
		
		<h4>Lista de Funcionarios:</h4>
		<table id="records_table">			
			<?php
				
			 	include 'config.php';//adicionar dir principal
				//buscar lista de funcionarios à base de dados.	
				
				try {
					$sql = "SELECT idfuncionario, pessoa_idpessoa, idpessoa, nome 
					FROM funcionario, pessoa 
					WHERE funcionario.pessoa_idpessoa=pessoa.idpessoa AND
						administrador = FALSE AND activo <> false
					 ORDER BY nome ASC";
					$stmt=$conPdo->query($sql);					
					if($stmt->execute()){						
						if($stmt->rowCount() > 0){							
							while($row=$stmt->fetch()){
								echo "<tr>";
									echo "<td><img data-url='calendario/calendario.php?tipo=funcionario&id_tipo=".$row['idfuncionario']."' src='user_images/".$row['pessoa_idpessoa'].".png' width='50px' height='50px' style='border-radius: 50%'></td>";
									echo "<td><a href='#' data-url='calendario/calendario.php?tipo=funcionario&id_tipo=".$row['idfuncionario']."'>&nbsp;".$row['nome']."</a></td>";							
								echo "</tr>";
							}
						}
					}
				} catch (PDOException $e) {
					die("Erro".$e->getMessage());
				}
				
			?>
		</table>
	</div>
	<div id="subConteudo">
			
	</div>
	<script type="text/javascript">
		
		$("td a,td img").click(function(event) {
			$("#subConteudo").load($(this).data("url"), function(){});
			//event.stopImmediatePropagation();

		});	

		/*
		$(document).on("click", "#submit", function(){				
			if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!="" && $("#username").val()!="" && $("#password").val()!="" && $("#username_exist").html()=="Disponível"){

				var form = $("#formulario")[0];
				//console.log(form);				
				var formData = new FormData(form);
				
				//console.log(formData);
				
				$.ajax({
				  type: "POST",
				  url: "register_final_html.php?tipo=0",
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

		$(document).on("click", "#submit_editar", function(){				
			if($("#nome").val()!="" && $("#fiscalNumber").val()!="" && $("#phone").val()!="" && $("#email").val()!="" && $("#birthDate").val()!="" && $("#address").val()!=""){
				$.ajax({
				  type: "POST",
				  url: "editar_final.php?tipo=0&enviar=1&idpessoa="+$("#hidden_id").val(),
				  data: $("#formulario_editar").serialize(),
				  success: function(data){
				  	$("#subConteudo").html(data);
				  }
			  
				});
			}else{
				alert("Preencha todos os campos.");
			}						
		});
		*/
	</script>	
</body>
</html>
