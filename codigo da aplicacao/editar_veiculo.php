<?php  
	include 'config.php';

	if(isset($_GET['idveiculo'])){
		try {
			
			$sql = "SELECT * FROM veiculo WHERE idveiculo=".$_GET['idveiculo'];
			$stmt=$conPdo->query($sql);					
			if($stmt->execute()){
									
				if($stmt->rowCount() == 1){
												
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					
			
			echo "<input type='hidden' id='hidden_id_vehicle' value='".$_GET['idveiculo']."'>";
		
		
	
?>


<center><h2><strong>Atualização de Veículos</strong></h2></center>
<br>
<form action="" method="post" id="formulario_veiculo_editar">

	<div class="container-fluid">
		<div class="col-md-7">
			<div class="form-group">
				<label for="marca">Marca:</label>
				<input type="text" id="marca" name="marca" class="form-control" value="<?php if(isset($row['marca'])) echo $row['marca']; ?>">
				<span class="help-block"><?php echo $txtMarca_err; ?></span>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<label for="modelo">Modelo:</label>
				<input type="text" id="modelo" name="modelo" class="form-control" value="<?php if(isset($row['modelo'])) echo $row['modelo']; ?>">
				<span class="help-block"><?php echo $txtModelo_err; ?></span>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="col-lg-4">	
			<div class="form-group">
				<label for="matricula">Matricula:</label>
				<input type="text" title="xx-xx-xx" id="matricula" name="matricula" class="form-control" value="<?php if(isset($row['matricula'])) echo $row['matricula']; ?>">
				<span class="help-block"><?php echo $txtMatricula_err; ?></span>
			</div>
		</div>
		<div class="col-lg-4">
			Deseja eliminar este registo? <input type="checkbox" name="eliminar" id="eliminar">
		</div>
	</div>
	<div class="container-fluid">
		<div class="col-lg-3">
			<div class="form-group" id="botoes_veiculo_edit">
            	<input type="button" class="btn btn-primary" id="atualiza_veiculo" name="atualiza_veiculo" value="Atualizar">            	
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

	if(isset($_POST['marca'])){
		try {

			$conPdo->beginTransaction();
			$sql_update = "UPDATE veiculo SET marca = :marca, modelo = :modelo, matricula = :matricula, activo=:activo WHERE idveiculo=".$_GET['idveiculo'];
			
			$stmt_update = $conPdo->prepare($sql_update);
			
			
			$stmt_update->bindParam(":marca", $param_marca, PDO::PARAM_STR);
			$stmt_update->bindParam(":modelo", $param_modelo, PDO::PARAM_STR);
			$stmt_update->bindParam(":matricula", $param_matricula, PDO::PARAM_STR);
			$stmt_update->bindParam(":activo", $param_activo, PDO::PARAM_STR);

			$param_marca = $_POST["marca"];
			$param_modelo = $_POST["modelo"];
			$param_matricula = $_POST["matricula"];	
			if(isset($_POST['eliminar'])){
				$param_activo= false;
			}
			else{
				$param_activo= true;
			}		
			
			$stmt_update->execute();
			$conPdo->commit();
			echo "<script type='text/javascript'>						
								refresh('gestaoVeiculo.php');					
							</script>";
			

		} catch (PDOException $e) {
			$conPdo->rollBack();
			die("erro".$e->getMessage());
		}
	
	}

	



?>