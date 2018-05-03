<?php
	
	//Includes connection file
	include 'config.php';

    //Defines variables both the ones of the form parameters and the ones with the errors
    //Initializes them with empty values.
	$txtUsername = $pswPassword = "";
	$txtUsername_err = $pswPassword_err = "";
	
	//inicia a sessão
	session_start();

    //Processes the information of the form when it was submitted
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
		//verifies if the field username is empty
		if (empty($_POST['username'])) {
			$txtUsername_err = "Por favor insira um nome de utilizador.";
		}else{
			$txtUsername = $_POST['username'];
		}

        //verifies if the field password is empty
		if (empty($_POST['password'])) {
			$pswPassword_err = "Por favor insira uma password.";
		}else{
			$pswPassword = $_POST['password'];
		}

        //validates the credentials only if the error variables are empty
		if (empty($txtUsername_err) && empty($pswPassword_err)) {
			
			//$passHashed = password_hash($pswPassword, PASSWORD_BCRYPT);
			try {
				//prepares the statement
				$querySql = "SELECT idpessoa, username, password, nome FROM pessoa WHERE username=:username";		
				
				if ($stmt=$conPdo->prepare($querySql)) {
					
					
					//associates the variable with the parameters
					$stmt->bindParam(':username', $txtParam_username, PDO::PARAM_STR);				
					$txtParam_username = $txtUsername;
					
					 //tries to execute the statement
					if ($stmt->execute()) {							
						
                        //verifies if the username exists and if so, verifies the password
						if ($stmt->rowCount() == 1) {								
							if ($row = $stmt->fetch()) {
								
								                            
								if(password_verify($pswPassword, $row['password']) || $pswPassword === $row['password']){
									$_SESSION['nome'] = $row['nome'];
									$_SESSION['idpessoa'] = $row['idpessoa'];
									
	                                try{
	                                    //verify what type of user logged in
	                                    $queryVerifyUser ="SELECT * FROM funcionario WHERE pessoa_idpessoa=".$row['idpessoa'];
	                                     	

	                                    //prepares the statement
	                                    if ($newStmt = $conPdo->query($queryVerifyUser)){                                   

	                                        //keep the number of records with this id found
	                                        $numNumberOfRecords=$newStmt->rowCount();
	                                       
	                                        if ($numNumberOfRecords == 1){

	                                            //save result of query
	                                            $arrFuncionario = $newStmt->fetch();

	                                            //define again session variables needed for alert system
	                                            header("Cache-control: private");
	                                            $_SESSION["tipo"] = "funcionario";
	                                            $_SESSION["secretaria"]=$arrFuncionario["administrador"];
	                                            $_SESSION["instrutorTeorica"]=$arrFuncionario["instrutorteorica"];
	                                            $_SESSION["instrutorPratica"]=$arrFuncionario["instrutorpratica"];
	                                            $_SESSION['id_tipo']=$arrFuncionario['idfuncionario'];
	                                        	header('location: index.php');
	                                        }else{
	                                            //if it's not a Funcionario is an Aluno
	                                            $_SESSION["tipo"] = "aluno";
	                                            try {
	                                            	$query_aluno = "SELECT idaluno, pessoa_idpessoa FROM aluno WHERE pessoa_idpessoa=".$row['idpessoa'];
	                                            	
	                                            	$statement=$conPdo->query($query_aluno);
	                                            	
	                                            	$row_aluno = $statement->fetch();
	                                            	
	                                            	$_SESSION['id_tipo']=$row_aluno['idaluno'];

	                                            	header('location: index.php');
	                                            } catch (PDOException $e) {
	                                            	die("erro".$e->getMessage());
	                                            }
	                                            
	                                        }
	                                    }
	                                }catch(PDOException $e){
	                                    die("Erro: Não foi possivel executar a query $queryVerifyUser".$e->getMessage());
	                                }	
								}															
								
							}
						}else{
							//mostra uma mensagem de erro se o username não existir
							$username_err = "Não foi encontrado nenhum registo com esse nome de utilizador.";
						}
					
					}else{
						echo "Erro. Tente outra vez mais tarde.";
					}
					                
					
				}
				

			} catch (PDOException $e) {
				die("Erro: ".$e->getMessage());
			}

		}

	}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-social/bootstrap-social.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-social/assets/css/font-awesome.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	
	  
    <style type="text/css">
        
        .modal{        	
        	margin: auto;
        }
        .container-fluid{ 
        	width: 50%;        	
        	margin: auto;
        }
       
        .modal-body{
        	height: 170px;
        	display:block;
        	text-align: center;

        }
       
    </style>
</head>
<body>

	<div class="container-fluid">
		<h2>Login</h2>
		<p>Por favor preencha as credenciais para efetuar o login.</p>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			
				
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
				<label>Nome de Utilizador:<sup>*</sup></label>
				<input type="text" name="username" class="form-control" value="<?php  echo $_POST['username'];?>">
				<span class="help-block"><?php echo $username_err; ?></span>				
			</div>
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
				<label>Password: <sup>*</sup></label>
				<input type="password" name="password" class="form-control">
				<span class="help-block"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary" value="Enviar">
					
				<button class="btn btn-social-icon btn-facebook" id="facebook_login"><span class="fa fa-facebook"></span></button>
				<div id="status"></div>	
				
			</div>
			<div class="form-group">
				<a href="#" id="btn_recovery">Recuperar password ...</a>
			</div>
				
			
		</form>
	</div>

	<div class="modal fade" id="email_recovery" role="dialog">
	    <div class="modal-dialog">                    
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header">
	              
	              <h4 class="modal-title">Passo 1 - Email de Recuperação de password</h4>
	              <button type="button" class="close" data-dismiss="modal" >&times;</button>
	            </div>
	            <div class="modal-body" id="modal_body_email">
	            	            	
	            </div>
	        </div>    
	    </div>                      
    </div>


<script type="text/javascript">
$(document).ready(function(){
   var id;
   
    // initialize and set up facebook javascript sdk
    
    $(document).on('click', '#btn_recovery', function(){
        $.ajax({
          type: "GET",
          url: "pswRecover2.php",                      
          success: function(data){
            $("#modal_body_email").html(data);
            $("#email_recovery").modal();
          }              
        });
    });

    $(document).on('click', '#btn_mail', function(){
    	$(this).attr('disabled', true);
        $.ajax({
          type: "POST",
          url: "pswRecover2.php",
          data: $("#recup_form").serialize(),                      
          success: function(data){
            $("#modal_body_email").html(data);
          }              
        });
    });
    
    $(document).on("click", "#facebook_login", function(){      
      login();
      return false;
    });


      window.fbAsyncInit = function() {
        FB.init({
          appId      : '170697620345126',
          cookie     : true,
          xfbml      : true,        
          version    : 'v2.11'
        });
        
        FB.AppEvents.logPageView();  

          
        };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));


      function login(){

        FB.login(function(response){        
          //console.log("entrou aqui");
          if(response.status === "connected"){
            document.getElementById("status").innerHTML="Okay you are connected";
            info();
          }else if(response.status==="not_authorized"){
            document.getElementById("status").innerHTML="You are not connected.";
          }else{
            document.getElementById("status").innerHTML="You are not logged in facebook account.";
          }
        });
      }

      function info(){
         
         FB.api('/me','GET',{fields: 'name, email, id'}, function(response){
            
              id = response.id;             
              
              $.ajax({
                url: 'facebook.php?facebook_operation=2&response_id='+id,
                type: 'GET',                  
                success:function(data){
                  location.href="index.php";
                }
              });
         });
      }
       
})
	</script>
</body>
</html>
