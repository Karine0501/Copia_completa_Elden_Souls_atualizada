<?php require_once 'cabecalho.php'; require_once 'menu.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){
    ?>
<?php $isAdmin = isset($_COOKIE['administrador']); ?>

<form action="buscarjogo.php" method="GET" id="form">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Buscar Jogos</h1>
    <p><input type="search" name="termo" size="30" maxlength="240" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,240}" required></p>

    <div class="grupoRadio">
        <label class="radioItem">
            <input type="radio" name="campo" value="nome">
            <span>Nome</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="console">
            <span>Console</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="genero">
            <span>Gênero</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="desenvolvedora">
            <span>Desenvolvedora</span>
        </label>
    </div>

    <p><input type="submit" name="botao" value="Buscar"></p>
</form>

<?php
if (isset($_GET['botao'])) {
    require_once 'persistence/JogoPA.php';
    $jogopa=new JogoPA();
    require_once 'model/Jogo.php';
    $jogo=new jogo();

    $apenasEmEstoque = !$isAdmin; // clientes não veem produtos com quantidade 0

    if (isset($_GET['campo'])&&$_GET['campo']!="") {
        $consulta=$jogopa->buscar($_GET['termo'],$_GET['campo'],$jogo, $apenasEmEstoque);
    }else{
        $consulta=$jogopa->buscar($_GET['termo'],"",$jogo, $apenasEmEstoque);
    }

    if ($consulta === false) {
        echo "<h2>Nenhum resultado correspondente</h2>";
    } else {
        echo "<section class='resultado'>";
        while ($linha = $consulta->fetch_assoc()) {
            $jogo->setCodJogo($linha['cod_jogo']);
            $jogo->setNome($linha['nome']);
            $jogo->setConsole($linha['console']);
            $jogo->setGenero($linha['genero']);
            $jogo->setDesenvolvedora($linha['desenvolvedora']);
            $jogo->setEstado($linha['estado']);
            $jogo->setQuantidade($linha['quantidade']);
            $jogo->setVCompra($linha['v_compra']);
            $jogo->setVVenda($linha['v_venda']);
            $jogo->setDescricao($linha['descricao']);
            $jogo->setFoto($linha['foto']);

            echo "
        <div class='cardProduto'>

            <div class='imagemProduto'>
                <img src='data:image/jpg;base64,".base64_encode($jogo->getFoto())."'>
            </div>

            <div class='infoProduto'>

                <h1>".$jogo->getNome()."</h1>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>C&oacute;digo:</span>
                    <span>".$jogo->getCodJogo()."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Console:</span>
                    <span>".$jogo->getConsole()."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>G&ecirc;nero:</span>
                    <span>".$jogo->getGenero()."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Desenvolvedora:</span>
                    <span>".$jogo->getDesenvolvedora()."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Estado:</span>
                    <span class='status'>".$jogo->getEstado()."</span>
                </div>

                <div class='linhaInfo'>
                    <span class='tituloInfo'>Quantidade:</span>
                    <span>".$jogo->getQuantidade()."</span>
                </div>";
                
                if ($isAdmin){
                    echo "
                <div class='linhaInfo'>
                    <span class='tituloInfo'>Valor Compra:</span>
                    <span>R$ ".number_format($jogo->getVCompra(),2,",",".")."</span>
                </div>";
                }

                echo "
                <div class='linhaInfo'>
                    <span class='tituloInfo'>Valor Venda:</span>
                    <span>R$ ".number_format($jogo->getVVenda(),2,",",".")."</span>
                </div>

                <div class='descricaoProduto'>
                    <h3>Descri&ccedil;&atilde;o</h3>
                    <p>".$jogo->getDescricao()."</p>
                </div>

                </div>";

                if ($isAdmin){
                    echo "
                        <a class='icones' href='alterarjogo.php?cod_jogo=".$jogo->getCodJogo()."'>
                            <img src='img/edit.png'/>
                        </a>
                        <a class='icones' href='excluirjogo.php?cod_jogo=".$jogo->getCodJogo()."'>
                            <img src='img/lixo.png'/>
                        </a>
                    ";
                }
                if (!$isAdmin){
                    echo "
                    <form action='comprarjogo.php' method='POST'>
                        <input type='hidden' name='cod_jogo' value='".$jogo->getCodJogo()."'>
                        <button class='icones' type='submit'>
                            <img src='img/comprar.png'/>
                        </button>
                    </form>
                    ";
                }
                echo "
                        </div>
                    </div>
                ";
            }
            echo "</section>";
        }
    }
?>
<script src="js/loader.js"></script>
<?php
}else{
    header('location: index.php');
}
?>
</body>
</html>