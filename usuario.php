<?php
include 'config.php';

// Verificar se uma sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Obtenha os dados do usuário
$user_id = $_SESSION['user_id'];
$sql = "SELECT firstname, lastname, cpf, birthdate, email, phone, cep, address, neighborhood, city, gender FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Atualização dos dados do usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $sql = "UPDATE users SET firstname=?, lastname=?, cpf=?, birthdate=?, email=?, phone=?, cep=?, address=?, neighborhood=?, city=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $firstname, $lastname, $cpf, $birthdate, $email, $phone, $cep, $address, $neighborhood, $city, $gender, $user_id);
    if ($stmt->execute()) {
        // Atualize o nome do usuário na sessão
        $_SESSION['user_name'] = $firstname;
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados: " . $stmt->error;
    }
    $stmt->close();

    header("Location: usuario.php");
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="#">
    <link rel="icon" href="./CSS/images/logo1.png">
    <title>Perfil do Usuário</title>
</head>
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
<body>
    <div class="main-container">
        <div class="left-content">
            <div class="content">
                <h2>Deseja Sair?</h2>
                <p>Faça logout para sair da sua conta</p>
                <br>
                <button class="btn" id="login"><a href="?logout">Logout</a></button>
                <br><br>
                <img src="CSS/images/img3.svg" alt="">
            </div>
        </div>

        <div class="right-content">
            <form method="POST">
                <div class="form-header">
                    <div class="title">
                        <a href="index.php"><img src="CSS/images/logo2.png" alt="" class="logo"></a>
                        <h3>PERFIL DO USUÁRIO</h3>
                        <p>Atualizar dados cadastrais</p>
                    </div>
                </div>
                
                <div class="input-group">
                    <div class="input-box">
                        <label for="firstname">Primeiro Nome</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" placeholder="Digite seu primeiro nome" required>
                    </div>

                    <div class="input-box">
                        <label for="lastname">Sobrenome</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" placeholder="Digite seu sobrenome" required>
                    </div>

                    <div class="input-box">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>" placeholder="Digite seu CPF" required>
                    </div>

                    <div class="input-box">
                        <label for="birthdate">Data de Nascimento</label>
                        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="input-box">
                        <label for="phone">Celular</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="(xx) xxxx-xxxx" required>
                    </div>

                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($user['cep']); ?>" placeholder="Digite seu CEP" required>
                    </div>

                    <div class="input-box">
                        <label for="address">Endereço</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Digite nome da rua" required>
                    </div>

                    <div class="input-box">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" name="neighborhood" value="<?php echo htmlspecialchars($user['neighborhood']); ?>" placeholder="Digite nome do bairro" required>
                    </div>

                    <div class="input-box">
                        <label for="city">Cidade</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" placeholder="Digite nome da cidade" required>
                    </div>
                </div>

                <div class="gender-inputs">
                    <div class="gender-title">
                        <h6>Gênero</h6>
                    </div>
                    <div class="gender-group">
                        <div class="gender-input">
                            <input id="female" type="radio" name="gender" value="Feminino" required <?php if($user['gender'] == 'Feminino') echo 'checked'; ?>>
                            <label for="female">Feminino</label>
                        </div>
                        <div class="gender-input">
                            <input id="male" type="radio" name="gender" value="Masculino" required <?php if($user['gender'] == 'Masculino') echo 'checked'; ?>>
                            <label for="male">Masculino</label>
                        </div>
                        <div class="gender-input">
                            <input id="others" type="radio" name="gender" value="Outros" required <?php if($user['gender'] == 'Outros') echo 'checked'; ?>>
                            <label for="others">Outros</label>
                        </div>
                        <div class="gender-input">
                            <input id="none" type="radio" name="gender" value="Prefiro não dizer" required <?php if($user['gender'] == 'Prefiro não dizer') echo 'checked'; ?>>
                            <label for="none">Prefiro não dizer</label>
                        </div>
                    </div>
                </div>

                <div class="continue-button">
                    <button type="submit">Atualizar Dados</button>
                </div>
            </form>
        </div>
    </div>

    <!-- navbar -->
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

        /* ESTILO DO CADASTRO */
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
            padding: 2rem; /* Adiciona padding para um espaçamento interno */
        }

        .left-content img {
            max-width: 80%; /* Ajusta o tamanho máximo da imagem */
            height: auto;
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
            background-color: #fff;
            padding: 3rem;
            border: 1px solid #ccc;
            box-sizing: border-box;
            overflow-y: auto; /* Adiciona rolagem vertical */
            height: 100%; /* Ajusta a altura para ocupar toda a altura do contêiner principal */
        }

        .form-header {
            margin-top: 1rem;
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
                flex-direction: column;
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
                flex-direction: column; /* Alinha os inputs verticalmente em dispositivos menores */
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
                overflow-y: scroll; /* Adiciona rolagem vertical */
            }
            .input-group {
                flex-direction: column;
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
