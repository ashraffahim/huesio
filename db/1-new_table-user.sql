CREATE TABLE `blog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(32) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `keywords` varchar(100) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_published` bit(1) DEFAULT b'0',
  `creation_date` datetime DEFAULT NULL,
  `updation_date` datetime DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;