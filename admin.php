<?php
include 'config.php';

// Verificar se uma sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado como administrador
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Logout do administrador
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_book'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = "O arquivo não é uma imagem.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $message = "Desculpe, o arquivo já existe.";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 500000) {
            $message = "Desculpe, o seu arquivo é muito grande.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $message = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $message = "Desculpe, o seu arquivo não foi carregado.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO books (title, author, genre, price, image_path) VALUES ('$title', '$author', '$genre', '$price', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    $message = "Livro adicionado com sucesso!";
                } else {
                    $message = "Erro: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $message = "Desculpe, houve um erro ao carregar seu arquivo.";
            }
        }
    } elseif (isset($_POST['remove_book'])) {
        $book_id = $_POST['book_id'];

        $sql = "SELECT image_path FROM books WHERE id='$book_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }
        }

        $sql = "DELETE FROM books WHERE id='$book_id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Livro removido com sucesso!";
        } else {
            $message = "Erro: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update_book'])) {
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];

        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message = "O arquivo não é uma imagem.";
                $uploadOk = 0;
            }

            if (file_exists($target_file)) {
                $message = "Desculpe, o arquivo já existe.";
                $uploadOk = 0;
            }

            if ($_FILES["image"]["size"] > 500000) {
                $message = "Desculpe, o seu arquivo é muito grande.";
                $uploadOk = 0;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $message = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $message = "Desculpe, o seu arquivo não foi carregado.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', price='$price', image_path='$target_file' WHERE id='$book_id'";
                    if ($conn->query($sql) === TRUE) {
                        $message = "Livro atualizado com sucesso!";
                    } else {
                        $message = "Erro: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    $message = "Desculpe, houve um erro ao carregar seu arquivo.";
                }
            }
        } else {
            $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', price='$price' WHERE id='$book_id'";
            if ($conn->query($sql) === TRUE) {
                $message = "Livro atualizado com sucesso!";
            } else {
                $message = "Erro: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Livros</title>
    <link rel="icon" href="./CSS/images/logo1.png">
    <!-- Importando fontes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Adicionar Livro</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="input-box">
                <input type="text" name="title" placeholder="Título" required>
            </div>
            <div class="input-box">
                <input type="text" name="author" placeholder="Autor" required>
            </div>
            <div class="input-box">
                <input type="text" name="genre" placeholder="Gênero">
            </div>
            <div class="input-box">
                <input type="text" name="price" placeholder="Preço">
            </div>
            <div class="input-box">
                <input type="file" name="image" accept="image/*" required>
            </div>
            <div class="input-box">
                <input type="submit" name="add_book" value="Adicionar" class="btn">
            </div>
        </form>

        <h2>Remover Livro</h2>
        <form method="post">
            <div class="input-box">
                <select name="book_id" required>
                    <option value="">Selecione um livro</option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="input-box">
                <input type="submit" name="remove_book" value="Remover" class="btn">
            </div>
        </form>

        <h2>Atualizar Livro</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="input-box">
                <select id="book_id" name="book_id" required>
                    <option value="">Selecione um livro</option>
                    <?php
                    $result = $conn->query("SELECT * FROM books");
                    while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="input-box">
                <input type="text" id="title" name="title" placeholder="Título">
            </div>
            <div class="input-box">
                <input type="text" id="author" name="author" placeholder="Autor">
            </div>
            <div class="input-box">
                <input type="text" id="genre" name="genre" placeholder="Gênero">
            </div>
            <div class="input-box">
                <input type="text" id="price" name="price" placeholder="Preço">
            </div>
            <div class="input-box">
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="input-box">
                <input type="submit" name="update_book" value="Atualizar" class="btn">
            </div>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>

    <button class="menu-btn" id="menu-btn" onclick="toggleNav()">☰</button>

    <div class="nav-wrapper" id="navWrapper">   
        <button class="close-btn" id="close-btn">&times;</button>
        <nav>
            <a href="index.php"><img src="CSS/images/logo1.png" alt=""></a>
            <a href="index.php">Home</a>            
            <a href="produtos.php">Produtos</a>            
            <a href="cart.php">Carrinho</a>
            <a href="admin.php?logout">Logout</a>
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

        /*ESTILO DO LOGIN*/
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family:'inter', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #fff9ea;
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 30%;
            max-width: 500px; /* Limite máximo de largura para manter o cartão consistente */
            height: 150vh;
            background: linear-gradient(to top, rgba(210, 208, 208, 0.2) 50%,rgba(210, 208, 208, 0.2) 50%), url(CSS/images/op.jpg);
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

        .container img {
            width: 30%;
            height: auto;
            display: center;
            align-items: flex-start;
        }

        .container .input-box {
            position: relative; 
            width: 100%;
            height: 50px;
            margin: 20px 0;
        }

        .input-box input {
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

        .input-box input::placeholder {
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

        .container .remember-forgot {
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

        .container .btn {
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

        .register-link p a:hover {
            text-decoration: underline;
        }

        /* Adicionando regras de mídia para tornar o layout responsivo em dispositivos móveis */
        @media screen and (max-width: 576px) {
            body {
                align-items: flex-start; /* Alinha o conteúdo ao início da página */
                background-position: top; /* Ajusta a posição do plano de fundo */
            }

            .container {
                width: 100%; /* O contêiner ocupará toda a largura da tela */
                height: 140vh;
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

        /*ESTILO DO MENSAGEM DE INSERÇÃO OU REMOÇÃO */
        .message {
            color: black;
            font-size: 14px; /* Defina o tamanho da fonte desejado */
            font-weight: 500;
            text-align: center; 
            text-transform: uppercase;
            margin-right: 3px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#book_id').change(function() {
            var book_id = $(this).val();
            if (book_id) {
                $.ajax({
                    url: 'get_book.php',
                    type: 'POST',
                    data: {book_id: book_id},
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#title').val(response.title);
                            $('#author').val(response.author);
                            $('#genre').val(response.genre);
                            $('#price').val(response.price);
                        }
                    }
                });
            } else {
                $('#title').val('');
                $('#author').val('');
                $('#genre').val('');
                $('#price').val('');
            }
        });
    });

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
