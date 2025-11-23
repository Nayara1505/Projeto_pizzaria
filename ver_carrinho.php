<?php
session_start();
include_once('config.php');

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

// Calcular totais
$subtotal = 0;
$quantidade_total = 0;

if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    foreach($_SESSION['carrinho'] as $item) {
        $subtotal += $item['preco'] * $item['quantidade'];
        $quantidade_total += $item['quantidade'];
    }
}

$frete = 4.00; 
$total = $subtotal + $frete;

// Remover produto do carrinho
if(isset($_GET['remover'])) {
    $produto_id = intval($_GET['remover']);
    foreach($_SESSION['carrinho'] as $key => $item) {
        if($item['id'] == $produto_id) {
            unset($_SESSION['carrinho'][$key]);
            break;
        }
    }
    // Reindexar array
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    header("Location: ver_carrinho.php");
    exit;
}

// Limpar carrinho
if(isset($_GET['limpar'])) {
    $_SESSION['carrinho'] = [];
    header("Location: ver_carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacola de Compras</title>
    
    <!-- Importação dos estilos -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/carrinho.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <!-- HEADER SIMPLIFICADO - APENAS PARA O CARRINHO -->
    <header>
        <nav id="navbar">
            <!-- Logotipo do site (ícone + texto) -->
            <div id="nav_logo">
                <i class="fa-solid fa-pizza-slice" id="nav_logo"> pizza lab</i>
            </div>

            <!-- Lista de navegação VAZIA (sem links) -->
            <ul id="nav_list">
                <!-- Links removidos intencionalmente -->
            </ul>

            <!-- Botões de autenticação (APENAS CARRINHO + PERFIL/SAIR) -->
            <div class="header-buttons">
                <a href="ver_carrinho.php" class="btn-carrinho">
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

        <!-- Menu móvel (também simplificado) -->
        <div id="mobile_menu">
            <ul id="mobile_nav_list">
                <!-- Links removidos intencionalmente -->
            </ul>

            <div id="mobile_auth_buttons">
                <a href="ver_carrinho.php" class="btn-default">Ver Sacola</a>
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <a href="perfil.php" class="btn-default">Perfil</a>
                    <a href="logout.php" class="btn-default btn-sair">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="btn-default">Entrar</a>
                    <a href="cadastro.php" class="btn-default">Cadastrar-se</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="carrinho-container">
        <div class="carrinho-content">
            <!-- Título -->
            <div class="carrinho-header">
                <h1>Sacola de Compras</h1>
                <span class="produto-count"><?php echo $quantidade_total; ?> produto(s) na sacola</span>
            </div>

            <?php if(empty($_SESSION['carrinho'])): ?>
                <!-- Carrinho Vazio -->
                <div class="carrinho-vazio">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>Sua sacola está vazia</h3>
                    <p>Adicione produtos à sacola para continuar comprando</p>
                    <a href="index.php#menu" class="btn-ir-loja">
                        <i class="fas fa-store"></i> Ir para a loja
                    </a>
                </div>
            <?php else: ?>
                <!-- Carrinho com Produtos -->
                <div class="carrinho-grid">
                    <!-- Lista de Produtos -->
                    <div class="produtos-section">
                        <h2>Seus Produtos</h2>
                        
                        <div class="produtos-lista">
                            <?php foreach($_SESSION['carrinho'] as $item): ?>
                                <div class="produto-item">
                                    <div class="produto-info">
                                        <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                        <div class="produto-detalhes">
                                            <span class="preco">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                                        </div>
                                        <div class="quantidade-controls">
                                            <button class="btn-quantidade" onclick="alterarQuantidade(<?php echo $item['id']; ?>, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="quantidade-display"><?php echo $item['quantidade']; ?></span>
                                            <button class="btn-quantidade" onclick="alterarQuantidade(<?php echo $item['id']; ?>, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="produto-actions">
                                        <a href="ver_carrinho.php?remover=<?php echo $item['id']; ?>" class="btn-remover">
                                            <i class="fas fa-trash"></i> Remover
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Resumo do Pedido -->
                    <div class="resumo-section">
                        <div class="resumo-card">
                            <h2>Resumo do Pedido</h2>
                            
                            <div class="resumo-linhas">
                                <div class="resumo-linha">
                                    <span>Subtotal</span>
                                    <span>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                </div>
                                
                                <div class="resumo-linha">
                                    <span>Frete</span>
                                    <span>R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                                </div>
                                
                                <div class="resumo-linha total">
                                    <strong>Total</strong>
                                    <strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                                </div>
                            </div>

                            <div class="resumo-actions">
                                <a href="checkout.php" class="btn-finalizar">
                                    <i class="fas fa-credit-card"></i> Finalizar Compra
                                </a>
                                
                                <a href="ver_carrinho.php?limpar=1" class="btn-limpar">
                                    <i class="fas fa-broom"></i> Limpar Sacola
                                </a>
                                
                                <a href="index.php#menu" class="btn-continuar">
                                    <i class="fas fa-arrow-left"></i> Continuar Comprando
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- =======================
         SCRIPT DO CARRINHO
    ======================== -->
    <script>
    // Função para alterar quantidade no carrinho
    function alterarQuantidade(produtoId, alteracao) {
        // Enviar requisição para atualizar quantidade
        fetch('atualizar_quantidade.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `produto_id=${produtoId}&alteracao=${alteracao}`
        })
        .then(response => response.text())
        .then(data => {
            if(data === 'success') {
                location.reload(); // Recarregar para atualizar totais
            } else if(data === 'stock_exceeded') {
                alert('Quantidade máxima em estoque atingida!');
            } else if(data === 'min_reached') {
                // Se tentar diminuir para menos de 1, remover produto
                if(confirm('Deseja remover este produto do carrinho?')) {
                    window.location.href = 'ver_carrinho.php?remover=' + produtoId;
                }
            } else {
                alert('Erro ao atualizar quantidade!');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar quantidade!');
        });
    }
    </script>

</body>
</html>