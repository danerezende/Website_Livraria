-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/06/2024 às 06:59
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `livraria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `price`) VALUES
(1, 'Shrek', 'William Steig', 'Infantil', 34.00),
(2, '1984', 'George Orwell', 'Ficção Científica', 46.00),
(3, 'O Código Da Vinci', 'Dan Brown', 'Romance', 40.60),
(4, 'World of Warcraft: Sombras da horda', 'Michael A. Stackpole', 'Fantasia', 50.40),
(6, 'Harry Potter e a Pedra Filosofial', 'J.K. Rowling', 'Fantasia', 80.00),
(7, 'Orgulho e Preconceito', 'Jane Austen', 'Romance', 80.00),
(8, 'Dom Quixote', 'Miguel de Cervantes', 'Romance', 65.95),
(9, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Ficção', 55.90),
(10, 'O Hobbit', 'J. R. R. Tolkien', 'Fantasia', 74.99),
(11, 'A Metamorfose', 'Franz Kafka', 'Suspense', 44.85),
(12, 'Crime e Castigo', 'Fiódor Dostoiévski', 'Romance', 51.99),
(13, 'Moby Dick', 'Herman Melville', 'Aventura', 35.99),
(14, 'O Médico e o Monstro', 'Robert Louis', 'Terror', 25.99),
(15, 'Cem anos de Solidão', 'Gabriel García', 'Ficção', 44.99),
(16, 'Memórias Póstumas de Brás Cubas', 'Machado de Assis', 'Romance', 21.85),
(17, 'A Revolução dos Bichos', 'George Orwell', 'Ficção', 30.00),
(18, 'O Vento Levou', 'Margaret Mitchell', 'Romance', 33.59),
(19, 'Nossas Noites', 'Kent Haruf', 'Ficção', 32.90),
(20, 'O Sol é para Todos', 'Harper Lee', 'Drama', 40.99),
(21, 'O Alquimista', 'Paulo Coelho', 'Ficção', 35.65),
(22, 'A Menina que Roubava Livros', 'Markus Zusak', 'Drama', 54.95),
(23, 'O Retrato de Dorian Gray', 'Oscar Wilde', 'Ficção', 36.99),
(24, 'O Nome Do Vento', 'Patrick Rothfuss', 'Fantasia', 28.85),
(25, 'A Cor Púrpura', 'Alice Walker', 'Ficção', 71.90),
(26, 'Anna Karenina', 'Lev Tolstói', 'Romance', 50.00),
(27, 'Matadouro 5', 'Kurt Vonnegut', 'Ficção', 49.99),
(28, 'O Martelo das bruxas', 'Lauren Acampora', 'Ficção', 21.90),
(29, 'A garota no trem', 'Paula Hawkins', 'Suspense', 32.95),
(30, 'Um estranho Sonhador', 'Laini Taylor', 'Fantasia', 62.90),
(31, 'Dom Casmurro', 'Machado de Assis', 'Romance', 16.99),
(32, 'A Culpa é das Estrelas', 'John Green', 'Drama', 44.50),
(33, 'O extraordinário', 'R.J. Palacio', 'Ficção', 50.00),
(34, 'As aventuras de Pi', 'Yann Martel', 'Aventura', 31.99),
(35, 'Jogos Vorazes', 'Suzanne Collins', 'Ficção', 55.55),
(36, 'Cidade dos Ossos', 'Cassandra Clare', 'Fantasia', 18.99),
(37, 'Corte de espinhos e rosas', 'Sarah J. Mass', 'Fantasia', 36.80),
(38, 'Morte Súbita', 'J.K. Rowling', 'Drama', 21.99),
(39, 'O circo da noite', 'Erin Morgenstern', 'Fantasia', 30.00),
(40, 'Percy Jackson e os olimpianos', 'Rick Riordan', 'Fantasia', 32.50),
(41, 'Um estudo em vermelho', 'Arthur Conan Doyle', 'Mistério', 43.50);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `birthdate` date NOT NULL DEFAULT '1970-01-01',
  `phone` varchar(15) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `neighborhood` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `password`, `email`, `reset_token`, `token_expiry`, `firstname`, `lastname`, `cpf`, `birthdate`, `phone`, `cep`, `address`, `neighborhood`, `city`, `gender`) VALUES
(1, '$2y$10$qCrt35UaraqHeU9s9CMHdeEfPhSCu.yqlyfReRj3EU.1E0.vMEVCG', 'teste@example.com', NULL, NULL, 'Teste', 'teste', '111.111.111-11', '1970-01-01', '(11) 1 1111-111', '11111-111', 'end', 'bairro', 'cidade', 'Masculino');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
