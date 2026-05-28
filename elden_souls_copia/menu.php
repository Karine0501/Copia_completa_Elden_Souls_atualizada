<section class="topo">

    <div id="logo">
        <a href="index.php">
            <img src="img/icone_001.png">
        </a>
    </div>

    <div id="menu">

        <ul class="nav">

        <?php
        if(isset($_COOKIE['administrador'])){ ?>

            <li>
                <a href="alterarsenha.php">
                    <img src="img/alterar.png">
                    <span>Senha</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <img src="img/livro.png">
                    <span>Livros</span>
                </a>

                <ol>
                    <li><a href="cadastrarliv.php">Cadastrar</a></li>
                    <li><a href="listarliv.php">Listar</a></li>
                    <li><a href="buscarliv.php">Buscar</a></li>
                </ol>
            </li>

            <li>
                <a href="#">
                    <img src="img/jogo.png">
                    <span>Jogos</span>
                </a>

                <ol>
                    <li><a href="cadastrarjogo.php">Cadastrar</a></li>
                    <li><a href="listarjogo.php">Listar</a></li>
                    <li><a href="buscarjogo.php">Buscar</a></li>
                </ol>
            </li>

            <li>
                <a href="#">
                    <img src="img/musica.png">
                    <span>Músicas</span>
                </a>

                <ol>
                    <li><a href="cadastrarmusica.php">Cadastrar</a></li>
                    <li><a href="listarmusica.php">Listar</a></li>
                    <li><a href="buscarmusica.php">Buscar</a></li>
                </ol>
            </li>

            <li>
                <a href="#">
                    <img src="img/cliente.png">
                    <span>Cliente</span>
                </a>

                <ol>
                    <li><a href="listarcliente.php">Listar</a></li>
                    <li><a href="buscarcliente.php">Buscar</a></li>
                    <li><a href="historicoadmin.php">Histórico de pedidos</a></li>
                </ol>
            </li>

            <li>
                <a href="logoff.php">
                    <img src="img/sair.png">
                    <span>Sair</span>
                </a>
            </li>

        <?php
        }else if(isset($_COOKIE['cliente'])){ ?>

             <li>
                <a href="#">
                    <img src="img/alterar.png">
                    <span>Alterar</span>
                </a>
                <ol>
                    <li><a href="alterarsenhacliente.php">Senha</a></li>
                    <li><a href="alterardados.php">Dados</a></li>

                </ol>
            </li>

            <li>
                <a href="buscarliv.php">
                    <img src="img/livro.png">
                    <span>Livros</span>
                </a>
            </li>

            <li>
                <a href="buscarjogo.php">
                    <img src="img/jogo.png">
                    <span>Jogos</span>
                </a>
            </li>

            <li>
                <a href="buscarmusica.php">
                    <img src="img/musica.png">
                    <span>Músicas</span>
                </a>
            </li>

             <li>
                <a href="#">
                    <img src="img/carrinho.png">
                    <span>Meu pedido</span>
                </a>
                <ol>
                    <li><a href="pedido.php">Carrinho</a></li>
                    <li><a href="historico.php">Histórico</a></li>

                </ol>
            </li>

            <li>
                <a href="logoff.php">
                    <img src="img/sair.png">
                    <span>Sair</span>
                </a>
            </li>

        <?php
        }else{ ?>

            <li>
                <a href="login.php">
                    <img src="img/login.png">
                    <span>Login</span>
                </a>
            </li>

            <li>
                <a href="cadastrarcliente.php">
                    <img src="img/cliente.png">
                    <span>Cadastro</span>
                </a>
            </li>

            <li>
                <a href="sobre.php">
                    <img src="img/sobre.png">
                    <span>Sobre</span>
                </a>
            </li>
            <li class="searchMenu">
            <form action="procurar.php">
            <input type="search" name="pesquisa" placeholder="Search...">
        </form>

</li>
        <?php } ?>

        </ul>

    </div>

</section>