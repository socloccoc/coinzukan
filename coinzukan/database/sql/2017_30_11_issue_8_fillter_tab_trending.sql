CREATE TABLE `coinmarketcap_new_currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `symbol` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `added` varchar(100) CHARACTER SET utf8 NOT NULL,
  `marketcap` double(20,8) NOT NULL,
  `price` double(20,8) NOT NULL,
  `circulating_supply` double(20,8) NOT NULL,
  `volume_24h` double(20,8) NOT NULL,
  `percent_change_24h` double(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `coinmarketcap_new_currencies`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `coinmarketcap_new_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
COMMIT;