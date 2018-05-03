<?php
	include "../config.php"; 
	header('content-type: application/json; charset=utf-8');
	//$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=bd_testes;','postgres', 'postgres');
	$tipo = filter_input(INPUT_GET, "tipo");
	$id_tipo = filter_input(INPUT_GET, "id_tipo");
	$dados = filter_input(INPUT_GET, "dados");
	$domingo = filter_input(INPUT_GET, "domingo");
	$sabado = filter_input(INPUT_GET, "sabado");

	/*
	var_dump($tipo);
	var_dump($id_tipo);
	var_dump($dados);
	var_dump($domingo);
	var_dump($sabado);
	//exit; */


 
		/*
		$today = date("Y-m-d"); // Data de hoje
		$dia = strtotime("-1 Month"); // -1 Mês da data de hoje
		$d = date("Y-m-d",$dia); // A data escolhida (hoje) e o seu formato
		*/
	

	
		if($dados == 0){
			//aulas praticas ja confirmadas
			$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
			f.idfuncionario,f.pessoa_idpessoa,
			p.idpessoa, p.nome,
			c.idcategoria, c.designacao,
			aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
			v.idveiculo, v.marca, v.modelo, v.matricula,
			al.idaluno , al.pessoa_idpessoa,
			p2.idpessoa, p2.nome as nomeAluno
			FROM aula a, funcionario f, pessoa p, categoria c, aulapratica aulap, veiculo v, aluno al, pessoa p2
			WHERE a.categoria_idcategoria = c.idcategoria AND
			a.funcionario_idfuncionario = f.idfuncionario AND
			f.pessoa_idpessoa = p.idpessoa AND
			a.idaula = aulap.aula_idaula AND
			aulap.veiculo_idveiculo = v.idveiculo AND
			aulap.aluno_idaluno = al.idaluno AND 
			al.pessoa_idpessoa = p2.idpessoa AND
			aulap.estadoaula_idestadoaula = 2";

			if($tipo == "funcionario"){
				$sql .= " AND a.funcionario_idfuncionario =".$id_tipo;
			}
			else{
				$sql .= " AND al.idaluno = ".$id_tipo;
			}
			
			/*
			 * fazer SQL DIFRENTE para aceitar todos ou so activos
			*/
		
			
		}
		elseif($dados == 1){
			//aulas com pedidos de aulas
			//so alunos podem fazer pedidos de aulas
			$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
			aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
			al.idaluno , al.pessoa_idpessoa,
			p2.idpessoa, p2.nome as nomeAluno
			FROM aula a, aulapratica aulap, aluno al, pessoa p2
			WHERE a.idaula = aulap.aula_idaula AND
			aulap.aluno_idaluno = al.idaluno AND 
			al.pessoa_idpessoa = p2.idpessoa AND
			aulap.estadoaula_idestadoaula = 1 AND
			al.idaluno = ".$id_tipo;//id_aluno
			

		}

		elseif($dados == 2){
			//aulas com pedido de cancelar
			//aunos e instrotores podem cancelar aulas
			$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
				f.idfuncionario,f.pessoa_idpessoa,
				p.idpessoa, p.nome,
				c.idcategoria, c.designacao,
				aulap.idaulapratica, aulap.aula_idaula, aulap.veiculo_idveiculo, aulap.aluno_idaluno,aulap.observacao,aulap.estadoaula_idestadoaula,
				v.idveiculo, v.marca, v.modelo, v.matricula,
				al.idaluno , al.pessoa_idpessoa,
				p2.idpessoa, p2.nome as nomeAluno
				FROM aula a, funcionario f, pessoa p, categoria c, aulapratica aulap, veiculo v, aluno al, pessoa p2
				WHERE a.categoria_idcategoria = c.idcategoria AND
				a.funcionario_idfuncionario = f.idfuncionario AND
				f.pessoa_idpessoa = p.idpessoa AND
				a.idaula = aulap.aula_idaula AND
				aulap.veiculo_idveiculo = v.idveiculo AND
				aulap.aluno_idaluno = al.idaluno AND 
				al.pessoa_idpessoa = p2.idpessoa AND
				aulap.estadoaula_idestadoaula = 3";

				if($tipo == "funcionario"){
					$sql .= " AND a.funcionario_idfuncionario = ".$id_tipo;
				}
				if($tipo == "aluno"){
					$sql .= " AND al.idaluno = ".$id_tipo;
				}

		}

		elseif($dados == 3){
			//exames marcados
			$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria,
					f.idfuncionario,f.pessoa_idpessoa,
					p.idpessoa, p.nome,
					c.idcategoria, c.designacao,
					e.idexame, e.aula_idaula, e.veiculo_idveiculo, e.aluno_idaluno,e.localizacao,
					v.idveiculo, v.marca, v.modelo, v.matricula,
					al.idaluno , al.pessoa_idpessoa,
					p2.idpessoa, p2.nome as nomeAluno
				FROM aula a, funcionario f, pessoa p, categoria c, exame e, veiculo v, aluno al, pessoa p2
				WHERE a.categoria_idcategoria = c.idcategoria AND
					a.funcionario_idfuncionario = f.idfuncionario AND
					f.pessoa_idpessoa = p.idpessoa AND
					a.idaula = e.aula_idaula AND
					e.veiculo_idveiculo = v.idveiculo AND
					e.aluno_idaluno = al.idaluno AND 
					al.pessoa_idpessoa = p2.idpessoa";

				if($tipo == "funcionario"){
					$sql .= " AND a.funcionario_idfuncionario = ".$id_tipo;
				}
				else{
					$sql .= " AND al.idaluno = ".$id_tipo;
				}
		}

		elseif($dados == 4){
			//aulas teoricas
			$sql = "SELECT a.idaula , a.dia, a.hora, a.funcionario_idfuncionario, a.categoria_idcategoria, 
					f.idfuncionario,f.pessoa_idpessoa,
					p.idpessoa, p.nome,
					c.idcategoria, c.designacao,
					aulat.aula_idaula, aulat.modulo_idmodulo,
					m.idmodulo, m.descricao
				FROM aula a, funcionario f, pessoa p, categoria c, aulateorica aulat, modulo m
				WHERE m.idmodulo = aulat.modulo_idmodulo AND
					aulat.aula_idaula = a.idaula AND 
					a.categoria_idcategoria = c.idcategoria AND
					a.funcionario_idfuncionario = f.idfuncionario AND
					f.pessoa_idpessoa = p.idpessoa";
		}

		

		$sql .= " AND a.dia BETWEEN '" .$domingo. "' AND '" .$sabado."'";
		$sql.=" ORDER BY dia ASC, hora ASC";
		
		//echo "<h1>2</h1><p>".$sql."</p>";
		
		/*
		var_dump($sql);
		exit;
		*/
		$statement = $conPdo->query($sql);
		
		

	$json['aula'] = $statement->fetchAll(PDO::FETCH_ASSOC);
	//echo "<h1>cenas</h1><p>".$json."</p>";
	echo json_encode($json);
?>