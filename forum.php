<?php

	//FORUM
	session_start();
	header("Content-Type: text/html;  charset=ISO-8859-1",true);

	if(!isset($_SESSION['user']))
	{
		include 'cabecalho.php';
		echo '<div class="erro"> Voce não tem permissão para ver o conteúdo do fórum<br><br>
		<a href="index.php">Retroceder</a>
		</div>';
		include 'rodape.php';
		exit;

	}


	//-------------------------------------------
	include 'cabecalho.php';

	//-------------------------------------------
	//dados do utilizador que está logado
	echo '<div class="dados_utilizador">
		<img src="imagens/avatar/' . $_SESSION['avatar'].'">
		<span>' . $_SESSION['user'] . '</<span> | 
		<a href="logout.php">Logout</a>
		</div>';

	//-------------------------------------------
	//Novo Post
	echo '<div class="novo_post"><a href="editor_post.php">Novo Post</a></div>';
		


	//-------------------------------------------
	//apresentação dos dados
	include 'config.php';
	$ligacao = new PDO("mysql:dbname=$base_dados;host=$host", $user, $password);


	$sql = "SELECT * FROM posts INNER JOIN users ON posts.id_user = users.id_user ORDER BY data_post DESC";
	$motor = $ligacao->prepare($sql);
	$motor->execute();
	$ligacao = null;

	if($motor->rowCount() == 0)
	{
		echo '<div class="login_sucesso">
				Não existem posts no fórum.
		     </div>';

	}
	else
	{
		//apresentcao
		foreach($motor as $post)
		{
			//dados do post
			$id_post = $post['id_post'];
			$id_user = $post['id_user'];
			$titulo = $post['titulo'];
			$mensagem = $post['mensagem'];
			$data_post = $post['data_post'];

			//dados do utilizador
			$username = $post['username'];
			$avatar = $post['avatar'];

			echo '<div class="post">';
			
			echo '<img src="imagens/avatar/' . $avatar . '">';	
			echo '<span id="post_username">'. $username .'</span>';	
			echo '<span id="post_titulo">'. $titulo .'</span>';
			echo '<hr>';
			echo '<div id="post_mensagem">' . $mensagem . '</div>';


			echo '<div id="post_data">';
			//EDITAR - Botao
			if($id_user == $_SESSION['id_user'])
			{
				echo '<a href="editor_post.php?pid='. $id_post . '" id="editar">Editar</a>';
			}


			echo  $data_post . '<span id="id_post">#' . $id_post . '</div>';


			echo '</div>';
		}
	}



	//-------------------------------------------
	include 'rodape.php';
?>