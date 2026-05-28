<?php

require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'persistence/Banco.php';

if (!isset($_COOKIE['cliente'])) {
    header('location: index.php');
    exit;
}

?>

<section class="listaProdutos">

<?php

if (!isset($_COOKIE['cod_ped'])) {

    echo "
    <div class='cardProduto carrinhoVazio'>
        <div class='infoProduto'>
            <h1>Seu carrinho está vazio!</h1>

            <br>
            <div id='btn-area'>
            <a href='buscarjogo.php' class='btnHome'>
                Ir para Catálogo
            </a>
            </div>
        </div>
    </div>
    ";

} else {


    $cod_ped = intval($_COOKIE['cod_ped']);

    $banco = new Banco();
    $con = $banco->conectar();

    $check = mysqli_query(
        $con,
        "SELECT cod_ped FROM pedido WHERE cod_ped = $cod_ped"
    );

    if (!$check || mysqli_num_rows($check) == 0) {
        setcookie('cod_ped', '', time() - 3600, '/');
        mysqli_close($con);
        header('location: pedido.php');
        exit;
    }


$sql = "
    SELECT
        itens.cod_produto,
        itens.tipo,
        itens.quantidade,
        itens.valor,
        (itens.quantidade * itens.valor) AS subtotal,

        CASE
            WHEN itens.tipo = 'JOGO' THEN jogo.nome
            WHEN itens.tipo = 'LIVRO' THEN livro.titulo
            WHEN itens.tipo = 'MUSICA' THEN musica.titulo
        END AS nome,

        CASE
            WHEN itens.tipo = 'JOGO' THEN jogo.foto
            WHEN itens.tipo = 'LIVRO' THEN livro.foto
            WHEN itens.tipo = 'MUSICA' THEN musica.foto
        END AS foto

    FROM itens

    LEFT JOIN jogo
        ON itens.cod_produto = jogo.cod_jogo
        AND itens.tipo = 'JOGO'

    LEFT JOIN livro
        ON itens.cod_produto = livro.cod_liv
        AND itens.tipo = 'LIVRO'

    LEFT JOIN musica
        ON itens.cod_produto = musica.cod_mu
        AND itens.tipo = 'MUSICA'

    WHERE itens.cod_ped = $cod_ped
    ";

    $consulta = mysqli_query($con, $sql);

    if (!$consulta) {
        die("Erro ao buscar itens do pedido: " . mysqli_error($con));
    }

    if (mysqli_num_rows($consulta) <= 0) {

        echo "
        <div class='cardProduto carrinhoVazio'>
            <div class='infoProduto'>
                <h1>Seu carrinho está vazio!</h1>
            </div>
        </div>
        ";

    } else {

        while ($linha = mysqli_fetch_assoc($consulta)) {

            echo "
            <div class='cardProduto'>

                <div class='imagemProduto'>
                    <img src='data:image/jpg;base64," . base64_encode($linha['foto']) . "'>
                </div>

                <div class='infoProduto'>

                    <h1>{$linha['nome']}</h1>

                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Quantidade:</span>
                        <span>{$linha['quantidade']}</span>
                    </div>

                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Unitário:</span>
                        <span>R$ " . number_format($linha['valor'], 2, ',', '.') . "</span>
                    </div>

                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Subtotal:</span>
                        <span>R$ " . number_format($linha['subtotal'], 2, ',', '.') . "</span>
                    </div>

                </div>

            </div>
            ";
        }

        $sqlTotal = "
        SELECT total
        FROM pedido
        WHERE cod_ped = $cod_ped
        ";

        $consultaTotal = mysqli_query($con, $sqlTotal);

        if (!$consultaTotal) {
            die("Erro ao buscar total do pedido: " . mysqli_error($con));
        }

        $pedido = mysqli_fetch_assoc($consultaTotal);

        if (!$pedido) {
            $pedido = ['total' => 0];
        }

        echo "
        <div class='cardProduto card-total'>

            <div class='infoProduto info-total'>

                <h1>Total do Pedido</h1>

                <div class='linha-total'>
                    <span class='tituloInfo'>Valor Total:</span>
                    <span>
                        R$ " . number_format($pedido['total'], 2, ',', '.') . "
                    </span>
                </div>

                <br>
                <div class='botao-confirmar'>
                    <form action='confirmacompra.php' method='POST' id='form'>
                    <div id='loader' style='display: none;'>
                     <img src='img/loader.gif'>
                    </div>
                        <button type='submit'>
                            Confirmar Pedido
                        </button>
                    </form>
                </div>
            </div>

        </div>
        ";
    }

    mysqli_close($con);
}

?>
</section>
<script src="js/loader.js"></script>
</body>
</html>