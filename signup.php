<?php
	//SIGNUP
	session_start();
	unset($_SESSION['user']);
	//==================================================
		//cabecalho
	include 'cabecalho.php';

	//verificar foram inseridos dados de utilizador
	if(!isset($_POST['btn_submit']))
	{
		ApresentarFormulario();
	}
	else
	{
		RegistrarUtilizador();
	}



	//rodapé
	include 'rodape.php';

	//FUNÇÔES
	function ApresentarFormulario()
	{
		echo '
			<form class="form_signup" method="post" action="signup.php?a=signup" enctype="multipart/form-data">
			<h3>SignUp</h3><hr><br>

			Username:<br><input type="text" size="20" name="text_utilizador"><br><br>
			Password:<br><input type="password" size="20" name="text_password_1"><br><br>
			Reescreva a Password:<br><input type="password" size="20" name="text_password_2"><br><br>

			<input type="hidden" name="MAX_FILE_SIZE" value="50000">
			Avatar: <input type="file" name="imagem_avatar"><br>
			<small>(Imagem do tipo JPG, tamanho máximo: <strong>50Kb<small>)<br><br>


			<input type="submit" name="btn_submit" value="Registrar"><br><br>
			<a href="index.php">Voltar</a>


			</form>

			

		';

			
	}

	function RegistrarUtilizador()
	{
		$utilizador = $_POST['text_utilizador'];
		$password1 = $_POST['text_password_1'];
		$password2 = $_POST['text_password_2'];
		$avatar = $_FILES['imagem_avatar'];
		$erro = false;



		//Verificar erro
		if($utilizador == "" || $password1 == "" || $password2 == "")
		{
			//erro - não foram preenchidosos campos corretamente
			echo '<div class="erro">Não foram preenchidos os campos necessários.</div>';
			$erro = true;
		}
		else if($password1 != $password2)
		{
			echo '<div class="erro">Passwords não coincidem.</div>';
			$erro = true;
		}

		//Erros do Avatar
		else if($avatar['name'] != "" && $avatar['type'] != "image/jpeg")
		{
			
			echo '<div class="erro">A imagem não é um JPG.</div>';
			$erro = true;
		}
		else if($avatar['name'] != "" && $avatar['size'] > $_POST['MAX_FILE_SIZE'])
		{
			echo '<div class="erro">O tamanho excede os 50Kb.</div>';
			$erro = true;
		
		}


  		if($erro)
  		{
  			ApresentarFormulario();
  			include 'rodape.php';
  			exit();
  		}

  		//Processar o Registro
  		include 'config.php';

  		$ligacao = new PDO("mysql:dbname=$base_dados;host=$host", $user, $password);
  		$motor = $ligacao->prepare("SELECT username FROM users WHERE username = ?");
  		$motor->bindParam(1, $utilizador, PDO::PARAM_STR);
  		$motor->execute();

  		if($motor->rowCount() != 0)
  		{
  			//Erro
  			echo '<div class="erro">Usuario já existente!!</div>';
  			$ligacao = null;
  			ApresentarFormulario();
  			include 'rodape.php';
  			exit;
  		}
  		else
  		{
  			//Registro do utilizador
  			$motor = $ligacao->prepare("SELECT MAX(id_user) AS MaxID FROM users");
  			$motor->execute();
  			$id_temp = $motor->fetch(PDO::FETCH_ASSOC)['MaxID'];
  			
  			if($id_temp == null)
  				$id_temp = 0;
  			else
  				$id_temp++;

  			$passwordEncriptada = md5($password1);
  			try {
  				
  			
  			$sql = "INSERT INTO users VALUES ( :id_user, :user, :pass, :avatar)";
  			$motor = $ligacao->prepare($sql);
  			$motor->bindParam(":id_user", $id_temp, PDO::PARAM_INT);
  			$motor->bindParam(":user", $utilizador, PDO::PARAM_STR);
  			$motor->bindParam(":pass", $passwordEncriptada, PDO::PARAM_STR);
  			$motor->bindParam(":avatar", $avatar['name'], PDO::PARAM_STR);
  			$motor->execute();
  			} catch (PDOException $e) {
  					echo 'Erro!! ' . $e->getMessage();
  			}

  			
  			$ligacao = null;

  			//upload do arquivo AVATAR no servidor WEB.
  			move_uploaded_file($avatar['tmp_name'], "imagens/avatar/" . $avatar['name'] );

  			//mensagem de boas vindas
  			echo '
  				<div class="novo_registro_sucesso">Bem-vindo ao Micro Forum. <strong>'. $utilizador . '</<strong></strong><br><br>
  				A partir deste momento esta em condições de fazer o seu login e participar nesta comunicade online,
  				<br><br>
  				<a href="index.php">Quadro de login</a>
  				</div>
  			';

  		}


	
	}

?>