-- IRENG17 schema-only dump generated from database/miscqccc_jarot.sql
-- Contains table structures and ALTER statements only. No INSERT/user/transaction data.
-- After importing this file, run: php artisan migrate --force
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `api`;
CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `sg_agent_code` varchar(255) DEFAULT NULL,
  `sg_sign` varchar(255) DEFAULT NULL,
  `sg_endpoint` varchar(255) DEFAULT NULL,
  `nx_agent_code` varchar(255) DEFAULT NULL,
  `nx_token` varchar(255) DEFAULT NULL,
  `nx_endpoint` varchar(255) DEFAULT NULL,
  `wsg_agent_code` varchar(255) DEFAULT NULL,
  `wsg_token` varchar(255) DEFAULT NULL,
  `wsg_endpoint` varchar(255) DEFAULT NULL,
  `ng_agent_code` varchar(255) DEFAULT NULL,
  `ng_signature` varchar(255) DEFAULT NULL,
  `ng_endpoint` varchar(255) DEFAULT NULL,
  `sg_status` varchar(255) DEFAULT NULL,
  `nx_status` varchar(255) DEFAULT NULL,
  `ng_status` varchar(255) DEFAULT NULL,
  `wsg_status` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bank` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `no_rek` varchar(255) NOT NULL,
  `type` int(255) NOT NULL COMMENT '1 = Bank, 2 = E-Wallet',
  `image_qr` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `gambar` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `banner_promosi`;
CREATE TABLE `banner_promosi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `batas_waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `bonuses`;
CREATE TABLE `bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `minimal` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `bonus_lama`;
CREATE TABLE `bonus_lama` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `fiver_games`;
CREATE TABLE `fiver_games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_code` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_provider` varchar(255) DEFAULT NULL,
  `game_category` varchar(255) DEFAULT NULL,
  `game_image` varchar(255) DEFAULT NULL,
  `game_rtp` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `fiver_games2`;
CREATE TABLE `fiver_games2` (
  `id` int(11) NOT NULL,
  `game_code` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_provider` varchar(255) DEFAULT NULL,
  `game_category` varchar(255) DEFAULT NULL,
  `game_image` varchar(255) DEFAULT NULL,
  `game_rtp` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

