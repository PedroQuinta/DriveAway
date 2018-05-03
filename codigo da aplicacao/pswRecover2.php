<?php
	
		
		if (empty($_POST['mail'])){
			
		}
		else{				
			
		
			include 'config.php';
			try {
				$query = "SELECT idpessoa, nome, email FROM pessoa WHERE email ='".$_POST['mail']."'";
				$stmt = $conPdo->query($query);

				$stmt->execute();
				//echo $stmt->rowCount(); 
				

				//var_dump($query);
				
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				//var_dump($user);
				
				if ($_POST['mail'] == $user['email']){

					include 'mailer.php';

					//$url = __DIR__."pswRecover3.php?id=".$user['idpessoa']."&email=".$user['email'];
					
					//$url =  "localhost/".$_SERVER['REQUEST_URI']."pswRecover3.php?id=".$user['idpessoa']."&email=".$user['email'];
					//
					$url = $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/pswRecover3.php?id=".$user['idpessoa']."&email=".$user['email'];

					$mensagem = "<h1 style='color:blue;'>Redefinir palavra-passe</h1>";
					$mensagem .=  "<p>click ";
					$mensagem .= "<a href=".$url.">AQUI</a> para redefenir a sua palavra-passe</p>";

					$titulo = "redefenir a password";

					
					//problemas com gmail . 
					$endreco = array($user['email']);
//					sendmail($endreco, $titulo, $mensagem);

					echo "<p>porfavor verifique o seu email</p>";
					exit;
				}
			} catch (PDOException $e) {
				die("Erro.".$e->getMessage());
				exit;	
			}
			
			
		}
	
	
?>
<style type="text/css">
	.form_recovery{
		display: inline-block;
	}
	.form_recovery label{
		margin-left: 10px;
	}
</style>	
<form class="form_recovery" method="post" id="recup_form">
	<div class="form_recovery form-group row">
		<label for="mail">Email para envio de nova password:</label>
		<div class="form-check-label col-12 col-sm-10">
			
			<input type="text" id="mail" name="mail" value="<?php if(isset($_POST['mail'])){echo $_POST['mail'];}?>">
			<br>
			<help-block><?php if (empty($_POST['mail'])){echo "Preencha com seu email!";} ?></help-block>
			
		</div>
	</div>
	<div class="form-group-row">
		<div class="offset-2 col-sm-10">
			<button type="button" class="btn btn-primary" name="btn_mail" id="btn_mail">Enviar</button>
		</div>
	</div>					
</form>  