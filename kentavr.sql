-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2018 г., 13:36
-- Версия сервера: 5.5.53
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kentavr`
--
CREATE DATABASE IF NOT EXISTS `kentavr` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kentavr`;

-- --------------------------------------------------------

--
-- Структура таблицы `confirm`
--

DROP TABLE IF EXISTS `confirm`;
CREATE TABLE `confirm` (
  `id` int(11) NOT NULL,
  `caption` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `confirm`
--

INSERT INTO `confirm` (`id`, `caption`) VALUES
(1, 'На согласовании'),
(2, 'Утвержденно'),
(3, 'Отменено');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `caption`) VALUES
(1, 'тенге'),
(2, 'доллар'),
(3, 'рубль'),
(4, 'евро');

-- --------------------------------------------------------

--
-- Структура таблицы `dept`
--

DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL,
  `dept` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dept`
--

INSERT INTO `dept` (`id`, `dept`) VALUES
(1, 'ВЦ'),
(2, 'Гараж'),
(3, 'РМЦ'),
(4, 'ПВТСКиБ'),
(5, 'ЦУБ'),
(6, 'Администрация'),
(7, 'Лаборатория');

-- --------------------------------------------------------

--
-- Структура таблицы `executor`
--

DROP TABLE IF EXISTS `executor`;
CREATE TABLE `executor` (
  `id` int(11) NOT NULL,
  `exec` varchar(45) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `executor`
--

INSERT INTO `executor` (`id`, `exec`, `id_user`) VALUES
(1, 'Нач.снабжения', 3),
(2, 'Снабженец', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_main`
--

DROP TABLE IF EXISTS `menu_main`;
CREATE TABLE `menu_main` (
  `id` int(11) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_main`
--

INSERT INTO `menu_main` (`id`, `caption`, `url`) VALUES
(1, 'Главная', '/'),
(2, 'Телефонный справочник', '/main/tel'),
(3, 'Почтовые номера', '/main/pechkin');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_right`
--

DROP TABLE IF EXISTS `menu_right`;
CREATE TABLE `menu_right` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) NOT NULL,
  `url` varchar(100) NOT NULL,
  `access` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_right`
--

INSERT INTO `menu_right` (`id`, `caption`, `url`, `access`) VALUES
(1, 'Menu 1', '#', '0'),
(2, 'Menu 2', '##', '0'),
(3, 'Menu 3', '###', '0'),
(7, 'Оформить заявку на ТМЦ', '/order/addprovision', '99'),
(8, 'Создать пользователя', '/admin/addusers', '1'),
(9, 'Утверждение заявок', '/order/appprovision', '6'),
(10, 'Снабжение - не назначенное', '/order/ordernot', '2'),
(11, 'Мои заявки на ТМЦ', '/order/myprov', '99'),
(12, 'Снабжение - к исполнению', '/order/orderexec', '2,3');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `tovname` varchar(250) NOT NULL,
  `qt` decimal(10,2) NOT NULL,
  `unit` int(11) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `curr` int(11) DEFAULT NULL,
  `term` int(11) NOT NULL,
  `conf` int(11) NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `dateconf` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `flag` tinyint(4) DEFAULT NULL,
  `id_sup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `datetime`, `user`, `tovname`, `qt`, `unit`, `cost`, `curr`, `term`, `conf`, `note`, `dateconf`, `deadline`, `status`, `flag`, `id_sup`) VALUES
