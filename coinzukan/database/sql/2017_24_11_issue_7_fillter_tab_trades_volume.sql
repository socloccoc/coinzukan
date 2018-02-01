CREATE TABLE `volume_history` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `symbol` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `volume_24h_usd` double(20,1) NOT NULL,
  `volume_7d_usd` double(20,1) NOT NULL,
  `volume_30d_usd` double(20,1) NOT NULL,
  `volume_24h_btc` double(20,1) NOT NULL,
  `volume_7d_btc` double(20,1) NOT NULL,
  `volume_30d_btc` double(20,1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `volume_history`
--
ALTER TABLE `volume_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `volume_history`
--
ALTER TABLE `volume_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;