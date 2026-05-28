<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

if (isset($_GET['cod_cli'])) {
	require_once 'persistence/ClientePA.php';
	$clientepa=new ClientePA();
	$consulta=$clientepa->buscar($_GET['cod_cli'],"cod_cli");
	if (!$consulta) {
		echo "<h2>Cliente código: ".$_GET['cod_cli']." não encontrado! <a href='buscarcliente.php'> Tente novamente</a></h2>";
	}else{
		require_once 'model/Cliente.php';
		$cliente=new Cliente();

		$linha=$consulta->fetch_assoc();
		$cliente->setCodCli($linha['cod_cli']);
		$cliente->setCpf($linha['cpf']);
		$cliente->setNome($linha['nome']);
		$cliente->setEndereco($linha['endereco']);
		$cliente->setTelefone($linha['telefone']);
?>
<form action="alterarcliente.php" method="POST" id="form">
	<div id="loader" style="display:none;">
		<img src="img/loading.gif">
	</div>
	<h1>Alterar Cliente </h1>
	<p>CPF:</p>
	<p><input type="number" name="cpf" min="1" value="<?=$cliente->getCpf() ?>" required></p>
	<input type="hidden" name="velho_cpf" value="<?= $cliente->getCpf() ?>">
	<p>Nome:</p>
	<p><input type="text" name="nome" size="30" maxlength="30" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{2,30}" value="<?=$cliente->getNome() ?>" required></p>
	<p>Endereço:</p>
	<p><input type="text" name="endereco" size="50" maxlength="50" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{3,50}"value="<?=$cliente->getEndereco() ?>" required ></p>
	<p>Telefone:</p>
	<p><input type="text" name="telefone" size="20" maxlength="20" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}" id="telefone" value="<?=$cliente->getTelefone() ?>" required></p>
	<br>
	<input type="hidden" name="cod_cli" value="<?= $cliente->getCodCli() ?>">
	<p><input type="submit" name="botao" value="Alterar"></p>
</form>
<script src="js/loader.js"></script>
<?php
	}
}else if (isset($_POST['botao'])) {
	require_once 'model/Cliente.php';
	require_once 'persistence/ClientePA.php';
	$cliente=new cliente();
	$clientepa=new ClientePA();

	$cliente->setCpf($_POST['cpf']);
	if ($cliente->getCpf()!=$_POST['velho_cpf']) {
		if (!$clientepa->verificarCpf($cliente->getCpf())) {
			echo "<h2>Cpf já cadastrado!</h2>";
			$flag=false;
		}else{
			$flag=true;
		}
	}else{
		$flag=true;
	}
	if ($flag) {
		$cliente->setCodCli($_POST['cod_cli']);
		$cliente->setNome($_POST['nome']);
		$cliente->setEndereco($_POST['endereco']);
		$cliente->setTelefone($_POST['telefone']);

		if ($clientepa->alterar($cliente)) {
			echo "<h2>Cliente alterado com sucesso</h2>";
		}else{
			echo "<h2> Erro na tentaiva de alterar!<a href='buscarcliente.php?termo=".$cliente->getCodCli()."&campo=cod_cli&botao=Buscar'> Tente novamente!</a></h2>";
		}
		
	}
}else{
	header('location:index.php');
}
?>
<div id="btn-area">
    <a href="buscarcliente.php" id="btn-voltar">Voltar</a>
</div>
<?php
}else{
	header('location: index.php');
}
?>
</body>
</html>