(1, '2018-02-14 00:02:43', 2, 'Товар 1', '1.00', 1, '1.00', 1, 2, 2, 'прим', '2018-02-14', '2018-02-23', 2, 1, 2),
(2, '2018-02-14 00:02:43', 2, 'товар 2', '5.00', 1, '5.00', 1, 2, 2, 'прим', '2018-02-14', '2018-02-23', 2, 1, 3),
(3, '2018-02-14 00:02:43', 2, 'товар 2', '20.00', 1, '5.00', 1, 4, 2, 'прим', '2018-02-14', '2018-03-16', 2, 1, 5),
(4, '2018-02-14 11:02:21', 2, 'товар тест', '5.00', 1, '5.00', 1, 1, 2, '', '2018-02-14', '2018-02-21', 2, 1, 1),
(5, '2018-02-14 11:02:13', 2, 'товар тест', '5.00', 1, '0.00', 1, 1, 2, '', '2018-02-14', '2018-02-21', 2, 1, 1),
(6, '2018-02-14 11:02:56', 2, 'товар тест', '15.00', 1, '0.00', 1, 1, 2, '', '2018-02-14', '2018-02-21', 2, 1, 1),
(7, '2018-02-14 11:02:05', 2, 'товар тест', '5.00', 1, '0.00', 1, 1, 2, '', '2018-02-14', '2018-02-21', 2, 1, 1),
(8, '2018-02-14 12:02:04', 3, '12345', '1.00', 1, '0.00', 1, 1, 3, '', '2018-02-14', NULL, NULL, NULL, NULL),
(9, '2018-02-15 11:02:59', 2, 'товар 2', '10.00', 2, '0.00', 1, 2, 2, '', '2018-02-15', '2018-02-23', 2, 1, NULL),
(10, '2018-02-15 14:02:56', 2, 'товар 2', '50.00', 1, '0.00', 1, 2, 2, '', '2018-02-15', '2018-02-23', 2, 1, 3),
(11, '2018-02-15 15:02:26', 2, 'товар новый', '10.00', 3, '10.00', 2, 3, 2, '', '2018-02-15', '2018-03-02', 2, 1, 7),
(12, '2018-02-15 15:02:56', 2, 'товар новый', '2.00', 1, '2.00', 1, 1, 2, '', '2018-02-15', '2018-02-21', 2, 1, 6),
(13, '2018-02-15 15:02:51', 3, 'товар супер новый', '1.00', 1, '0.00', 1, 1, 2, '', '2018-02-15', '2018-02-21', 2, 1, 8),
(14, '2018-02-15 16:02:39', 2, 'товар тест', '1.00', 1, '0.00', 1, 1, 2, '', '2018-02-15', '2018-02-21', 2, 1, 1),
(15, '2018-02-16 11:02:19', 2, 'dsfdfgdfhdhgfghfg', '5.00', 1, '0.00', 1, 1, 2, '', '2018-02-16', '2018-02-21', 4, 1, 9),
(16, '2018-02-16 16:02:53', 3, 'vcngvgjgjvhjh', '5.00', 1, '500.00', 1, 4, 2, '', '2018-02-17', '2018-03-23', 2, 1, 10),
(17, '2018-02-17 16:02:24', 1, 'шины на камаз', '2.00', 4, '0.00', 1, 3, 2, 'хоршие', '2018-02-17', '2018-03-09', 2, 1, 12),
(18, '2018-02-17 16:02:50', 2, 'шины на камаз', '5.00', 4, '0.00', 1, 3, 2, '', '2018-02-17', '2018-03-09', 2, 1, 12),
(19, '2018-02-17 16:02:50', 2, 'шины на камаз', '2.00', 4, '0.00', 1, 1, 2, '', '2018-02-17', '2018-02-21', 2, 1, 11),
(20, '2018-02-17 16:02:50', 2, 'шины на камаз', '2.00', 1, '0.00', 1, 4, 2, '', '2018-02-17', '2018-03-23', 2, 1, 13),
(21, '2018-02-17 22:02:46', 2, 'ghjghkgllugjjului', '3.00', 1, '0.00', 1, 1, 2, '', '2018-02-17', '2018-02-21', 2, 1, 14),
(22, '2018-02-17 22:02:13', 2, 'hgmhj,gh,hjk,hj', '1.00', 1, '0.00', 1, 1, 2, '', '2018-02-17', '2018-02-21', 2, 1, 15),
(23, '2018-02-21 14:02:30', 3, 'qwerty', '10.00', 1, '0.00', 1, 2, 2, '', '2018-02-21', '2018-03-02', 2, 1, 16),
(24, '2018-02-21 14:02:53', 2, 'qwerty', '8.00', 1, '0.00', 1, 2, 2, '', '2018-02-21', '2018-03-02', 2, 1, 16),
(25, '2018-02-21 16:02:22', 2, 'лампочки 100Вт', '10.00', 1, '0.00', 1, 1, 2, '', '2018-02-21', '2018-02-28', 2, 1, 17),
(26, '2018-02-21 17:02:07', 2, 'двигатель', '5.00', 1, '10.00', 1, 1, 2, '', '2018-02-21', '2018-02-28', 2, 1, 18);

