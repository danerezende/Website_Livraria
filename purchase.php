<?php
include 'config.php';
include 'navbar.php';

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Seu carrinho está vazio.";
    exit();
}

// Lógica para processar o pagamento e registrar a compra
// Aqui você pode adicionar o código para registrar a compra no banco de dados, enviar e-mails de confirmação, etc.

// Limpar o carrinho após finalizar a compra
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Finalizada</title>
    <link rel="icon" href="./CSS/images/logo1.png">
    
</head>
<body>
<div class="menu">
         <br>
         <br>
         <br>
            <h2 class="section-title">Compra Finalizada com Sucesso!</h2>
            <p>Obrigado por sua compra. <br> Você receberá um e-mail de confirmação em breve.</p>
    <a href="index.php">Voltar à Página Inicial</a>
</body>
        </div> 
  
    


<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #fff9ea;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

h2 {
    color: #333;
    font-weight: 500;
    font-size: 22px;
    margin-bottom: 20px;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    margin-top: 20px;
    text-align: center;
    
}

/* Estilo para o parágrafo */
p {
    font-size: 16px;
    line-height: 1.6;
    text-align: center;
    margin-bottom: 30px;
}

/* Estilo para o link de voltar */
a {
    text-decoration: none;
    color: #333; 
    font-weight: bold;
   
}
a:hover {
    text-decoration: underline;
}

</style>
</html>
