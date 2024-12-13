<?php
include 'config.php';

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_user = 'admin';
$admin_pass = 'admin123';
$hashed_admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT); // Criptografar a senha

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if ($username == $admin_user && password_verify($password, $hashed_admin_pass)) {
        $_SESSION['admin_logged_in'] = true;
        if ($remember) {
            setcookie('username', $username, time() + (86400 * 30), "/"); // 30 dias
            setcookie('password', $hashed_admin_pass, time() + (86400 * 30), "/"); // 30 dias
        } else {
            if (isset($_COOKIE['username'])) {
                setcookie('username', '', time() - 3600, "/");
            }
            if (isset($_COOKIE['password'])) {
                setcookie('password', '', time() - 3600, "/");
            }
        }
        // Redirecionar para a página de administrador
        header('Location: admin.php');
        exit;
    } else {
        $erro = "Usuário ou senha de administrador incorretos";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Administrador</title>
    <link rel="icon" href="./CSS/images/logo1.png">
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/login.css">
   



</head>

<body>
    <div class="container">
        <div><a href="index.php"><img src="CSS/images/logo2.png" alt=""></a></div>

        <h3>Olá Administrador!</h3>
        <p>Faça login para ter acesso à sua conta.</p>

        <form method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="Usuário Adm" autofocus required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Senha" required><br>
                <i class='bx bxs-lock-alt'></i>
            </div>
             <!-- MENSAGEM DE ERRO DE LOGIN-->
             <div class="error-message">
                    <?php
                    // Verifique se houve algum erro e exiba-o na div de mensagens de erro
                    if (isset($erro)) {
                    echo $erro;
                    }
                    ?>
                </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember">  Lembrar senha</label>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>



<button class="menu-btn" id="menu-btn" onclick="toggleNav()">☰</button>

<div class="nav-wrapper" id="navWrapper">   
    <button class="close-btn" id="close-btn">&times;</button>
    <nav>        
        <a href="index.php"><img src="CSS/images/logo1.png" alt=""></a>
        <a href="index.php">Home</a>            
        <a href="produtos.php">Produtos</a>            
        <a href="cart.php">Carrinho</a>
        <a href="register.php">Cadastro</a>
        <a href="login.php">Meu Login</a>
        <a href="admin.php">Admin</a>
        <a href="search.php">Pesquisar</a>
    </nav>
</div>

<style>

:root {
    --color-primary-1: #fff9ea;
    --color-primary-2: #bfbbff;
    --color-primary-3: #8794f4;
    --color-primary-4: #495ef8;
    --color-primary-5: #1128d0;
    --color-primary-6: #09198f;

    --color-neutral-0: #fff;
    --color-neutral-1: #333;
}

/* Adicione todo o estilo do navbar e do botão de menu aqui */
.nav-wrapper {
position: fixed;
top: 0;
right: -350px; /* Esconde o navbar inicialmente */
width: 250px; /* Define a largura do navbar */
background: linear-gradient(to top, rgba(179, 177, 177, 0.2) 50%, rgba(179, 177, 177, 0.2) 50%), url(CSS/images/op.jpg);
color: #fff;            
z-index: 9999; /* Z-index para garantir que o navbar fique sobre o conteúdo */
padding: 20px; /* Adiciona espaçamento interno */
overflow-y: auto; /* Adiciona uma barra de rolagem vertical se necessário */
height: 100%; /* Faz com que o navbar ocupe toda a altura da tela */            
}

.nav-wrapper img {   
width: 90px; 
} 

nav {
height: auto; /* Ajusta a altura automaticamente */
}

nav a {
text-decoration: none;
display: block;
color: #333;
font-weight: 400;
margin-top: 40px;
margin-bottom: 10px;
font-size: 17px;
text-align: center;
}

nav a:hover {
color: var(--color-primary-4);
}

.menu-btn {
position: fixed;
top: 25px;
right: 20px;
background: linear-gradient(to top, rgba(179, 177, 177, 0.2) 50%, rgba(179, 177, 177, 0.2) 50%), url(CSS/images/op.jpg);
color: #fff;
padding: 15px 25px; /* Ajusta o tamanho do botão */
font-size: 1em; /* Ajusta o tamanho do ícone */
border: none;
cursor: pointer;
z-index: 10000; /* Z-index para garantir que o botão fique sobre o navbar */
}

.menu-btn:focus {
outline: none;
}

.close-btn {
display: none;
position: absolute;
top: 20px;
right: 20px;
background: none;
border: none;
font-size: 1.5em;
color: #333;
cursor: pointer;
z-index: 10001; /* Z-index para garantir que o botão fique sobre o navbar */
}

.container {
padding: 20px;
margin-right: 250px; /* Adiciona margem à direita para o conteúdo não ser ocultado pelo navbar */
}

/* Classe para mostrar o menu */
.nav-wrapper.open {
right: 0;
}

.nav-wrapper.open .close-btn {
display: block; /* Mostra o botão de fechar quando o menu está aberto */
}

.container {
padding: 20px;
margin-left: 250px; /* Adiciona margem à direita para o conteúdo não ser ocultado pelo navbar */
}


     
/*ESTILO DO MENSAGEM DE ERRO */
.error-message {
color: red;
font-size: 13px; /* Defina o tamanho da fonte desejado */
text-align: center; /* Alinhe o texto à esquerda */
margin-right: 3px;
margin-bottom: 20px;
}


/*ESTILO DO LOGIN*/
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');


* {
padding: 0;
margin: 0;
box-sizing: border-box;
font-family:'inter', sans-serif;
}

body{
display: flex;
justify-content: center;
align-items: center;
min-height: 100vh;
background: #fff9ea;
background-size: cover;
background-position: center;
    
}

.container{
width: 30%;
max-width: 500px; /* Limite máximo de largura para manter o cartão consistente */
height: 93vh;
background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(CSS/images/op.jpg);
border: 2px solid rgba(255, 255, 255, .2);
backdrop-filter: blur(20px);
box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);   
color: #1a1919;
border-radius: 5px;
padding: 80px 40px;
text-align: center;
margin: 20px; /* Adiciona espaço ao redor do contêiner */

}

