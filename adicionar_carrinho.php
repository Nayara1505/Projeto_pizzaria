<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = array();
    }
    
    if(isset($_POST['produto_id']) && isset($_POST['produto_nome']) && isset($_POST['produto_preco'])) {
        
        $produto_id = $_POST['produto_id'];
        $produto_nome = $_POST['produto_nome'];
        $produto_preco = floatval($_POST['produto_preco']);
        
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