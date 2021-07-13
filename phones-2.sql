-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 13 2021 г., 19:50
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phones-2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT 'LOGIN',
  `name` varchar(100) DEFAULT NULL COMMENT 'Name',
  `password` varchar(255) NOT NULL,
  `type_user` text NOT NULL DEFAULT '0',
  `colorinterface` varchar(20) DEFAULT 'white',
  `typeStatusPhone` varchar(30) NOT NULL DEFAULT 'row',
  `img_url` text DEFAULT '/resources/images/icon-admin.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `name`, `password`, `type_user`, `colorinterface`, `typeStatusPhone`, `img_url`) VALUES
(43, 'admin', 'Vladislav', '$2y$10$ntQfzT0Wgiik343xoAt28u6paZQ9QODMuocCmIEGMt//UJEfbMEPO', '1', 'dark', 'row', '/resources/upload/804027fd20b7b1aab91908a8bf84e5c6.png'),
(44, 'user', 'Владислав', '$2y$10$g1QI7iIpdo7o7RBlBcuS1OvoN.f5RRCStK2oU5qOXncGVhRR84APC', '0', 'white', 'table', '/resources/images/icon-admin.png'),
(46, 'vlad', 'мдфв', '$2y$10$8YPLbaHLDLg9m8EmKa7AjuMd6JYwvqnP1KLrLT1qePsZ1/ITe9/bS', '1', 'white', 'row', '/resources/images/icon-admin.png');

-- --------------------------------------------------------

--
-- Структура таблицы `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `type` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `theme` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkRegistr` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `actions`
--

