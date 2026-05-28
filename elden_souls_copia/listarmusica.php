<?php require_once 'cabecalho.php';
require_once 'menu.php';

require_once 'persistence/MusicaPA.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

    $musicapa = new MusicaPA();
    $total = $musicapa->contar();

    if($total <= 0){
        echo "<h2>Não há Músicas cadastrados! Cadastre-os primeiro!</h2>";
    }else{
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }else{
            $pagina = 1;
        }

        $limite = 2;
        $offset = ($pagina - 1) * $limite;

        $isAdmin = isset($_COOKIE['administrador']);
        $apenasEmEstoque = !$isAdmin;

        $consulta = $musicapa->listar($limite, $offset, $apenasEmEstoque);

        require_once 'model/Musica.php';
        $musica = new Musica();

        echo "<section class='listaProdutos'>";

        while($linha = $consulta->fetch_assoc()){
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
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Compra:</span>
                        <span>R$ ".number_format($musica->getVCompra(),2,",",".")."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Venda:</span>
                        <span>R$ ".number_format($musica->getVVenda(),2,",",".")."</span>
                    </div>
                </div>
            </div>
            ";
        }

        echo "</section>";

        echo "<section class='paginacao'>";
        if($pagina > 1){
            $voltar = $pagina - 1;
            echo "<a class='btnPagina' href='listarmusica.php?pagina=$voltar'>❮ Anterior</a>";
        }
        $total_pag = ceil($total / $limite);
        echo "<span class='paginaAtual'>$pagina / $total_pag</span>";
        if($pagina < $total_pag){
            $proxima = $pagina + 1;
            echo "<a class='btnPagina' href='listarmusica.php?pagina=$proxima'>Próxima ❯</a>";
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