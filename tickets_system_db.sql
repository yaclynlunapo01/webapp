-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 16 2021 г., 10:41
-- Версия сервера: 10.4.17-MariaDB
-- Версия PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tickets_system_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `asientos`
--

CREATE TABLE `asientos` (
  `id_asientos` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `numero_asientos` int(11) NOT NULL,
  `id_sector_asientos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `boletos`
--

CREATE TABLE `boletos` (
  `id_boleto` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `id_eventos` int(11) NOT NULL,
  `id_asiento` int(11) NOT NULL,
  `id_localidad` int(11) NOT NULL,
  `id_estados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `credenciales_usuarios`
--

CREATE TABLE `credenciales_usuarios` (
  `id_credenciales_usuarios` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `login_usuarios` varchar(60) NOT NULL,
  `contrasena_usuarios` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `credenciales_usuarios`
--

INSERT INTO `credenciales_usuarios` (`id_credenciales_usuarios`, `id_usuarios`, `login_usuarios`, `contrasena_usuarios`) VALUES
(1, 1, 'y_luna@gmail.com', '123456789'),
(2, 4, 'cris_93@mail.ru', '123456'),
(6, 12, 'tomakoba_e@mail.ru', '123456789'),
(7, 13, 'margotromero@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Структура таблицы `estados`
--

CREATE TABLE `estados` (
  `id_estados` int(11) NOT NULL,
  `nombre_estados` varchar(60) NOT NULL,
  `tabla_estados` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `estados`
--

INSERT INTO `estados` (`id_estados`, `nombre_estados`, `tabla_estados`) VALUES
(1, 'ACTIVO', 'eventos'),
(2, 'REALIZADO', 'eventos'),
(3, 'CANCELADO', 'eventos'),
(4, 'ACTIVO', 'boletos'),
(5, 'RETORNADO', 'boletos');

-- --------------------------------------------------------

--
-- Структура таблицы `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `nombre_evento` varchar(120) NOT NULL,
  `id_tipo_evento` int(11) NOT NULL,
  `fecha_evento` date NOT NULL,
  `hora_evento` time NOT NULL,
  `descripcion_evento` varchar(500) NOT NULL,
  `id_estado_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `eventos`
--

INSERT INTO `eventos` (`id_evento`, `nombre_evento`, `id_tipo_evento`, `fecha_evento`, `hora_evento`, `descripcion_evento`, `id_estado_evento`) VALUES
(1, 'Динамо - Спартак', 1, '2021-05-11', '16:00:00', 'Баскетвольный матч', 1),
(2, 'Грегорий Лепс  в Концерте', 3, '2021-05-12', '18:00:00', 'Грегорий Лепс  в Концерте', 1),
(3, '9 мая - День победы!', 3, '2021-05-09', '10:00:00', 'Концерт в чести дня победы', 1),
(4, 'Real Madrid vs Barcelona', 1, '2021-05-20', '20:00:00', 'Real Madrid vs Barcelona', 1),
(5, 'Margot en concierto', 3, '2021-05-30', '19:30:00', 'Unica presentacion', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `localidad`
--

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL,
  `nombre_localidad` varchar(60) NOT NULL,
  `precio_localidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `rol_usuarios`
--

CREATE TABLE `rol_usuarios` (
  `id_rol_usuarios` int(11) NOT NULL,
  `nombre_rol_usuarios` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `rol_usuarios`
--

INSERT INTO `rol_usuarios` (`id_rol_usuarios`, `nombre_rol_usuarios`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'CLIENTE');

-- --------------------------------------------------------

--
-- Структура таблицы `sector`
--

CREATE TABLE `sector` (
  `id_sector` int(11) NOT NULL,
  `nombre_sector` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `tipo_eventos`
--

CREATE TABLE `tipo_eventos` (
  `id_tipo_evento` int(11) NOT NULL,
  `nombre_tipo_evento` varchar(60) NOT NULL,
  `abreviacion_tipo_evento` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tipo_eventos`
--

INSERT INTO `tipo_eventos` (`id_tipo_evento`, `nombre_tipo_evento`, `abreviacion_tipo_evento`) VALUES
(1, 'Спортивный', 'SPT'),
(3, 'Концерт', 'CRT');

-- --------------------------------------------------------

--
-- Структура таблицы `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `patronimico` varchar(60) NOT NULL,
  `correo_usuarios` varchar(100) NOT NULL,
  `fecha_nacimiento_usuarios` date NOT NULL,
  `id_rol_usuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre`, `apellido`, `patronimico`, `correo_usuarios`, `fecha_nacimiento_usuarios`, `id_rol_usuarios`) VALUES
(1, 'Yaklyn', 'Luna', 'Del Valle', 'y_luna@gmail.com', '1993-02-02', 1),
(4, 'Cristian', 'Nolivos', 'Alejandro', 'cris_93@mail.ru', '1993-08-21', 2),
(12, 'Елена', 'Томакова', 'Александровна', 'tomakoba_e@mail.ru', '1986-06-19', 2),
(13, 'Маргот', 'Ромеро', 'Элли', 'margotromero@gmail.com', '1991-04-30', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `asientos`
--
ALTER TABLE `asientos`
  ADD PRIMARY KEY (`id_asientos`),
  ADD KEY `id_sector_asientos` (`id_sector_asientos`),
  ADD KEY `id_asiento_FK` (`id_evento`);

--
-- Индексы таблицы `boletos`
--
ALTER TABLE `boletos`
  ADD PRIMARY KEY (`id_boleto`),
  ADD KEY `id_localidad` (`id_localidad`),
  ADD KEY `id_asiento` (`id_asiento`),
  ADD KEY `id_eventos` (`id_eventos`),
  ADD KEY `id_usuarios` (`id_usuarios`),
  ADD KEY `id_estados_FK2` (`id_estados`);

--
-- Индексы таблицы `credenciales_usuarios`
--
ALTER TABLE `credenciales_usuarios`
  ADD PRIMARY KEY (`id_credenciales_usuarios`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Индексы таблицы `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estados`);

--
-- Индексы таблицы `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `id_tipo_evento` (`id_tipo_evento`),
  ADD KEY `id_estado_evento` (`id_estado_evento`);

--
-- Индексы таблицы `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id_localidad`);

--
-- Индексы таблицы `rol_usuarios`
--
ALTER TABLE `rol_usuarios`
  ADD PRIMARY KEY (`id_rol_usuarios`);

--
-- Индексы таблицы `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id_sector`);

--
-- Индексы таблицы `tipo_eventos`
--
ALTER TABLE `tipo_eventos`
  ADD PRIMARY KEY (`id_tipo_evento`);

--
-- Индексы таблицы `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`),
  ADD KEY `id_rol_usuarios_FK` (`id_rol_usuarios`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `asientos`
--
ALTER TABLE `asientos`
  MODIFY `id_asientos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id_boleto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `credenciales_usuarios`
--
ALTER TABLE `credenciales_usuarios`
  MODIFY `id_credenciales_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rol_usuarios`
--
ALTER TABLE `rol_usuarios`
  MODIFY `id_rol_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `sector`
--
ALTER TABLE `sector`
  MODIFY `id_sector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tipo_eventos`
--
ALTER TABLE `tipo_eventos`
  MODIFY `id_tipo_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `asientos`
--
ALTER TABLE `asientos`
  ADD CONSTRAINT `asientos_ibfk_1` FOREIGN KEY (`id_sector_asientos`) REFERENCES `sector` (`id_sector`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asientos_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `boletos`
--
ALTER TABLE `boletos`
  ADD CONSTRAINT `boletos_ibfk_1` FOREIGN KEY (`id_asiento`) REFERENCES `asientos` (`id_asientos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_ibfk_2` FOREIGN KEY (`id_localidad`) REFERENCES `localidad` (`id_localidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_ibfk_3` FOREIGN KEY (`id_eventos`) REFERENCES `eventos` (`id_evento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_ibfk_4` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `credenciales_usuarios`
--
ALTER TABLE `credenciales_usuarios`
  ADD CONSTRAINT `credenciales_usuarios_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_tipo_evento`) REFERENCES `tipo_eventos` (`id_tipo_evento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`id_estado_evento`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol_usuarios`) REFERENCES `rol_usuarios` (`id_rol_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
