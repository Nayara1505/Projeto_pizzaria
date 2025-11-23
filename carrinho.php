<?php
session_start();

if(!isset($_SESSION['usuario_id'])) {
    echo 'not_logged_in';
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = array();
    }
    
    if(isset($_POST['produto_id']) && isset($_POST['produto_nome']) && isset($_POST['produto_preco'])) {
        
        $produto_id = intval($_POST['produto_id']);
        $produto_nome = htmlspecialchars(trim($_POST['produto_nome']));
        $produto_preco = floatval($_POST['produto_preco']);
        
        if($produto_id <= 0 || $produto_preco <= 0 || empty($produto_nome)) {
            echo 'error';
            exit;
        }
        
        $produto_existente = false;
        foreach($_SESSION['carrinho'] as &$item) {
            if($item['id'] == $produto_id) {
                $item['quantidade'] += 1; 
                $produto_existente = true;
                break;
            }
        }
        
        if(!$produto_existente) {
            $produto = array(
                'id' => $produto_id,
                'nome' => $produto_nome,
                'preco' => $produto_preco,
                'quantidade' => 1
            );
            
            $_SESSION['carrinho'][] = $produto;
        }
        
        echo 'success';
        exit;
        
    } else {
        echo 'error';
        exit;
    }
    
} else {
    echo 'error';
    exit;
}
?>