<?php
	
	//Instalar 
	//Criar BD
	include 'config.php';

	$ligacao = new PDO("mysql: host=$host", $user, $password);
	$motor = $ligacao->prepare("CREATE DATABASE $base_dados");
	$motor->execute();
	$ligacao = null;

	echo '<p>Base de dados criadas com sucesso!.</p>';


	//===================================================
	//Adicionar as tabelas
	$ligacao = new PDO("mysql:dbname=$base_dados;host=$host", $user, $password);

	//tabela user
	$sql = "CREATE TABLE users(
			id_user 			INT NOT NULL PRIMARY KEY,
			username 			VARCHAR(50),
			pass 				VARCHAR(100),
			avatar 				VARCHAR(250)
			)";
	
	$motor = $ligacao->prepare($sql);
	$motor->execute();

	echo '<p>Tabela Users criada com sucesso!!</p>';
	
	//tabela post----------------------
try
{
    
    $sql = "CREATE TABLE posts(
    	   id_post 				INT NOT NULL PRIMARY KEY,
    	   id_user 				INT NOT NULL,
    	   titulo				VARCHAR(100),
    	   mensagem 			TEXT,
    	   data_post 			DATETIME,
    	   FOREIGN KEY(id_user) REFERENCES users(id_user) ON DELETE CASCADE 
    	   )";
	$motor = $ligacao->prepare($sql);
	$motor->execute();

	echo '<p>Tabela Post criada com sucesso!!</p><hr>';

	$ligacao = null;
}
catch (PDOException $e)
{
	echo '<p>ERRO!</p><hr>';
	echo $e->getMessage;
}
?>