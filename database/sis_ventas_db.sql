-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-01-2026 a las 18:48:22
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sis_ventas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) NOT NULL,
  `ci` varchar(155) NOT NULL,
  `ci_exp` varchar(155) NOT NULL,
  `cel` varchar(155) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `ci`, `ci_exp`, `cel`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'JUAN ALVARES', '48965126', 'LP', '68412345', 1, '2020-04-14 04:00:00', '2020-04-15 04:28:15'),
(2, 'JORGE FLORES', '65432178', 'LP', '78945612', 1, '2020-04-15 03:24:00', '2020-04-15 04:27:53'),
(3, 'JORGE CASTELLON', '666666', 'LP', '6666666', 1, '2022-09-15 22:52:37', '2022-09-15 22:52:37'),
(4, 'FERNANDA CONTRERAS', '456456456', 'CB', '67867868', 1, '2026-01-13 18:34:25', '2026-01-13 18:34:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descuento` decimal(24,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id`, `nom`, `descuento`, `tipo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'SIN DESCUENTO', 0.00, 'BS', 'NO SE REALIZA NINGÚN DESCUENTO SOBRE EL PRODUCTO', '2020-04-03 17:35:28', '2020-04-03 17:35:28'),
(2, 'DESCUENTO MENOR', 5.00, 'BS', 'DESCUENTO DEL 5 BS. DEL TOTAL DE PRODUCTOS ADQUIRIDOS', '2020-04-03 17:35:35', '2022-09-15 22:43:05'),
(3, 'DESCUENTO PRUEBA', 2.00, 'BS', 'PRUEBA DESCUENTO DE 10 BS', '2022-09-15 22:43:43', '2022-09-16 23:49:29'),
(4, 'DESCUENTO 3', 4.00, 'P', 'DESCUENTO POR PORCENTAJE', '2026-01-13 18:19:06', '2026-01-13 18:19:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` int NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `descuento_id` bigint UNSIGNED NOT NULL,
  `descuento` decimal(24,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `producto_id`, `cantidad`, `costo`, `descuento_id`, `descuento`, `tipo`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 5, 35.00, 1, 0.00, '', 175.00, '2022-09-16 00:06:39', '2022-09-16 00:06:39'),
(2, 1, 1, 3, 12.50, 1, 0.00, '', 37.50, '2022-09-16 00:06:39', '2022-09-16 00:06:39'),
(3, 1, 2, 5, 20.00, 1, 0.00, '', 100.00, '2022-09-16 00:06:39', '2022-09-16 00:06:39'),
(4, 2, 1, 5, 12.50, 1, 0.00, '', 62.50, '2022-09-16 00:08:00', '2022-09-16 00:08:00'),
(5, 2, 2, 7, 20.00, 1, 0.00, '', 140.00, '2022-09-16 00:08:00', '2022-09-16 00:08:00'),
(6, 2, 3, 11, 35.00, 3, 0.00, '', 365.00, '2022-09-16 00:08:00', '2022-09-16 00:08:00'),
(7, 3, 1, 4, 12.50, 1, 0.00, '', 50.00, '2022-09-16 00:08:55', '2022-09-16 00:08:55'),
(8, 3, 2, 3, 20.00, 1, 0.00, '', 60.00, '2022-09-16 00:08:55', '2022-09-16 00:08:55'),
(9, 3, 3, 12, 35.00, 3, 0.00, '', 400.00, '2022-09-16 00:08:55', '2022-09-16 00:08:55'),
(10, 4, 1, 10, 12.50, 1, 0.00, '', 125.00, '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(11, 4, 2, 6, 20.00, 1, 0.00, '', 120.00, '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(12, 4, 3, 4, 35.00, 1, 0.00, '', 140.00, '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(13, 4, 4, 5, 7.00, 1, 0.00, '', 35.00, '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(14, 4, 5, 5, 9.00, 1, 0.00, '', 45.00, '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(15, 5, 4, 11, 7.00, 1, 0.00, '', 77.00, '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(16, 5, 3, 11, 35.00, 3, 0.00, '', 374.00, '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(17, 5, 1, 2, 12.50, 1, 0.00, '', 25.00, '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(18, 5, 5, 2, 9.00, 1, 0.00, '', 18.00, '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(19, 6, 3, 12, 35.00, 3, 0.00, '', 396.00, '2022-09-16 23:57:05', '2022-09-16 23:57:05'),
(20, 6, 1, 1, 12.50, 1, 0.00, '', 12.50, '2022-09-16 23:57:05', '2022-09-16 23:57:05'),
(21, 7, 3, 11, 35.00, 3, 0.00, '', 363.00, '2022-09-17 00:01:41', '2022-09-17 00:01:41'),
(22, 7, 3, 12, 35.00, 3, 0.00, '', 396.00, '2022-09-17 00:01:41', '2022-09-17 00:01:41'),
(25, 13, 1, 5, 12.50, 4, 4.00, 'P', 60.00, '2026-01-13 18:47:03', '2026-01-13 18:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `cel`, `fono`, `foto`, `correo`, `rol`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'JORGE', 'ALCANTARA', '', '12345678', 'LP', 'DIRECCIÓN', '78945612', '', 'user_default.png', 'jorge@gmail.com', 'ROL', 2, '2020-04-03 17:34:24', '2020-04-03 17:34:24'),
(2, 'JAIME', 'CASTRO', '', '87654321', 'LP', 'DIRECCIÓN', '68412345', '', 'user_default.png', 'jaime@hotmail.com', 'ROL', 3, '2020-04-03 17:35:02', '2020-04-03 17:35:02'),
(3, 'PABLO', 'GONZALES', '', '444', 'LP', 'ZONA LOS OLIVOS CALLE 3 # 3232', '66666666', '2322222', 'user_default.png', 'pablo@gmail.com', 'VENDEDOR', 4, '2022-09-16 00:08:26', '2022-09-16 00:08:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint UNSIGNED NOT NULL,
  `cod` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_aut` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_emp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dpto` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `calle` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `casilla` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actividad_eco` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `cod`, `nit`, `nro_aut`, `nro_emp`, `name`, `alias`, `pais`, `dpto`, `ciudad`, `zona`, `calle`, `nro`, `email`, `fono`, `cel`, `fax`, `casilla`, `web`, `logo`, `actividad_eco`, `created_at`, `updated_at`) VALUES
(1, 'EMP01', '111111111111', '0000000000', '6666544555', 'EMPRESA SAN MIGUEL', 'E.P.', 'BOLIVIA', 'COCHABAMBA', 'COCHABAMBA', 'EXALTACIÓN', 'LOS OLIVOS', '111', 'sanmiguel@gmail.com', '2222221', '787767777', '', '', '', 'EMPRESA_SAN_MIGUEL1663280732.jpg', 'CON FINES DE LUCRO', '2020-04-03 17:34:20', '2026-01-13 18:43:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_08_150906_create_empresas_table', 1),
(4, '2020_03_31_100532_create_empleados_table', 1),
(5, '2020_03_31_100608_create_ventas_table', 1),
(6, '2020_03_31_100619_create_productos_table', 1),
(7, '2020_03_31_100631_create_descuentos_table', 1),
(8, '2020_03_31_100646_create_promocions_table', 1),
(9, '2020_03_31_101301_create_detalle_ventas_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` decimal(24,2) NOT NULL,
  `disponible` int NOT NULL,
  `ingresos` int NOT NULL,
  `salidas` int NOT NULL,
  `descripcion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nom`, `costo`, `disponible`, `ingresos`, `salidas`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'PRODUCTO 1', 12.50, 8, 46, 30, '', '2020-04-03 17:35:12', '2026-01-13 18:47:03'),
(2, 'PRODUCTO 2', 20.00, 10, 44, 21, '', '2020-04-03 17:35:21', '2026-01-13 18:34:50'),
(3, 'GALONES DE 15 L', 35.00, 4, 100, 78, 'INGRESO DE GALONES', '2022-09-15 22:50:54', '2026-01-13 18:34:50'),
(4, 'BOTELLA DE 1 L', 7.00, 44, 60, 16, '', '2022-09-16 00:09:11', '2022-09-16 15:31:13'),
(5, 'BOTELLA DE 1.5 L', 9.00, 23, 30, 7, '', '2022-09-16 00:09:25', '2022-09-16 15:31:13'),
(6, 'PRODUCTO PRUEBA', 90.00, 10, 10, 0, 'DESC', '2026-01-13 18:13:45', '2026-01-13 18:14:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `descuento_id` bigint UNSIGNED NOT NULL,
  `inicio` int NOT NULL,
  `fin` int DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nom`, `producto_id`, `descuento_id`, `inicio`, `fin`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(6, 'PROMOCION 1', 1, 2, 4, NULL, '2020-04-06', '2020-04-30', '2020-04-06 18:58:14', '2020-04-06 19:14:01'),
(7, 'PROMOCION DE PRUEBA', 1, 2, 1, NULL, '2022-09-13', '2022-09-14', '2022-09-13 23:45:58', '2022-09-13 23:45:58'),
(8, 'PROMOCION GALONES DE 15L', 3, 3, 10, 15, '2022-09-15', '2022-09-18', '2022-09-15 22:51:41', '2022-09-15 22:53:03'),
(9, 'PROMOCION NUEVA', 1, 4, 5, NULL, '2026-01-13', '2026-01-14', '2026-01-13 18:29:24', '2026-01-13 18:29:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `motivo` varchar(155) NOT NULL,
  `estado` varchar(155) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `user_id`, `motivo`, `estado`, `created_at`, `updated_at`) VALUES
(3, 2, 'RAZON MOTIVO', 'ENVIADO', '2020-04-15 14:12:31', '2020-04-15 15:02:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('ADMINISTRADOR','EMPLEADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `tipo`, `foto`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$sUEoG1YP5g4ptaI.1BrxuOIswhG.xd3aq87ot9YQwdwT3JytQILgu', 'ADMINISTRADOR', 'admin1768329970.jpg', 1, '2020-04-03 17:34:20', '2026-01-13 18:46:20'),
(2, 'JALCANTARA', '$2y$10$5tX7XgcVf8n.K2D792aUrOVw8F69QOa2Af/XVHJpoXqhDNwfXmj4e', 'ADMINISTRADOR', 'user_default.png', 1, '2020-04-03 17:34:24', '2020-04-15 15:02:23'),
(3, 'JCASTRO', '$2y$10$rusaJNsC9WptSR8Sz5fX1OVnsl6rfWPuVWPFz.z0C0FCF2rynvuiK', 'EMPLEADO', 'JCASTRO1663342918.jpg', 1, '2020-04-03 17:35:02', '2022-09-16 15:42:25'),
(4, 'PGONZALES', '$2y$10$rcF8.yxn8gbuxUBE1BhhUOjVkCzSmGZ/Roxdczmn3c0o4qjheaUca', 'EMPLEADO', 'user_default.png', 1, '2022-09-16 00:08:26', '2022-09-16 00:08:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `nit` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_venta` date NOT NULL,
  `nro_factura` bigint NOT NULL,
  `total` decimal(24,2) NOT NULL,
  `total_final` decimal(24,2) NOT NULL,
  `qr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_control` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `user_id`, `cliente_id`, `nit`, `fecha_venta`, `nro_factura`, `total`, `total_final`, `qr`, `codigo_control`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '48965126', '2022-09-15', 10001, 312.50, 312.50, 'QR_489651261663286799.png', '4C-AB-DC-A3-DC', '2022-09-16 00:06:39', '2022-09-16 00:06:39'),
(2, 1, 2, '65432178', '2022-09-15', 10002, 567.50, 567.50, 'QR_654321781663286880.png', 'FF-68-FB-F4-78', '2022-09-16 00:08:00', '2022-09-16 00:08:00'),
(3, 2, 3, '666666', '2022-09-15', 10003, 510.00, 510.00, 'QR_6666661663286935.png', '59-B2-E1-83-ED', '2022-09-16 00:08:55', '2022-09-16 00:08:55'),
(4, 2, 2, '65432178', '2022-09-15', 10004, 465.00, 465.00, 'QR_654321781663286995.png', '3B-97-22-25-39', '2022-09-16 00:09:55', '2022-09-16 00:09:55'),
(5, 1, 2, '65432178', '2022-09-16', 10005, 494.00, 494.00, 'QR_654321781663342272.png', '94-99-13-A9-35', '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(6, 1, 3, '666666', '2022-09-16', 10006, 408.50, 408.50, 'QR_6666661663372625.png', '29-1C-E9-4E-1E', '2022-09-16 23:57:05', '2022-09-16 23:57:05'),
(7, 1, 1, '48965126', '2022-09-16', 10007, 759.00, 759.00, 'QR_489651261663372900.png', '1D-11-3A-94-AB', '2022-09-17 00:01:40', '2022-09-17 00:01:40'),
(13, 1, 2, '65432178', '2026-01-13', 10008, 60.00, 60.00, 'QR_654321781768330023.png', '8B-E1-7B-38-7B', '2026-01-13 18:47:03', '2026-01-13 18:47:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_promociones`
--

CREATE TABLE `venta_promociones` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `promocion_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `venta_promociones`
--

INSERT INTO `venta_promociones` (`id`, `venta_id`, `promocion_id`, `created_at`, `updated_at`) VALUES
(1, 2, 8, '2022-09-16 00:08:00', '2022-09-16 00:08:00'),
(2, 3, 8, '2022-09-16 00:08:55', '2022-09-16 00:08:55'),
(3, 5, 8, '2022-09-16 15:31:13', '2022-09-16 15:31:13'),
(4, 6, 8, '2022-09-16 23:57:05', '2022-09-16 23:57:05'),
(5, 7, 8, '2022-09-17 00:01:41', '2022-09-17 00:01:41'),
(6, 7, 8, '2022-09-17 00:01:41', '2022-09-17 00:01:41'),
(7, 7, 8, '2022-09-17 00:01:41', '2022-09-17 00:01:41'),
(8, 13, 9, '2026-01-13 18:47:03', '2026-01-13 18:47:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  ADD KEY `detalle_ventas_producto_id_foreign` (`producto_id`),
  ADD KEY `detalle_ventas_descuento_id_foreign` (`descuento_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleados_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `descuento_id` (`descuento_id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `venta_promociones`
--
ALTER TABLE `venta_promociones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `promocion_id` (`promocion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `venta_promociones`
--
ALTER TABLE `venta_promociones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_descuento_id_foreign` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`),
  ADD CONSTRAINT `detalle_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `promociones_ibfk_2` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `venta_promociones`
--
ALTER TABLE `venta_promociones`
  ADD CONSTRAINT `venta_promociones_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_promociones_ibfk_2` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
