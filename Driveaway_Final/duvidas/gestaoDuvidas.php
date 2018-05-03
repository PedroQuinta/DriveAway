<!DOCTYPE html>
<html>
<head>
	
	<title>Duvidas?</title>

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
			 
			width: 50vw;
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
		@media screen and (max-width: 900px) {
           	#subConteudo{margin-left: 0px; margin-right: 0px; float: left; width: 50vw;}
           	#lista{width: 200px;}

        }



        td{overflow:hidden;white-space: nowrap; text-overflow: ellipsis;}
        a.green:link,a.green:visited,a.green:hover,a.green:active{color: green;}
        a.orange:link,a.orange:visited,a.orange:hover,a.orange:active{color: orange;}
        

	</style>

</head>
<body>
	<div id="lista" class="container">
		
		<h4>Lista de Dúvidas</h4>
		<table id="records_table">			
			<?php
				
			 	include '../config.php';//adicionar dir principal
				//buscar lista de funcionarios à base de dados.	
				
				try {

					session_start();	

					if($_SESSION['tipo'] == "aluno"){
						echo "<button type='button' data-url='duvidas/fazerPergunta.php' class='btn btn-success pull-left' name='nPergunta' id='nPergunta'>Nova Duvida</button>";
						/*
						if (isset($_POST['nPergunta'])){
							header('location: /fazerPergunta.php');
						}
						*/
						$sql = "SELECT idpergunta, titulo, pergunta,respondido FROM pergunta WHERE aluno_idaluno =".$_SESSION['id_tipo']." ORDER BY respondido ASC,titulo ASC";
					}
					else{
						$sql = "SELECT idpergunta, titulo, pergunta,respondido FROM pergunta WHERE funcionario_idfuncionario =".$_SESSION['id_tipo']." ORDER BY respondido ASC,titulo ASC";
					}

					
					
					/*
					var_dump($sql);
					exit;
					*/
				
					$stmt = $conPdo->query($sql);
					$stmt->execute();
					
					$r = $stmt->fetch(PDO::FETCH_ASSOC);
					
					foreach($conPdo->query($sql) as $r){				
						echo "<tr>";
						if($r['respondido'] == true){
							echo "<td><a class='green'href='#' data-url='duvidas/fazerPergunta.php?id=".$r['idpergunta']."'>".$r['titulo']."</a></td>";
						
						}
						else{
							echo "<td><a href='#' class='orange' data-url='duvidas/fazerPergunta.php?id=".$r['idpergunta']."'>".$r['titulo']."</a></td>";

						}
						echo "</tr>";
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
		$("td a,#nPergunta").click(function(event) {
			$("#subConteudo").load($(this).data("url"), function(){});
			//event.stopImmediatePropagation();

		});	
	</script>
		
	
	
</body>
</html>