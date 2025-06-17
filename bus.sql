--
-- Struktur untuk tabel `operators`
--
CREATE TABLE `operators` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktur untuk tabel `vehicles` (Dengan kolom 'type')
--
CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `capacity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktur untuk tabel `locations`
--
CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktur untuk tabel `ticket_schedules` (Dengan 'schedule_date' dan 'available_seats')
--
CREATE TABLE `ticket_schedules` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `origin_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time_estimation` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_seats` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Struktur untuk tabel `charter_services`
--
CREATE TABLE `charter_services` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `service_name` varchar(150) NOT NULL,
  `service_area` varchar(100) NOT NULL,
  `base_price` decimal(12,2) NOT NULL,
  `price_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes
--
ALTER TABLE `users` ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `operators` ADD PRIMARY KEY (`id`);
ALTER TABLE `vehicles` ADD PRIMARY KEY (`id`), ADD KEY `operator_id` (`operator_id`);
ALTER TABLE `locations` ADD PRIMARY KEY (`id`);
ALTER TABLE `ticket_schedules` ADD PRIMARY KEY (`id`), ADD KEY `fk_vehicle` (`vehicle_id`), ADD KEY `fk_origin` (`origin_id`), ADD KEY `fk_destination` (`destination_id`);
ALTER TABLE `charter_services` ADD PRIMARY KEY (`id`), ADD KEY `fk_charter_vehicle` (`vehicle_id`);

--
-- AUTO_INCREMENT
--
ALTER TABLE `users` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `operators` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `vehicles` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `locations` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ticket_schedules` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `charter_services` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints (Foreign Keys)
--
ALTER TABLE `vehicles` ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE;
ALTER TABLE `charter_services` ADD CONSTRAINT `charter_services_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
ALTER TABLE `ticket_schedules` ADD CONSTRAINT `ticket_schedules_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`), ADD CONSTRAINT `ticket_schedules_ibfk_2` FOREIGN KEY (`origin_id`) REFERENCES `locations` (`id`), ADD CONSTRAINT `ticket_schedules_ibfk_3` FOREIGN KEY (`destination_id`) REFERENCES `locations` (`id`);

COMMIT;