-- --------------------------------------------------------

--
-- Структура таблицы `order_perf`
--

DROP TABLE IF EXISTS `order_perf`;
CREATE TABLE `order_perf` (
  `id` int(11) NOT NULL,
  `id_sup` int(11) NOT NULL,
  `qt` decimal(10,2) NOT NULL,
  `unit` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `curr` int(11) NOT NULL,
  `rem` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_perf`
--

INSERT INTO `order_perf` (`id`, `id_sup`, `qt`, `unit`, `cost`, `curr`, `rem`, `created_at`) VALUES
(1, 15, '1.00', 1, '50.00', 1, '', 1520936200),
(2, 15, '1.00', 1, '50.00', 1, '', 1520936785),
(3, 15, '1.00', 1, '50.00', 1, '', 1520936810),
(5, 15, '1.00', 1, '50.00', 1, '', 1520937162);

-- --------------------------------------------------------

--
-- Структура таблицы `order_supply`
--

DROP TABLE IF EXISTS `order_supply`;
CREATE TABLE `order_supply` (
  `id` int(11) NOT NULL,
  `qt` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `curr` int(11) DEFAULT NULL,
  `exec` int(11) NOT NULL,
  `st` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_supply`
--

INSERT INTO `order_supply` (`id`, `qt`, `cost`, `curr`, `exec`, `st`, `created_at`) VALUES
(1, NULL, '100.00', 1, 2, 0, 0),
(2, NULL, '100.00', 1, 2, 0, 0),
(3, NULL, '100.00', 1, 2, 0, 0),
(5, NULL, '100.00', 1, 2, 0, 0),
(6, NULL, '300.00', 1, 2, 0, 0),
(7, NULL, '100.00', 1, 2, 0, 0),
(8, NULL, '100.00', 1, 2, 0, 0),
(9, NULL, '100.00', 1, 2, 0, 0),
(10, NULL, '100.00', 1, 2, 0, 0),
(11, NULL, '100.00', 1, 2, 0, 0),
(12, NULL, '100.00', 1, 2, 0, 0),
(13, NULL, '200.00', 1, 2, 0, 0),
(14, NULL, '200.00', 1, 2, 0, 0),
(15, NULL, '200.00', 1, 1, 0, 0),
(16, NULL, '100.00', 1, 2, 0, 0),
(17, NULL, '800.00', 1, 1, 0, 0),
(18, NULL, '500.00', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pechkinbook`
--

DROP TABLE IF EXISTS `pechkinbook`;
CREATE TABLE `pechkinbook` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `number` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pechkinbook`
--

INSERT INTO `pechkinbook` (`id`, `name`, `number`) VALUES
(1, 'Ахметзянов Тимур', '964'),
(2, 'Носов Роман', '2181');

-- --------------------------------------------------------

--
-- Структура таблицы `phonebook`
--

DROP TABLE IF EXISTS `phonebook`;
CREATE TABLE `phonebook` (
  `idphonebook` int(11) NOT NULL,
  `post` varchar(45) NOT NULL,
  `fio` varchar(100) DEFAULT NULL,
  `tel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `phonebook`
--

INSERT INTO `phonebook` (`idphonebook`, `post`, `fio`, `tel`) VALUES
(1, 'Директор', 'Абдрахманов Марат Тлектесович', '102'),
(2, 'Директор по производству', 'Абубакиров Дмитрий Равильевич', '105');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Администратор'),
(6, 'Главный инженер'),
(4, 'Заказчик'),
(2, 'Начальник снабжения'),
(5, 'Секретарь'),
(3, 'Снабженец');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `caption`) VALUES
(1, 'В обработке снабжения'),
(2, 'Запущено в работу'),
(3, 'Частично выполнено'),
(4, 'Поставлено на склад');

-- --------------------------------------------------------

--
-- Структура таблицы `term`
--

DROP TABLE IF EXISTS `term`;
CREATE TABLE `term` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) NOT NULL,
  `strtotime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `term`
--

INSERT INTO `term` (`id`, `caption`, `strtotime`) VALUES
(1, '1-3 дня', '3'),
(2, 'Неделя', '+1 week next Friday'),
(3, '2 недели', '+2 week next Friday'),
(4, 'Месяц', '+1 month next Friday');

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `caption` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `caption`) VALUES
(1, 'шт'),
(2, 'кг'),
(3, 'тонна'),
(4, 'комплект'),
(5, 'литр');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `salt` varchar(35) NOT NULL,
  `uq_str` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `fio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `salt`, `uq_str`, `role`, `dept`, `fio`) VALUES
(1, 'admin', '$2y$10$NG1F7L1WzJWgdJvRelJmh.VNpzgCQEfFTdV2MDTrvt0oiETAOdcTW', 'S<-/PL[Y)C{b)^b!i>S*not9)OCkX7', '', 1, 1, 'Тимур'),
(2, 'ingener', '$2y$10$C2XPfom6CYLHYFhosd6pTOG0NzpmTkTSYcdVP6Npze/1uzhwinFR.', 'UcpO5HBV2|/h`Gp1jCxRTE-}!}`Yh>', NULL, 6, 6, 'Инженер'),
(3, 'snab', '$2y$10$AnuCWv1OCHtVfEEnlIios.lk5CYwI2p6l4UfooFSyKgoNodyaOHMG', 'iTGk>{}/Z/s1b[Sbs29xXn?<.gx+)U', NULL, 2, 6, 'Снабжение'),
(4, 'test', '$2y$10$GFqzBJGO8e3cxULCBOkEvOxuWIW2AhR/oORERLL89PlF/5c97r8Qq', 'GEb@/hC3msCB?npORkKHRxrUXP}Y!V', NULL, 4, 1, 'Заказчик'),
(5, 'igor', '$2y$10$4rTPU6FS66GIXW.TdHq3i.NplRwWyFkl1.JEvQYXVzqzQB3ZYv/su', '%>dIM?/F.V)(8VPmyRiAn)IY^Mu9iX', NULL, 3, 6, 'Игорь');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `confirm`
--
ALTER TABLE `confirm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `executor`
--
ALTER TABLE `executor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu_main`
--
ALTER TABLE `menu_main`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caption_UNIQUE` (`caption`),
  ADD UNIQUE KEY `url_UNIQUE` (`url`);

--
-- Индексы таблицы `menu_right`
--
ALTER TABLE `menu_right`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `caption_UNIQUE` (`caption`),
  ADD UNIQUE KEY `url_UNIQUE` (`url`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_provision_unit_idx` (`unit`),
  ADD KEY `fk_provision_curr_idx` (`curr`),
  ADD KEY `fk_provision_term_idx` (`term`),
  ADD KEY `fk_provision_conf_idx` (`conf`),
  ADD KEY `fk_order_id` (`user`),
  ADD KEY `fk_order_status_idx` (`status`);

