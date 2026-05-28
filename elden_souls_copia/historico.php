<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

require_once 'persistence/PedidoPA.php';
require_once 'persistence/ItensPA.php';

$pedidopa=new PedidoPA();
$itenspa=new ItensPA();

$total_ped = $pedidopa->contar();

if ($total_ped <= 0) {

	echo "<h2>Não há Pedidos! </h2>";
}else{

	if(isset($_GET['pagina'])){
		$pagina = $_GET['pagina'];
	}else{
		$pagina = 1;
	}

	$limite = 2;
	$offset = ($pagina - 1) * $limite;

	$consulta = $pedidopa->listarPedido($_COOKIE['cliente'],$limite,$offset);

	require_once 'model/Pedido.php';
	require_once 'model/Itens.php';

	$pedido = new Pedido();
	$itens = new Itens();
	echo "<section class='listaProdutos'>";
	
	while($linha = $consulta->fetch_assoc()){

		$pedido->setCodPed($linha['cod_ped']);
		$pedido->setCodCli($linha['cod_cli']);
		$pedido->setDataPed($linha['data_ped']);
		$pedido->setTotal($linha['total']);
		$pedido->setStatus($linha['status']);

	
			echo "
		<div class='cardProduto'>

			<div class='infoProduto'>
				<div class='caixaNumeroPedido'>
    				C&oacute;digo Pedido: ".$pedido->getCodPed()."
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>C&oacute;digo Cliente:</span>
					<span>".$pedido->getCodCli()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Data do pedido:</span>
					<span>".$pedido->getDataPed()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Total:</span>
					<span>".$pedido->getTotal()."</span>
				</div>

				<div class='linhaInfo'>
					<span class='tituloInfo'>Status:</span>
					<span>".$pedido->getStatus()."</span>
				</div>

			</div>

		";
	
	
	$con_itens = $itenspa->listarItensPorPedido($pedido->getCodPed());


	echo "<table>";
	echo "<thead>";
	echo"<tr>";
	echo "<th> Código Item</th>";
	echo "<th> Nome </th>";
	echo "<th> Quantidade </th>";
	echo "<th> Tipo </th>";
	echo "<th> Valor </th>";
	echo "</tr>";
	echo "</thead>";

	echo "<tbody>";
	
	while($item = $con_itens->fetch_assoc()){
		$itens->setCodItem($item['cod_item']);
		$itens->setCodPed($item['cod_ped']);
		$itens->setCodProduto($item['cod_produto']);
		$itens->setQuantidade($item['quantidade']);
		$itens->setTipo($item['tipo']);
		$itens->setValor($item['valor']);

		
		echo "

			<tr>
			<td>".$itens->getCodItem()."</td>
			<td>".$itenspa->converteNome($itens->getCodProduto(),$itens->getTipo())."</td>
			<td>".$itens->getQuantidade()."</td>
			<td>".$itens->getTipo()."</td>
			<td>".$itens->getValor()."</td>
			
		</tr>
			
		";
	}
	echo "</table>";
	echo "</tbody>";
	echo "</div>";
}

	echo "</section>";
 
	echo "<section class='paginacao'>";

if($pagina > 1){
    $voltar = $pagina - 1;
    echo "<a class='btnPagina' href='historico.php?pagina=$voltar'>❮ Anterior</a>";
}

$total_pag = ceil($total_ped/ $limite);

echo "<span class='paginaAtual'>$pagina / $total_pag</span>";

if($pagina < $total_pag){
    $proxima = $pagina + 1;
    echo "<a class='btnPagina' href='historico.php?pagina=$proxima'>Próxima ❯</a>";
}

echo "</section>";
}
}else{
	header('location: index.php');
}

?>

</body>
</html>
