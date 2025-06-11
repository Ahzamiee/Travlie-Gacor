-- Tabel untuk Perusahaan Otobus / Travel
CREATE TABLE `operators` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `type` ENUM('Bus','Travel') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk jenis-jenis armada
CREATE TABLE `vehicles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `operator_id` INT(11) NOT NULL,
  `class_name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `capacity` INT(4) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`operator_id`) REFERENCES `operators`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk lokasi
CREATE TABLE `locations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `location_name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk JADWAL PER TIKET
CREATE TABLE `ticket_schedules` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` INT(11) NOT NULL,
  `origin_id` INT(11) NOT NULL,
  `destination_id` INT(11) NOT NULL,
  `departure_time` TIME NOT NULL,
  `arrival_time_estimation` TIME NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`),
  FOREIGN KEY (`origin_id`) REFERENCES `locations`(`id`),
  FOREIGN KEY (`destination_id`) REFERENCES `locations`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel untuk LAYANAN SEWA ROMBONGAN
CREATE TABLE `charter_services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` INT(11) NOT NULL,
  `service_name` VARCHAR(150) NOT NULL,
  `service_area` VARCHAR(100) NOT NULL,
  `base_price` DECIMAL(12,2) NOT NULL,
  `price_description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
