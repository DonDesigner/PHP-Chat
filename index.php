<?php
	//INDEX
	session_start();
	$sessao_user = null;





	if(isset($_SESSION['user']))
	{
		include 'cabecalho.php';
		echo '<div class="mensagem"><strong>' . $_SESSION['user'] . ' já se encontra logado no site.<br><br>
		      <a href="forum.php">Avançar</a></div>'; 
		include 'rodape.php';
		exit;
	}

	//cabecalho
	include 'cabecalho.php';

	if($sessao_user == null)
	{
		include 'login.php';
	}

	//rodapé
	include 'rodape.php';
?>

	