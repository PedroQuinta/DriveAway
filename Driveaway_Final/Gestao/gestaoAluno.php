<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>gestao de alunos</title>
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
		#add_record{
			margin-left: 5px;
			margin-bottom: 5px;
			margin-top: 5px;
		}

 		 @media screen and (max-width: 1300px) {
           	#subConteudo{margin-left: 0px; margin-right: 0px; float: right; width: 750px;}
           	#lista{width: 200px;}   
        }
	</style>
</head>
<body>
	<div id="add_record" class="row row-content align-items-left">
		<a href="#" data-url="Gestao/register_final_html.php?tipo=1" class="btn btn-success pull-left">Adicionar Registo</a>
	</div>	
	
	<div id="lista" class="container">
		
		<h4>Lista de Alunos:</h2>
		<table>			
			<?php 
			 	include '../config.php';//adcicionat dir principal
				//buscar lista de funcionarios à base de dados.	
				$gestao = "Gestao/";
				try {
					$sql = "SELECT idpessoa, nome, pessoa_idpessoa FROM pessoa, aluno WHERE aluno.pessoa_idpessoa=pessoa.idpessoa AND aluno.estado_idestado <> 3 AND aluno.estado_idestado <> 4 ORDER BY nome ASC";
					$stmt=$conPdo->query($sql);					
					if($stmt->execute()){						
						if($stmt->rowCount() > 0){							
							while($row=$stmt->fetch()){
								echo "<tr>";
									echo "<td><img data-url='".$gestao."editar_final.php?tipo=1&idpessoa=".$row['idpessoa']."' src='user_images/".$row['pessoa_idpessoa'].".png' width='50px' height='50px'></td>";
									echo "<td><a href='#' data-url='".$gestao."editar_final.php?tipo=1&idpessoa=".$row['idpessoa']."'>".$row['nome']."</a></td>";

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
	
		$("td a,#add_record a,td img").click(function(event) {
			$("#subConteudo").load($(this).data("url"), function(){});
			//event.stopImmediatePropagation();

		});		
		
	</script>	
</body>
</html>