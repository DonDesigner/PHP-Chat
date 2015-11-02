<?php

	$utilizador = "root";
	$password = "1234";
	$novaBD = "negocios";
	$host = "localhost";

	//AdicionarClientes("Luiz Felipe");

	//AdicionarEncomendas(array(1, 'Avião', 1, '2012-04-30'));

	BuscarEncomendasClientes(0);
function BuscarEncomendasClientes($id_cliente)
{
	global $utilizador, $password, $novaBD, $host;
	try {
		$ligacao = new PDO("mysql:dbname=$novaBD;host=$host", $utilizador, $password);
		

		$sql= "SELECT clientes.*, encomendas.* FROM clietes, encomendas
			   WHERE clientes.id_cliente = encomendas.id_cliente";

		$resultado = $ligacao->prepare($sql);
		$resultado->execute();
		foreach ($resultado as $linha)
		{
			echo "-> ". $linha['produto'] . ' (' . $linha['quantidade'] . ') ' . $linha['data_encomenda'] . '<br>';
		}



		$ligacao = null;
	} catch (Exception $e) {
		
	}
	

}	

function AdicionarClientes($nome){

	global $utilizador, $password, $novaBD, $host;

	try{

	//verificar o id_cliente disponivel
	$ligacao = new PDO("mysql:dbname=$novaBD;host=$host", $utilizador, $password);

	//verificar o id_cliente disponível
	$resultado = $ligacao->prepare("SELECT MAX(id_cliente) as MaxID from clientes");
	$resultado->execute();
	$id_temp = $resultado->fetch(PDO::FETCH_ASSOC)['MaxID'];
	
	if($id_temp == null)
		$id_temp = 0 ;
	else
		$id_temp++;

	//adicionar cliente
	$resultado = $ligacao->prepare("INSERT INTO clientes VALUES (?,?)");
	$resultado->execute(array($id_temp, $nome));
	echo "Novo cliente adicionado com sucesso!";
	}
	catch(PDOException $erro)
	{
		echo $erro->getMessage();
	}
}

function AdicionarEncomendas($elementos){

	global $utilizador, $password, $novaBD, $host;

	try {
		
		$id_cliente = $elementos[0];
		$produto = $elementos[1];
		$quantidade = $elementos[2];
		$data_encomenda = $elementos[3];

		//verificar se o id_cliente é válido;
		$ligacao = new PDO("mysql:dbname=$novaBD; host=$host", $utilizador, $password);

		$sql = "SELECT id_cliente FROM clientes WHERE id_cliente = :id_cliente";
		$resultado = $ligacao->prepare($sql);
		$resultado->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
		$final = $resultado->execute();


		$numLinhas =  $resultado->rowCount();

		//verifica se o ID existe
		if($numLinhas == 0)
		{
			echo '<p>Não existe cliente com o ID informado!</p>';
			exit;
		}

		//verificar o id_cliente disponível
		$resultado = $ligacao->prepare("SELECT MAX(id_encomendas) as MaxID from encomendas");
		$resultado->execute();
		$id_temp = $resultado->fetch(PDO::FETCH_ASSOC)['MaxID'];
		
		if($id_temp == null)
			$id_temp = 0 ;
		else
			$id_temp++;



		$sql = "INSERT INTO encomendas
				VALUES(:id_temp,
					   :id_cliente,
					   :produto,
					   :quantidade,
					   :data_encomenda)";
		$resultado = $ligacao->prepare($sql);
		$resultado->bindParam(":id_temp", $id_temp, PDO::PARAM_INT);
		$resultado->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
		$resultado->bindParam(":produto", $produto, PDO::PARAM_STR);
		$resultado->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
		$resultado->bindParam(":data_encomenda", $data_encomenda, PDO::PARAM_STR);
		
		$resultado->execute();

		echo '<p>Encomendas OK</p>';


		//fechar
		$ligacao = null;	
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

}

function CriarBD(){

	global $utilizador, $password, $novaBD, $host;

	try {

		//criar uma nova base de dados
		$ligacao = new PDO("mysql:  host=$host", $utilizador, $password);
		$ligacao->prepare("CREATE DATABASE $novaBD")->execute();


		//adicionar a tabele clientes
		$sql="CREATE TABLE clientes
			 (
			 	id_cliente 		INT NOT NULL PRIMARY KEY,
			 	nome 			VARCHAR(50)
			 )";
		$ligacao = new PDO("mysql:dbname=$novaBD;host=$host", $utilizador, $password);
		$ligacao->prepare($sql)->execute();

			//adicionar a tabele encoentdas
		$sql="CREATE TABLE encomendas
			 (
			 	id_encomendas 	INT NOT NULL PRIMARY KEY,
			 	id_cliente 		INT NOT NULL,
			 	produto 		VARCHAR(100),
			 	quantidade		INT,
			 	data_encomenda	DATE,
			 	FOREIGN KEY(id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE ON UPDATE NO ACTION
			 )";
		$ligacao = new PDO("mysql:dbname=$novaBD;host=$host", $utilizador, $password);
		$ligacao->prepare($sql)->execute();


	} catch (PDOException $e) {
			echo '<p>Houve um Erro!!</p><hr>';
			echo $e->getMessage();
	}
}

?>

	