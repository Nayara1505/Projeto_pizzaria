<?php
session_start();
include_once('config.php');

if (isset($_POST['submit']))
{
    // Coletar dados SEM mysqli_real_escape_string (não necessário com prepared statements)
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $cidade = trim($_POST['cidade']);
    $endereco = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 

    // ========== VALIDAÇÕES ADICIONAIS ==========
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Por favor, insira um email válido!');
                window.location.href = 'cadastro.php';
              </script>";
        exit;
    }

    // Validar CPF (exatamente 11 dígitos)
    if (strlen($cpf) != 11 || !is_numeric($cpf)) {
        echo "<script>
                alert('CPF deve conter exatamente 11 dígitos numéricos!');
                window.location.href = 'cadastro.php';
              </script>";
        exit;
    }

    // Validar telefone (10 ou 11 dígitos - celular ou fixo)
    if (strlen($telefone) < 10 || strlen($telefone) > 11 || !is_numeric($telefone)) {
        echo "<script>
                alert('Telefone deve conter 10 ou 11 dígitos numéricos!');
                window.location.href = 'cadastro.php';
              </script>";
        exit;
    }
    // ========== FIM DAS VALIDAÇÕES ==========

    // VERIFICAÇÃO DE EMAIL EXISTENTE (também deve usar prepared statement)
    $check_stmt = mysqli_prepare($conexao, "SELECT email FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
                alert('Este email já está cadastrado!');
                window.location.href = 'cadastro.php';
              </script>";
        mysqli_stmt_close($check_stmt);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // INSERÇÃO PRINCIPAL
    $stmt = mysqli_prepare($conexao, 
        "INSERT INTO usuarios(nome, email, cpf, telefone, cidade, endereco, numero, senha) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($stmt, "ssssssss", $nome, $email, $cpf, $telefone, $cidade, $endereco, $numero, $senha);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'login.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Erro ao cadastrar!');
                window.location.href = 'cadastro.php';
              </script>";
    }
    
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/cadastro.css">
</head>
<body>

    <div class="cadastro-container">

        <h2>Criar conta</h2>
        <p>Preencha os dados abaixo para criar sua conta</p>

        <form action="cadastro.php" method="POST">

            <div class="input-group">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
            </div>

            <div class="input-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>

            <div class="input-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
            </div>

            <div class="input-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" placeholder="Sua cidade" required>
            </div>

            <div class="input-group">
                <label for="endereco">Endereço</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, bairro..." required>
            </div>

            <div class="input-group">
                <label for="numero">Número da residência</label>
                <input type="text" id="numero" name="numero" placeholder="000" required>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
            </div>

            <button class="btn-cadastrar" type="submit" name="submit">Cadastrar</button>
        </form>

        <a href="index.php" class="btn-voltar">
            <i class="fa-solid fa-arrow-left"></i> Voltar para o Início
        </a>

        <div class="login-link">
            Já tem uma conta? <a href="login.php">Entrar</a>
        </div>

    </div>

</body>
</html>