DROP TABLE IF EXISTS `game_list`;
CREATE TABLE `game_list` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_is_url` tinyint(1) NOT NULL DEFAULT 0,
  `game_id` varchar(255) DEFAULT NULL,
  `game_id_long` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_type_id` int(11) DEFAULT NULL,
  `game_demo` tinyint(1) NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT NULL,
  `technology` varchar(255) DEFAULT NULL,
  `technology_id` int(11) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `aspect_ratio` varchar(255) DEFAULT NULL,
  `jurisdictions` text DEFAULT NULL,
  `frb_available` tinyint(1) NOT NULL DEFAULT 0,
  `data_type` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `game_locked` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_list_provider_type_status_index` (`provider`,`data_type`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `game_lists`;
CREATE TABLE `game_lists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_code` varchar(255) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `game_users`;
CREATE TABLE `game_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ext_id` varchar(255) DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_users_provider_user_status_index` (`provider`,`user_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `game_code` int(11) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_provider` varchar(255) DEFAULT NULL,
  `game_image` varchar(255) DEFAULT NULL,
  `game_category` varchar(255) DEFAULT NULL,
  `game_demo` varchar(255) DEFAULT NULL,
  `game_device` varchar(255) DEFAULT NULL,
  `rtp` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `game_transaction`;
CREATE TABLE `game_transaction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codes` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `transaksi` text DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `game_id` text DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `jenis` text DEFAULT NULL,
  `metode` text DEFAULT NULL,
  `pay_from` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `genral_settings`;
CREATE TABLE `genral_settings` (
  `id` int(11) NOT NULL,
  `nama_web` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `wa` varchar(255) DEFAULT NULL,
  `tele` varchar(255) DEFAULT NULL,
  `running_text` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `popup` varchar(255) DEFAULT NULL,
  `popup_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `popup_title` varchar(255) DEFAULT NULL,
  `popup_bg` varchar(255) NOT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `template` varchar(255) NOT NULL DEFAULT 'main',
  `updated_at` datetime DEFAULT NULL,
  `live_chat` varchar(255) DEFAULT NULL,
  `live_chat_js` varchar(2000) NOT NULL,
  `msg_popup` longtext DEFAULT NULL,
  `popup_cta_text` varchar(255) DEFAULT NULL,
  `popup_cta_url` varchar(255) DEFAULT NULL,
  `themes` varchar(255) DEFAULT NULL,
  `seo_banner` longtext DEFAULT NULL,
  `seo_meta_keywords` longtext DEFAULT NULL,
  `seo_description` longtext DEFAULT NULL,
  `seo_social_title` longtext DEFAULT NULL,
  `seo_social_description` longtext DEFAULT NULL,
  `maintenance_mode` int(11) DEFAULT 0,
  `deposit_delay` int(11) DEFAULT 24,
  `url_gateway` varchar(255) DEFAULT NULL,
  `apikey_gateway` varchar(255) DEFAULT NULL,
  `callback_url` varchar(255) DEFAULT NULL,
  `qris_status` int(11) DEFAULT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `minimal_depo` int(255) NOT NULL,
  `maksimal_wd` int(255) NOT NULL,
  `minimal_wd` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trans_id` varchar(300) DEFAULT NULL,
  `jumlah` bigint(20) NOT NULL DEFAULT 0,
  `type` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '1 Deposit, 2 Withdraw',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `history_user_id_type_index` (`user_id`,`type`),
  KEY `history_trans_id_index` (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `networks`;
CREATE TABLE `networks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `ref_code` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `referral_commissions`;
CREATE TABLE `referral_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `referred_user_id` bigint(20) UNSIGNED NOT NULL,
  `referrer_user_id` bigint(20) UNSIGNED NOT NULL,
  `referral_code` varchar(50) DEFAULT NULL,
  `deposit_amount` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `commission_amount` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `provider_response` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `promosi`;
CREATE TABLE `promosi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `batas_waktu` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `saldo`;
CREATE TABLE `saldo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `saldo` bigint(20) DEFAULT NULL,
  `bonus` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `saldo_log`;
CREATE TABLE `saldo_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saldo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `saldo_before` int(11) NOT NULL,
  `saldo_trans` int(11) NOT NULL,
  `saldo_after` int(11) NOT NULL,
  `bonus_before` int(11) NOT NULL,
  `bonus_trans` int(11) NOT NULL,
  `bonus_after` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `slot_game_histories`;
CREATE TABLE `slot_game_histories` (
  `id` int(11) NOT NULL,
  `roundId` varchar(255) DEFAULT NULL,
  `userCode` varchar(255) DEFAULT NULL,
  `providerCode` varchar(255) DEFAULT NULL,
  `gameCode` varchar(255) DEFAULT NULL,
  `spinType` varchar(255) DEFAULT NULL,
  `bet` decimal(10,2) DEFAULT NULL,
  `win` decimal(10,2) DEFAULT NULL,
  `userBalance` decimal(10,2) DEFAULT NULL,
  `userTotalDebit` decimal(10,2) DEFAULT NULL,
  `userTotalCredit` decimal(10,2) DEFAULT NULL,
  `txnId` varchar(255) DEFAULT NULL,
  `txnType` varchar(255) DEFAULT NULL,
  `isBuy` tinyint(1) DEFAULT NULL,
  `isCall` tinyint(1) DEFAULT NULL,
  `userBeforeBalance` decimal(10,2) DEFAULT NULL,
  `userAfterBalance` decimal(10,2) DEFAULT NULL,
  `agentBeforeBalance` decimal(10,2) DEFAULT NULL,
  `agentAfterBalance` decimal(10,2) DEFAULT NULL,
  `spinedAt` timestamp NULL DEFAULT current_timestamp(),
  `createdAt` timestamp NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `spins`;
CREATE TABLE `spins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prize` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tb_gamenew`;
CREATE TABLE `tb_gamenew` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_code` varchar(200) NOT NULL,
  `game_name` varchar(200) NOT NULL,
  `game_provider` varchar(200) NOT NULL,
  `game_category` varchar(200) NOT NULL,
  `images` varchar(200) NOT NULL,
  `game_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '1 Deposit 2Withdraw',
  `status` varchar(255) DEFAULT NULL COMMENT '1 Pending 2 Approved  3 Rejected',
  `trans_id` varchar(300) DEFAULT NULL,
  `bonus_id` bigint(20) DEFAULT NULL,
  `bonus_persentase` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `bukti_transfer` text DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `rek_pengirim` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `qris_url` varchar(255) DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  `qris_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `extplayer` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ip_register` varchar(40) DEFAULT NULL,
  `level` int(11) DEFAULT NULL COMMENT '1 = Admin, 2 = Developer',
  `telp` varchar(255) DEFAULT NULL,
  `ref_code` varchar(255) DEFAULT NULL,
  `ref_link` varchar(100) DEFAULT NULL,
  `nama_rek` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `no_rek` varchar(255) DEFAULT NULL,
  `captcha` varchar(11) DEFAULT NULL,
  `game_mode` int(11) NOT NULL DEFAULT 1 COMMENT '0 = Locker, 1 = Allow'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_name` varchar(255) DEFAULT NULL,
  `user_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `w_gamelists`;
CREATE TABLE `w_gamelists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) DEFAULT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_code` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `free_rounds_status` int(11) DEFAULT NULL,
  `desktop` int(11) DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_type_status_index` (`type`,`status`);

ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `banner_promosi`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `bonuses`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `bonus_lama`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE;

ALTER TABLE `fiver_games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fiver_games_provider_category_status_index` (`game_provider`,`game_category`,`status`);

ALTER TABLE `fiver_games2`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_provider_category_index` (`game_provider`,`game_category`);

ALTER TABLE `game_transaction`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `genral_settings`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `networks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `networks_ref_code_index` (`ref_code`),
  ADD UNIQUE KEY `networks_user_id_unique` (`user_id`);

ALTER TABLE `referral_commissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_commissions_transaksi_id_unique` (`transaksi_id`),
  ADD KEY `referral_commissions_referred_user_id_index` (`referred_user_id`),
  ADD KEY `referral_commissions_referrer_user_id_index` (`referrer_user_id`),
  ADD KEY `referral_commissions_referral_code_index` (`referral_code`),
  ADD KEY `referral_commissions_status_index` (`status`);

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`) USING BTREE;

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

ALTER TABLE `promosi`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `saldo_user_id_index` (`user_id`);

ALTER TABLE `saldo_log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `slot_game_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `spins`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tb_gamenew`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `transaksi_user_id_bank_id_status_index` (`user_id`,`bank_id`,`status`),
  ADD KEY `transaksi_ref_index` (`ref`),
  ADD KEY `transaksi_trans_id_index` (`trans_id`),
  ADD KEY `transaksi_type_status_index` (`type`,`status`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  ADD KEY `users_name_telp_email_index` (`name`,`telp`,`email`);

ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

ALTER TABLE `api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=741025731;

ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

ALTER TABLE `banner_promosi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

ALTER TABLE `bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `bonus_lama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `fiver_games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10001;

ALTER TABLE `fiver_games2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3687;

ALTER TABLE `game_transaction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

ALTER TABLE `networks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `referral_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `promosi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

ALTER TABLE `saldo_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `slot_game_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `spins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

ALTER TABLE `tb_gamenew`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2091;

ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

COMMIT;
