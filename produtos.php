

<?php
include 'config.php';
include 'navbar.php';

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Produtos</title>
<link rel="icon" href="./CSS/images/logo1.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

      

        .container {
            background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(CSS/images/op.jpg);
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

        h1, h2 {    
            
            color: #333;
            font-weight: 500;
            font-size: 22px;
            line-height: 1.5; /* Aumentar o espaço entre as linhas */
            text-align: center; /* Alinhar para o centro */
            letter-spacing: 1.4px; 
            text-transform:uppercase;

        
        }

        .product-card img {
            width: 150px;
            height: auto;
            max-height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
            
        }

        .product-info {
            margin-bottom: 10px;
            width: 100%;
            text-align: center;
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
            background: #1128d0;
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
    <br>
    <br>
    <h2>Livros Disponíveis</h2>

        <div class="product-container">
            <?php while ($book = $result->fetch_assoc()): ?>
                <div class="product-card">
                <div class="dest-heart"><i class="fa-regular fa-bookmark"></i></div>                      

                    <img src="<?php echo $book['image_path']; ?>" alt="<?php echo $book['title']; ?>">
                    
            <div class="product-info">
                    <h3><?php echo $book['title']; ?></h3>
                    <span class="product-info"><p>Autor: <?php echo $book['author']; ?></p></span>
                    <span class="product-info"><p>Gênero: <?php echo $book['genre']; ?></p></span>                    
                    <h4><p>R$<?php echo $book['price']; ?></p></h4>               

                    <div class="dest-rate">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <span>(100+)</span>
                    </div>  
              
            </div>
                    <form method="post" class="form-container" action="add_to_cart.php">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <input type="number" class="product-input" name="quantity" value="1" min="1" placeholder="Quantidade">
                        
                        <button class="btn-default" type="submit" name="add_to_cart">
                        <i class="fa-solid fa-basket-shopping"></i>
                        </button>
                    
                    </form>
        </div>
            <?php endwhile; ?>
        </div>
  
</body>
</html>
