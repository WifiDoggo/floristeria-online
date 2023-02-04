-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2023 a las 23:31:12
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_productos` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `nombre_productos` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_user`, `id_productos`, `precio`, `cantidad`, `total`, `nombre_productos`) VALUES
(34, 2, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(35, 2, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(36, 2, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(37, 2, '3', '62.00', 1, '62.00', 'Girasoles de Cumpleaños'),
(38, 0, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(39, 0, '2', '67.00', 1, '67.00', 'Caja de rosas rojas'),
(40, 0, '3', '62.00', 1, '62.00', 'Girasoles de Cumpleaños'),
(41, 0, '4', '99.00', 1, '99.00', 'Arreglo Floral \"Hogarth\"'),
(42, 0, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(43, 0, '2', '67.00', 1, '67.00', 'Caja de rosas rojas'),
(44, 0, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(45, 0, '2', '67.00', 1, '67.00', 'Caja de rosas rojas'),
(46, 0, '3', '62.00', 1, '62.00', 'Girasoles de Cumpleaños'),
(47, 0, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas'),
(48, 2, '1', '44.00', 1, '44.00', 'Ramo de rosas rojas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `disponible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `id_categoria`, `disponible`) VALUES
(1, 'Ramo de rosas rojas', 'Ramo de rosas rojas 100% naturales', '44.00', 1, 1),
(2, 'Caja de rosas rojas', 'Cajas de rosas rojas naturales', '67.00', 1, 1),
(3, 'Girasoles de Cumpleaños', 'Arreglo floral de girasoles, regalo de cumpleaños para hombre', '62.00', 5, 1),
(4, 'Arreglo Floral \"Hogarth\"', 'Para el artista plástico Wiliam Hogarth la forma de una S curvada era la forma de la belleza. Este Arreglo Floral está inspirado en su teoría, presentando las rosas o las aves del paraíso en una línea curva. Uno de nuestros best-sellers ideal para aniversarios.', '99.00', 1, 1),
(5, 'Arreglo Floral Romántico', 'Arreglo floral de diversas flores de colores cálidos, perfecto para tu enamorada.', '250.00', 1, 1),
(6, 'Cesta de Flores Victoria', 'Arreglo floral bonito, esta cesta de flores está compuesta de flores silvestres de colores cálidos, excelente para decoración.', '29.00', 2, 1),
(7, 'Oso de Rosas', 'Bello oso de rosas sentado sobre caja de madera vintage ideal para sorprender en esa ocasión especial', '357.00', 1, 1),
(8, 'Detalle con Rosas, Chocolate y Peluche', 'Detalle de rosas con bombones y un osito de peluche, perfecto para dar de regalo a tu pareja en ocasiones especiales.', '71.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(4) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'administrador'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `cedula` int(10) NOT NULL,
  `contrasena` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `id_rol` int(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `apellido`, `cedula`, `contrasena`, `correo`, `id_rol`, `id_user`) VALUES
('Juan Carlos', 'Salas Bello', 29650848, '123', 'juan@gmail.com', 1, 2),
('Gabriel', 'tirado', 27568789, '123', 'gabriel@gmail.com', 1, 3),
('José', 'Mijares', 123456, '123', 'hola@gmail.com', 2, 4),
('Abraham', 'Nieves', 24815101, '123', 'seisuke@gmail.com', 1, 5),
('Gabriel', 'Chupiplim', 12345678, '123', 'julian@gmail.com', 1, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
