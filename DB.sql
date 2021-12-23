-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2021 年 12 月 09 日 18:58
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `b-ring`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'エリア名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `area`
--

INSERT INTO `area` (`id`, `name`) VALUES
(1, '北海道エリア'),
(2, '東北エリア'),
(3, '関東エリア'),
(4, '北信越エリア'),
(5, '東海エリア'),
(6, '近畿エリア'),
(7, '中国エリア'),
(8, '四国エリア'),
(9, '九州エリア');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(33, 3, 1, '2021-11-04 17:00:43', '2021-11-04 17:00:43'),
(34, 17, 1, '2021-11-09 17:13:27', '2021-11-09 17:13:27'),
(35, 15, 1, '2021-11-09 17:13:32', '2021-11-09 17:13:32');

-- --------------------------------------------------------

--
-- テーブルの構造 `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `title` varchar(50) NOT NULL COMMENT 'タイトル',
  `area_id` int(11) NOT NULL COMMENT 'エリアID',
  `location` varchar(255) NOT NULL COMMENT '目的地',
  `file_name` varchar(255) NOT NULL COMMENT '写真',
  `file_path` varchar(255) NOT NULL,
  `contents` varchar(255) NOT NULL COMMENT '感想',
  `user_id` int(11) NOT NULL,
  `del_flg` int(11) NOT NULL DEFAULT '0' COMMENT '権限(0:表示1:非表示)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `post`
--

INSERT INTO `post` (`id`, `title`, `area_id`, `location`, `file_name`, `file_path`, `contents`, `user_id`, `del_flg`, `created_at`, `updated_at`) VALUES
(1, 'クラーク博士', 1, 'クラーク博士', '20211104075956dog.jpeg', 'img/20211104075956dog.jpeg', 'クラーク博士を見に行きました！', 1, 0, '2021-10-21 22:47:18', '2021-11-04 17:22:55'),
(2, '弘前城', 2, '弘前城', '20211103175620hirosakijou.jpeg', 'img/20211103175620hirosakijou.jpeg', '当時の規模のまま残る城門や天守閣は必見です。', 1, 0, '2021-10-22 00:52:56', '2021-11-04 14:08:24'),
(3, '時計台', 1, '札幌時計台', '20211027082706Pf82WbYmKI3lC3t4lEB51TMaZKlxJHqIBZgkY1NF.jpeg', 'img/20211027082706Pf82WbYmKI3lC3t4lEB51TMaZKlxJHqIBZgkY1NF.jpeg', '札幌の時計台に行きました。', 1, 0, '2021-10-27 17:27:06', '2021-11-02 02:28:18'),
(4, '藻岩山に行きました。', 1, '藻岩山', '2021102708405502-55589.jpeg', 'img/2021102708405502-55589.jpeg', '藻岩山に行きました。\r\nとても綺麗でした。', 1, 0, '2021-10-27 17:40:55', NULL),
(5, '銀山温泉に行きました！', 2, '銀山温泉', '20211027084747Y373763155.jpeg', 'img/20211027084747Y373763155.jpeg', '銀山温泉に行きました。\r\n温泉でとても癒やされました。', 1, 0, '2021-10-27 17:47:47', NULL),
(6, '松島の絶景', 2, '松島', '2021102708494634267818_m.jpeg', 'img/2021102708494634267818_m.jpeg', '松島に行きました。\r\nさすが日本三景といえる絶景が広がっていました。', 1, 0, '2021-10-27 17:49:46', NULL),
(7, '華厳滝', 3, '華厳滝', '2021102708552821e9371c-225e-4978-b35b-588970c36062_m.jpeg', 'img/2021102708552821e9371c-225e-4978-b35b-588970c36062_m.jpeg', '華厳滝に行きました。\r\n壮大な滝を眺めてリフレッシュできました。', 1, 0, '2021-10-27 17:55:28', NULL),
(8, '日光東照宮はおすすめです！', 3, '日光東照宮', '20211027085727toshogu-guide-key.jpeg', 'img/20211027085727toshogu-guide-key.jpeg', '日光東照宮に行きました。\r\n都心から行きやすくおすすめです。', 1, 0, '2021-10-27 17:57:27', NULL),
(9, '埼玉県の長瀞に行きました。', 3, '長瀞岩畳', '20211027090008spot-nagatoro-nagatoro2.jpeg', 'img/20211027090008spot-nagatoro-nagatoro2.jpeg', '長瀞の岩畳へ行きました！\r\n名物グルメの味噌ポテトも美味しかったです！', 1, 0, '2021-10-27 18:00:08', NULL),
(11, 'テスト', 5, '名古屋城', '2021110312111902-55589.jpeg', 'img/2021110312111902-55589.jpeg', '１２３', 1, 1, '2021-11-03 21:09:13', '2021-11-04 01:27:54'),
(12, 'うみてらす名立', 4, 'うみてらす名立', '20211103170921umiterasu.jpeg', 'img/20211103170921umiterasu.jpeg', '目的地は日本海を望む絶好のロケーションに立地する「うみてらす名立」。\r\nこちらは多彩な施設が揃う人気のスポットで、海に面して公園が整備されており、潮風に吹かれながらの散策もおすすめです。', 2, 0, '2021-11-04 02:09:21', NULL),
(13, '氷見のぶりは絶品', 4, '道の駅「ひみ番屋街」', '20211103171334himigyokou.jpeg', 'img/20211103171334himigyokou.jpeg', '氷見の寒ブリを求めていきました！\r\n富山湾の眺めもよかったです。', 2, 0, '2021-11-04 02:13:34', NULL),
(14, '砂浜を走りました！', 4, '千里浜ドライブウェイ', '20211103171658senrihama.jpeg', 'img/20211103171658senrihama.jpeg', '砂浜の上を走ることのできる千里浜へ。\r\n海を間近に望み潮風に吹かれながらのツーリングは最高でした。', 2, 0, '2021-11-04 02:16:58', NULL),
(15, '伊良湖岬', 5, '伊良湖岬', '20211103174722irako.jpeg', 'img/20211103174722irako.jpeg', 'オーシャンビューツーリングが最高でした。', 2, 0, '2021-11-04 02:47:22', NULL),
(16, '白川郷', 5, '白川郷', '20211103174939himigyokou.jpeg', 'img/20211103174939himigyokou.jpeg', '郡上市から長良川に沿って国道156号を北へ。国道156号は御母衣湖を過ぎると飛越峡合掌ラインと呼ばれるルートで、爽快なツーリングが楽しめます。', 2, 0, '2021-11-04 02:49:39', NULL),
(17, '伊勢志摩スカイライン～「伊勢神宮」', 5, '伊勢神宮', '20211103175217isejingu.jpeg', 'img/20211103175217isejingu.jpeg', '伊勢志摩スカイラインは鳥羽市と伊勢市をつなぐドライブウェイで、随所に絶景ポイントがあり爽快なツーリングが楽しめます。\r\nおかげ横丁のグルメも美味しかったです！', 2, 0, '2021-11-04 02:52:17', NULL),
(18, 'タイトル', 1, '目的地', '１２３４５６７８', '12345678', '内容', 3, 0, '2021-11-18 19:47:22', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'ユーザ名',
  `email` varchar(50) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(100) NOT NULL COMMENT 'パスワード',
  `birth` date DEFAULT NULL COMMENT '誕生日',
  `manufacturer` varchar(50) NOT NULL COMMENT 'バイクのメーカー名',
  `bike_name` varchar(50) NOT NULL COMMENT 'バイクの車種名',
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '管理ユーザ：1　一般ユーザ：0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birth`, `manufacturer`, `bike_name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'ませ', 'owner@test.co.jp', '$2y$10$HPvWJ3qaNpUC9GL9dIXk8eq.BJ05GBZC6dVEWOPlTtkiOiVabnIDC', '1994-06-21', 'YAMAHA', 'ドラッグスター400', 1, '2021-10-19 18:44:55', '2021-11-09 17:14:47'),
(2, 'すずき', 'general@test.co.jp', '$2y$10$fnCEPtpGAHGPnYEY9SCMY.yw.R9bqafdczpVcOchEnKV/wJQTcSHu', '2000-01-01', 'SUZUKI', 'イントルーダー400', 0, '2021-10-20 11:15:40', '2021-11-02 14:08:21'),
(3, 'ほんだ', 'general1@test.co.jp', '$2y$10$BcPaEd7F1Zus53j40LhBpe7B5/q7qrCrazm4Wc0jWf9iqAUIMi4aq', '1994-06-21', 'HONDA', 'シャドウ400', 0, '2021-11-02 14:17:15', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- テーブルの AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;
