<?php
include 'config.php';

// Verificar se uma sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifique se o usuário está logado
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

// Lógica de logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Selecionar 4 livros aleatórios do banco de dados
$result = $conn->query("SELECT * FROM books ORDER BY RAND() LIMIT 4");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="./CSS/images/logo1.png">
</head>
<body>
    
    <style>
        #cta .titles {
            font-size: 2rem;
            color: var(--color-neutral-1);
        }

        #cta .titles span {
            font-size: 2.2rem;
            color: var(--color-primary-6);
            font-style: italic;
        }
    </style>

    <header>
        <?php if ($user_name): ?>
            <!-- Navbar para usuários logados -->
            <nav id="navbar">
                <div class="icon">
                    <a href="index.php"><img src="CSS/images/logo2.png" alt=""></a>
                </div>  
                <ul id="nav_list">
                    <li class="nav-item active"><a href="index.php">Home</a></li>
                    <li class="nav-item"><a href="#group">Quem Somos</a></li>
                    <li class="nav-item"><a href="produtos.php">Produtos</a></li>
                    <li class="nav-item"><a href="cart.php">Carrinho</a></li>                          
                    <li class="nav-item">
                        <a href="usuario.php">Minha Conta</a>
                        <ul class="submenu">
                            <li><a href="?logout">Sair</a></li>
                        </ul>
                    </li>                
                </ul>
                <a href="search.php" class="btn-default">Pesquisar</a>
                <button id="mobile_btn"><i class="fa-solid fa-bars"></i></button>
            </nav>
        <?php else: ?>
            <!-- Navbar padrão para visitantes -->
            <nav id="navbar">
                <div class="icon">
                    <a href="index.php"><img src="CSS/images/logo2.png" alt=""></a>
                </div>  
                <ul id="nav_list">
                    <li class="nav-item active"><a href="index.php">Home</a></li>
                    <li class="nav-item"><a href="#group">Quem Somos</a></li>
                    <li class="nav-item"><a href="produtos.php">Produtos</a></li>
                    <li class="nav-item"><a href="cart.php">Carrinho</a></li>
                    <li class="nav-item"><a href="register.php">Cadastro</a></li>            
                    <li class="nav-item"><a href="login.php">Login</a>
                        <ul class="submenu">
                            <li><a href="admin_login.php">Login Admin</a></li>
                        </ul>
                    </li>                
                </ul>
                <a href="search.php" class="btn-default">Pesquisar</a>
                <button id="mobile_btn"><i class="fa-solid fa-bars"></i></button>
            </nav>
        <?php endif; ?>
        <div id="mobile_menu">
            <ul id="mobile_nav_list">
                <li class="nav-item"><a href="index.php">Home</a></li>
                <li class="nav-item"><a href="#group">Quem Somos</a></li>
                <li class="nav-item"><a href="produtos.php">Produtos</a></li>
                <li class="nav-item"><a href="cart.php">Carrinho</a></li>
                <li class="nav-item"><a href="register.php">Cadastro</a></li>
                
            </ul>
        </div>
    </header>
    <main id="content">
        <section id="home">
            <div class="shape"><img src="CSS/images/book.jpg" alt=""></div>

            <div id="cta">
                <?php if ($user_name): ?>
                    <h1 class="titles">Olá <span class="user-name"><?php echo htmlspecialchars($user_name); ?></span>,<br>Bem-vindo(a) de volta!</h1>                    
                <p class="description">
                    Tem novidade na área! Estamos expandido nosso catálogo pensando em encher suas estantes de livros que você precisa curtir!        
                    Aproveite ao máximo nossas ofertas de livros exclusivas em nosso site.
                </p>
                <?php else: ?>
                    <h1 class="title">Livraria<br><span>Folster</span></h1>
                    <p class="description">
                        Promovemos a leitura ao oferecer a diversidade literária a 
                        preços econômicos para leitores de todo o Brasil.
                    </p>
                <?php endif; ?>
                <div id="cta_buttons">
                    <a href="#menu" class="btn-default">Ver Destaques</a>
                </div>                          

                <div class="social-media-buttons">
                    <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                    <a href=""><i class="fa-brands fa-instagram"></i></a>  
                    <a href=""><i class="fa-brands fa-facebook"></i></a>  
                </div>
            </div>

            <div id="banner"></div>               
        </section>

        <section id="menu">
            <h2 class="section-title">Destaques</h2>
            <h3 class="section-subtitle">Livros mais vendidos</h3>           
         
            <div id="Destaques">
            <?php while ($book = $result->fetch_assoc()): ?>
                <div class="destaque">
                    <div class="dest-heart"><i class="fa-solid fa-heart"></i></div>                       
                    <img src="<?php echo $book['image_path']; ?>" alt="<?php echo $book['title']; ?>">
                    <h3 class="dest-title"><?php echo $book['title']; ?></h3>                  
                    <span class="dest-description"><?php echo $book['author']; ?></span>
                    <span class="dest-description"><?php echo $book['genre']; ?></span>

                    <div class="dest-rate">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <span>(600+)</span>
                    </div>  
                                      
                    <div class="dest-price">
                        <h4>R$<?php echo $book['price']; ?></h4>

                        <form method="post" class="form-container" action="add_to_cart.php">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="redirect_to" value="index.php">
                            <button class="btn-default" type="submit" name="add_to_cart">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </button>
                        </form>
                    </div>
                </div>               
                <?php endwhile; ?>
            </div>
        </section>

        <section id="group">  
            <img src="CSS/images/hero1.png" id="group_img" alt="">
            <div id="group_content">
                <h2 class="section-title">Conheça Nosso Time</h2>
                <h3 class="section-subtitle"></h3>
                <p class="description"> Com habilidades Full Stack e uma abordagem ágil, 
                    estamos sempre prontos para enfrentar desafios complexos e superar expectativas.
                </p>

                <div id="teams">
                    <div class="team">
                        <img src="CSS/images/avatar1.png" class="team-avatar" alt="">
                        <div class="team-content">
                            <h3>Adalbino Caúncra Fernandes Gomes</h3>                  
                            <p>Desenvolvedor Back-end: Responsável por criar e manter 
                                a lógica e o funcionamento dos servidores e bancos de dados.
                            </p> 
                        </div>
                    </div>

                    <div class="team">
                        <img src="CSS/images/avatar2.png" class="team-avatar" alt="">
                        <div class="team-content">
                            <h3>Danielle Rezende de Sousa</h3>
                            <p> Agilista: Especialista em metodologias ágeis, responsável por implementar e manter as práticas ágeis, 
                                garantindo que os processos sejam eficientes.
                            </p> 
                        </div>
                    </div>

                    <div class="team">
                        <img src="CSS/images/avatar5.png" class="team-avatar" alt="">
                        <div class="team-content">
                            <h3>Luís Felipe Soledade Folster</h3>
                            <p>Product Owner (PO): Responsável por definir e priorizar os requisitos do produto e manter uma visão clara 
                                do produto com colaboração da equipe de desenvolvimento.
                            </p> 
                        </div>
                    </div>

                    <div class="team">
                        <img src="CSS/images/avatar4.png" class="team-avatar" alt="">
                        <div class="team-content">
                            <h3>Paulo Ricardo Gouvea dos Santos</h3>
                            <p>Desenvolvedor Full Stack: Responsável por desenvolver tanto o frontend quanto o backend da aplicação web.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <img src="CSS/images/wave.svg" alt="">
        <div id="footer_items">
            <span id="copyright">
                <p>&copy; 2024 Livraria Folster - Todos os direitos reservados<br>
                    R. João Pereira dos Santos, 99 - Pte. do Imaruim, Palhoça - SC, 88130-475
                </p>
            </span>

            <div class="social-media-buttons">
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>            
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-facebook"></i></a>                   
            </div>
        </div>
    </footer>

    <script src="JS/script.js"></script>
</body>
</html>
