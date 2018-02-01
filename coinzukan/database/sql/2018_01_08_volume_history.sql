CREATE TABLE `volume_history` (  `id` int(11) NOT NULL,  `name` varchar(100) NOT NULL,  `symbol` varchar(100) NOT NULL,  `volume_24h_usd` double(20,1) NOT NULL,  `volume_7d_usd` double(20,1) NOT NULL,  `volume_30d_usd` double(20,1) NOT NULL,  `volume_24h_btc` double(20,1) NOT NULL,  `volume_7d_btc` double(20,1) NOT NULL,  `volume_30d_btc` double(20,1) NOT NULL,  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8;