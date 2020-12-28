-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-12-29 07:53:23
-- 伺服器版本： 10.4.14-MariaDB
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `cms`
--

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Bootstrap'),
(2, 'Javascript'),
(4, 'PHP'),
(9, 'C#'),
(12, 'jQuery');

-- --------------------------------------------------------

--
-- 資料表結構 `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(2, 1, 'trst', 'trts@yyu.edy.tw', 'tes', 'approve', '2020-11-06'),
(4, 1, 'trst', 'trts@yyu.edy.tw', 'test', 'approve', '2020-11-06'),
(5, 5, 'ts', 'trestts@yyu.edy.tw', 'setse', 'approve', '2020-11-06'),
(12, 24, 'trst', 'trts@yyu.edy.tw', 'test', 'approve', '2020-11-19');

-- --------------------------------------------------------

--
-- 資料表結構 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text COLLATE utf8_unicode_ci NOT NULL,
  `post_content` text COLLATE utf8_unicode_ci NOT NULL,
  `post_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `likes`) VALUES
(42, 1, 'hello', '', 'admin', '2020-12-22', 'IMG_20200418_104252_285.jpg', '<p>test</p>', 'test', 0, 'published', 71, 4),
(43, 1, 'good', '', 'helloworld1', '2020-12-22', 'IMG_20200418_104252_285.jpg', '<p>helloworld1</p>', 'helloworld1', 0, 'draft', 5, 0),
(46, 2, 'sweet', '', 'admin', '2020-12-22', 'IMG_20200418_104252_285.jpg', '<p>awsdfsdfdf</p>', 'sweet', 0, 'published', 8, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2a$09$anexamplestringforsalt$',
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`, `token`) VALUES
(6, 'admin', '$2a$09$anexamplestringforsaledjoxbV9HmMM122coGXE98Xp6vn5mGIG', 'wetset', 'setadmin', 'set@emai.com', '', 'admin', '$2a$09$anexamplestringforsalt$', ''),
(10, 'helloworld1', '$2y$12$hCAwQ/hh.QENY/gwE1EoU.FS/UWilr9l3Kt1bkC.QTogoWuA9TRO.', 'helloworld1', 'helloworld1', 'kuei@gm.ttu.edu.tw', '', 'subscriber', '$2a$09$anexamplestringforsalt$', ''),
(12, 'test', '$2y$12$W9.n2TJY/4MugqR30NHSRukS8RiXxR2zvq7yqy6ieJ11raSiAqbju', 'test', 'test', 'test@test.test', '', 'subscriber', '$2a$09$anexamplestringforsalt$', '');

-- --------------------------------------------------------

--
-- 資料表結構 `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '6u507cr0v3ob80866u6730n329', 1605515560),
(2, 'ter3jj6i1unom8l1ujhdn89itg', 1605496869),
(3, '0lcca5k5vo76eo6je463akkssj', 1605579486),
(4, 'jjdv5t3bn8do6no8r3oa3p0p4r', 1605776430),
(5, '988nqdvq8q8lscki1h9jku1mkp', 1605862874),
(6, 'sb2mgln3td1tahmce40d13t8ei', 1606109037),
(7, '7v7mplqie79fbe6njtd4aq3fl7', 1606117753),
(8, 'rjsh3r8bgs3loem7g5sc969el4', 1606287062),
(9, '740ffmlq89i2s7a7h4opthip9p', 1606375033),
(10, '8uhk9q9cictopqap98dbmunc73', 1606714999),
(11, '1rlb3452hsnr6kqn38ggla9ina', 1606813230),
(12, 'lvt6f0np0abua0tjt5jvmhbg7m', 1606896535),
(13, 'h00rnd7ifal1575j08r2jvj02i', 1607674761),
(14, '3vmo0epj8204tl616ncvj7p3oj', 1607935672),
(15, 'il7v68j7n51qniup74r2c822em', 1608002065),
(16, '7c7hv56k48ea0hg6ejm2vl092k', 1608008138),
(17, 'al324u0gf60v0lg2lo7b0o7fv5', 1608607675);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- 資料表索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- 資料表索引 `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
