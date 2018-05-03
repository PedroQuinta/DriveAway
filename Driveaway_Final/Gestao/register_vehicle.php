<?php  
	session_start();
	
	
	include "../config.php";
	$gestao = "Gestao/";
	if(isset($_GET['teste'])){
		

		$txtMarca = $txtModelo = $txtMatricula = "";

		$txtMarca_err = $txtModelo_err = $txtMatricula_err = "";

		if(empty($_POST['marca'])){
			$txtMarca_err = "Insira uma marca.";
		}else{
			$txtMarca = $_POST['marca'];
		}

		if(empty($_POST['modelo'])){
			$txtModelo_err = "Insira um modelo.";		
		}else{
			$txtModelo = $_POST['modelo'];
		}

		if(empty($_POST['matricula'])){
			$txtMatricula_err = "Insira uma matricula";
		}else{
			$txtMatricula = $_POST['matricula'];
		}

		if(empty($txtMatricula_err) && empty($txtModelo_err) && empty($txtMarca_err)){
			

			try {
				
				$conPdo->beginTransaction();

				$query_vehicle = "INSERT INTO veiculo (marca, modelo, matricula, categoria_idcategoria) VALUES (:marca, :modelo, :matricula, :categoria_idcategoria)";

				if($stmt = $conPdo->prepare($query_vehicle)){

					$stmt->bindParam(':marca', $param_marca, PDO::PARAM_STR);
					$stmt->bindParam(':modelo', $param_modelo, PDO::PARAM_STR);
					$stmt->bindParam(':matricula', $param_matricula, PDO::PARAM_STR);
					$stmt->bindParam(':categoria_idcategoria', $param_categoria_idcategoria, PDO::PARAM_STR);


					$param_marca = $txtMarca;
					$param_matricula = $txtMatricula;
					$param_modelo = $txtModelo;
					$param_categoria_idcategoria = $_POST['veiculo_categoria'];
					if($stmt->execute()){
						echo "veiculo adicionado com sucesso";
						$conPdo->commit();
						echo "<script type='text/javascript'>						
								refresh('".$gestao."gestaoVeiculo.php');					
							</script>";
					}

				}
			} catch (PDOException $e) {
				$conPdo->rollBack();
				die("Erro ao executar a query $query_vehicle".$e->getMessage());
			}

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registar Veículos</title>
</head>
<body>
	<center><h2><strong>Registo de Veículos</strong></h2></center>
<br>
<form action='<?php echo $_SERVER['PHP_SELF'];?>' method="post" id="formulario_veiculo">

	<div class="container-fluid">
		<div class="col-md-7">
			<div class="form-group">
				<label for="marca">Marca:</label>
				<input type="text" id="marca" name="marca" class="form-control" value="<?php echo $_POST['marca'];?>">
				<span class="help-block"><?php echo $txtMarca_err; ?></span>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<label for="modelo">Modelo:</label>
				<input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $_POST['modelo'];?>">
				<span class="help-block"><?php  echo $txtModelo_err; ?></span>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="col-lg-4">	
			<div class="form-group">
				<label for="matricula">Matricula:</label>
				<input type="text" title="xx-xx-xx" pattern="^[A-Z0-9]{2}-?[A-Z0-9]{2}-?[A-Z0-9]{2}$" id="matricula" name="matricula" class="form-control" value="<?php echo $_POST['matricula'];?>">
				<span class="help-block"><?php echo $txtMatricula_err; ?></span>
			</div>
		</div>
		<div class="col-lg-4">	
			<div class="form-group">
				<label for="veiculo_categoria">Categoria:</label>
				<select id="veiculo_categoria" name="veiculo_categoria">
					<?php  

						try {
							$sql = "SELECT idcategoria, designacao FROM categoria";
							$statement=$conPdo->query($sql);		

							while($result = $statement->fetch()){
								echo "<option value='".$result['idcategoria']."'>".$result['designacao']."</option>";
							}


						} catch (PDOException $e) {
							die("Erro.".$e->getMessage());
						}

					?>
				</select>				
				<span class="help-block"><?php echo $veiculo_categoria_err; ?></span>
			</div>
		</div>
	</div>	
	<div class="container-fluid">
		<div class="col-lg-3">
			<div class="form-group" id="botoes_veiculo">
            	<input type="button" class="btn btn-primary" id="submit_veiculo" name="submit_veiculo" value="Enviar">
            	<input type="reset" class="btn btn-default" id="reset" value="Reset">
        	</div>
    	</div>	        	
    </div>                 
</form>
<script type="text/javascript">
	
	$("#submit_veiculo").click(function(){
			
					
			if($("#marca").val()!="" && $("#modelo").val()!="" && $("#matricula").val()!=""){

				var form = $("#formulario_veiculo");
				console.log(form);				
				
				$.ajax({
				  type: "POST",
				  url: "Gestao/register_vehicle.php?teste=1",
				  data: $("#formulario_veiculo").serialize(),			 
				  success: function(cenas){
				  	console.log(cenas);
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