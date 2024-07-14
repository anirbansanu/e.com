-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: edotcom
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 => Inactive,1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Nike','Leading manufacturer of sportswear and athletic shoes.','1','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(2,'Adidas','Global brand specializing in athletic shoes, clothing, and accessories.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(3,'Puma','Worldwide sports brand known for athletic and casual footwear, apparel, and accessories.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(4,'Under Armour','American sportswear company focusing on performance apparel and accessories.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(5,'Reebok','International brand producing athletic footwear, apparel, and accessories.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(6,'Levi\'s','Iconic brand known for denim jeans and casual apparel.','1','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(7,'Gucci','Luxury brand known for high-end fashion and leather goods.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(8,'Louis Vuitton','Luxury brand specializing in designer handbags, luggage, and accessories.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(9,'H&M','Swedish multinational clothing retail company.','1','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL),(10,'Zara','Spanish apparel retailer known for its fast fashion.','0','2024-07-08 13:18:20','2024-07-08 13:18:20',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_06_28_172710_create_permission_tables',1),(6,'2024_07_04_181614_add_soft_deletes_to_users_table',1),(8,'2024_07_06_041431_create_settings_table',2),(10,'2024_07_07_095925_add_group_columns_to_permissions_table',3),(11,'2024_07_08_062002_create_brand_table',4),(13,'2024_07_08_070444_create_product_categories_table',5),(14,'2024_07_08_100725_create_product_attributes_table',6),(15,'2024_07_08_082921_create_product_units_table',7),(19,'2024_07_08_092344_create_media_table',8),(20,'2024_07_08_092343_create_uploads_table',9),(21,'2024_07_08_072051_create_products_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(1,'App\\Models\\User',2),(2,'App\\Models\\User',3),(2,'App\\Models\\User',4),(2,'App\\Models\\User',5),(2,'App\\Models\\User',6),(2,'App\\Models\\User',7),(2,'App\\Models\\User',8),(2,'App\\Models\\User',9),(2,'App\\Models\\User',10),(2,'App\\Models\\User',11),(2,'App\\Models\\User',12),(2,'App\\Models\\User',13),(2,'App\\Models\\User',14),(2,'App\\Models\\User',15),(2,'App\\Models\\User',16),(2,'App\\Models\\User',17),(2,'App\\Models\\User',18),(2,'App\\Models\\User',19),(2,'App\\Models\\User',20),(2,'App\\Models\\User',21),(2,'App\\Models\\User',22),(2,'App\\Models\\User',23),(2,'App\\Models\\User',24),(1,'App\\Models\\User',28),(1,'App\\Models\\User',30),(2,'App\\Models\\User',31),(1,'App\\Models\\User',32),(2,'App\\Models\\User',33);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (148,'users.index','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(149,'users.create','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(150,'users.store','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(151,'users.edit','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(152,'users.update','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(153,'users.destroy','web','users',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(154,'admin.settings.roles.index','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(155,'admin.settings.roles.create','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(156,'admin.settings.roles.store','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(157,'admin.settings.roles.edit','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(158,'admin.settings.roles.update','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(159,'admin.settings.roles.destroy','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(160,'admin.settings.roles.syncPermission','web','roles',22,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(161,'admin.settings.permissions.index','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(162,'admin.settings.permissions.create','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(163,'admin.settings.permissions.store','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(164,'admin.settings.permissions.edit','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(165,'admin.settings.permissions.update','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(166,'admin.settings.permissions.destroy','web','permissions',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(167,'admin.settings.website','web','settings',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(168,'admin.settings.website.update','web','settings',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(169,'admin.settings.app','web','settings',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(170,'admin.settings.app.update','web','settings',23,'2024-07-08 03:25:11','2024-07-08 03:25:11'),(171,'admin.products.brands.index','web','brands',2,'2024-07-08 13:34:24','2024-07-08 13:34:24'),(172,'admin.products.brands.create','web','brands',2,'2024-07-08 13:35:10','2024-07-08 13:35:10'),(173,'admin.products.brands.store','web','brands',2,'2024-07-08 13:35:34','2024-07-08 13:35:34'),(174,'admin.products.brands.edit','web','brands',2,'2024-07-08 13:35:50','2024-07-08 13:35:50'),(175,'admin.products.brands.update','web','brands',2,'2024-07-08 13:36:07','2024-07-08 13:36:07'),(176,'admin.products.brands.destroy','web','brands',2,'2024-07-08 13:36:25','2024-07-08 13:36:25'),(177,'admin.products.categories.index','web','products.categories',3,'2024-07-09 14:25:49','2024-07-09 14:25:49'),(178,'admin.products.categories.create','web','products.categories',3,'2024-07-09 14:26:23','2024-07-09 14:26:23'),(179,'admin.products.categories.store','web','products.categories',3,'2024-07-09 14:27:18','2024-07-09 14:27:18'),(180,'admin.products.categories.edit','web','products.categories',3,'2024-07-09 14:28:05','2024-07-09 14:28:05'),(181,'admin.products.categories.update','web','products.categories',3,'2024-07-09 14:28:55','2024-07-09 14:28:55'),(182,'admin.products.categories.destroy','web','products.categories',3,'2024-07-09 14:32:49','2024-07-09 14:32:49'),(183,'admin.products.attributes.index','web','products.attributes',4,'2024-07-10 00:43:10','2024-07-10 00:43:10'),(184,'admin.products.attributes.create','web','products.attributes',4,'2024-07-10 00:43:57','2024-07-10 00:43:57'),(185,'admin.products.attributes.store','web','products.attributes',4,'2024-07-10 00:44:25','2024-07-10 00:44:25'),(186,'admin.products.attributes.edit','web','products.attributes',4,'2024-07-10 00:44:50','2024-07-10 00:44:50'),(187,'admin.products.attributes.update','web','products.attributes',4,'2024-07-10 00:45:11','2024-07-10 00:45:11'),(188,'admin.products.attributes.destroy','web','products.attributes',4,'2024-07-10 00:45:27','2024-07-10 00:45:27'),(189,'admin.products.units.index','web','products.units',5,'2024-07-10 13:52:51','2024-07-10 13:52:51'),(190,'admin.products.units.create','web','products.units',5,'2024-07-10 13:52:51','2024-07-10 13:52:51'),(191,'admin.products.units.store','web','products.units',5,'2024-07-10 13:52:51','2024-07-10 13:52:51'),(192,'admin.products.units.edit','web','products.units',5,'2024-07-10 13:52:51','2024-07-10 13:52:51'),(193,'admin.products.units.update','web','products.units',5,'2024-07-10 13:52:51','2024-07-10 13:52:51'),(194,'admin.products.units.destroy','web','products.units',5,'2024-07-10 13:52:52','2024-07-10 13:52:52'),(198,'admin.products.listing.index','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50'),(199,'admin.products.listing.create','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50'),(200,'admin.products.listing.edit','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50'),(201,'admin.products.listing.destroy','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50'),(202,'admin.products.listing.show','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50'),(203,'admin.products.listing.update','web','products.listing',7,'2024-07-11 12:46:50','2024-07-11 12:46:50');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_attributes`
--

DROP TABLE IF EXISTS `product_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_unit` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_attributes`
--

LOCK TABLES `product_attributes` WRITE;
/*!40000 ALTER TABLE `product_attributes` DISABLE KEYS */;
INSERT INTO `product_attributes` VALUES (1,'Color',0,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(2,'Size',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(3,'Weight',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(4,'Material',0,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(5,'Length',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(6,'Width',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(7,'Height',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(8,'Volume',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(9,'Density',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(10,'Diameter',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(11,'Radius',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(12,'Thickness',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(13,'Capacity',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(14,'Power',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(15,'Voltage',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(16,'Frequency',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(17,'Speed',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(18,'Temperature',1,'2024-07-10 00:55:59','2024-07-10 00:55:59',NULL),(19,'Pressure',1,'2024-07-10 00:55:59','2024-07-10 01:06:06','2024-07-10 01:06:06'),(20,'Humidity',1,'2024-07-10 00:55:59','2024-07-10 01:05:55','2024-07-10 01:05:55');
/*!40000 ALTER TABLE `product_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
INSERT INTO `product_categories` VALUES (1,'corporis','corporis','Quae consequatur ex quod voluptates quos.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(2,'impedit','impedit','Quibusdam et praesentium laboriosam amet.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(3,'veritatis','veritatis','Totam cupiditate error nisi est autem animi.',0,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(4,'magni','magni','Assumenda sed ut earum numquam autem fuga.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(5,'repudiandae','repudiandae','Odit unde labore aut.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(6,'quae','quae','Libero est sit consequatur quasi blanditiis vel eligendi.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(7,'voluptas','voluptas','Praesentium consequatur quo omnis explicabo in.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(8,'eum','eum','Quas iste eum cupiditate totam id nisi assumenda necessitatibus.',0,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(9,'dolore','dolore','Cum iste laborum quasi.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(10,'iusto','iusto','Vitae corrupti ut nulla quis laborum.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(11,'aspernatur','aspernatur','Nihil autem assumenda placeat quidem aut saepe consequuntur provident.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(12,'qui','qui','Aliquam odio consequatur et provident autem molestiae at omnis.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(13,'perferendis','perferendis','Quia consequatur dolor molestiae et iusto nulla dolorum modi.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(14,'sapiente','sapiente','Rerum minus dolorem esse nihil.',0,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(15,'quia','quia','Blanditiis enim nesciunt omnis veniam.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(16,'similique','similique','Quis dicta assumenda rerum aperiam dolorem enim officia.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(17,'sequi','sequi','Hic quia ut non modi repellat cupiditate.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(18,'incidunt','incidunt','Esse velit deserunt dignissimos expedita porro.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(19,'sit','sit','Soluta excepturi dolores quo quis unde corrupti iure alias.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL),(20,'et','et','Est sapiente et saepe quo.',1,'2024-07-09 14:19:00','2024-07-09 14:19:00',NULL);
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_units`
--

DROP TABLE IF EXISTS `product_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_units`
--

LOCK TABLES `product_units` WRITE;
/*!40000 ALTER TABLE `product_units` DISABLE KEYS */;
INSERT INTO `product_units` VALUES (1,'Piece','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(2,'Box','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(3,'Dozen','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(4,'Set','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(5,'Meter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(6,'Liter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(7,'Gram','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(8,'Kilogram','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(9,'Square Meter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(10,'Cubic Meter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(11,'Hour','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(12,'Day','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(13,'Week','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(14,'Month','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(15,'Year','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(16,'Bottle','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(17,'Packet','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(18,'Carton','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(19,'Roll','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(20,'Sheet','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(21,'Pair','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(22,'Piece','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(23,'Liter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(24,'Pound','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(25,'Inch','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(26,'Centimeter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(27,'Millimeter','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(28,'Unit','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL),(29,'Volume','2024-07-10 14:04:58','2024-07-10 14:04:58',NULL);
/*!40000 ALTER TABLE `product_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `brand_id` bigint unsigned NOT NULL,
  `added_by` bigint unsigned NOT NULL,
  `gender` enum('Male','Female','Male & Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `step` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_added_by_foreign` (`added_by`),
  CONSTRAINT `products_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'maxime','rerum-aliquid-rerum-cupiditate-necessitatibus-nostrum','Rerum enim nihil error cumque doloremque et.',14,8,6,'Male',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(2,'aut','nulla-nulla-eum-et-molestias-fuga-cupiditate-mollitia-blanditiis','Non adipisci necessitatibus omnis ut quo praesentium.',14,3,28,'Male & Female',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(3,'deserunt','adipisci-omnis-voluptas-laudantium-quia-sequi-perspiciatis','Ullam voluptatibus sed nihil qui numquam.',4,7,1,'Female',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(4,'autem','nihil-expedita-officia-qui-cum-voluptatem-sed-doloremque','Reiciendis itaque vitae explicabo dolore.',18,6,3,'Male',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(5,'sed','deserunt-consectetur-eum-debitis-laudantium-beatae','Dolor qui quisquam officiis totam sed quaerat.',7,4,9,'Male & Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(6,'expedita','nisi-facilis-consectetur-possimus-at-omnis-eum-amet','Voluptas cupiditate magni ipsa aperiam.',4,5,14,'Male',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(7,'voluptatum','sint-sint-repellat-qui','Ut et aut enim harum minus sunt excepturi.',10,6,32,'Male & Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(8,'unde','animi-aut-ut-laboriosam-debitis-quas-ex','Voluptatem a voluptas dolorum omnis porro vel error.',3,6,20,'Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(9,'eligendi','nam-placeat-fuga-ea-laboriosam-molestiae-veritatis-excepturi','Quo molestias doloribus accusantium nemo itaque aut.',8,1,5,'Male & Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(10,'magnam','et-qui-quod-sit','Recusandae rerum qui nihil et officia molestias.',18,2,15,'Male & Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(11,'maxime','assumenda-voluptatem-et-labore-vitae-et','Alias enim labore quia earum animi.',18,1,3,'Male',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(12,'eligendi','iusto-corrupti-ut-nobis-modi-et-placeat','Quibusdam sed voluptatem itaque.',1,3,19,'Male',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(13,'deserunt','nesciunt-aut-optio-quo','Consequatur ipsa libero perspiciatis quia.',17,7,10,'Male',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(14,'repellendus','fugiat-praesentium-molestias-incidunt-saepe-autem-ducimus-perspiciatis-illum','Asperiores dolores ut nihil nulla porro.',9,3,23,'Female',1,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44'),(15,'perferendis','porro-rerum-asperiores-qui-quisquam-suscipit-voluptatem-praesentium','Asperiores vel ut quia quis omnis quae.',14,9,28,'Male & Female',0,1,NULL,'2024-07-11 12:20:44','2024-07-11 12:20:44');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(164,1),(165,1),(166,1),(167,1),(168,1),(169,1),(170,1),(171,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1),(181,1),(182,1),(183,1),(184,1),(185,1),(186,1),(187,1),(188,1),(189,1),(190,1),(191,1),(192,1),(193,1),(194,1),(198,1),(199,1),(200,1),(201,1),(202,1),(203,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2024-07-05 13:42:42','2024-07-05 13:42:42'),(2,'user','web','2024-07-05 13:42:42','2024-07-05 13:42:42');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` enum('app','website') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'app_name','E.com','app','2024-07-06 06:10:29','2024-07-06 21:44:48'),(2,'app_version','1.0.0','app','2024-07-06 06:10:29','2024-07-06 06:16:43'),(3,'app_debug','true','app','2024-07-06 06:10:29','2024-07-06 06:16:43'),(4,'website_name','E.com','website','2024-07-06 06:10:29','2024-07-06 21:44:48'),(5,'website_url','localhost:8000','website','2024-07-06 06:10:29','2024-07-06 06:17:51'),(6,'contact_email','contact@mywebsite.com','app','2024-07-06 06:10:29','2024-07-06 06:16:43'),(7,'api','localhost:8000/api/','app','2024-07-06 06:17:51','2024-07-06 06:17:51'),(8,'website_version','1.0.0','website','2024-07-06 06:17:51','2024-07-06 06:17:51'),(9,'website_debug','true','website','2024-07-06 06:17:51','2024-07-06 06:17:51');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uploads` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ani','','ani@yopmail.com','adminani',NULL,'$2y$10$h/IbN8ZlpYjuF5uvHzYaXe7YfvFytPriocMqh4abmMyMoE/O7JsYO',NULL,'2024-07-05 13:42:42','2024-07-05 13:42:42',NULL),(2,'Admin','User 2','admin2@example.com','adminuser2',NULL,'$2y$10$3VOimT0L.T50/9kVoYtoA.mACb1y6ywIPOZMt/B7QDi7KfgMiGNFu',NULL,'2024-07-05 13:42:42','2024-07-05 13:42:42',NULL),(3,'Rita','Goyal','date.chhaya@example.org','rita1',NULL,'$2y$10$xQAjRIloIP6ulLF1AkWwNuWcCWRDj6q2Kj1DcB7/7O0t2eVy5ULMu',NULL,'2024-07-05 13:42:42','2024-07-05 13:42:42',NULL),(4,'Manpreet','Kaul','yoommen@example.org','manpreet2',NULL,'$2y$10$4mF0aMl95CCGmrg8vIgjM.4vtiHEjSQtlEweSgapseRC1OjxM1jDK',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(5,'Faraz','Samra','lanka.anil@example.net','faraz3',NULL,'$2y$10$BgYXUT6RxuKHgJ4kV48eBeIDVhaefgc79IihQAKK9TPUA6qm.Sjpq',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(6,'Urvashi','Bedi','somnath.madan@example.com','urvashi4',NULL,'$2y$10$T3yi07VIgP/yZhQgc9lKUOWILafP4IfmCpAh3g2MV9mONoz4QuPKS',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(7,'Afreen','Kadakia','samir.sodhi@example.com','afreen5',NULL,'$2y$10$LBVuwtMVszUuoImtZIq5ROHy//E7Qw1XwIr7iUbIDJ5Zh0p38Eeoy',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(8,'Monica','Naik','jdave@example.org','monica6',NULL,'$2y$10$VQkxWYICS79krM1LvnM6bOtMVP.q1Fr4YQUD9vVmx1E9w9E4d7E5.',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(9,'Zaad','Modi','mehta.fardeen@example.com','zaad7',NULL,'$2y$10$GVJafoDXp23d1RT9QBQl3uNkcvstFc2zG16zFhO.e80728w/4yKRO',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(10,'Faraz','Garde','ramesh24@example.org','faraz8',NULL,'$2y$10$MZwRAEkI1kKYhfeYFKNC2eaV7Fsj9BLpb/w44Z0rOGvUS8AedU9D.',NULL,'2024-07-05 13:42:43','2024-07-05 13:42:43',NULL),(11,'Amolika','Lal','alpa25@example.net','amolika9',NULL,'$2y$10$1sjpuCcvBHnY5Fu7ao9IWO/oHXkWmRUp/q/Aekqtn8.VWituZG3Ma',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(12,'Sameera','Sachdev','vkothari@example.net','sameera10',NULL,'$2y$10$UQRmq.X1hzZby/FkrPCiOeEWUWCFxNy8yq6Au7hkM4x9hCCwCHKUK',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(13,'Biren','Sampath','jyoti77@example.org','biren11',NULL,'$2y$10$.zY.Xr17Tm2pvsDNcAJTze.DLUPZd71.7dfnr3cfFIWJdwhcV9UTq',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(14,'Saurabh','Bhargava','charu.halder@example.net','saurabh12',NULL,'$2y$10$DPpnZoFzKIsMi1qEsVmVI.DRoGbsx/kwuYOsDJFD0CM8iizmG2RFm',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(15,'Naresh','Sura','jha.pooja@example.com','naresh13',NULL,'$2y$10$T/pIvWQyWjtElm1mu.Vn8eP68vcSaMOYIi9IZhPvNYXDPNM.s1ZI.',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(16,'Mohit','Babu','radha92@example.com','mohit14',NULL,'$2y$10$jkAY2NsxwV8AP6G4TKBPAeoQXdXZvDgCqr.EZYrGHWnv1W4P83LfC',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(17,'John','Sandhu','ykrishnamurthy@example.net','john15',NULL,'$2y$10$hjVhGUupUrsU.T0Ww/VLvuO.JLOXlpE.e5E75KHqM7MHK2C1nLy0y',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(18,'Nawab','Nazareth','pjani@example.org','nawab16',NULL,'$2y$10$HbK.qqRl4Jmdg7EuY1WS5eolC2NDwV.kDT1PDF9lHK4g5D5VxwjzG',NULL,'2024-07-05 13:42:44','2024-07-05 13:42:44',NULL),(19,'Pooja','Dayal','sameedha74@example.net','pooja17',NULL,'$2y$10$6HMJYgBnhdC6klEZMO983uhYHhkvv.8iuvV2LewgUs6msZsckEjhq',NULL,'2024-07-05 13:42:45','2024-07-05 13:42:45',NULL),(20,'Radheshyam','Bains','radhika.wali@example.com','radheshyam18',NULL,'$2y$10$4KiLuiptDJDMoAuNF9VcO.1RDONtFACPHF8JvPAtonZu2PPa.59x.',NULL,'2024-07-05 13:42:45','2024-07-05 13:42:45',NULL),(21,'Niyati','Raju','zganesan@example.com','niyati19',NULL,'$2y$10$osy8ngVdSAkt85m8kwfnRefLtHZGojAPEZRnR7hU9n/I73W33pvgG',NULL,'2024-07-05 13:42:45','2024-07-05 13:42:45',NULL),(22,'Akanksha','Banik','vijay.mitra@example.org','akanksha20',NULL,'$2y$10$S8/9f/0a7r9VE64mi3qvRO8O6jBJ4V0tQddv3C9s2Maj7PqbPTyYC',NULL,'2024-07-05 13:42:45','2024-07-05 14:59:04','2024-07-05 14:59:04'),(23,'test','test','test@test.com','test3510',NULL,'$2y$10$XnKZ2JuQR6r1uP0l6csJkeS6kZEbF1D9mgvA19ZVOUWG/D5rVVG5a',NULL,'2024-07-05 22:25:44','2024-07-05 22:25:44',NULL),(24,'Admin','User','admin@example.com','adminuser',NULL,'$2y$10$byzqRQPSd/dS9ZMAVhwA4eXKIkpdOzAQg3SGtrjKqTC01MyMBVbBO',NULL,'2024-07-07 04:47:41','2024-07-07 04:47:41',NULL),(25,'Regular','User','user@example.com','regularuser',NULL,'$2y$10$jCl4aDVQnwbajZbuICVdquGTSDmrFCDU7no21MmGh3M2FIOIDUjne',NULL,'2024-07-07 04:47:42','2024-07-07 04:47:42',NULL),(28,'Admin','User','admin@test.com','admin1234',NULL,'$2y$10$Oe7Z/vzdtC53PnIUOzsUx.kzqBAl/jM1Oh.tA7WuNNxv4VEDyteem',NULL,'2024-07-07 04:50:18','2024-07-07 04:50:18',NULL),(30,'Admin','User','admin@admin1998.com','admin1998',NULL,'$2y$10$6izf4N910Hn6lpIRhwURFeajxcLRbCDLNR3SP6NAbLW9gdvgu8nFu',NULL,'2024-07-07 04:51:53','2024-07-07 04:51:53',NULL),(31,'Regular','User','user@1998user.com','1998user',NULL,'$2y$10$4npV0rK6qzjqK9j95R2PZ.Nw0CZ4/oYfcM0MrwvLTfT9FWeAVXEXe',NULL,'2024-07-07 04:51:53','2024-07-07 04:51:53',NULL),(32,'Sahil','User','sahil@admin.com','sahil',NULL,'$2y$10$2FDpAOG0VnBCsP88IN64E.bwGWVmSGWU5zQVkmdcImxdc8a5OK1m6',NULL,'2024-07-08 01:17:24','2024-07-08 01:17:24',NULL),(33,'Regular','Sahil','sahil@user.com','Sahiluser',NULL,'$2y$10$5Fc1TKCBDNEyJtOT.Ksey.q.wRVlFy/bFcdlDkUXNRjiUTtyNnrTG',NULL,'2024-07-08 01:17:24','2024-07-08 01:17:24',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-14  0:58:56
