<?php 
		include "../config.php"; 
	header('content-type: application/json; charset=utf-8');
	//$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=bd_testes;','postgres', 'postgres');
	$idcategoria = filter_input(INPUT_GET, "idcategoria");
	$dia = filter_input(INPUT_GET, "dia");
	$hora = filter_input(INPUT_GET, "hora");

	$sql = "SELECT idaluno, nome
			FROM Aluno al, pessoa p , categoria_aluno ca
			WHERE al.pessoa_idpessoa = p.idpessoa AND
			ca.aluno_idaluno = al.idaluno AND
			al.estado_idestado not in (3,4) AND
			ca.categoria_idcategoria = ".$idcategoria." AND
			idaluno not in(
				 SELECT al.idaluno
				 FROM aluno al , aulapratica aulap, aula a
				 WHERE al.idaluno = aulap.aluno_idaluno AND
				 aulap.aula_idaula = a.idaula AND
				 dia = '".$dia."' AND hora = '".$hora.":00' AND
				 aulap.estadoaula_idestadoaula NOT IN(1,4,5)
			) AND
			idaluno not in(
				 SELECT al.idaluno
				 FROM aluno al , exame e, aula a
				 WHERE al.idaluno = e.aluno_idaluno AND
				 e.aula_idaula = a.idaula AND
				 dia = '".$dia."' AND hora = '".$hora.":00'
			)
			
			ORDER BY nome ASC";
	//var_dump($sql);
	
	/*v2
	$sql = "SELECT idaluno, nome
			FROM Aluno al, pessoa p , categoria_aluno ca
			WHERE al.pessoa_idpessoa = p.idpessoa AND
			ca.aluno_idaluno = al.idaluno AND
			ca.categoria_idcategoria = ".$idcategoria." AND
			idaluno not in(
				 SELECT al.idaluno
				 FROM aluno al , aulapratica aulap, aula a
				 WHERE al.idaluno = aulap.aluno_idaluno AND
				 aulap.aula_idaula = a.idaula AND
				 dia = '".$dia."' AND hora = '".$hora.":00' AND
				 aulap.estadoaula_idestadoaula NOT IN(1,4,5)
			)";
		*/
		/* v1
		$sql = "SELECT idaluno, nome
					FROM Aluno al, pessoa p , categoria_aluno ca
					WHERE al.pessoa_idpessoa = p.idpessoa AND
					ca.aluno_idaluno = al.idaluno AND
					ca.categoria_idcategoria = " . $idcategoria . " AND
					idaluno not in(
						SELECT al.idaluno
						FROM aluno al , aulapratica aulap, aula a
						WHERE al.idaluno = aulap.aluno_idaluno AND
						aulap.aula_idaula = a.idaula AND
						dia = '" . $dia . "' AND hora = '" . $hora . ":00' 
					)";
		*/

	$statement = $conPdo->query($sql);

	//var_dump($sql);

	$json['alunos'] = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($json);

 ?>