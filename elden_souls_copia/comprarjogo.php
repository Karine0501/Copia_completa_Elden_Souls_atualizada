<?php
require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'persistence/Banco.php';

if (!isset($_COOKIE['cliente']) && !isset($_COOKIE['administrador'])) {
    header('Location: login.php');
    exit;
}

if (empty($_POST['cod_jogo'])) {
    header('Location: buscarjogo.php');
    exit;
}

$cod_jogo = intval($_POST['cod_jogo']);
$cod_cli = intval($_COOKIE['cliente']);
if (!isset($_COOKIE['cliente'])) {
    die("Cliente inválido para pedido.");
}

$banco = new Banco();
$con = $banco->conectar();

if (!isset($_COOKIE['cod_ped'])) {
    $data = date('Y-m-d');
    $sqlPedido = "INSERT INTO pedido (cod_cli, data_ped, total, status)
                  VALUES ($cod_cli, '$data', 0, 'ABERTO')";
    if (!mysqli_query($con, $sqlPedido)) {
        die("Erro ao criar pedido: " . mysqli_error($con));
    }
    $cod_ped = mysqli_insert_id($con);
    if (!$cod_ped) {
        die("Falha crítica: ID do pedido não gerado.");
    }
    setcookie('cod_ped', $cod_ped, time() + 86400, '/');
} else {
    $cod_ped = intval($_COOKIE['cod_ped']);
}

// Verifica estoque disponível do jogo
$sqlEstoque = "SELECT quantidade FROM jogo WHERE cod_jogo = $cod_jogo";
$resultEstoque = mysqli_query($con, $sqlEstoque);
if (!$resultEstoque) {
    die("Erro ao consultar estoque: " . mysqli_error($con));
}
$estoque = mysqli_fetch_assoc($resultEstoque);
if (!$estoque) {
    header('location: buscarjogo.php');
    exit;
}
$disponivel = $estoque['quantidade'];

// Verifica quantos já estão no carrinho (pedido em aberto)
$sqlNoCarrinho = "SELECT quantidade FROM itens 
                  WHERE cod_ped = $cod_ped 
                    AND cod_produto = $cod_jogo 
                    AND tipo = 'JOGO'";
$resultCarrinho = mysqli_query($con, $sqlNoCarrinho);
$qtdCarrinho = 0;
if ($resultCarrinho && mysqli_num_rows($resultCarrinho) > 0) {
    $linhaCarrinho = mysqli_fetch_assoc($resultCarrinho);
    $qtdCarrinho = $linhaCarrinho['quantidade'];
}

// Se adicionar mais um ultrapassar o estoque, bloqueia
if ($qtdCarrinho + 1 > $disponivel) {
    mysqli_close($con);
    echo "<h2>Estoque insuficiente! Você já possui $qtdCarrinho unidade(s) no carrinho. Estoque disponível: $disponivel.</h2>";
    echo "<div id='btn-area'><a href='buscarjogo.php' class='btnHome'>Voltar à busca</a></div>";
    exit;
}

$sqlJogo = "SELECT v_venda FROM jogo WHERE cod_jogo = $cod_jogo";
$consultaJogo = mysqli_query($con, $sqlJogo);
if (!$consultaJogo) {
    die("Erro ao buscar jogo: " . mysqli_error($con));
}
$jogo = mysqli_fetch_assoc($consultaJogo);
if (!$jogo) {
    header('location: buscarjogo.php');
    exit;
}
$valor = $jogo['v_venda'];

$sqlItem = "SELECT quantidade FROM itens 
            WHERE cod_ped = $cod_ped 
              AND cod_produto = $cod_jogo 
              AND tipo = 'JOGO'";
$consultaItem = mysqli_query($con, $sqlItem);
if (!$consultaItem) {
    die("Erro ao verificar item: " . mysqli_error($con));
}

if (mysqli_num_rows($consultaItem) > 0) {
    $sqlUpdate = "UPDATE itens 
                  SET quantidade = quantidade + 1 
                  WHERE cod_ped = $cod_ped 
                    AND cod_produto = $cod_jogo 
                    AND tipo = 'JOGO'";
    if (!mysqli_query($con, $sqlUpdate)) {
        die("Erro ao atualizar item: " . mysqli_error($con));
    }
} else {
    $sqlInsert = "INSERT INTO itens (cod_ped, cod_produto, quantidade, tipo, valor)
                  VALUES ($cod_ped, $cod_jogo, 1, 'JOGO', $valor)";
    if (!mysqli_query($con, $sqlInsert)) {
        die("Erro ao inserir item: " . mysqli_error($con));
    }
}

$sqlTotal = "UPDATE pedido
             SET total = (SELECT COALESCE(SUM(quantidade * valor), 0) FROM itens WHERE cod_ped = $cod_ped)
             WHERE cod_ped = $cod_ped";
if (!mysqli_query($con, $sqlTotal)) {
    die("Erro ao atualizar total: " . mysqli_error($con));
}

mysqli_close($con);
header('location: pedido.php');
exit;
?>