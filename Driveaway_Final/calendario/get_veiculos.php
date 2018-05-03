<?php 
	include "../config.php"; 
	header('content-type: application/json; charset=utf-8');
	//$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=bd_testes;','postgres', 'postgres');
	$idcategoria = filter_input(INPUT_GET, "idcategoria");
	$dia = filter_input(INPUT_GET, "dia");
	$hora = filter_input(INPUT_GET, "hora");

	//$sql = "SELECT * FROM veiculo WHERE Categoria_IDCategoria = ".$idcategoria;
	$sql = "SELECT * 
			FROM veiculo 
			WHERE Categoria_IDCategoria = ".$idcategoria."
			and activo <> false and idveiculo not in(
				 SELECT v.idveiculo
				 FROM veiculo v , aulapratica aulap, aula a
				 WHERE v.idveiculo = aulap.veiculo_idveiculo AND
				 aulap.aula_idaula = a.idaula AND
				 dia = '".$dia."' AND hora = '".$hora."' AND
				 aulap.estadoaula_idestadoaula NOT IN(1,4,5)
			)  AND
			idveiculo not in(
				 SELECT v.idveiculo
				 FROM veiculo v , exame e, aula a
				 WHERE v.idveiculo = e.veiculo_idveiculo AND
				 e.aula_idaula = a.idaula AND
				 dia = '".$dia."' AND hora = '".$hora.":00'
			)
			ORDER BY marca ASC";
	$statement = $conPdo->query($sql);

	//var_dump($sql);

	$json['veiculo'] = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($json);

 ?>