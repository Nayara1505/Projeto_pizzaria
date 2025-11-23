<?php
session_start();
include_once('config.php');

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])){
    header("Location: ver_carrinho.php");
    exit;
}

$subtotal = 0;
$quantidade_total = 0;

foreach($_SESSION['carrinho'] as $item) {
    $subtotal += $item['preco'] * $item['quantidade'];
    $quantidade_total += $item['quantidade'];
}

$frete = 4.00; 
$total = $subtotal + $frete;

if(isset($_POST['finalizar_pedido'])) {
    $metodo_pagamento = $_POST['metodo_pagamento'];
    
    $_SESSION['carrinho'] = [];
    
    header("Location: pedido_sucesso.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Pizza Lab</title>
    
    <!-- Importação dos estilos -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/checkout.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav id="navbar">
            <div id="nav_logo">
                <i class="fa-solid fa-pizza-slice"> pizza lab</i>
            </div>

            <ul id="nav_list">
                <!-- Links podem ser adicionados aqui -->
            </ul>

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

            <button id="mobile_btn">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main class="checkout-container">
        <div class="checkout-content">
            <!-- Título -->
            <div class="checkout-header">
                <h1>Finalizar Compra</h1>
                <span class="pedido-count"><?php echo $quantidade_total; ?> item(ns) no pedido</span>
            </div>

            <form method="POST" class="checkout-form">
                <div class="checkout-grid">
                    <!-- Coluna da Esquerda - Formulários -->
                    <div class="form-section">
                        <!-- Métodos de Pagamento (ESTILO SIMPLES) -->
                        <section class="form-group">
                            <h2>Método de Pagamento</h2>
                            
                            <!-- PIX -->
                            <div class="metodo-pagamento-simples">
                                <div class="metodo-option">
                                    <input type="radio" id="pix" name="metodo_pagamento" value="pix" checked class="radio-hidden">
                                    <label for="pix" class="metodo-simples-label">
                                        <span class="checkmark"></span>
                                        <span class="metodo-simples-titulo">Pix</span>
                                    </label>
                                </div>
                                <p class="metodo-simples-descricao">
                                    Pagamento aprovado na hora. Você poderá finalizar o seu Pix por meio do QR Code ou código no banco que preferir! Mas fique atento, este código só será válido por 24 horas.
                                </p>
                            </div>

                            <!-- Cartão de Crédito Local -->
                            <div class="metodo-pagamento-simples">
                                <div class="metodo-option">
                                    <input type="radio" id="credito" name="metodo_pagamento" value="credito" class="radio-hidden">
                                    <label for="credito" class="metodo-simples-label">
                                        <span class="checkmark"></span>
                                        <span class="metodo-simples-titulo">Cartão de crédito local com parcelamento</span>
                                    </label>
                                </div>
                                <div class="bandeiras-simples">
                                    <span class="bandeira-simples">VISA</span>
                                    <span class="bandeira-simples">Mastercard</span>
                                    <span class="bandeira-simples">AMERICAN EXPRESS</span>
                                    <span class="bandeira-simples">Discover</span>
                                    <span class="bandeira-simples">Diners Club</span>
                                </div>
                            </div>

                            <!-- Cartão de Débito -->
                            <div class="metodo-pagamento-simples">
                                <div class="metodo-option">
                                    <input type="radio" id="debito" name="metodo_pagamento" value="debito" class="radio-hidden">
                                    <label for="debito" class="metodo-simples-label">
                                        <span class="checkmark"></span>
                                        <span class="metodo-simples-titulo">Cartão de débito local/Internacional</span>
                                    </label>
                                </div>
                                <div class="bandeiras-simples">
                                    <span class="bandeira-simples">VISA</span>
                                    <span class="bandeira-simples">Mastercard</span>
                                    <span class="bandeira-simples">Discover</span>
                                    <span class="bandeira-simples">Diners Club</span>
                                </div>
                            </div>

                            <!-- PayPal -->
                            <div class="metodo-pagamento-simples">
                                <div class="metodo-option">
                                    <input type="radio" id="paypal" name="metodo_pagamento" value="paypal" class="radio-hidden">
                                    <label for="paypal" class="metodo-simples-label">
                                        <span class="checkmark"></span>
                                        <span class="metodo-simples-titulo">PayPal</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Boleto Bancário -->
                            <div class="metodo-pagamento-simples">
                                <div class="metodo-option">
                                    <input type="radio" id="boleto" name="metodo_pagamento" value="boleto" class="radio-hidden">
                                    <label for="boleto" class="metodo-simples-label">
                                        <span class="checkmark"></span>
                                        <span class="metodo-simples-titulo">Boleto Bancário</span>
                                    </label>
                                </div>
                            </div>
                        </section>

                        <hr class="divider">

                        <!-- Informações de Entrega -->
                        <section class="form-group">
                            <h2>Informações de Entrega</h2>
                            
                            <div class="input-group">
                                <label for="nome_completo">Nome Completo</label>
                                <input type="text" id="nome_completo" name="nome_completo" 
                                    placeholder="Digite seu nome completo" required>
                            </div>

                            <div class="input-group">
                                <label for="telefone">Telefone</label>
                                <input type="tel" id="telefone" name="telefone" 
                                    placeholder="(00) 00000-0000" required
                                    pattern="\([0-9]{2}\) [0-9]{4,5}-[0-9]{4}">
                            </div>

                            <div class="input-group">
                                <label for="endereco">Endereço Completo</label>
                                <textarea id="endereco" name="endereco" required 
                                        placeholder="Rua, número, bairro, cidade, estado e CEP" 
                                        required rows="3"></textarea>
                            </div>
                        </section>
                    </div>

                    <!-- Coluna da Direita - Resumo -->
                    <div class="resumo-section">
                        <div class="resumo-card">
                            <h2>Resumo do Pedido</h2>
                            
                            <div class="produtos-resumo">
                                <?php foreach($_SESSION['carrinho'] as $item): ?>
                                    <div class="produto-resumo">
                                        <div class="produto-info">
                                            <h4><?php echo htmlspecialchars($item['nome']); ?></h4>
                                            <span class="quantidade">Quantidade: <?php echo $item['quantidade']; ?></span>
                                        </div>
                                        <span class="preco">R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <hr class="divider">

                            <div class="resumo-totais">
                                <div class="total-linha">
                                    <span>Subtotal</span>
                                    <span>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                </div>
                                
                                <div class="total-linha">
                                    <span>Frete</span>
                                    <span>R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                                </div>
                                
                                <div class="total-linha total-final">
                                    <strong>Total</strong>
                                    <strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                                </div>
                            </div>

                            <button type="submit" name="finalizar_pedido" class="btn-confirmar-pedido">
                                <i class="fas fa-check-circle"></i> Confirmar Pedido
                            </button>

                            <a href="ver_carrinho.php" class="btn-voltar-carrinho">
                                <i class="fas fa-arrow-left"></i> Voltar ao Carrinho
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Script para formatação de campos -->
    <script>
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 7) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
        value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
        }
        e.target.value = value;
    });

    document.querySelectorAll('.metodo-pagamento-simples input').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.metodo-pagamento-simples').forEach(container => {
                container.classList.remove('selected');
            });
        
            if (this.checked) {
                const container = this.closest('.metodo-pagamento-simples');
                container.classList.add('selected');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('pix').checked = true;
        document.querySelector('#pix').closest('.metodo-pagamento-simples').classList.add('selected');
    });

    const form = document.querySelector('.checkout-form');
        if (form) {
        form.addEventListener('submit', function(e) {
            const metodoSelecionado = document.querySelector('input[name="metodo_pagamento"]:checked');
            if (!metodoSelecionado) {
                e.preventDefault();
                alert('Por favor, selecione um método de pagamento.');
                return;
            }

            const botaoConfirmar = document.querySelector('.btn-confirmar-pedido');
            if (botaoConfirmar) {
                botaoConfirmar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
                botaoConfirmar.disabled = true;
            }
});
}

</script>
</body>

</html>
