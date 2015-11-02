<?php
	session_start();


if(!isset($_SESSION['username']))
{
	erro();
	exit;
}


$user = $_SESSION['username'];
echo "<p> Usuario: " . $user;


function erro()
{
	echo 'Acesso negado!';
}

echo '<tr><p> Fim da página </p>';

?>