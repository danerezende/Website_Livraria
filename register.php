<?php
include 'config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores do formulário
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $cpf = $_POST['cpf'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cep = $_POST['cep'];
    $address = $_POST['address'];
    $neighborhood = $_POST['neighborhood'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Verificação básica dos dados do formulário
    if (!empty($birthdate)) {
        $date = DateTime::createFromFormat('Y-m-d', $birthdate);
        if ($date && $date->format('Y-m-d') === $birthdate) {
            // Verifique se o email, telefone ou CPF já estão cadastrados
            $sql = "SELECT * FROM users WHERE email = ? OR phone = ? OR cpf = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $email, $phone, $cpf);
                $stmt->execute();
                $stmt->store_result();
                
                if ($stmt->num_rows > 0) {
                    $error_message = "Usuário já cadastrado";
                } else {
                    // Criptografe a senha
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Prepare a consulta SQL para inserir os dados no banco de dados
                    $sql = "INSERT INTO users (firstname, lastname, cpf, birthdate, email, phone, cep, address, neighborhood, city, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    // Use prepared statements para prevenir SQL Injection
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("ssssssssssss", $firstname, $lastname, $cpf, $birthdate, $email, $phone, $cep, $address, $neighborhood, $city, $gender, $hashed_password);

                        // Execute a consulta
                        if ($stmt->execute()) {
                            // Exiba a mensagem de registro bem-sucedido e redirecione para a página de login após 0.5 segundos
                            echo "<script>
                                alert('Registro bem-sucedido!');
                                setTimeout(function() {
                                    window.location.href = 'login.php';
                                }, 500); // Redireciona após 0.5 segundos
                            </script>";
                        } else {
                            $error_message = "Erro: " . $stmt->error;
                        }
                    } else {
                        $error_message = "Erro: " . $conn->error;
                    }
                }
                $stmt->close();
            } else {
                $error_message = "Erro: " . $conn->error;
            }
        } else {
            $error_message = "Data de nascimento inválida.";
        }
    } else {
        $error_message = "A data de nascimento é obrigatória.";
    }

    // Feche a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="CSS/cadastro.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="./CSS/images/logo1.png">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function applyMask(input, mask) {
                input.addEventListener("input", function() {
                    var value = input.value.replace(/\D/g, '');
                    var newValue = '';
                    var maskIndex = 0;
                    for (var i = 0; i < value.length; i++) {
                        while (maskIndex < mask.length && mask[maskIndex].match(/\D/)) {
                            newValue += mask[maskIndex++];
                        }
                        if (maskIndex < mask.length) {
                            newValue += value[i];
                            maskIndex++;
                        }
                    }
                    input.value = newValue;
                });
            }

            var cpfInput = document.getElementById("cpf");
            var phoneInput = document.getElementById("phone");
            var cepInput = document.getElementById("cep");

            applyMask(cpfInput, "999.999.999-99");
            applyMask(phoneInput, "(99) 9 9999-9999");
            applyMask(cepInput, "99999-999");

            cpfInput.setAttribute("maxlength", "14"); // Máximo de caracteres para CPF (11 dígitos + 3 pontos + hífen)
            phoneInput.setAttribute("maxlength", "16"); // Máximo de caracteres para telefone (11 dígitos + 4 espaços e parênteses)
            cepInput.setAttribute("maxlength", "9"); // Máximo de caracteres para CEP (8 dígitos + hífen)
        });
    </script>
    <!-- Validação senha-->
    <script>
        function validarSenha() {
            var senha = document.getElementById("password").value;
            var confirmarSenha = document.getElementById("confirmPassword").value;

            if (senha != confirmarSenha) {
                alert("As senhas não coincidem. Por favor, digite as senhas novamente.");
                return false;
            }
            return true;
        }
        
    </script>

    <!-- Usuario já cadastrado-->
    <style>
        .error-message {
            color: red;
            font-size: 13px; /* Defina o tamanho da fonte desejado */
            text-align: center; /* Alinhe o texto à esquerda */
            margin-right: 3px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>  

    <div class="main-container">
        <div class="left-content">
            <div class="content">            
                <h2>Já Possui Conta?</h2>        
                <p>Faça login para entrar em sua conta</p>
                <br> 
                
                <!-- Usuario já cadastrado-->
                <div class="error-message">
                    <?php
                    if (!empty($error_message)) {
                        echo $error_message;
                    }
                    ?>
                </div>

                <button class="btn" id="login"><a href="login.php">Login</a></button>
                <br><br>
                
                <img src="CSS/images/img.svg" alt="">
            </div>
        </div>

        <div class="right-content">
            <form method="post" action="register.php" onsubmit="return validarSenha()">
                <div class="form-header">     
                    <div class="title">
                        <a href="index.php"><img src="CSS/images/logo2.png" alt="" class="logo"></a> 
                        <h3>Cadastre-se</h3>                   
                    </div>                                     
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="firstname">Primeiro Nome</label>
                        <input id="firstname" type="text" name="firstname" placeholder="Digite seu primeiro nome" required>            
                    </div>

                    <div class="input-box">
                        <label for="lastname">Sobrenome</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Digite seu sobrenome" required>
                    </div>

                    <div class="input-box">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
                    </div>

                    <div class="input-box">
                        <label for="birthdate">Data de Nascimento</label>
                        <input type="date" id="birthdate" name="birthdate" required>
                    </div>

                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="input-box">
                        <label for="phone">Celular</label>
                        <input type="text" id="phone" name="phone" placeholder="(xx) xxxx-xxxx" required>
                    </div>

                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep"  placeholder="Digite seu CEP"  required>
                    </div>

                    <div class="input-box">
                        <label for="address">Endereço</label>
                        <input type="text" id="address" name="address" placeholder="Digite nome da rua" required>
                    </div>

                    <div class="input-box">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" id="neighborhood" name="neighborhood" placeholder="Digite nome do bairro"  required>
                    </div>

                    <div class="input-box">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" name="city" placeholder="Digite nome da cidade" required>
                    </div>

                    <div class="input-box">
                        <label for="password">Senha</label>
                        <input id="password" type="password" name="password" placeholder="Digite sua senha" maxlength="8" required>
                    </div>

                    <div class="input-box">
                        <label for="confirmPassword">Confirme sua Senha</label>                        
                        <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Digite sua senha novamente" maxlength="8" required>
                    </div> 
                </div>   

                <div class="gender-inputs">
                    <div class="gender-title">
                        <h6>Gênero</h6>
                    </div>
                    <div class="gender-group">
                        <div class="gender-input">
                            <input id="female" type="radio" name="gender" value="Feminino" required>
                            <label for="female">Feminino</label>
                        </div>
                        <div class="gender-input">
                            <input id="male" type="radio" name="gender" value="Masculino" required>
                            <label for="male">Masculino</label>
                        </div>
                        <div class="gender-input">
                            <input id="others" type="radio" name="gender" value="Outros" required>
                            <label for="others">Outros</label>
                        </div>
                        <div class="gender-input">
                            <input id="none" type="radio" name="gender" value="Prefiro não dizer" required>
                            <label for="none">Prefiro não dizer</label>
                        </div>
                    </div>           
                </div>

                <div class="continue-button">
                    <button type="submit">Continuar</button>
                </div>
            </form>
            <!-- Usuario já cadastrado-->
            <div class="error-message">
                <?php
                if (!empty($error_message)) {
                    echo $error_message;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- navbar-->
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
        <a href="admin_login.php">Login Admin</a>
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
color: #495ef8;
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


/* Classe para mostrar o menu */
.nav-wrapper.open {
right: 0;
}

.nav-wrapper.open .close-btn {
display: block; /* Mostra o botão de fechar quando o menu está aberto */
}


/* ESTILO CADASTRO */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap');
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff9ea;
}

.main-container {
    width: 70%;
    display: flex;
    flex-wrap: nowrap;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);
    overflow: hidden; /* Para garantir que o conteúdo não saia dos limites do container */
    height: 90vh; /* Ajusta a altura para ocupar quase toda a tela */
}

