<?php
	include "../config.php"; 
	header('content-type: application/json; charset=utf-8');
	//$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=bd_testes;','postgres', 'postgres');
	$idfunc = filter_input(INPUT_GET, "idfunc");

	/*$sql = "SELECT cf.funcionario_idfuncionario, cf.categoria_idcategoria,
f.idfuncionario, f.pessoa_idpessoa,
p.idpessoa, p.nome
FROM categoria_func cf, funcionario f, pessoa p
WHERE cf.funcionario_idfuncionario = f.idfuncionario AND
f.pessoa_idpessoa = p.idpessoa AND
 cf.categoria_idcategoria = ".$idcategoria;
 */
 	

 	$categoria = "SELECT cf.categoria_idcategoria, cf.funcionario_idfuncionario,
					c.idcategoria, c.designacao
			 		FROM categoria_func cf, categoria c
			 		WHERE c.idcategoria = cf.categoria_idcategoria AND
			 		cf.funcionario_idfuncionario = ".$idfunc;


	$statement = $conPdo->query($categoria);

	$json['categoria'] = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($json);

 ?>