.container h3 {
text-align: center;
}

.container img{
width: 30%;
height: auto;
display: center;
align-items: flex-start;
    
}

.container .input-box{
position: relative; 
width: 100%;
height: 50px;
margin: 30px 0;
    
}

.input-box input{
width: 100%;
height: 100%;
background: transparent;
border: none;
outline: none;
border-radius: 10px;
padding: 20px 45px 20px 20px;
margin: 0.6rem 0;
padding: 0.8rem 1.2rem;
border: none;
box-shadow: 1px 1px 6px #0000001c;
font-size: 0.8rem;

}
.input-box input::placeholder{
color: #000000be;
    
}
.input-box i {
position: absolute;
right: 20px;
top: 70%;
transform: translateY(-50%);
   

}
.input-box input:hover {
background-color: #eeeeee75;
}

.input-box input:focus-visible {
outline: 1px solid #6c63ff;
}

.container .remember-forgot{
display: flex;
justify-content: space-between;
font-size: 14.5px;
margin: -15px 0 15px;   
padding: 20px 45px 20px 20px;
padding: 0.8rem 1.2rem;
font-size: 0.8rem;
}

.remember-forgot label input {   
accent-color: #383838be;
margin-right: 3px;

}
.remember-forgot a {
color: #000000be;
text-decoration: none;
    

}
.remember-forgot a:hover {
text-decoration: underline;

}

.container .btn{
width: 100%;
height: 40px;
background: linear-gradient(-45deg, #bfbbff, #1128d0);
border: none;
outline: none;
border-radius: 12px;
box-shadow: 0 0 10px rgba(0, 0, 0, .1);
cursor: pointer;
font-size: 16px;
color: #ffffff;
margin: 10px 0;
padding: 0.62rem;

}


.btn:hover {
background-color: #8794f4;
}

.container .register-link {
font-size: 14.5px;
text-align: center;
margin-top: 20px 0 15px;

}
.register-link p a {
color: #000000be;
text-decoration: none;
font-weight: 600;
}

.register-link p a:hover{
text-decoration: underline;

}

/* Adicionando regras de mídia para tornar o layout responsivo em dispositivos móveis */

/* Quando a largura da tela for menor ou igual a 576 pixels (celulares em modo retrato) */
@media screen and (max-width: 576px) {
    body {
        align-items: flex-start; /* Alinha o conteúdo ao início da página */
        background-position: top; /* Ajusta a posição do plano de fundo */
    }

    .container {
        width: 100%; /* O contêiner ocupará toda a largura da tela */
        max-width: 100%; /* Remove o limite máximo de largura */
        padding: 20px; /* Reduz o preenchimento */
        margin: 0; /* Remove a margem */
        border-radius: 0; /* Remove as bordas arredondadas */
    }

    .container img {
        width: 70%; /* Reduz o tamanho da imagem */
        margin: 0 auto; /* Centraliza a imagem */
    }

    .container .input-box {
        margin: 15px 0; /* Reduz a margem */
    }

    .container .remember-forgot,
    .register-link {
        padding: 10px; /* Reduz o preenchimento */
        font-size: 14px; /* Reduz o tamanho da fonte */
    }

    .container .btn {
        font-size: 14px; /* Reduz o tamanho da fonte do botão */
        padding: 8px; /* Reduz o preenchimento do botão */
    }
}


/* Responsividade adicional para tablets */
@media screen and (max-width: 768px) {
    .container {
        width: 100%; /* Ajusta a largura para tablets */
        max-width: 100%; /* Remove o limite máximo de largura */
        padding: 20px; /* Ajusta o padding */
    }

    .container img {
        width: 50%; /* Ajusta o tamanho da imagem */
    }

    .container .input-box {
        height: 45px; /* Ajusta a altura das caixas de input */
    }
}

/* Responsividade adicional para laptops pequenos */
@media screen and (max-width: 1024px) {
    .container {
        width: 85%; /* Ajusta a largura para laptops pequenos */
        max-width: 100%; /* Remove o limite máximo de largura */
    }

    .container .input-box {
        height: 50px; /* Ajusta a altura das caixas de input */
    }
}

</style>

<script>
    function toggleNav() {
        var navWrapper = document.getElementById('navWrapper');
        var menuButton = document.querySelector('.menu-btn');
        if (navWrapper.classList.contains('open')) { // Verifica se o navbar está aberto
            navWrapper.classList.remove('open'); // Fecha o navbar
            menuButton.style.display = "block"; // Mostra o botão
        } else {
            navWrapper.classList.add('open'); // Abre o navbar
            menuButton.style.display = "none"; // Esconde o botão
        }
    }

    document.getElementById('close-btn').addEventListener('click', toggleNav);
</script>
</body>
</html>
