<?php
	include 'config.php';
	if (isset($_POST["btn_atualizar_pass"])){

		
		if ($_POST["pass"] === $_POST["pass_conf"]){
			//altera os valores da base de dados
			echo "Coincidem!";
			//password_hash($pswPassword, PASSWORD_BCRYPT)
			$pass_nova = password_hash($_POST['pass'], PASSWORD_BCRYPT);
			try {
				$query_alterar = "UPDATE pessoa SET password='".$pass_nova. "' WHERE idpessoa=".$_POST['id']." AND email = '".$_POST['email']."'";	
			
			
			
			
			

			//executar query
				$stmt = $conPdo->query($query_alterar);
				$stmt ->execute();

				//alert("Password alterada com sucesso.");
				$url = $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
				var_dump($url);
				//header("location: ".$url."/login.php");	
				header("location: login.php");	
				
			} catch (PDOException $e) {
				die("Erro. ".$e->getMessage());
			}
			
					
		}
		else{
			echo "Não coincidem";
		}
	}
		
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Recuperar Password</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-social/bootstrap-social.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-social/assets/css/font-awesome.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

  	<style type="text/css">
        .container-fluid{ 
        	width: 50%;        	
        	margin: auto;
        }       
    </style>

 </head>
 <body>

	<div class="container-fluid">
		<h2>Recuperar Password</h2>
		<p>Por favor preencha a nova password.</p>
		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">	

			<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">		
			<input type="hidden" name="email" value="<?php echo $_GET['email'] ?>">		
				
			<div class="form-group">
				<label for="pass">Nova password:<sup>*</sup></label>
				<input type="password" id="pass" name="pass" class="form-control">
				<span class="help-block"><?php echo $password_err; ?></span>				
			</div>
			<div class="form-group">
				<label for="pass_conf">Confirmar nova password:<sup>*</sup></label>
				<input type="password" id="pass_conf" name="pass_conf" class="form-control">
				<span class="help-block"><?php echo $password2_err; ?></span>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary" name="btn_atualizar_pass" id="btn_atualizar_pass">Alterar</button>				
			</div>

		</form>
	</div>

</body>
</html>

	
