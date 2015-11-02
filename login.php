<?php
	//LOGIN
	echo'
		<form class="form_login" method="post" action="login_verificacao.php">

		<h3>Login</h3><hr><br>
		Para entrar no Micro Forum é necessário ter um usuário e senha!<br>
		Criar um novo usuário.
		<a href="signup.php">Nova Conta</a>
		<br><br>

		Username:<br><input type="text" size=20 name="text_utilizador"><br><br>
		Password:<br><input type="password" size=20 name="text_password"><br><br>

        <input type="submit" name="btn_submit" value="Entrar">

		</form>
	';
?>