.left-content, .right-content {
    flex: 1 1 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Ajusta a altura para ocupar toda a altura do contêiner principal */
    flex-direction: column; /* Alinha os itens em coluna */
}

.left-content {
    background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(CSS/images/op.jpg);
    background-size: cover;
    background-position: center;
    padding: 1rem; /* Adiciona padding para um espaçamento interno */
}

.left-content img {
    width: 25rem;
}

.left-content .content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #1a1919;
    margin-top: 1rem; /* Adiciona margem superior para o conteúdo abaixo da imagem */
}

.btn {
    width: 60%; /* Ajusta a largura do botão */
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

.btn a {
    text-decoration: none;
    font-size: 0.93rem;
    font-weight: 500;
    color: #fff;
}

.right-content {
    overflow-y: auto; /* Habilita a rolagem vertical conforme necessário */
    background-color: #fff;
    padding: 3rem;
    border: 1px solid #ccc;
    box-sizing: border-box;
    height: 100%; /* Ajusta a altura para ocupar toda a altura do contêiner principal */
}

.form-header {
    margin-top: 140px; /* Adiciona margem acima do container */
    margin-bottom: 1rem;
    display: flex;
    flex-direction: column;
    text-transform: uppercase;
}

.form-header img {
    width: 5rem;
    justify-content: space-between;
    float: right;
    margin-top: 30px;
}

.title {
    display: flex;
    justify-content: space-between; /* Distribui os itens uniformemente ao longo do eixo principal */
    align-items: center;
    flex-direction: column;
    float: left;

}

.input-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 1rem 0;
}

