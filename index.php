<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Lab</title>

    <!-- Importação dos estilos CSS principais -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/testimonials.css">

    <!-- Biblioteca de ícones Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonte personalizada (Google Fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Biblioteca jQuery (para o menu responsivo) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Biblioteca para animações ao rolar a página -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- Variável global para verificar se usuário está logado -->
    <script>const usuarioLogado = <?php echo isset($_SESSION['usuario_id']) ? 'true' : 'false'; ?>;</script>

</head>

<body>
     <!-- =======================
         CABEÇALHO / MENU
    ======================== -->
    <header>
        <nav id="navbar">
            <!-- Logotipo do site (ícone + texto) -->
            <div id = "nav_logo">
                <i class="fa-solid fa-pizza-slice" id="nav_logo"> pizza lab</i>
            </div>

            <!-- Lista de navegação principal -->
            <ul id="nav_list">
                <li class="nav-item active"><a href="#home">Início</a></li>
                <li class="nav-item"><a href="#menu">Cardápio</a></li>
                <li class="nav-item"><a href="#testimonials">Avaliações</a></li>
            </ul>

            <!-- Botões de autenticação -->
            <div class="header-buttons">
                <a href="<?php echo isset($_SESSION['usuario_id']) ? 'ver_carrinho.php' : 'login.php'; ?>" class="btn-carrinho">
                    <i class="fa-solid fa-basket-shopping"></i>
                <span class="carrinho-contador">
                    <?php 
                    $total_itens = 0;
                    if(isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
                        foreach($_SESSION['carrinho'] as $item) {
                            $total_itens += $item['quantidade'];
                        }
                    }
                    echo $total_itens;
                    ?>
                </span>
                </a>

                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <a href="perfil.php" class="btn-perfil">Perfil</a>
                    <a href="logout.php" class="btn-sair">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Entrar</a>
                    <a href="cadastro.php" class="btn-cadastrar">Cadastrar-se</a>
                <?php endif; ?>
            </div>

            <!-- Botão para abrir o menu mobile -->
            <button id="mobile_btn">
                <i class="fa-solid fa-bars"></i>
            </button>
            </nav>

            <!-- Menu móvel (aparece apenas em telas pequenas) -->
            <div id="mobile_menu">
                <ul id="mobile_nav_list">
                    <li class="nav-item"><a href="#home">Início</a></li>
                    <li class="nav-item"><a href="#menu">Cardápio</a></li>
                    <li class="nav-item"><a href="#testimonials">Avaliações</a></li>
                </ul>

            <div id="mobile_auth_buttons">
                <a href="<?php echo isset($_SESSION['usuario_id']) ? 'ver_carrinho.php' : 'login.php'; ?>" class="btn-default">Ver Sacola</a>
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="perfil.php" class="btn-default">Perfil</a>
                <a href="logout.php" class="btn-default btn-sair">Sair</a>
            <?php else: ?>
                <a href="login.php" class="btn-default">Entrar</a>
                <a href="cadastro.php" class="btn-default">Cadastrar-se</a>
            <?php endif; ?>
            </div>
    </header>

    <!-- =======================
         CONTEÚDO PRINCIPAL
    ======================== -->
    <main id="content">

        <!-- ========= SEÇÃO HOME ========= -->
        <section id="home">
            <div class="shape"></div>
            <div id="cta">
                <h1 class="title">
                    O sabor que vai até 
                    <span>você</span>
                </h1>

                <!-- Texto de descrição -->
                <span class="descrition">
                    Desfrute de uma experiência gastronômica única com entrega no conforto da sua casa. 
                    Sabores autênticos, pratos especiais e ingredientes selecionados.
                </span>

                <!-- Botões principais -->
                <div id="cta_buttons">
                    <a href="#menu" class="btn-default">Ver cardápio</a>

                    <!-- Botão com telefone -->
                    <a href="tel:+55555555555" id="phone_button">
                        <button class="btn-default">
                            <i class="fa-solid fa-phone"></i>
                        </button>
                        (81) 92342-3243
                    </a>
                </div>

                <!-- Ícones de redes sociais -->
                <div class="social-media-buttons">
                    <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                    <a href=""><i class="fa-brands fa-instagram"></i></a>
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>

            <!-- Imagem principal -->
            <div id="banner">
                <img src="src/imagens/fundosite.png" alt="Imagem inicial do site">
            </div>
        </section>

        <!-- ========= SEÇÃO CARDÁPIO ========= -->
        <section id="menu">
            <h2 class="section-title">Cardápio</h2>
            <h3 class="section-subtitle">Nossos pratos especiais</h3>

            <!-- Container dos pratos -->
            <div id="dishes">

                <!-- =================== PRATO 1 =================== -->
                <div class="dish">
                    <!-- Ícone de favorito -->
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <!-- Imagem do prato -->
                    <img src="src/imagens/dish.png" class="dish-image" alt="Pizza de calabresa">

                    <h3 class="dish-title">Calabresa</h3>

                    <!-- Texto de descrição -->
                    <span class="dish-description">
                        Calabresa fatiada, molho de tomate artesanal, queijo mussarela, cebola em rodelas, orégano e azeite.
                    </span>

                    <!-- Nota do prato -->
                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <!-- Preço + botão -->
                    <div class="dish-price">
                        <h4>R$25,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(1, 'Calabresa', 25.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 2 =================== -->
                <div class="dish">
                    <!-- Ícone de favorito -->
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <!-- Imagem do prato -->
                    <img src="src/imagens/dish2.png" class="dish-image" alt="Pizza de frango especial">

                    <h3 class="dish-title">Frango Especial</h3>

                    <!-- Texto de descrição -->
                    <span class="dish-description">
                        Molho de tomate artesanal, queijo mussarela, queijo coalho, frango fresco grelhado, bacon, cebola e molho barbecue.
                    </span>

                    <!-- Nota do prato -->
                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <!-- Preço + botão -->
                    <div class="dish-price">
                        <h4>R$35,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(2, 'Frango Especial', 35.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 3 =================== -->
                <div class="dish">
                    <!-- Ícone de favorito -->
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <!-- Imagem do prato -->
                    <img src="src/imagens/dish3.png" class="dish-image" alt="Pizza de frango com catupiry">

                    <h3 class="dish-title">Frango com Catupiry</h3>

                    <!-- Texto de descrição -->
                    <span class="dish-description">
                        Frango desfiado temperado, molho de tomate artesanal, queijo mussarela e catupiry. 
                    </span>

                    <!-- Nota do prato -->
                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <!-- Preço + botão -->
                    <div class="dish-price">
                        <h4>R$25,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(3, 'Frango com Catupiry', 25.00, 10)">
                                <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 4 =================== -->
                <div class="dish">
                    <!-- Ícone de favorito -->
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <!-- Imagem do prato -->
                    <img src="src/imagens/dish4.png" class="dish-image" alt="Pizza de quatro queijos">

                    <h3 class="dish-title">
                        Quatro Queijos
                    </h3>

                    <!-- Texto de descrição -->
                    <span class="dish-description">
                        Mussarela, provolone, parmesão, gorgonzola, molho de tomate e orégano. 
                    </span>

                    <!-- Nota do prato -->
                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <!-- Preço + botão -->
                    <div class="dish-price">
                        <h4>R$30,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(4, 'Quatro Queijos', 30.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 5 =================== -->
                <div class="dish">
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <img src="src/imagens/dish5.png" class="dish-image" alt="Pizza de pepperoni">

                    <h3 class="dish-title">
                        Pepperoni
                    </h3>

                    <span class="dish-description">
                        Pepperoni, queijo mussarela, molho de tomate artesanal e orégano.
                    </span>

                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <div class="dish-price">
                        <h4>R$ 28,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(5, 'Pepperoni', 28.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 6 =================== -->
                <div class="dish">
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <img src="src/imagens/dish6.png" class="dish-image" alt="Pizza de marguerita">

                    <h3 class="dish-title">
                        Marguerita
                    </h3>

                    <span class="dish-description">
                        Mussarela fresca, tomate em rodelas, manjericão fresco, molho de tomate artesanal, azeitonas e azeite extra virgem.
                    </span>

                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <div class="dish-price">
                        <h4>R$ 25,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(6, 'Marguerita', 25.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 7 =================== -->
                <div class="dish">
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <img src="src/imagens/dish7.png" class="dish-image" alt="Pizza amante de carne">

                    <h3 class="dish-title">
                        Amante de Carne
                    </h3>

                    <span class="dish-description">
                        Molho de tomate artesanal, queijo mussarela, calabresa, presunto, bacon e pepperoni.
                    </span>

                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <div class="dish-price">
                        <h4>R$ 40,00</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(7, 'Amante de Carne', 40.00, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div>

                <!-- =================== PRATO 8 =================== -->
                <div class="dish">
                    <div class="dish-heart">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <img src="src/imagens/dish8.png" class="dish-image" alt="Pizza de mussarela">

                    <h3 class="dish-title">
                        Mussarela
                    </h3>

                    <span class="dish-description">
                        Molho de tomate artesanal, queijo musarela, pepperoni, cogumelos fatiados, cebola e manjericão.
                    </span>

                    <div class="dish-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(500+)</span>
                    </div>

                    <div class="dish-price">
                        <h4>R$ 33,85</h4>
                        <button class="btn-default" onclick="adicionarAoCarrinho(8, 'Mussarela', 33.85, 10)">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    </div>
                </div> 
            </div>
        </section>

        <!-- Seção de depoimentos dos clientes -->
        <section id="testimonials">
            <img src="src/imagens/chef.png" id="testimonial_chef" alt="">

            <!-- Container do conteúdo de texto dos depoimentos -->
            <div id="testimonials_content">
                <h2 class="section-title">
                    Depoimentos
                </h2>

                <h3 class="section-subtitle">
                    O que os clientes falam sobre nós:
                </h3>

                <!-- Lista de todos os feedbacks -->
                <div id="feedbacks">

                    <!-- ======== FEEDBACK 1 ======== -->
                    <div class="feedback">
                        <img src="src/imagens/avatar1.png" class="feedback-avatar" alt="Avatar do batman">

                        <div class="feedback-content">

                            <!-- Nome + estrelas -->
                            <p>Batman
                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </p>

                            <!-- Comentário do cliente -->
                            <p>
                                Este restaurante é eficiente e discreto, com pratos preparados com grande precisão e cuidado. Não costumo recomendar lugares, mas este realmente vale a visita.
                            </p>
                        </div>
                    </div>

                    <!-- ======== FEEDBACK 2 ======== -->
                    <div class="feedback">
                        <img src="src/imagens/avatar2.png" class="feedback-avatar" alt="Avatar da mulher-maravilha">

                        <div class="feedback-content">

                             <!-- Nome + estrelas -->
                            <p>Mulher-Maravilha
                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </p>

                            <!-- Comentário do cliente -->
                            <p>
                                Este restaurante é excepcional: comida saborosa e cuidadosamente preparada, ambiente acolhedor e serviço impecável. Cada prato revela dedicação, e por isso o recomendo com total confiança.
                            </p>
                        </div>
                    </div>
                </div>

                 <!-- Botão para ver mais avaliações -->
                <button class="btn-default">
                    Ver mais avaliações
                </button>

            </div>
        </section>
    </main>

    <footer>
        <!-- Imagem decorativa de onda no topo do rodapé -->
        <img src="src/imagens/wave.svg" alt="">

        <!-- Container dos itens do rodapé -->
        <div id="footer_items">

            <!-- Direitos autorais -->
            <span id="copyright">
                &copy 2025 Pizza Lab
            </span>

            <!-- Ícones de redes sociais -->
            <div class="social-media-buttons">
                <a href="">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>

            </div>
        </div>
    </footer>

    <!-- =======================
         SCRIPT PRINCIPAL
    ======================== -->
    <script src="javascript/script.js"></script>

    <script>
    // Função global para adicionar ao carrinho
    function adicionarAoCarrinho(id, nome, preco, estoque) {
        // Verificar se usuário está logado
        if (!usuarioLogado) {
            alert('Você precisa estar logado para adicionar itens ao carrinho!');
            window.location.href = 'login.php';
            return;
        }

    // Enviar dados para o carrinho.php via AJAX
    fetch('carrinho.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `produto_id=${id}&produto_nome=${encodeURIComponent(nome)}&produto_preco=${preco}&produto_estoque=${estoque}`
    })
    .then(response => response.text())
    .then(data => {
        if(data === 'success') {
            alert('Produto adicionado ao carrinho!');
            // Atualizar contador do carrinho
            location.reload();
        } else {
            alert('Erro ao adicionar produto ao carrinho!');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao adicionar produto ao carrinho!');
    });
}
</script>

</body>
</html>