<!DOCTYPE html>
<html lang="pt-br">
<head>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    
    <link rel="stylesheet" href="CSS/styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        footer {
            width: 100%;
            background-color: var(--color-primary-2);
            text-align: center;
            position: relative;
            bottom: 0;
            padding: 20px 0;
        }

        footer img {
            width: 100%;
        }

        #footer_items {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1200px; /* Limitar a largura máxima do conteúdo do footer */
            margin: 0 auto; /* Centralizar o footer */
        }

        @media (min-width: 600px) {
            #footer_items {
                flex-direction: row;
                justify-content: space-between;
                padding: 0 8%;
            }
        }

        #copyright {
            color: var(--color-neutral-1);
            font-weight: 400;
            font-size: 12px;
            line-height: 1.5; /* Aumentar o espaço entre as linhas */
            text-align: center;
            margin-bottom: 10px;
        }

        .social-media-buttons {
            margin-top: 10px;
        }

        .social-media-buttons a {
            margin: 0 10px;
            font-size: 18px; /* Ajustar o tamanho dos ícones */
        }

        @media (max-width: 600px) {
            #copyright {
                font-size: 10px; /* Diminuir o tamanho do texto */
            }

            .social-media-buttons a {
                font-size: 16px; /* Diminuir o tamanho dos ícones */
                margin: 0 5px; /* Reduzir o espaçamento entre os ícones */
            }
        }
    </style>
</head>
<body>
    <main>
        <!-- Conteúdo da página -->
        <!-- Você pode adicionar mais conteúdo aqui para que a página tenha uma barra de rolagem -->
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
</body>
</html>