.input-box {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.1rem;
    flex: 0.47;
}

.input-box input {
    margin: 0.6rem 0;
    padding: 0.8rem 1.2rem;
    border: none;
    border-radius: 10px;
    box-shadow: 1px 1px 6px #0000001c;
    font-size: 0.8rem;
}

.input-box input:hover {
    background-color: #eeeeee75;
}

.input-box input:focus-visible {
    outline: 1px solid #6c63ff;
}

.input-box label,
.gender-title h6 {
    font-size: 0.75rem;
    font-weight: 600;
    color: #000000c0;
}

.input-box input::placeholder {
    color: #000000be;
}

.gender-group {
    display: flex;
    justify-content: space-between;
    margin-top: 0.62rem;
    padding: 0 .5rem;
}

.gender-input {
    display: flex;
    align-items: center;
}

.gender-input input {
    margin-right: 0.35rem;
}

.gender-input label {
    font-size: 0.81rem;
    font-weight: 600;
    color: #000000c0;
}

.continue-button button {
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

.continue-button button:hover {
    background-color: #8794f4;
}

@media (max-width: 1330px) {
    .main-container {
        width: 90%;
    }
    .right-content {
        padding: 2rem;
    }
}

@media (max-width: 1064px) {
    .main-container {
        flex-direction: row;
        align-items: center;
        height: auto;
    }
    .left-content {
        display: none; /* Oculta o conteúdo esquerdo em dispositivos menores */
    }
    .right-content {
        width: 100%;
        height: auto;
        padding: 2rem; /* Adiciona padding para melhorar a visualização */
    }
    .input-group {
        flex-direction: row; /* Alinha os inputs verticalmente em dispositivos menores */
        width: 100%;
    }
    .input-box {
        width: 100%;
    }
    .gender-group {
        flex-direction: column;
        padding: 0;
    }
    .gender-input {
        margin-bottom: 10px;
    }
}

@media (max-width: 768px) {
    .main-container {
        width: 100%;
        height: 100vh; /* Ocupa toda a altura da tela */
        padding: 0;
    }
    .right-content {
        padding: 1rem;
        height: auto; /* Adiciona rolagem vertical */
    }
    .input-group {
        flex-direction: row;
        width: 100%;
    }
    .input-box {
        width: 100%;
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
