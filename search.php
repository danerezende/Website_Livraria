<?php
include 'config.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="./CSS/images/logo1.png">
    <title>Pesquisa de Livros</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #fff9ea;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

  
        .container {
            background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(css/images/op.jpg);
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);  
            color: #1a1919;
            border-radius: 5px;
            max-width: 1200px;
            width: 90%; /* Ajuste para largura responsiva */
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
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
        h1, h2 {
            color: #333;
            font-size: 25px;
            line-height: 1.5; /* Aumentar o espaço entre as linhas */
            text-align: center; /* Alinhar para o centro */
        }

        .product-card img {
            width: 150px;
            height: auto;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product-info {
            text-align: left;
            margin-bottom: 10px;
            width: 100%;
        }

        .product-info h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .product-info p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        .product-card form {
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .product-card {
                flex: 1 1 calc(50% - 20px); /* Ajuste para dois produtos por linha em telas menores */
            }
        }

        @media (max-width: 576px) {
            .product-card {
                flex: 1 1 calc(100% - 20px); /* Um produto por linha em telas muito pequenas */
            }
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            padding: 20px;
        }

        .product-card {
            flex: 1 1 calc(25% - 20px); /* Ajuste para quatro produtos por linha */
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            width: 100%; /* Garante que o width: calc(25% - 20px) seja eficaz */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #fff;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: column; /* Para alinhar os elementos verticalmente */
            align-items: center; /* Alinha os elementos no centro horizontal */
        }

        .product-input {
            width: calc(100% - 20px);
            padding: 5px;
            margin-bottom: 10px; /* Espaçamento entre o input e o botão */
        }

        .btn{
            width: calc(100% - 20px);
            height: 40px;
            margin-top: auto; /* Empurra o botão para a parte inferior */
            background: linear-gradient(-45deg, #bfbbff, #150ae8f1);
            border: none;
            outline: none;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #ffffff;
            margin: 10px 0;
            padding: 0.62rem;
        }

        .btn:hover {
            background-color: var(--color-primary-3);
        }


        .dest-heart {
            position: absolute;
            background-color: var(--color-primary-5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--color-primary-1);
            width: 40px;
            height: 40px;
            right: 0px;
            top: 0;
            border-radius: 0px 5px 5px 50px;
        }

        .dest-rate i {
            color: var(--color-primary-5);
        }


        .form-container {
            display: flex;
            align-items: center; /* Alinha os itens verticalmente */
            gap: 5px; /* Espaçamento entre os itens */
        }

        .product-input {
            width: 45px; /* Ajuste a largura do input conforme necessário */
            padding: 8px; /* Ajuste o padding interno conforme necessário */
            border: none; /* Adicione uma borda para melhor visualização */
            border-radius: 5px; /* Adicione borda arredondada */
        }


        .btn-default {
            background-color: var(--color-primary-5);
            border: none;
            border-radius: 5px;
            color: white;
            padding: 10px 12px;
            cursor: pointer;
            display: flex;
            align-items: center; /* Alinha os conteúdos verticalmente */
        }

        .btn-default i {
            margin-right: 0px; /* Espaçamento entre o ícone e o texto */
        }

        

    </style>
</head>
<body>
    <h2>Pesquisa de Livros</h2>
    <form method="get" class="container">
    <div class="input-box">
            <input type="text" name="genre" id="genre" class="product-input" placeholder="Gênero">
            </div>
            <div class="input-box">
            <input type="text" name="author" id="author" class="product-input" placeholder="Autor"><br>
            </div>
            <input type="submit" value="Pesquisar" class="btn">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['genre']) || isset($_GET['author']))) {
        $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
        $author = isset($_GET['author']) ? $_GET['author'] : '';
        $query = "SELECT * FROM books WHERE 1=1";

        if (!empty($genre)) {
            $query .= " AND genre LIKE '%$genre%'";
        }

        if (!empty($author)) {
            $query .= " AND author LIKE '%$author%'";
        }

        $result = $conn->query($query);

        echo "<h2>Resultados da Pesquisa</h2>";
        if ($result->num_rows > 0) {
            echo '<div class="product-container">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<div class="dest-heart"><i class="fa-regular fa-bookmark"></i></div>';
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['title'] . '">';
                echo '<div class="product-info">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<span class="product-info"><p>Autor: ' . $row['author'] . '</p></span>';
                echo '<span class="product-info"><p>Gênero: ' . $row['genre'] . '</p></span>';
                echo '<h4><p>Preço: R$' . $row['price'] . '</p></h4>';
                echo '<div class="dest-rate">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <span>(100+)</span>
                    </div>';
                echo '</div>';
                echo '<form method="post" class="form-container" action="add_to_cart.php">';
                echo '<input type="hidden" name="book_id" value="' . $row['id'] . '">';
                echo '<input type="hidden" name="redirect_to" value="search.php?genre=' . urlencode($genre) . '&author=' . urlencode($author) . '">';
                echo '<input type="number" class="product-input" name="quantity" value="1" min="1" placeholder="Quantidade">';
                echo '<button class="btn-default" type="submit" name="add_to_cart">
                        <i class="fa-solid fa-basket-shopping"></i>
                        </button>';
                echo '</form>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "<p>Nenhum livro encontrado.</p>";
        }

        $conn->close();
    }
    ?>

           
    
                


</body>
</html>
