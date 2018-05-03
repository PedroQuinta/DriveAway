<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Gestão de Veículos</title>
	<style type="text/css">
		#vehicle_content{
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
		#add_record{
			margin-left: 5px;
			margin-bottom: 5px;
			margin-top: 5px;
		}
		#vehicle_info{float: left; width: 750px; margin-left: 150px;}
	</style>
</head>
<body>
	<div id="add_record" class="row row-content align-items-left">
		<a href="#" data-url="register_vehicle.php" class="btn btn-success pull-left">Adicionar Veiculo</a>
	</div>	
	
	<div id="vehicle_content" class="container">
		
		<h4>Lista de Veículos: </h4>
		<table>
			<?php  

				include 'config.php';

				try {
					$query_get_vehicle="SELECT * FROM veiculo where activo <> false ORDER BY marca ASC";
					$stmt = $conPdo->query($query_get_vehicle);
					if($stmt->execute()){
						if($stmt->rowCount() > 0){
							while ($row_vehicle = $stmt->fetch()) {
								echo "<tr>";	
									echo "<td><a href='#' data-url='editar_veiculo.php?idveiculo=".$row_vehicle['idveiculo']."'>".$row_vehicle['marca']."-".$row_vehicle['modelo']."</a></td>";
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
	<div id="vehicle_info"></div>
	<script type="text/javascript">		

		
		$("td a,#add_record a").click(function(event) {
			$("#vehicle_info").load($(this).data("url"));
		});	
		
		
		
		$(document).on("click", "#atualiza_veiculo", function(){				
			if($("#marca").val()!="" && $("#modelo").val()!="" && $("#matricula").val()!=""){
				$.ajax({
				  type: "POST",
				  url: "editar_veiculo.php?teste=1&idveiculo="+$("#hidden_id_vehicle").val(),
				  data: $("#formulario_veiculo_editar").serialize(),
				  success: function(cenas){
				  	$("#vehicle_info").html(cenas);
				  }
			  
				});
			}else{
				alert("Preencha todos os campos.");
			}

						
		});
		
	</script>
</body>
</html>