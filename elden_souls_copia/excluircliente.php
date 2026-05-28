<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

	if (isset($_GET['cod_cli'])) {
		require_once 'persistence/ClientePA.php';
		require_once 'model/Cliente.php';
		$clientepa=new ClientePA();
		$cliente=new Cliente();
		$consulta=$clientepa->buscar($_GET['cod_cli'],"cod_cli");
		if (!$consulta) {
			echo "<h2>Cliente não encontrado!
			<a href='buscarcliente.php'>Tente novamente</a></h2>";

		}else{
			$linha=$consulta->fetch_assoc();
			$cliente->setCodCli($linha['cod_cli']);
			$cliente->setNome($linha['nome']);
?>
	<form action="excluircliente.php" method="POST" id="form">
		<div id="loader" style="display:none;">
			<img src="img/loader.gif">
		</div>
		<h1>Excluir cliente</h1>
		<p>Tem certeza que deseja excluir o <b><?= $cliente->getNome() ?></b>?</p>
		<input type="hidden" name="cod_cli" value="<?=$cliente->getCodCli() ?>">
		<p><input type="submit" name="botao" value="Sim">
		<button><a href="buscarcliente.php">Não</a></button>
		</p>
		<br>
	</form>
	<script src="js/loader.js"></script>
<?php
		}
	}else if (isset($_POST['botao'])) {
		require_once 'persistence/ClientePA.php';
		require_once 'model/Cliente.php';
		$clientepa=new ClientePA();
		$cliente=new Cliente();
		
		$cliente->setCodCli($_POST['cod_cli']);
		$resposta=$clientepa->excluir($cliente->getCodCli());
		
		if ($resposta) {
			echo "<h2>Cliente excluido com sucesso!</h2>";
		}else if ($resposta=="cliente") {
			echo "<h2>Erro ao tentar excluir Cliente!</h2>";
		}else{
		header('location: index.php');
	}

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

