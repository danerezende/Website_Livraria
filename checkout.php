<?php
include 'config.php';
include 'navbar.php';

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "<div class='empty-cart-message'>Seu carrinho está vazio.</div>";
    exit();
}

$cart_books = array();
$total_itens = 0;
$total_preco = 0.00;

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart_ids = implode(',', array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM books WHERE id IN ($cart_ids)");
    while ($row = $result->fetch_assoc()) {
        $cart_books[] = $row;
        $total_itens += $_SESSION['cart'][$row['id']];
        $total_preco += $row['price'] * $_SESSION['cart'][$row['id']];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./CSS/images/logo1.png">
    <title>Checkout</title>
  
</head>
<body>
    
        <h2>Resumo da Compra</h2>
    <div class="cart-container">
            <div class="cart-items">
                <?php foreach ($cart_books as $book): ?>
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h3><?php echo $book['title']; ?></h3>
                            <p>Autor: <?php echo $book['author']; ?></p>
                            <p>Gênero: <?php echo $book['genre']; ?></p>
                            <p>Preço: R$<?php echo number_format($book['price'], 2, ',', '.'); ?></p>
                            <p>Quantidade: <?php echo $_SESSION['cart'][$book['id']]; ?></p>
                        </div>
            </div>
                <?php endforeach; ?>            
            <div class="finish">
                <p>Total de itens: <?php echo $total_itens; ?></p>
                <p>Preço total: R$<?php echo number_format($total_preco, 2, ',', '.'); ?></p>
                <form action="purchase.php" method="post">
                    <button type="submit">Finalizar Compra</button>
                </form>
            </div>
    </div>    
</body>

<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #fff9ea;
    margin: 0;
    padding: 20px;
    display: flex;
    justify-content: center;
}

.container {
    width: 100%;
    max-width: 1000px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    background: linear-gradient(to top, rgba(210, 208, 208, 0.2)50%,rgba(210, 208, 208, 0.2)50%), url(CSS/images/op.jpg);
    margin-top: 15px;

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

.cart-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
            padding: 10px;        
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;

}

.cart-items {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.cart-item {
    display: flex;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-info {
    flex: 1;
}

.cart-item-info h3 {
    margin-bottom: 5px;
    font-size: 1.2rem;
    color: #555;
}

.cart-item-info p {
    margin-bottom: 5px;
    font-size: 1rem;
    color: #777;
}

.finish {
    flex: 1;
    background-color: #fff;
    padding: 20px;
    z-index: 1;
    width: 100%;
    text-align: right;
}

.finish p {
    margin: 10px 0;
    font-size: 16px;
    color: #555;
}

.finish button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: var(--color-primary-5);
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    border-radius: 5px;
    padding: 8px 16px;
    text-decoration: none;
    font-size: 13px;
}

.finish button:hover {
    background-color: var(--color-primary-3);
}

.finish button:active {
    background-color: var(--color-primary-3);
}

.finish button:focus {
    outline: none;
}

.empty-cart-message {
    font-size: 18px;
    color: #777;
    text-align: center;
    margin-top: 20px;
}
</style>
</html>
