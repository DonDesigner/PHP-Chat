<?php
	session_start();
	//LOGOUT
	include 'cabecalho.php';

	$mensagem = "Página indisponivél!";

	if(isset($_SESSION['user']))
	$mensagem = 'Até à próxima, '. $_SESSION['user']. '!';


	//faz loh
	unset($_SESSION['user']);
	
	echo '<div class="login_sucesso"> '. $mensagem .'<br><br>
		<a href="index.php">Inicio</a>
		 </div>';

	include 'rodape.php';


?>