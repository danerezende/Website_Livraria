<?php
include 'config.php';

// Verifica se a sessão já está ativa, caso contrário, inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Define quantidade padrão como 1
    $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : 'produtos.php';
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] += $quantity;
    } else {
        $_SESSION['cart'][$book_id] = $quantity;
    }

    header("Location: $redirect_to");
    exit();
}
?>
