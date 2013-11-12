CREATE DATABASE cf DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE cf;

-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jun 10, 2012 as 07:02 
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: cf
--

-- --------------------------------------------------------

--
-- Estrutura da tabela produto
--


CREATE TABLE IF NOT EXISTS produto (
  id_produto int(11) NOT NULL AUTO_INCREMENT,
  nm_produto varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  vl_produto float NOT NULL,
  st_ativo int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_produto),
  UNIQUE KEY un_nm_produto (nm_produto)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela produto
--

INSERT INTO produto (id_produto, nm_produto, vl_produto, st_ativo) VALUES
(12, 'Batom vermelho', 15.99, 1),
(13, 'Paleta 112 cores', 179.9, 0),
(14, 'Xbox 720', 1400, 1),
(15, 'Geladeira Eletrolux', 1799, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela promocao
--

CREATE TABLE IF NOT EXISTS promocao (
  id_promocao int(11) NOT NULL AUTO_INCREMENT,
  nm_promocao varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  pc_promocao int(11) NOT NULL,
  dt_validade timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  st_ativo int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_promocao)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela promocao
--

INSERT INTO promocao (id_promocao, nm_promocao, pc_promocao, dt_validade, st_ativo) VALUES
(1, 'Promocao Dia das Mães', 55, '2012-06-30 00:00:00', 1),
(2, 'Dia do Namorados', 15, '2012-06-13 00:00:00', 1),
(3, 'Pascoa Feliz com 50% de desconto', 50, '2012-07-13 00:00:00', 1),
(4, 'Pascoa Feliz com 50% de desconto', 50, '2012-07-06 13:58:02', 0),
(5, 'Pascoa Feliz com 50% de desconto', 50, '2012-07-13 00:00:00', 1),
(6, 'Promocao Dia das Mães', 95, '2012-07-28 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela promocao_x_produto
--

CREATE TABLE IF NOT EXISTS promocao_x_produto (
  id_promocao_x_produto int(11) NOT NULL AUTO_INCREMENT,
  id_produto int(11) NOT NULL,
  id_promocao int(11) NOT NULL,
  PRIMARY KEY (id_promocao_x_produto),
  KEY fk_reference_3 (id_produto),
  KEY fk_reference_4 (id_promocao)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela promocao_x_produto
--

INSERT INTO promocao_x_produto (id_promocao_x_produto, id_produto, id_promocao) VALUES
(4, 15, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela usuario
--

CREATE TABLE IF NOT EXISTS usuario (
  id_usuario int(11) NOT NULL AUTO_INCREMENT,
  nm_usuario varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  nu_cpf varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  fg_perfil int(11) NOT NULL DEFAULT '0',
  tx_email varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  tx_senha varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  st_ativo int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_usuario),
  UNIQUE KEY un_tx_email (tx_email),
  UNIQUE KEY un_nu_cpf (nu_cpf)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

--
-- Extraindo dados da tabela usuario
--

INSERT INTO usuario (id_usuario, nm_usuario, nu_cpf, fg_perfil, tx_email, tx_senha, st_ativo) VALUES
(2, 'Michael Fernandes Rodrigues', '73762385149', 0, 'cerberosnash@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'Jussara Lima', '22841425401', 0, 'jussara.lima@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(4, 'Administrador', '88545485883', 1, 'administrador@cf.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(51, 'Carlos Roberto', '02489102133', 0, 'carlos@icmbio.gov.br', 'e10adc3949ba59abbe56e057f20f883e', 0),
(62, 'Maria Mirtes Fernandes de Souza', '21691334618', 0, 'cliente@gmail.com.br', 'e10adc3949ba59abbe56e057f20f883e', 1),
(64, 'Gabriela Benigno dos Santos Alves', '71445723859', 0, 'gabrielabenigno@gmail.com.br', 'e10adc3949ba59abbe56e057f20f883e', 0),
(66, 'Root', '75884444605', 0, 'root@cf.com', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela venda
--

CREATE TABLE IF NOT EXISTS venda (
  id_venda int(11) NOT NULL AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  dt_venda timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  vl_total float NOT NULL,
  st_ativo int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_venda),
  KEY fk_reference_1 (id_usuario)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela venda
--

INSERT INTO venda (id_venda, id_usuario, dt_venda, vl_total, st_ativo) VALUES
(2, 51, '2012-06-10 13:54:54', 273.45, 0),
(3, 2, '2012-07-06 13:45:19', 0, 0),
(4, 2, '2012-07-06 13:47:24', 6461.96, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela venda_x_produto
--

CREATE TABLE IF NOT EXISTS venda_x_produto (
  id_venda_x_produto int(11) NOT NULL AUTO_INCREMENT,
  id_venda int(11) NOT NULL,
  id_produto int(11) NOT NULL,
  vl_produto float NOT NULL,
  qt_produto int(11) NOT NULL,
  PRIMARY KEY (id_venda_x_produto),
  KEY fk_reference_5 (id_venda),
  KEY fk_reference_6 (id_produto)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela venda_x_produto
--

INSERT INTO venda_x_produto (id_venda_x_produto, id_venda, id_produto, vl_produto, qt_produto) VALUES
(1, 2, 13, 79.9, 3),
(2, 2, 12, 6.75, 5),
(3, 3, 12, 15.99, 1),
(4, 3, 15, 1, 1),
(5, 4, 14, 1400, 2),
(6, 4, 15, 1799, 2),
(7, 4, 12, 15.99, 4);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela promocao_x_produto
--
ALTER TABLE promocao_x_produto
  ADD CONSTRAINT fk_reference_3 FOREIGN KEY (id_produto) REFERENCES produto (id_produto),
  ADD CONSTRAINT fk_reference_4 FOREIGN KEY (id_promocao) REFERENCES promocao (id_promocao);

--
-- Restrições para a tabela venda
--
ALTER TABLE venda
  ADD CONSTRAINT fk_reference_1 FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario);

--
-- Restrições para a tabela venda_x_produto
--
ALTER TABLE venda_x_produto
  ADD CONSTRAINT fk_reference_5 FOREIGN KEY (id_venda) REFERENCES venda (id_venda),
  ADD CONSTRAINT fk_reference_6 FOREIGN KEY (id_produto) REFERENCES produto (id_produto);
