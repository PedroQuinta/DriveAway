<?php  

	//inicia a sessão
	session_start();

	//faz unset às variáveis de sessão
	unset($_SESSION);

	//Destroy de session.
	session_destroy();

	//Redirect to login page
	header("location: index.php");
	exit;
?>