INSERT INTO `actions` (`id`, `type`, `user`, `user_level`, `theme`, `text`, `linkRegistr`, `subject`, `date`) VALUES
(1, 'setting base', 'admin', 'admin', 'Очистка таблицы', 'Таблица actions очищена успешно.', NULL, 'Table actions', 'June 9, 2021, 6:47 pm'),
(2, 'setting base', 'admin', 'admin', 'Очистка таблицы', 'Таблицы блокировки очищены успешно.', NULL, 'Table message', 'June 9, 2021, 6:49 pm'),
(3, 'setting base', 'admin', 'admin', 'Очистка таблицы', 'Таблицы блокировки очищены успешно.', NULL, 'Table message', 'June 9, 2021, 6:49 pm'),
(4, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 9, 2021, 6:50 pm'),
(5, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 9, 2021, 6:54 pm'),
(6, 'setting phone', 'phone', 'admin', 'Call on', 'Телефон c номером: 500 установил вызов с $call_id <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, '500', 'June 9, 2021, 7:42 pm'),
(7, 'setting phone', 'phone', 'admin', 'call off', 'Телефон c номером: 500 завершил вызов с $call_id <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, '500', 'June 9, 2021, 7:42 pm'),
(8, 'setting phone', 'phone', 'admin', 'Call on', 'Телефон c номером: 500 установил вызов с $call_id <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, '500', 'June 9, 2021, 7:42 pm'),
(9, 'setting phone', 'phone', 'admin', 'call off', 'Телефон c номером: 500 завершил вызов с $call_id <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, '500', 'June 9, 2021, 7:43 pm'),
(10, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 10, 2021, 2:04 am'),
(11, 'Sign in', 'admin', 'admin', 'Авторизация провал', 'Пользователь admin не прошёл авторизацию. Пароль не верный', NULL, 'admin', 'June 10, 2021, 2:05 am'),
(12, 'Sign in', 'asd', 'admin', 'Авторизация провал', 'Пользователь asd не прошёл авторизацию. Логин не найден', NULL, 'admin', 'June 10, 2021, 2:06 am'),
(13, 'Sign in', 'asda', 'admin', 'Авторизация провал', 'Пользователь asda не прошёл авторизацию. Логин не найден', NULL, 'admin', 'June 10, 2021, 2:06 am'),
(14, 'Sign in', 'asd', 'admin', 'Авторизация провал', 'Пользователь asd не прошёл авторизацию. Логин не найден', NULL, 'admin', 'June 10, 2021, 2:06 am'),
(15, 'Sign in', 'asd', 'admin', 'Авторизация провал', 'Пользователь asd не прошёл авторизацию. Логин не найден', NULL, 'admin', 'June 10, 2021, 2:06 am'),
(16, 'Sign in', 'asd', 'admin', 'Авторизация провал', 'Пользователь asd не прошёл авторизацию. Логин не найден', NULL, 'admin', 'June 10, 2021, 2:06 am'),
(17, 'setting', 'asd', 'admin', 'Блокировка доступа', 'IP : 127.0.0.1 заблокирован с 02:06:35  до 02:36:35. Попытка авторизации по логину asd', NULL, NULL, NULL),
(18, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 192.168.1.2', NULL, 'admin', 'June 10, 2021, 2:07 am'),
(19, 'setting base', 'admin', 'admin', 'Очистка таблицы', 'Таблицы блокировки очищены успешно.', NULL, 'Table message', 'June 10, 2021, 2:07 am'),
(20, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 10, 2021, 2:08 am'),
(21, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 10, 2021, 5:09 pm'),
(22, 'setting', 'admin', 'admin', 'Остановка автоматического сканера сети', 'Сканер завершил процесс успешно. Сканирование всех телефонов завершено. ', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(23, 'setting', 'admin', 'admin', 'Запуск автоматического сканера сети', 'Сканер запущен успешно. Сканирование всех телефонов запущено ', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(24, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(25, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(26, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(27, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(28, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(29, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(30, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(31, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(32, 'setting phone', 'admin', 'admin', 'Телефон не в сети', 'При автоматическом сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:31 pm'),
(33, 'setting phone', '500', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(34, 'setting phone', '418', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(35, 'setting phone', '420', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(36, 'setting phone', '502', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(37, 'setting phone', '520', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(38, 'setting phone', '5003', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(39, 'setting phone', '443-1', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(40, 'setting phone', '50039', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(41, 'setting phone', '5009', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(42, 'setting phone', '500', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(43, 'setting phone', '418', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(44, 'setting phone', '420', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(45, 'setting phone', '502', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(46, 'setting phone', '520', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(47, 'setting phone', '5003', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(48, 'setting phone', '443-1', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(49, 'setting phone', '50039', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(50, 'setting phone', '5009', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'June 10, 2021, 5:39 pm'),
(51, 'setting phone', 'admin', 'Администратор', 'Изменение параметров телефона', 'Параметры у телефона номером: 500 изменены успешно', NULL, '500', 'June 10, 2021, 5:49 pm'),
(52, 'Sign in', 'user', 'admin', 'Авторизация провал', 'Пользователь user не прошёл авторизацию. Пароль не верный', NULL, 'admin', 'June 10, 2021, 5:51 pm'),
(53, 'Sign in', 'user', 'admin', 'Авторизация успешно', 'Пользователь user прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 10, 2021, 5:51 pm'),
(54, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 20, 2021, 6:26 am'),
(55, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 20, 2021, 6:55 am'),
(56, 'setting', 'admin', 'admin', 'Изменение параметров ботов', 'Изменение параметров ботов выполнено успешно', NULL, 'Бот', 'June 20, 2021, 6:56 am'),
(57, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 20, 2021, 7:20 am'),
(58, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'June 21, 2021, 7:02 am'),
(59, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'July 9, 2021, 7:57 am'),
(60, 'Sign in', 'admin', 'admin', 'Авторизация успешно', 'Пользователь admin прошёл авторизацию успешно c ip адреса: 127.0.0.1', NULL, 'admin', 'July 9, 2021, 1:52 pm'),
(61, 'setting phone', '500', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: 192.168.44.56 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(62, 'setting phone', '418', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(63, 'setting phone', '420', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(64, 'setting phone', '502', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(65, 'setting phone', '520', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(66, 'setting phone', '5003', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(67, 'setting phone', '443-1', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(68, 'setting phone', '50039', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(69, 'setting phone', '5009', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'July 9, 2021, 1:52 pm'),
(70, 'message', 'admin', 'admin', 'asd', 'asd', NULL, '5002', 'July 9, 2021, 1:52 pm'),
(71, 'setting phone', 'admin', 'Администратор', 'Изменение параметров телефона', 'Параметры у телефона номером: 427 изменены успешно', NULL, '427', 'July 9, 2021, 1:52 pm'),
(72, 'message', 'admin', 'admin', 'asd', 'asd', NULL, '421-427', 'July 9, 2021, 1:53 pm'),
(73, 'setting', 'admin', 'admin', 'Остановка автоматического сканера сети', 'Сканер завершил процесс успешно. Сканирование всех телефонов завершено. ', NULL, 'Scanner', 'July 9, 2021, 1:53 pm'),
(74, 'setting', 'admin', 'admin', 'Остановка автоматического сканера сети', 'Сканер завершил процесс успешно. Сканирование всех телефонов завершено. ', NULL, 'Scanner', 'July 9, 2021, 1:53 pm'),
(75, 'setting', 'admin', 'admin', 'Остановка автоматического сканера сети', 'Сканер завершил процесс успешно. Сканирование всех телефонов завершено. ', NULL, 'Scanner', 'July 9, 2021, 1:53 pm'),
(76, 'setting', 'admin', 'admin', 'Бот', 'Бот остановлен', NULL, 'admin', 'July 9, 2021, 1:54 pm'),
(77, 'setting phone', '500', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: 192.168.44.56 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(78, 'setting phone', '418', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(79, 'setting phone', '420', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(80, 'setting phone', '502', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(81, 'setting phone', '520', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(82, 'setting phone', '5003', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(83, 'setting phone', '443-1', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(84, 'setting phone', '50039', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(85, 'setting phone', '5009', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(86, 'setting phone', 'admin', 'Администратор', 'Изменение параметров телефона', 'Параметры у телефона номером: 421 изменены успешно', NULL, '421', 'July 9, 2021, 1:56 pm'),
(87, 'setting phone', '500', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 500 не в сети. <br> mac: $mac; <br> ip: 192.168.44.56 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(88, 'setting phone', '418', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 418 не в сети. <br> mac: ; <br> ip: 10.10.10.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(89, 'setting phone', '420', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 420 не в сети. <br> mac: ; <br> ip: 10.10.10.100 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(90, 'setting phone', '502', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 502 не в сети. <br> mac: $mac; <br> ip: $ip <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(91, 'setting phone', '520', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 520 не в сети. <br> mac: $mac; <br> ip: 192.168.5.1 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(92, 'setting phone', '5003', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5003 не в сети. <br> mac: ; <br> ip: 188.113.158.63 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(93, 'setting phone', '443-1', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 443-1 не в сети. <br> mac: safd554sdf9999; <br> ip: 192.168.1.669 <br> Телефон расположен у   <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(94, 'setting phone', '50039', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 50039 не в сети. <br> mac: ; <br> ip: 188.113.158.63-64 <br> Телефон расположен у  ad <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(95, 'setting phone', '5009', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 5009 не в сети. <br> mac: safd554sdf; <br> ip: 192.168.1.199 <br> Телефон расположен у  yj <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm'),
(96, 'setting phone', '421', 'admin', 'Телефон не в сети', 'При ручном сканировании телефон 421 не в сети. <br> mac: ; <br> ip: 192.168.66.255 <br> Телефон расположен у  sleeping <br>', NULL, 'Scanner', 'July 9, 2021, 1:56 pm');

-- --------------------------------------------------------

--
-- Структура таблицы `automessage`
--

CREATE TABLE `automessage` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `textMessage` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `automessage`
--

INSERT INTO `automessage` (`id`, `name`, `textMessage`) VALUES
(8, '\"На завтрак\"', 'Добро пожаловать на завтрак'),
(9, '\"На обед\"', 'Добро пожаловать на обед'),
(10, '\"На ужин\"', 'Добро пожаловать на ужин');

-- --------------------------------------------------------

--
-- Структура таблицы `customization`
--

CREATE TABLE `customization` (
  `id` int(1) NOT NULL,
  `properies` varchar(255) DEFAULT NULL,
  `loginPhones` varchar(80) NOT NULL DEFAULT 'admin',
  `passwordPhones` varchar(80) NOT NULL DEFAULT 'admin',
  `botToken1` text NOT NULL DEFAULT '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4',
  `botChatID1` text NOT NULL DEFAULT '-1001466502233',
  `botToken2` text NOT NULL DEFAULT '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4',
  `botChatID2` text NOT NULL DEFAULT '-1001229181136',
  `botCheck` varchar(5) NOT NULL DEFAULT '0',
  `botToken3` varchar(255) NOT NULL DEFAULT '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `customization`
--

INSERT INTO `customization` (`id`, `properies`, `loginPhones`, `passwordPhones`, `botToken1`, `botChatID1`, `botToken2`, `botChatID2`, `botCheck`, `botToken3`) VALUES
(1, '0', 'admin', 'A1234567', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4', '-1001438413003', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4', '-1001438413003', '0', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4'),
(2, 'success', 'admin', 'admin', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4', '-1001466502233', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4', '-1001229181136', '0', '1709353106:AAEEoof7_zNdy28Kxl6PDWOYI48XEfe70A4');

-- --------------------------------------------------------

--
-- Структура таблицы `ddoscheck`
--

CREATE TABLE `ddoscheck` (
  `id` int(11) NOT NULL,
  `ipRem` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ddoscheck`
--

INSERT INTO `ddoscheck` (`id`, `ipRem`) VALUES
(1, '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `number` varchar(10) DEFAULT NULL COMMENT 'номер получателя',
  `ip` varchar(30) DEFAULT NULL COMMENT 'ip получателя',
  `title` varchar(100) DEFAULT NULL,
  `textmessage` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `number`, `ip`, `title`, `textmessage`) VALUES
(1, NULL, NULL, NULL, NULL),
(2, '5002', '192.168.1.1', 'asd', 'asd'),
(3, '421', '192.168.1.1', 'asd', 'asd'),
(4, '422', '192.168.1.1', 'asd', 'asd'),
(5, '423', '192.168.1.1', 'asd', 'asd'),
(6, '424', '192.168.1.1', 'asd', 'asd'),
(7, '425', '192.168.1.1', 'asd', 'asd'),
(8, '426', '192.168.1.1', 'asd', 'asd'),
(9, '428', '192.168.1.1', 'asd', 'asd'),
(10, '429', '192.168.1.1', 'asd', 'asd'),
(11, '430', '192.168.1.1', 'asd', 'asd'),
(12, '431', '192.168.1.1', 'asd', 'asd'),
(13, '432', '192.168.1.1', 'asd', 'asd'),
(14, '433', '192.168.1.1', 'asd', 'asd'),
(15, '434', '192.168.1.1', 'asd', 'asd'),
(16, '435', '192.168.1.1', 'asd', 'asd'),
(17, '436', '192.168.1.1', 'asd', 'asd'),
(18, '437', '192.168.1.1', 'asd', 'asd'),
(19, '438', '192.168.1.1', 'asd', 'asd'),
(20, '439', '192.168.1.1', 'asd', 'asd'),
(21, '440', '192.168.1.1', 'asd', 'asd'),
(22, '441', '192.168.1.1', 'asd', 'asd'),
(23, '442', '192.168.1.1', 'asd', 'asd'),
(24, '443', '192.168.1.1', 'asd', 'asd'),
(25, '443-1', '192.168.1.669', 'asd', 'asd'),
(26, '503', '192.168.1.1', 'asd', 'asd'),
(27, '504', '192.168.1.1', 'asd', 'asd'),
(28, '505', '192.168.1.1', 'asd', 'asd'),
(29, '506', '192.168.1.1', 'asd', 'asd'),
(30, '507', '192.168.1.1', 'asd', 'asd'),
(31, '508', '192.168.1.1', 'asd', 'asd'),
(32, '509', '192.168.1.1', 'asd', 'asd'),
(33, '510', '192.168.1.1', 'asd', 'asd'),
(34, '511', '192.168.1.1', 'asd', 'asd'),
(35, '51111', '192.168.1.1', 'asd', 'asd'),
(36, '5111', '192.168.1.1', 'asd', 'asd'),
(37, '512', '192.168.1.1', 'asd', 'asd'),
(38, '513', '192.168.1.1', 'asd', 'asd'),
(39, '514', '192.168.1.1', 'asd', 'asd'),
(40, '515', '192.168.1.1', 'asd', 'asd'),
(41, '516', '192.168.1.1', 'asd', 'asd'),
(42, '517', '192.168.1.1', 'asd', 'asd'),
(43, '518', '192.168.1.1', 'asd', 'asd'),
(44, '519', '192.168.1.1', 'asd', 'asd'),
(45, '521', '192.168.1.1', 'asd', 'asd'),
(46, '523', '192.168.1.2', 'asd', 'asd'),
(47, '524', '192.168.1.2', 'asd', 'asd'),
(48, '525', '192.168.1.2', 'asd', 'asd'),
(49, '526', '192.168.1.2', 'asd', 'asd'),
(50, '527', '192.168.1.2', 'asd', 'asd'),
(51, '528', '192.168.1.2', 'asd', 'asd'),
(52, '529', '192.168.1.2', 'asd', 'asd'),
(53, '530', '192.168.1.2', 'asd', 'asd'),
(54, '531', '192.168.1.2', 'asd', 'asd'),
(55, '532', '192.168.1.2', 'asd', 'asd'),
(56, '533', '192.168.1.2', 'asd', 'asd'),
(57, '534', '192.168.1.2', 'asd', 'asd'),
(58, '535', '192.168.1.2', 'asd', 'asd'),
(59, '536', '192.168.1.2', 'asd', 'asd'),
(60, '537', '192.168.1.2', 'asd', 'asd'),
(61, '538', '192.168.1.2', 'asd', 'asd'),
(62, '539', '192.168.1.2', 'asd', 'asd'),
(63, '540', '192.168.1.2', 'asd', 'asd'),
(64, '541', '192.168.1.2', 'asd', 'asd'),
(65, '542', '192.168.1.2', 'asd', 'asd'),
(66, '427', '192.168.1.1', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Структура таблицы `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'место в номере',
  `ip` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `mac` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_phone` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'тип телефона',
  `depends` int(11) DEFAULT NULL COMMENT 'Зависит от первичного',
  `check_ping` tinyint(1) DEFAULT 0 COMMENT 'доступен ли телефон',
  `port_pp` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'порт на патч панели',
  `chatID` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '542712641',
  `botStatus` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'on/off',
  `block` int(5) DEFAULT 1,
  `floor` int(100) DEFAULT 1,
  `timestamp` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `phones`
--

INSERT INTO `phones` (`id`, `number`, `name`, `ip`, `mac`, `type_phone`, `depends`, `check_ping`, `port_pp`, `chatID`, `botStatus`, `block`, `floor`, `timestamp`) VALUES
(9, '500', 'sleeping', '192.168.44.56', '$mac', 'primary', NULL, 0, 'L-29', '584311288', '1', 1, 5, 1),
(15, '5001', 'restroom', '192.168.1.1', '', 'secondary', 500, 1, 'L-33', '542712641', '0', 1, 5, 0),
(16, '5002', 'restroom', '192.168.1.1', '', 'secondary', 500, 1, 'L-33', '542712641', '0', 1, 5, 0),
(26, '418', 'sleeping', '10.10.10.1', '', 'primary', NULL, 0, 'L-44', '542712641', '1', 1, 4, 0),
(28, '420', 'sleeping', '10.10.10.100', '', 'primary', NULL, 0, 'L-44', '542712641', '0', 1, 4, 0),
(29, '421', 'sleeping', '192.168.66.255', '', 'primary', NULL, 0, 'L-44', '542712641', '0', 1, 4, 0),
(30, '422', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(31, '423', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(32, '424', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(33, '425', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(34, '426', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(35, '427', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '584311288', '1', 5, 4, 0),
(36, '428', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(37, '429', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(38, '430', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(39, '431', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(40, '432', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '1', 1, 4, 0),
(41, '433', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(42, '434', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(43, '435', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(44, '436', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(45, '437', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(46, '438', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(47, '439', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(48, '440', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(49, '441', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(50, '442', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 4, 0),
(51, '502', 'sleeping', '$ip', '$mac', 'primary', NULL, 0, 'L-44', '542712641', '0', 1, 5, 1),
(52, '503', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(53, '504', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(54, '505', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(55, '506', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(56, '507', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(57, '508', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(58, '509', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(59, '510', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(60, '511', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(61, '512', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(62, '513', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(63, '514', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(64, '515', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(65, '516', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(66, '517', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(67, '518', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(68, '519', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(69, '520', 'sleeping', '192.168.5.1', '$mac', 'primary', NULL, 0, 'L-44', '542712641', '0', 1, 5, 1),
(70, '521', 'sleeping', '192.168.1.1', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(72, '523', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(73, '524', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(74, '525', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(75, '526', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(76, '527', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(77, '528', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(78, '529', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(79, '530', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(80, '531', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(81, '532', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(82, '533', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(83, '534', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(84, '535', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(85, '536', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(86, '537', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(87, '538', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(88, '539', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(89, '540', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(90, '541', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(91, '542', 'sleeping', '192.168.1.2', '', 'primary', NULL, 1, 'L-44', '542712641', '0', 1, 5, 0),
(92, '51111', NULL, '192.168.1.1', '', '', 511, 1, 'l-33', '542712641', '0', 1, 5, 0),
(93, '5111', 'rhjdfnm', '192.168.1.1', '', 'secondary', 511, 1, 'l-33', '542712641', '0', 1, 5, 0),
(110, '5003', '', '188.113.158.63', NULL, 'secondary', 500, 0, '5', '542712641', '0', 1, 4, 1),
(111, '443', '', '192.168.1.1', 'safd554sdf', 'primary', NULL, 1, '34', '542712641', '0', 1, 4, 1),
(112, '443-1', '', '192.168.1.669', 'safd554sdf9999', 'secondary', 443, 0, '34', '542712641', '0', 5, 4, 1),
(113, '50039', 'ad', '188.113.158.63-64', NULL, 'secondary', NULL, 0, '5', '542712641', '0', 1, 4, 1),
(116, '5009', 'yj', '192.168.1.199', 'safd554sdf', 'primary', NULL, 0, '34', '542712641', '0', 5, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `stoplist`
--

CREATE TABLE `stoplist` (
  `id` int(11) NOT NULL,
  `ipStop` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeStop` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeStart` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `automessage`
--
ALTER TABLE `automessage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `customization`
--
ALTER TABLE `customization`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ddoscheck`
--
ALTER TABLE `ddoscheck`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stoplist`
--
ALTER TABLE `stoplist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT для таблицы `automessage`
--
ALTER TABLE `automessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `customization`
--
ALTER TABLE `customization`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `ddoscheck`
--
ALTER TABLE `ddoscheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT для таблицы `stoplist`
--
ALTER TABLE `stoplist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
