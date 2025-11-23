<?php
session_start();
include_once('config.php');

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['usuario_id'];

// CORREÇÃO: Usar Prepared Statement
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

// Verificar se usuário foi encontrado
if(!$usuario) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    
    <!-- Importação dos estilos -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/perfil.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Conteúdo principal -->
    <main>
        <div class="perfil-container">
            <h2>Meu Perfil</h2>
            
            <div class="perfil-info">
                <div class="info-group">
                    <label>Nome:</label>
                    <span><?php echo htmlspecialchars($usuario['nome']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>Email:</label>
                    <span><?php echo htmlspecialchars($usuario['email']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>CPF:</label>
                    <span><?php echo htmlspecialchars($usuario['cpf']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>Telefone:</label>
                    <span><?php echo htmlspecialchars($usuario['telefone']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>Cidade:</label>
                    <span><?php echo htmlspecialchars($usuario['cidade']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>Endereço:</label>
                    <span><?php echo htmlspecialchars($usuario['endereco']); ?></span>
                </div>
                
                <div class="info-group">
                    <label>Número:</label>
                    <span><?php echo htmlspecialchars($usuario['numero']); ?></span>
                </div>
            </div>
            
            <a href="index.php" class="btn-voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar para o Início
            </a>
            
            <a href="logout.php" class="btn-sair">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a>
        </div>
    </main>
</body>
</html>