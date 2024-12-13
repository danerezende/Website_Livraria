<?php
include 'config.php';
include 'navbar.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $book_id = $_POST['book_id'];
    if (isset($_SESSION['cart'][$book_id])) {
        unset($_SESSION['cart'][$book_id]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_quantity'])) {
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];
    if (isset($_SESSION['cart'][$book_id])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$book_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$book_id]);
        }
    }
}

$cart_books = array();
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart_ids = implode(',', array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM books WHERE id IN ($cart_ids)");
    while ($row = $result->fetch_assoc()) {
        $cart_books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./CSS/images/logo1.png">
    <title>Carrinho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap">
    <style>
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
            padding: 0 20px;
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(CSS/images/op.jpg);
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);
            padding: 20px;
        }

        .cart-item, .empty-cart {
            border: 1px solid #ddd;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            min-width: 300px;
        }

        .cart-item img {
            width: 120px;
            height: auto;
            object-fit: contain;
            border-radius: 5px;
        }

        .cart-item-info {
            flex: 1;
            padding-left: 20px;
            text-align: left;
        }

        .cart-item-info h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .cart-item-info p {
            margin-bottom: 8px;
            font-size: 1.2em;
        }

        .cart-item-info form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .cart-item-info input[type="number"] {
            width: 50px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1.2em;
        }

        .cart-item-info button {
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary-5);
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color .3s ease;
            color: #ffffff;
            text-decoration: none;
            font-size: 1.2em;
        }

        .cart-item-info button:hover {
            background-color: var(--color-primary-3);
        }

        .cart-item-info button:active {
            background-color: var(--color-primary-3);
        }

        .cart-item-info button:focus {
            outline: none;
        }

        .checkout {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            width: 100%;
            max-width: 800px;
        }

        .checkout-btn, .btn-products {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--color-primary-5);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .checkout-btn:hover, .btn-products:hover {
            background-color: var(--color-primary-3);
        }

        .checkout-btn:active, .btn-products:active {
            background-color: var(--color-primary-3);
        }

        .checkout-btn:focus, .btn-products:focus {
            outline: none;
        }

        .empty-cart {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
            margin-top: 20px;
        }

        .empty-cart i {
            margin-top: 15px;
            font-size: 5em;
            color: var(--color-primary-5);
            margin-bottom: 15px;
        }

        .empty-cart .description span {
            display: block;
            font-weight: bold;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .empty-cart .description p {
            font-size: 1.2em;
            color: #333;
        }

        .empty-cart .btn-choose-products {
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary-5);
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color .3s ease;
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
        }

        .btn-choose-products a {
            color: inherit;
            text-decoration: none;
        }

        .btn-choose-products:hover {
            background-color: var(--color-primary-3);
        }

        h1, h2 {
            color: #333;
            font-weight: 500;
            font-size: 1.5em; /* Diminuir tamanho do título */
            line-height: 1.5;
            text-align: center;
            margin: 20px 0;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            body {
                padding: 0 10px;
            }

            .cart-container {
                padding: 10px;
                background: none;
                box-shadow: none;
            }

            .cart-item, .empty-cart {
                flex-direction: column;
                align-items: center;
                max-width: 100%;
                min-width: 300px;
            }

            .cart-item img {
                width: 100px;
                margin-bottom: 10px;
            }

            .cart-item-info {
                padding-left: 0;
                text-align: center;
            }

            .cart-item-info form {
                flex-direction: column;
            }

            .checkout {
                flex-direction: column;
                gap: 10px;
                max-width: 100%;
            }

            .checkout-btn, .btn-products {
                width: 100%;
                text-align: center;
            }

            .empty-cart i {
                font-size: 4em;
            }

            .empty-cart .description span {
                font-size: 1.2em;
            }

            .empty-cart .btn-choose-products {
                font-size: 14px;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .cart-item img {
                width: 80px;
            }

            .cart-item-info {
                max-width: 100%;
            }

            .empty-cart .description span {
                font-size: 1em;
            }

            .empty-cart .btn-choose-products {
                font-size: 14px;
                padding: 10px 20px;
            }

            .cart-item-info button {
                font-size: 1em;
                padding: 10px;
            }

            .checkout-btn, .btn-products {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Meu Carrinho</h2>
        <?php if (count($cart_books) > 0): ?>
            <?php foreach ($cart_books as $book): ?>
                <div class="cart-item">
                    <img src="<?php echo $book['image_path']; ?>" alt="<?php echo $book['title']; ?>">
                    <div class="cart-item-info">
                        <h3><?php echo $book['title']; ?></h3>
                        <p>Autor: <?php echo $book['author']; ?></p>
                        <p>Gênero: <?php echo $book['genre']; ?></p>
                        <div class="dest-price">
                            <h4>
                                <p>R$<?php echo $book['price']; ?></p>
                            </h4>
                        </div>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $_SESSION['cart'][$book['id']]; ?>" min="1">
                            <button type="submit" name="update_quantity">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button type="submit" name="remove_from_cart">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="checkout">
                <a href="produtos.php" class="btn-products">Escolher produtos</a>
                <a href="checkout.php" class="checkout-btn">Finalizar Compra</a>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <p class="description">
                    <span>Ops! Sua bolsa está vazia.</span><br>
                    Para inserir produtos no seu carrinho, clique no botão "Escolher mais produtos" e navegue pelo site.
                </p>
                <a href="produtos.php" class="btn-choose-products">Escolher produtos</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
