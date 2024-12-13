<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="./CSS/images/logo1.png">
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


</style>


    <div class="container">
        <!-- Conteúdo da página --> 
   
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