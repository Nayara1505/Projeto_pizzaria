<?php
session_start();

if(isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    $total_itens = 0;
    foreach($_SESSION['carrinho'] as $item) {
        $total_itens += $item['quantidade'];
    }
    echo $total_itens;
} else {
    echo '0';
}
?>