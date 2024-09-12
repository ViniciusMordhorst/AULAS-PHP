-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:33306
-- Tempo de geração: 13/09/2024 às 01:22
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
-- Banco de dados: `ifpr`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `laboratorio`
--

CREATE TABLE `laboratorio` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(50) DEFAULT NULL,
  `NUMERO_COMPUTADORES` int(11) DEFAULT NULL,
  `BLOCO` char(1) DEFAULT NULL,
  `SALA` int(11) DEFAULT NULL,
  `LIBERADO` int(11) DEFAULT NULL,
  `CRIADO_EM` timestamp NOT NULL DEFAULT current_timestamp(),
  `ATUALIZADO_EM` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `laboratorio`
--

INSERT INTO `laboratorio` (`ID`, `NOME`, `NUMERO_COMPUTADORES`, `BLOCO`, `SALA`, `LIBERADO`, `CRIADO_EM`, `ATUALIZADO_EM`) VALUES
(1, 'Laboratório 01', 10, 'A', 1, 1, '2024-08-18 21:43:38', '2024-08-18 21:43:38'),
(2, 'Laboratório 02', 20, 'A', 2, 1, '2024-08-18 21:58:09', '2024-08-18 21:58:09'),
(3, 'Laboratório 03', 15, 'C', 1, 1, '2024-08-18 21:59:33', '2024-08-18 21:59:33'),
(4, 'Laboratório 04', 10, 'D', 1, 1, '2024-08-18 22:00:21', '2024-08-18 22:00:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `SENHA` varchar(250) DEFAULT NULL,
  `TIPO` char(1) DEFAULT NULL,
  `CRIADO_EM` timestamp NOT NULL DEFAULT current_timestamp(),
  `ATUALIZADO_EM` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ULTIMO_LOGIN` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`ID`, `NOME`, `EMAIL`, `SENHA`, `TIPO`, `CRIADO_EM`, `ATUALIZADO_EM`, `ULTIMO_LOGIN`) VALUES
(1, 'Admin', 'admin@hotmail.com', '$2a$12$9N4slQK8n7wFBGha3kIDT.7YzvJxGCybnCKIDwDft0Az8CVoRA.c.', '1', '2024-08-18 21:42:04', '2024-08-28 16:14:09', '2024-08-28 21:14:09'),
(2, 'Carlos Dante', 'carlos@hotmail.com', '$2y$10$UtWCM4/AIMIWfAR5HCUJYOtfl/SLISTC1qi1nFx5gNwYR8QEvCfCG', '0', '2024-08-18 21:42:47', '2024-08-28 16:33:12', '2024-08-28 16:33:12'),
(3, 'Vinicius', 'vinicius@hotmail.com', '$2y$10$3c72jZuXQ7WsTVqF6fO8O.3FELBqVkxbgef.VoQ70rPLQDrcGMO3m', '1', '2024-08-18 21:44:06', '2024-09-12 23:20:27', '2024-09-12 23:20:27'),
(5, 'Luis', 'luis@gmail.com', '$2y$10$0qf.3zgfwkLw8Ujq.Xj16.xvspGieJNENZWfaevDn2cY0AJ/1rwIu', '0', '2024-08-18 21:48:29', '2024-08-18 21:48:29', '2024-08-18 21:48:29'),
(6, 'Leonir1', 'leonir1@gmail.com', '$2y$10$7qWJm2/jnq8vU20I3z3yVu6OhrVoyFufqqvrdzAvdj7UIZmZA25/2', '0', '2024-08-26 14:49:05', '2024-08-28 16:21:02', '2024-08-28 21:17:14'),
(9, 'teste1', 'teste@gmail.com', '$2y$10$3B9muIorV10mrc9rghmO/Ol3/tSGsB3qDfGQtXbqGTdkLveQYp162', '0', '2024-08-28 16:31:52', '2024-08-28 16:51:26', '2024-08-28 16:51:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `ID` int(11) NOT NULL,
  `PESSOA_ID` int(11) DEFAULT NULL,
  `LABORATORIO_ID` int(11) DEFAULT NULL,
  `DESCRICAO` text DEFAULT NULL,
  `DATA` date DEFAULT NULL,
  `HORA_INICIO` time DEFAULT NULL,
  `HORA_FIM` time DEFAULT NULL,
  `CRIADO_EM` timestamp NOT NULL DEFAULT current_timestamp(),
  `ATUALIZADO_EM` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`ID`, `PESSOA_ID`, `LABORATORIO_ID`, `DESCRICAO`, `DATA`, `HORA_INICIO`, `HORA_FIM`, `CRIADO_EM`, `ATUALIZADO_EM`) VALUES
(8, 6, 1, 'Aula 02', '2024-08-26', '19:30:00', '21:10:00', '2024-08-26 14:49:52', '2024-08-28 16:46:50'),
(9, 2, 1, 'Teste', '2024-08-26', '21:10:00', '23:00:00', '2024-08-26 14:51:05', '2024-08-26 14:51:05'),
(22, 5, 2, 'teste', '2024-08-28', '16:50:00', '19:00:00', '2024-08-27 16:47:35', '2024-08-28 16:38:09'),
(23, 5, 2, 'teste', '2024-08-27', '18:00:00', '19:47:00', '2024-08-27 16:48:10', '2024-08-27 16:48:10'),
(26, 9, 3, 'teste', '2024-08-31', '15:58:00', '18:01:00', '2024-08-28 16:56:22', '2024-08-28 16:56:22'),
(27, 9, 3, '123123', '2024-08-30', '16:57:00', '17:01:00', '2024-08-28 17:00:48', '2024-08-28 17:00:48'),
(31, 9, 4, 'teste', '2024-08-28', '16:10:00', '19:15:00', '2024-08-28 17:10:34', '2024-08-28 17:10:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` varchar(20) DEFAULT 'padrao'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `tipo_usuario`) VALUES
(1, 'Admin', 'vinicius@hotmail.com', '$2a$12$9N4slQK8n7wFBGha3kIDT.7YzvJxGCybnCKIDwDft0Az8CVoRA.c.', 'admin'),
(11, 'teste', 'teste@gmail.com', '$2y$10$sIjOEcLo2fu.ghh15H4e.ePbBFFEDXjDxkqzrKzt0tfsP00waSHeC', 'padrao'),
(13, 'Nicolas ', 'nicolas@gmail.com', '$2y$10$Anh.QTrZM1Ek95Fa3ILVNOKG6kV5AQhUSCQcfR6d05ZCTOLF5JVPi', 'padrao');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PESSOA_ID` (`PESSOA_ID`),
  ADD KEY `LABORATORIO_ID` (`LABORATORIO_ID`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`PESSOA_ID`) REFERENCES `pessoa` (`ID`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`LABORATORIO_ID`) REFERENCES `laboratorio` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
