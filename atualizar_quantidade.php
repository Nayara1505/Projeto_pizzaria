<?php
session_start();

if(!isset($_SESSION['usuario_id'])) {
    echo 'not_logged_in';
    exit;
}

if(!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo 'empty_cart';
    exit;
}

if(isset($_POST['produto_id']) && isset($_POST['alteracao'])) {
    $produto_id = intval($_POST['produto_id']);
    $alteracao = intval($_POST['alteracao']);

    foreach($_SESSION['carrinho'] as &$item) {
        if($item['id'] == $produto_id) {
            $nova_quantidade = $item['quantidade'] + $alteracao;
            
            if($nova_quantidade < 1) {
                echo 'min_reached';
                exit;
            }
            
            $estoque_maximo = 10;
            if($nova_quantidade > $estoque_maximo) {
                echo 'stock_exceeded';
                exit;
            }
            
            $item['quantidade'] = $nova_quantidade;
            echo 'success';
            exit;
        }
    }
    
    echo 'product_not_found';
} else {
    echo 'missing_data';
}
?>