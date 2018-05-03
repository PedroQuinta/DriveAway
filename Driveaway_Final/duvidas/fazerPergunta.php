<?php 
	include '../config.php';

	session_start();

	if($_GET['enviar'] == 1){

		include "../notificacoes/nova_notificacao.php";

			
		if(!isset($_GET['id'])){

			$query = "SELECT funcionario_idfuncionario FROM aluno WHERE idaluno= ".$_SESSION['id_tipo'];
			
			$stmt2 = $conPdo->query($query);
			

			$r = $stmt2->fetch(PDO::FETCH_ASSOC);

			$idfunc = $r['funcionario_idfuncionario'];


				
			$query2 = "INSERT INTO pergunta (funcionario_idfuncionario,aluno_idaluno,titulo, pergunta) values (".$idfunc.",".$_SESSION['id_tipo'].",'".$_POST['tit']."', '".$_POST['perg']."')";
			
			//var_dump($query2);
			
			$stmt2 = $conPdo->query($query2);


			$query = "SELECT pessoa_idpessoa FROM funcionario WHERE idfuncionario= ".$idfunc;
			
			$stmt2 = $conPdo->query($query);
			

			$r = $stmt2->fetch(PDO::FETCH_ASSOC);

			$idfunc_pessoa = $r['pessoa_idpessoa'];
			

			new_notification("Dúvida: ".$_POST['tit'],3,"duvidas/gestaoDuvidas.php",$idfunc_pessoa);

			echo "<h1>Pergunta efectuada</h1>";
			
		}
		else{
			$query_resp = "UPDATE pergunta SET resposta='".$_POST['resp']."', respondido = true WHERE idpergunta=".$_POST['id'];
				$stmt2 = $conPdo->query($query_resp);
				$stmt2->execute();
				//var_dump($query_resp);

			$query = "SELECT pessoa_idpessoa, titulo FROM aluno,pergunta WHERE aluno.idaluno = pergunta.aluno_idaluno AND idpergunta=".$_POST['id'];
			$stmt = $conPdo->query($query);
			$r = $stmt->fetch(PDO::FETCH_ASSOC);

			echo "<h1>Resposta Enviada</h1>";
			var_dump($r);
			new_notification("Dúvida respondida: ".$r['titulo'],3,"duvidas/gestaoDuvidas.php",$r['pessoa_idpessoa']);

		}

			echo "

				<script>
					
					refresh('duvidas/gestaoDuvidas.php');
					
				</script> 

			";
			exit;
		
	}
		
		if(isset($_GET['id'])){
			$sql = "SELECT idpergunta,titulo,pergunta,resposta FROM pergunta WHERE idpergunta=".$_GET['id']."";
			
			$stmt = $conPdo->query($sql);

			$stmt->execute();
			//echo $stmt->rowCount(); 
			
			$r = $stmt->fetch(PDO::FETCH_ASSOC);	
		}
		
?>

<!DOCTYPE html>
<html>
<head>
	
	<title>Duvidas?</title>
	
	<style type="text/css">
		@media screen and (max-width: 900px) {
           
           	textarea{width:100%; min-width: 180px;}   
           	input[type=text]{width:100%; min-width: 180px;}   
        }
        textarea{width:100%; min-width: 180px;}   
        input[type=text]{width:100%; min-width: 180px;} 

	</style>
	
</head>
<body>
	<form method="POST" action="" id='form_pergunta'>	
		
	
	<?php
		
	
		if (isset($_GET['id'])){
			echo '<p>Titulo:</p>
					<p><input type="text" id="tit" name="tit" value="'.$r['titulo'].'" disabled></p>';
			echo '<p>Pergunta:</p>
					<p><textarea rows="4" cols="50" name="perg" id="perg" disabled>'.$r['pergunta'].'</textarea></p>	';
			echo "<input type='hidden' value='".$_GET['id']."' name='id' id='idpergunta' readonly";
			echo "<p>Resposta:</p>";
			echo "<p><textarea rows='4' cols='50' name='resp' id='resp'>".$r['resposta']."</textarea></p>";
			
		}	
		else{
			echo '<p>Titulo:</p>
					<p><input type="text" id="tit" name="tit"></p>';
			echo '<p>Pergunta:</p>
				<p><textarea rows="4" cols="50" name="perg" id="perg"></textarea></p>';

		}
		



		
				
	?>	
		<p><button type='button' name='btn' id='btn'></button></p>
	</form>
	
	<script type="text/javascript">
		$(document).ready(function() {
			var tipo = "<?php echo $_SESSION['tipo'] ;?>";
			var get = '<?php echo $_GET["id"] ;?>';
			if(get != ""){
				if(tipo == "aluno"){
					$("#btn").hide();
					$("#resp").attr('disabled', true);
				}
				$("#btn").html("Responder");
				$("#btn").click(function(event) {
					$.ajax({
					  type: "POST",
					  url: "duvidas/fazerPergunta.php?enviar=1&id="+$("#idpergunta").val(),
					  data: $("#form_pergunta").serialize(),
					  success: function(html){
					  	$("#subConteudo").html(html);
					  }
				  
					});
				});
			}
			else{
				$("#btn").html("Perguntar");
				$("#btn").click(function(event) {
					$.ajax({
					  type: "POST",
					  url: "duvidas/fazerPergunta.php?enviar=1",
					  data: $("#form_pergunta").serialize(),
					  success: function(html){
					  	$("#subConteudo").html(html);
					  }
				  
					});
				});
			}

		});
	</script>
</body>
</html>