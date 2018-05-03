<?php  
	session_start();
	//error_reporting(E_ALL);
	//ini_set('display_errors', true);
	//ini_set('display_startup_errors', true);
	//ini_set('memory_limit', '-1');
	//includes the connection to the BD file
	require_once "../config.php";
	
	$gestao = "Gestao/";
	//define variables and initialize them with zero
	$txtName = $numPhone = $txtEmail = $atestado =  $dateBirthday = $txtAddress = $txtUsername = $pswPassword = $pswConfirmPassword = $numFiscalNumber = $imgFile = $tmp_dir = $imgSize ="";

	$txtName_err = $numPhone_err = $txtEmail_err = $atestado_err = $dateBirthday_err = $txtAddress_err = $txtUsername_err = $pswPassword_err = $pswConfirmPassword_err = $numFiscalNumber_err= $imgFile_err = "";
		//$_GET['tipo']==0)
		if (!empty($_FILES['foto_atestado']) || $_GET['tipo'] == 0) {
			$atestado = $_POST['foto_atestado'];
		} else {
			$atestado_err = "Por favor insira o atestado médico.";
		}

		if (empty($_FILES['foto_perfil'])) {
			$foto_perfil_err = "Por favor insira uma foto.";
		} else {
			$foto_perfil = $_POST['foto_perfil'];
		}


		//profile Image validation
		if(empty($imgFile)){
			$imgFile_err = "Por favor insira uma foto de registo.";
		}
	
		//name validation
		if (empty($_POST['nome'])) {
			$txtName_err = "Por favor preencha o campo do nome.";
		}else{
			$txtName = $_POST['nome'];
		}

		//phone number validation
		if (empty($_POST['phone'])) {
			$numPhone_err = "Por favor preencha o phone";
		}elseif(strlen($_POST['phone']) != 9){
			$numPhone_err = "O número de telefone tem de ter 9 digitos.";
		}elseif(!is_numeric($_POST['phone'])){		
			$numPhone_err = "O telefone não pode ter letras";
		}else{
			$numPhone = $_POST['phone'];
		}

       //fiscalNumber validation
       if (empty($_POST['fiscalNumber'])) {
           $numFiscalNumber_err = "Por favor preencha o Contribuinte";
       }elseif(strlen($_POST['fiscalNumber']) != 9){
           $numFiscalNumber_err = "O número de Contribuinte tem de ter 9 digitos.";
       }elseif (!is_numeric($_POST['fiscalNumber'])) {
           $numFiscalNumber_err = "Não inseriu um número.";
       }else{
           $numFiscalNumber = $_POST['fiscalNumber'];
       }

       //email validation
       if (empty($_POST['email'])) {
           $txtEmail_err = "Por favor preencha o email.";
       }else{
           $txtEmail = $_POST['email'];
       }


       //birth date validation
       if (empty($_POST['birthDate'])) {
           $dateBirthday_err = "Por favor preencha a data de nascimento.";
       }else if(time() < strtotime('+15 years', strtotime($_POST['birthDate']))){
	       $dateBirthday_err = "Erro. Idade inferior a 15 anos.";
	   }else{
           $dateBirthday = $_POST['birthDate'];
       }

       //address validation
       if (empty($_POST['address'])) {
           $txtAddress_err = "Por favor preencha a address";
       }else{
           $txtAddress = $_POST['address'];
       }


       //username validation
       if (empty($_POST['username'])) {
           $txtUsername_err = "Por favor insira um name.";
       }

       //password validation
       if (empty($_POST['password'])) {
           $pswPassword_err = "Por favor preencha uma password.";
       }elseif(strlen($_POST['password']) < 6){
           $pswPassword_err = "A Password tem que ter no minimo 6 caracteres.";
       }else{
           $pswPassword = $_POST['password'];
       }

       	$txt_username = $_POST['username'];
		//verifies if there are input error before inserting into the BD
		if (!empty($txt_username) && empty($pswPassword_err) && empty($txtName_err) && empty($txtEmail_err) 
		&& empty($txtAddress_err) && empty($dateBirthday_err) && empty($numFiscalNumber_err) 
		&& empty($numPhone_err) && empty($atestado_err) && empty($foto_perfil_err)) {
			
			//creates pessoa
			try {
				echo "<p>entrou no try que de transaction</p>";
				 // START TRANSATION
        		$conPdo->beginTransaction();
				//query with a prepared statement
				$queryInsert = "INSERT INTO pessoa (nome, telefone, email, datanascimento, morada, username, password, contribuinte) VALUES (:nome, :phone, :email, :birthDate, :address, :username, :password, :fiscalNumber)";
				
				if ($stmtSD=$conPdo->prepare($queryInsert)) {
				
					//sets up the variables by binding up to the parameters
					$stmtSD->bindParam(':nome', $txtParam_name, PDO::PARAM_STR);
					$stmtSD->bindParam(':phone', $numParam_phone, PDO::PARAM_STR);
					$stmtSD->bindParam(':email', $txtParam_email, PDO::PARAM_STR);
					$stmtSD->bindParam(':birthDate', $dateParam_birthday, PDO::PARAM_STR);
					$stmtSD->bindParam(':address', $txtParam_address, PDO::PARAM_STR);
					$stmtSD->bindParam(':username', $txtParam_username, PDO::PARAM_STR);
					$stmtSD->bindParam(':password', $pswParam_password, PDO::PARAM_STR);
					$stmtSD->bindParam(':fiscalNumber', $numParam_fiscalNumber, PDO::PARAM_STR);
					

					
					//parameters
					$txtParam_name = $txtName;
					$numParam_phone = $numPhone;
					$txtParam_email = $txtEmail;
					$dateParam_birthday = $dateBirthday;
					$txtParam_address = $txtAddress;
					
					//hashed the password using the bcrypt algorithm that PHP offers, it randomly generates salts				
					$pswHash = password_hash($pswPassword, PASSWORD_BCRYPT);
					$pswParam_password = $pswHash;
					$txtParam_username = $txt_username;
					$numParam_fiscalNumber = $numFiscalNumber;
					
					
					
					
						//tries to execute the statement
					
						if ($stmtSD->execute()) {

								//processes data from the form when it is submitted
								//if (isset($_POST['submit'])) {
									//echo "entrou no submit<br>";
									//image variables
								//if(isset($_FILES['perfil'])){
								$imgFile = $_FILES['foto_perfil']['name'];
								$tmp_file = $_FILES['foto_perfil']['tmp_name'];
								$imgSize = $_FILES['foto_perfil']['size'];

								$imgFile_at = $_FILES['foto_atestado']['name'];
								$tmp_file_at = $_FILES['foto_atestado']['tmp_name'];
								$imgSize_at = $_FILES['foto_atestado']['size'];
													
													//profile images upload directory
								$upload_dir = '../user_images/';
								$upload_dir_at = '../user_medicalForms/';

													//gets the image extension
													//$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
								$imgExt = strtolower(end(explode('.', $_FILES['foto_perfil']['name'])));
								$imgExt_at = strtolower(end(explode('.', $_FILES['foto_atestado']['name'])));						
													//extensões válidas
								$valid_extensions = 'png';

													//rename uploading image


								$userpic = $conPdo->lastInsertId() . "." . $imgExt;
								$medicalForm = $conPdo->lastInsertId() . "." . $imgExt_at;

								$_FILES['foto_perfil']['name'] = $userpic;
								$_FILES['foto_atestado']['name'] = $medicalForm;
												
													
													//validate only some formats
								if ($imgExt === $valid_extensions) {
														// file size '3.2MB'


									if ($imgSize < (180 * 180)) {
										move_uploaded_file($tmp_file, __DIR__ . $upload_dir . $_FILES['foto_perfil']['name']);
										echo "<p>".$tmp_file, __DIR__ . $upload_dir . $_FILES['foto_perfil']['name']."</p>";

									} else {
										$imgFile_err = "Atenção, ficheiro demasiado grande.";
									}

								} else {
									$imgFile_err = " Apenas, formatos, JPG, JPEG, PNG e GIF são permitidos.";
								}

								if ($imgExt_at === $valid_extensions) {
									if ($imgSize_at < (180 * 180)) {
										move_uploaded_file($tmp_file_at, __DIR__ . $upload_dir_at . $_FILES['foto_atestado']['name']);
										echo "<p>".$tmp_file_at, __DIR__ . $upload_dir_at . $_FILES['foto_atestado']['name']."</p>";

									} else {
										$imgFileAt_err = "Atenção, ficheiro demasiado grande.";
									}

								} else {
									$imgFileAt_err = " Apenas, formatos, JPG, JPEG, PNG e GIF são permitidos.";
								}	
									
									//echo "o ficheiro de imagem é ".$userpic;
								//}
									
								
							//if(isset($_SESSION['tipo_insc'])){
								
								echo "O tipo guardado na sessão é : ".$_GET['tipo'];
								if($_GET['tipo']==0){
									
									require 'func.php';	
								}else if($_GET['tipo']==1){ 
									
									require 'aluno.php';
								}

								      
							//}
						}else{
							echo "Erro. Tente outra vez.";
						}
				}else{
					echo "Não conseguiu efetuar o prepare.";
				}
			} catch (PDOException $e) {
				die("Erro ao executar a query $queryInsert".$e->getMessage());
			}			
			unset($stmt);

		}



		unset($conPdo);
	

?>