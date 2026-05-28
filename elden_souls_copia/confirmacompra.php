<?php

require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'persistence/Banco.php';

if (!isset($_COOKIE['cliente'])) {
    header('location: index.php');
    exit;
}

if (!isset($_COOKIE['cod_ped'])) {
    header('location: pedido.php');
    exit;
}

$cod_ped = intval($_COOKIE['cod_ped']);

$banco = new Banco();
$con = $banco->conectar();
mysqli_begin_transaction($con);

$check = mysqli_query($con, "SELECT cod_ped FROM pedido WHERE cod_ped = $cod_ped AND status = 'ABERTO'");

if (!$check || mysqli_num_rows($check) == 0) {

    mysqli_rollback($con);

    setcookie('cod_ped', '', time() - 3600, '/');
    mysqli_close($con);

    header('location: pedido.php');
    exit;
}

/* verificar itens do pedido */
$sqlItens = "
SELECT
    cod_produto,
    quantidade,
    tipo
FROM itens
WHERE cod_ped = $cod_ped
";

$consultaItens = mysqli_query($con, $sqlItens);

if (!$consultaItens) {
    mysqli_rollback($con);
    die("Erro ao buscar itens: " . mysqli_error($con));
}

if (mysqli_num_rows($consultaItens) <= 0) {
    mysqli_rollback($con);
    die("Pedido vazio.");
}

/* valida quantidade no estoque antes de finalizar */
while ($item = mysqli_fetch_assoc($consultaItens)) {

    $cod_produto = intval($item['cod_produto']);
    $qtdCompra = intval($item['quantidade']);
    $tipo = $item['tipo'];

    if ($tipo == 'JOGO') {

        $sqlEstoque = "
        SELECT quantidade
        FROM jogo
        WHERE cod_jogo = $cod_produto
        ";

    } else if ($tipo == 'LIVRO') {

        $sqlEstoque = "
        SELECT quantidade
        FROM livro
        WHERE cod_liv = $cod_produto
        ";

    } else if ($tipo == 'MUSICA') {

        $sqlEstoque = "
        SELECT quantidade
        FROM musica
        WHERE cod_mu = $cod_produto
        ";

    } else {

        mysqli_rollback($con);
        die("Tipo de produto inválido.");
    }

    $consultaEstoque = mysqli_query($con, $sqlEstoque);

    if (!$consultaEstoque) {
        mysqli_rollback($con);
        die("Erro ao verificar estoque: " . mysqli_error($con));
    }

    $produto = mysqli_fetch_assoc($consultaEstoque);

    if (!$produto) {
        mysqli_rollback($con);
        die("Produto não encontrado.");
    }

    if ($produto['quantidade'] < $qtdCompra) {
    mysqli_rollback($con);
    echo "<h2>Estoque insuficiente para o produto '{$item['tipo']}' (código $cod_produto). Estoque disponível: {$produto['quantidade']}, solicitado: $qtdCompra.</h2>";
    echo "<div id='btn-area'><a href='pedido.php' class='btnHome'>Voltar à busca</a></div>";
    exit;
}
}

/* volta para o começo dos itens */
mysqli_data_seek($consultaItens, 0);

/* desconta do estoque */
while ($item = mysqli_fetch_assoc($consultaItens)) {

    $cod_produto = intval($item['cod_produto']);
    $qtdCompra = intval($item['quantidade']);
    $tipo = $item['tipo'];

    if ($tipo == 'JOGO') {

        $sqlUpdate = "
        UPDATE jogo
        SET quantidade = quantidade - $qtdCompra
        WHERE cod_jogo = $cod_produto
        ";

    } else if ($tipo == 'LIVRO') {

        $sqlUpdate = "
        UPDATE livro
        SET quantidade = quantidade - $qtdCompra
        WHERE cod_liv = $cod_produto
        ";

    } else if ($tipo == 'MUSICA') {

        $sqlUpdate = "
        UPDATE musica
        SET quantidade = quantidade - $qtdCompra
        WHERE cod_mu = $cod_produto
        ";

    }

    if (!mysqli_query($con, $sqlUpdate)) {
        mysqli_rollback($con);
        die("Erro ao atualizar estoque: " . mysqli_error($con));
    }
}

/* finalizar compra */
$sql = "
UPDATE pedido
SET status = 'FECHADO'
WHERE cod_ped = $cod_ped
";

$result = mysqli_query($con, $sql);

if (!$result) {
    mysqli_rollback($con);
    die("Erro ao finalizar pedido: " . mysqli_error($con));
}

mysqli_commit($con);

/* limpa somente apos o sucesso */
setcookie('cod_ped', '', time() - 3600, '/');

mysqli_close($con);

?>

<section class="listaProdutos confirmacao">

    <div class="cardProduto">

        <div class="infoProduto">

            <h1>Pedido Confirmado!</h1>

            <br>

            <p>
                Obrigado pela sua compra.
            </p>

            <br><br>
            <div id="btn-area">
            <a href="buscarjogo.php" class="btnHome">
                Continuar Comprando
            </a>
            </div>

        </div>

    </div>

</section>

</body>
</html>