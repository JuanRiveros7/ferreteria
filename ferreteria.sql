-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-08-2025 a las 23:26:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ferreteria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Herramientas'),
(2, 'Materiales de construcción'),
(3, 'Pinturas y acabados'),
(4, 'Fontanería y plomería'),
(5, 'Electricidad'),
(6, 'Seguridad industrial'),
(7, 'Tornillería y fijaciones'),
(8, 'Ferretería general'),
(9, 'Maquinaria y equipos'),
(10, 'Jardinería y exteriores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `id_categoria`) VALUES
(1, 'Martillo de Uña 16 oz', 'Mango en fibra, anti-vibración', 22.00, 30, 1),
(2, 'Cemento Gris 50 kg', 'Alta resistencia, uso general', 46000.00, 60, 2),
(3, 'Ladrillo H-10', 'Para muros, alta precisión', 1500.00, 500, 2),
(4, 'Arena de Río 1 m³', 'Lavada, granulometría fina', 70000.00, 12, 2),
(5, 'Varilla Corrugada 3/8 x 6 m', 'Grado 420, para refuerzo', 38000.00, 40, 2),
(6, 'Bloque de Concreto 12 cm', 'Tipo liviano, bodega y muro', 3800.00, 300, 2),
(7, 'Pintura Vinílica Blanca 1 Galón', 'Ideal para interiores, acabado mate', 65000.00, 15, 3),
(8, 'Esmalte Sintético Negro 1/4 Galón', 'Alta resistencia para metal y madera', 25000.00, 20, 3),
(9, 'Barniz Transparente Brillante', 'Protección y realce para madera', 32000.00, 12, 3),
(10, 'Masilla Plástica 1Kg', 'Rellena grietas en paredes', 18000.00, 30, 3),
(11, 'Rodillo de Lana 9”', 'Para aplicar pintura en paredes lisas', 12000.00, 25, 3),
(12, 'Tubo PVC 1/2” x 3m', 'Resistente y fácil de instalar', 9500.00, 40, 4),
(13, 'Llave de Paso de Latón 1/2”', 'Control de flujo de agua', 18000.00, 18, 4),
(14, 'Grifo Lavamanos Monocomando', 'Acabado cromado', 78000.00, 10, 4),
(15, 'Cinta de Teflón 12mm x 10m', 'Sellado de roscas', 1500.00, 100, 4),
(16, 'Bomba de Agua 1HP', 'Para sistemas de presión de agua', 450000.00, 5, 4),
(17, 'Cable Eléctrico 2x14 AWG', 'Para instalaciones domésticas', 3500.00, 200, 5),
(18, 'Interruptor Sencillo Blanco', 'Uso residencial', 1800.00, 150, 5),
(19, 'Bombillo LED 9W Luz Cálida', 'Bajo consumo', 7500.00, 80, 5),
(20, 'Toma Doble con Tierra', 'Plástico ABS resistente', 3800.00, 60, 5),
(21, 'Breaker 20A', 'Protección de circuitos', 12500.00, 25, 5),
(22, 'Casco de Seguridad Naranja', 'Certificado ANSI', 28000.00, 20, 6),
(23, 'Guantes de Cuero para Soldar', 'Resistentes al calor', 18000.00, 30, 6),
(24, 'Gafas de Protección Transparente', 'Anti-rayaduras', 8500.00, 40, 6),
(25, 'Chaleco Reflectivo Amarillo', 'Alta visibilidad', 12000.00, 50, 6),
(26, 'Botas de Seguridad con Punta de Acero', 'Antideslizantes', 95000.00, 15, 6),
(27, 'Tornillo para Madera 1”', 'Caja x 100 unidades', 7500.00, 60, 7),
(28, 'Perno con Tuerca 3/8” x 4”', 'Galvanizado', 2500.00, 80, 7),
(29, 'Clavo de Acero 2”', 'Bolsa x 100 unidades', 4500.00, 90, 7),
(30, 'Arandela Plana 1/4”', 'Bolsa x 50 unidades', 2000.00, 100, 7),
(31, 'Taco Plástico #8', 'Bolsa x 50 unidades', 3500.00, 70, 7),
(32, 'Candado de Latón 40mm', 'Incluye 2 llaves', 12500.00, 35, 8),
(33, 'Cerradura de Sobreponer', 'Alta seguridad', 38000.00, 20, 8),
(34, 'Bisagra de Acero 3”', 'Par', 2500.00, 50, 8),
(35, 'Manija para Puerta Interior', 'Acabado satinado', 28000.00, 15, 8),
(36, 'Adhesivo Epóxico 90g', 'Alta resistencia', 8000.00, 25, 8),
(37, 'Taladro Percutor 750W', 'Con maletín y brocas', 320000.00, 8, 9),
(38, 'Amoladora Angular 4 1/2”', '850W', 270000.00, 10, 9),
(39, 'Hidrolavadora 1400 PSI', 'Uso doméstico', 420000.00, 6, 9),
(40, 'Compresor de Aire 24L', 'Motor 2HP', 580000.00, 4, 9),
(41, 'Soldadora Inverter 200A', 'Incluye pinza y cables', 650000.00, 5, 9),
(42, 'Manguera de Jardín 15m', 'Con conectores', 32000.00, 25, 10),
(43, 'Pala de Punta', 'Mango de madera', 25000.00, 15, 10),
(44, 'Tijera de Podar', 'Hoja de acero', 18000.00, 20, 10),
(45, 'Fertilizante Granulado 5Kg', 'Para césped y plantas', 42000.00, 12, 10),
(46, 'Malla Plástica para Jardín 1x10m', 'Protección de áreas', 28000.00, 8, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(12) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documento`, `nombre`, `email`, `usuario`, `contrasena`, `id_rol`) VALUES
(1103466687, 'Miguel Angel', 'Miguel@gmail.com', 'Miguel', '$2y$10$2561HF9Gv2UHS.d6sSl4u.yBoeSreT0/7JcUVOHwMMlhKfwMS3m8y', 3),
(1107977792, 'Juan Esteban Riveros Nuñez', 'juanestebank7@gmail.com', 'Mono', '$2y$10$LDr187Zf0maus.qfB.Z8j.At7uYxQ/3kjePLjkqKLZ8ZMT/EF1Ch.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `documento` int(12) NOT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documento`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `documento` (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `documento` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1154788896;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
