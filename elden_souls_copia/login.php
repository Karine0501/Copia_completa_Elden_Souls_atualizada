<?php require_once 'cabecalho.php';
require_once 'menu.php';

?>

<form action="login.php" method="POST" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>

	<h1>Login</h1>

	<p>Digite o login:</p>
	<p><input type="text" name="login" size="20" maxlength="20"
			pattern="[0-9a-zA-Z_@]{3,20}"
			title="Somente letras e números _ e @ mín. 3 máx. 20"
			required></p>

	<p>Senha:</p>
	<p><input type="password" name="senha" size="10" maxlength="10"
			pattern="[0-9a-zA-Z_@\-]{5,10}"
			title="letras e números, _,@ e hífen. mín. 5 máx. 10"
			required></p>

	<p><input type="submit" name="botao" value="Login"></p>
</form>

<?php
if (isset($_POST['botao'])) {

	require_once 'model/Administrador.php';
	require_once 'persistence/AdministradorPA.php';

	require_once 'model/Cliente.php';
	require_once 'persistence/ClientePA.php';

	$login=$_POST['login'];
	$senha=$_POST['senha'];
	
	$administrador=new Administrador();
	$administradorpa=new AdministradorPA();

	$administrador->setLogin($login);
	$administrador->setSenha($senha);

	$consulta=$administradorpa->logar($login, $senha);

	if ($consulta) {

		$administrador->setCodAdm($consulta);
		$administrador->logar($administrador->getCodAdm(), 1);

		echo "<h2>Login com sucesso! Bem-Vindo Admin!</h2>";
		echo "<meta http-equiv='refresh' content='2;url=index.php'>";
		exit;
	}

	$cliente=new Cliente();
	$clientepa=new ClientePA();

	$cliente->setLogin($login);
	$cliente->setSenha($senha);

	$consulta=$clientepa->logar($login, $senha);

	if ($consulta) {

		$cliente->setCodCli($consulta);
		$cliente->logar($cliente->getCodCli());

		echo "<h2>Login com sucesso! Bem-Vindo!</h2>";
		echo "<meta http-equiv='refresh' content='2;url=index.php'>";
		exit;
	}

	echo "<h2>Login ou Senha incorretos!</h2>";
}
?>

<script src="js/loader.js"></script>
</body>
</html>