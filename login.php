<?php
session_start();
include_once('config.php');

if(isset($_POST['submit']))
{
    // Validação básica
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'];

    if(!$email || empty($senha)) {
        echo "<script>alert('Dados inválidos');</script>";
    } else {
        // Usando prepared statements para prevenir SQL Injection
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verificar senha com hash (assumindo que está usando password_hash)
            if(password_verify($senha, $user['senha'])) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['email'] = $user['email'];

                header("Location: index.php");
                exit;
            } else {
                // Mensagem genérica para não revelar qual campo está errado
                echo "<script>alert('Credenciais inválidas');</script>";
            }
        } else {
            echo "<script>alert('Credenciais inválidas');</script>";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>

    <div class="login-container">
        <h2>Entrar</h2>  
        <p>Digite suas credenciais para acessar sua conta</p>

        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="********" required>
            </div>

            <button class="btn-login" type="submit" name="submit">Entrar</button> 
        </form>

        <a href="index.php" class="btn-voltar">
            <i class="fa-solid fa-arrow-left"></i> Voltar para o Início
        </a>

        <div class="register-link">
            Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
        </div>
    </div>
</body>
</html>