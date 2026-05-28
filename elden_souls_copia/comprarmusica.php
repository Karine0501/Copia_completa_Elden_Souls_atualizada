<?php
require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'persistence/Banco.php';

if (!isset($_COOKIE['cliente']) && !isset($_COOKIE['administrador'])) {
    header('Location: login.php');
    exit;
}

if (empty($_POST['cod_mu'])) {
    header('Location: buscarmusica.php');
    exit;
}

$cod_mu = intval($_POST['cod_mu']);
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

// Verifica estoque disponível
$sqlEstoque = "SELECT quantidade FROM musica WHERE cod_mu = $cod_mu";
$resultEstoque = mysqli_query($con, $sqlEstoque);
if (!$resultEstoque) {
    die("Erro ao consultar estoque: " . mysqli_error($con));
}
$estoque = mysqli_fetch_assoc($resultEstoque);
if (!$estoque) {
    header('location: buscarmusica.php');
    exit;
}
$disponivel = $estoque['quantidade'];

// Verifica quantidade já no carrinho
$sqlNoCarrinho = "SELECT quantidade FROM itens 
                  WHERE cod_ped = $cod_ped 
                    AND cod_produto = $cod_mu 
                    AND tipo = 'MUSICA'";
$resultCarrinho = mysqli_query($con, $sqlNoCarrinho);
$qtdCarrinho = 0;
if ($resultCarrinho && mysqli_num_rows($resultCarrinho) > 0) {
    $linhaCarrinho = mysqli_fetch_assoc($resultCarrinho);
    $qtdCarrinho = $linhaCarrinho['quantidade'];
}

// Bloqueia se ultrapassar estoque
if ($qtdCarrinho + 1 > $disponivel) {
    mysqli_close($con);
    echo "<h2>Estoque insuficiente! Você já possui $qtdCarrinho unidade(s) no carrinho. Estoque disponível: $disponivel.</h2>";
    echo "<div id='btn-area'><a href='buscarmusica.php' class='btnHome'>Voltar à busca</a></div>";
    exit;
}

$sqlMusica = "SELECT v_venda FROM musica WHERE cod_mu = $cod_mu";
$consultaMusica = mysqli_query($con, $sqlMusica);
if (!$consultaMusica) {
    die("Erro ao buscar musica: " . mysqli_error($con));
}
$musica = mysqli_fetch_assoc($consultaMusica);
if (!$musica) {
    header('location: buscarmusica.php');
    exit;
}
$valor = $musica['v_venda'];

$sqlItem = "SELECT quantidade FROM itens 
            WHERE cod_ped = $cod_ped 
              AND cod_produto = $cod_mu 
              AND tipo = 'MUSICA'";
$consultaItem = mysqli_query($con, $sqlItem);
if (!$consultaItem) {
    die("Erro ao verificar item: " . mysqli_error($con));
}

if (mysqli_num_rows($consultaItem) > 0) {
    $sqlUpdate = "UPDATE itens 
                  SET quantidade = quantidade + 1 
                  WHERE cod_ped = $cod_ped 
                    AND cod_produto = $cod_mu 
                    AND tipo = 'MUSICA'";
    if (!mysqli_query($con, $sqlUpdate)) {
        die("Erro ao atualizar item: " . mysqli_error($con));
    }
} else {
    $sqlInsert = "INSERT INTO itens (cod_ped, cod_produto, quantidade, tipo, valor)
                  VALUES ($cod_ped, $cod_mu, 1, 'MUSICA', $valor)";
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