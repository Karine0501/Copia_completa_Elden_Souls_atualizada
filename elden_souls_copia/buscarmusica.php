<?php require_once 'cabecalho.php'; require_once 'menu.php';
if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])) {

?>
<?php $isAdmin = isset($_COOKIE['administrador']); ?>

<form action="buscarmusica.php" method="GET" id="form">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Buscar Musica</h1>
    <p><input type="search" name="termo" size="30" maxlength="240" pattern="[0-9a-zA-Z\s-,.s-çÇãÃâÂáÁäÄéÉíÍóôÔõÕÓúÚüÜ]{1,240}" required></p>
    <div class="grupoRadio">
        <label class="radioItem">
            <input type="radio" name="campo" value="titulo">
            <span>Titulo</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="artista">
            <span>Artista</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="genero">
            <span>Genero</span>
        </label>
        <label class="radioItem">
            <input type="radio" name="campo" value="Formato">
            <span>Formato</span>
        </label>
    </div>
    <p><input type="submit" name="botao" value="Buscar"></p>
</form>

<?php
if (isset($_GET['botao'])) {
    require_once 'persistence/MusicaPA.php';
    $musicapa = new MusicaPA();
    require_once 'model/Musica.php';
    $musica = new Musica();

    $apenasEmEstoque = !$isAdmin;

    if (isset($_GET['campo']) && $_GET['campo'] != "") {
        $consulta = $musicapa->buscar($_GET['termo'], $_GET['campo'], $apenasEmEstoque);
    } else {
        $consulta = $musicapa->buscar($_GET['termo'], "", $apenasEmEstoque);
    }

    if (!$consulta) {
        echo "<h2>Nenhum resultado correspondente</h2>";
    } else {
        echo "<section class='resultado'>";
        while ($linha = $consulta->fetch_assoc()) {
            $musica->setCodMu($linha['cod_mu']);
            $musica->setTitulo($linha['titulo']);
            $musica->setArtista($linha['artista']);
            $musica->setGenero($linha['genero']);
            $musica->setFormato($linha['formato']);
            $musica->setEstado($linha['estado']);
            $musica->setQuantidade($linha['quantidade']);
            $musica->setVCompra($linha['v_compra']);
            $musica->setVVenda($linha['v_venda']);
            $musica->setFoto($linha['foto']);

            echo "
            <div class='cardProduto'>
                <div class='imagemProduto'>
                    <img src='data:image/jpg;base64,".base64_encode($musica->getFoto())."'>
                </div>
                <div class='infoProduto'>
                    <h1>".$musica->getTitulo()."</h1>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>C&oacute;digo:</span>
                        <span>".$musica->getCodMu()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Artista:</span>
                        <span>".$musica->getArtista()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>G&ecirc;nero:</span>
                        <span>".$musica->getGenero()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Formato:</span>
                        <span>".$musica->getFormato()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Estado:</span>
                        <span class='status'>".$musica->getEstado()."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Quantidade:</span>
                        <span>".$musica->getQuantidade()."</span>
                    </div>";

            if ($isAdmin){
                echo "
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Compra:</span>
                        <span>R$ ".number_format($musica->getVCompra(),2,",",".")."</span>
                    </div>";
            }
            echo "
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Venda:</span>
                        <span>R$ ".number_format($musica->getVVenda(),2,",",".")."</span>
                    </div>
                </div>";

            if ($isAdmin){
                echo "
                    <a class='icones' href='alterarmusica.php?cod_mu=".$musica->getCodMu()."'>
                        <img src='img/edit.png'/>
                    </a>
                    <a class='icones' href='excluirmusica.php?cod_mu=".$musica->getCodMu()."'>
                        <img src='img/lixo.png'/>
                    </a>";
            }

            if (!$isAdmin){
                echo "
                    <form action='comprarmusica.php' method='POST'>
                        <input type='hidden' name='cod_mu' value='".$musica->getCodMu()."'>
                        <button class='icones' type='submit'>
                            <img src='img/comprar.png'/>
                        </button>
                    </form>";
            }

            echo "
                </div>
            </div>";
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