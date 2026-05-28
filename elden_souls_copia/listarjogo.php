<?php require_once 'cabecalho.php';
require_once 'menu.php';

require_once 'persistence/JogoPA.php';

if (isset($_COOKIE['administrador'])||isset($_COOKIE['cliente'])){

    $jogopa = new JogoPA();
    $total = $jogopa->contar();

    if($total <= 0){
        echo "<h2>Não há jogos cadastrados! Cadastre-os primeiro!</h2>";
    }else{
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }else{
            $pagina = 1;
        }

        $limite = 2;
        $offset = ($pagina - 1) * $limite;

        $isAdmin = isset($_COOKIE['administrador']);
        $apenasEmEstoque = !$isAdmin; // clientes não veem estoque zero

        $consulta = $jogopa->listar($limite, $offset, $apenasEmEstoque);

        require_once 'model/Jogo.php';
        $jogo = new Jogo();

        echo "<section class='listaProdutos'>";

        while($linha = $consulta->fetch_assoc()){
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
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Compra:</span>
                        <span>R$ ".number_format($jogo->getVCompra(),2,",",".")."</span>
                    </div>
                    <div class='linhaInfo'>
                        <span class='tituloInfo'>Valor Venda:</span>
                        <span>R$ ".number_format($jogo->getVVenda(),2,",",".")."</span>
                    </div>
                    <div class='descricaoProduto'>
                        <h3>Descri&ccedil;&atilde;o</h3>
                        <p>".$jogo->getDescricao()."</p>
                    </div>
                </div>
            </div>
            ";
        }

        echo "</section>";

        echo "<section class='paginacao'>";
        if($pagina > 1){
            $voltar = $pagina - 1;
            echo "<a class='btnPagina' href='listarjogo.php?pagina=$voltar'>❮ Anterior</a>";
        }
        $total_pag = ceil($total / $limite);
        echo "<span class='paginaAtual'>$pagina / $total_pag</span>";
        if($pagina < $total_pag){
            $proxima = $pagina + 1;
            echo "<a class='btnPagina' href='listarjogo.php?pagina=$proxima'>Próxima ❯</a>";
        }
        echo "</section>";
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