--
-- Индексы таблицы `order_perf`
--
ALTER TABLE `order_perf`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_supply`
--
ALTER TABLE `order_supply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_supply_exec_idx` (`exec`);

--
-- Индексы таблицы `pechkinbook`
--
ALTER TABLE `pechkinbook`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `phonebook`
--
ALTER TABLE `phonebook`
  ADD PRIMARY KEY (`idphonebook`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `fk_users_dept_idx` (`dept`),
  ADD KEY `fk_users_role_idx` (`role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `confirm`
--
ALTER TABLE `confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `dept`
--
ALTER TABLE `dept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `executor`
--
ALTER TABLE `executor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `menu_main`
--
ALTER TABLE `menu_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `menu_right`
--
ALTER TABLE `menu_right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `order_perf`
--
ALTER TABLE `order_perf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `order_supply`
--
ALTER TABLE `order_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pechkinbook`
--
ALTER TABLE `pechkinbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `phonebook`
--
ALTER TABLE `phonebook`
  MODIFY `idphonebook` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_conf` FOREIGN KEY (`conf`) REFERENCES `confirm` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_curr` FOREIGN KEY (`curr`) REFERENCES `currency` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_status` FOREIGN KEY (`status`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_term` FOREIGN KEY (`term`) REFERENCES `term` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_unit` FOREIGN KEY (`unit`) REFERENCES `units` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_supply`
--
ALTER TABLE `order_supply`
  ADD CONSTRAINT `fk_order_supply_exec` FOREIGN KEY (`exec`) REFERENCES `executor` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_dept` FOREIGN KEY (`dept`) REFERENCES `dept` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
