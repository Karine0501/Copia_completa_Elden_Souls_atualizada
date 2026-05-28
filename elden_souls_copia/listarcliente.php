<?php require_once 'cabecalho.php';
require_once 'menu.php';

require_once 'persistence/ClientePA.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

$clientepa = new ClientePA();
$total = $clientepa->contar();

if($total <= 0){

	echo "<h2>Não há Clientes cadastrados! Cadastre-os primeiro!</h2>";

}else{

	if(isset($_GET['pagina'])){
		$pagina = $_GET['pagina'];
	}else{
		$pagina = 1;
	}

	$limite = 2;
	$offset = ($pagina - 1) * $limite;

	$consulta = $clientepa->listar($limite,$offset);

	require_once 'model/Cliente.php';

	$cliente = new Cliente();

	echo "<section class='listaProdutos'>";

	while($linha = $consulta->fetch_assoc()){
        $cliente->setCodCli($linha['cod_cli']);
		$cliente->setNome($linha['nome']);
		$cliente->setCpf($linha['cpf']);
		$cliente->setEndereco($linha['endereco']);
		$cliente->setTelefone($linha['telefone']);
		
	

		echo "
		<div class='cardProduto'> 

			<div class='infoProduto'>

				<h1>".$cliente->getNome()."</h1>

				<div class='linhaInfo'>
					<span class='tituloInfo'>C&oacute;digo:</span>
					<span>".$cliente->getCodCli()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Cpf:</span>
					<span>".$cliente->getCpf()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Endereço:</span>
					<span>".$cliente->getEndereco()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Telefone:</span>
					<span>".$cliente->gettelefone()."</span>
				</div>
				</div>

			</div>

		</div>
		";
	}

	echo "</section>";
	echo "<section class='paginacao'>";

if($pagina > 1){
    $voltar = $pagina - 1;
    echo "<a class='btnPagina' href='listarcliente.php?pagina=$voltar'>❮ Anterior</a>";
}

$total_pag = ceil($total / $limite);

echo "<span class='paginaAtual'>$pagina / $total_pag</span>";

if($pagina < $total_pag){
    $proxima = $pagina + 1;
    echo "<a class='btnPagina' href='listarcliente.php?pagina=$proxima'>Próxima ❯</a>";
}

echo "</section>";
}
?>
<?php
}else{
	header('location: index.php');
}
?>
</body>
</html>