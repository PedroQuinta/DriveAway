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
			 
			width: 750px;
			margin-left: 150px; 

		}
		.btn-success{
			margin-left: 5px;
		}
		#add_record{
			margin-left: 5px;
			margin-bottom: 5px;
			margin-top: 5px;
		}	
		
				
	</style>
</head>
<body>
	<div id="add_record" class="row row-content align-items-left">
		<a href="#" data-url="register_final_html.php?tipo=0" class="btn btn-success pull-left">Adicionar Registo</a>
	</div>		
	<div id="lista" class="container">
		
		<h4>Lista de Funcionarios:</h4>
		<table id="records_table">			
			<?php
				
			 	include 'config.php';//adicionar dir principal
				//buscar lista de funcionarios à base de dados.	
				
				try {
					$sql = "SELECT idfuncionario, pessoa_idpessoa, idpessoa, nome FROM funcionario, pessoa 
					WHERE funcionario.pessoa_idpessoa=pessoa.idpessoa AND
						administrador = FALSE AND activo <> false
					 ORDER BY nome ASC";
					$stmt=$conPdo->query($sql);					
					if($stmt->execute()){						
						if($stmt->rowCount() > 0){							
							while($row=$stmt->fetch()){
								echo "<tr>";
									echo "<td><img data-url='editar_final.php?tipo=0&idpessoa=".$row['idpessoa']."' src='user_images/".$row['pessoa_idpessoa'].".png' width='50px' height='50px' style='border-radius: 50%'></td>";
									echo "<td><a href='#' data-url='editar_final.php?tipo=0&idpessoa=".$row['idpessoa']."'>&nbsp;".$row['nome']."</a></td>";
									
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
		/*
		$(document).on("click", "a", function(){
			$("#subConteudo").load($(this).data("url"), function(){

			});
			event.stopImmediatePropagation();
		});
		$(document).on("click", "td img", function(){
			$("#subConteudo").load($(this).data("url"), function(){
				
			});
			event.stopImmediatePropagation();
		});
		*/
	
		$("td a,#add_record a,td img").click(function(event) {
			$("#subConteudo").load($(this).data("url"), function(){});
			//event.stopImmediatePropagation();

		});		
		
		/*
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
