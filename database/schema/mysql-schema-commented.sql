/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*
    Migrations table is created by Laravel/Lumen migration system
    to store which migrations have already been created and run.
*/
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

/*
    The field "description" of the status contains the status itself (in_progress, completed, pending).
*/
CREATE TABLE `status` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL, --Primary key (Uuid)
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, -- It is unique because status description cannot be equal in two different status.
  `created_at` timestamp NULL DEFAULT NULL, -- Default timestamps provided by Lumen
  `updated_at` timestamp NULL DEFAULT NULL, -- Default timestamps provided by Lumen
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_description_unique` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `status_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

/*
    This table exists as a pivot table so that not only the
    current status of each task can be retrieved but also the change history.
 */
CREATE TABLE `status_task` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT, --Primary key (Perhaps could be replaced by a composite primary key)
  `status_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL, --Foreign key (Uuid)
  `task_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL, --Foreign key (Uuid)
  `created_at` timestamp NOT NULL, --Timestamp that is important to show when has the status change happened for each task.
  PRIMARY KEY (`id`),
  KEY `status_task_status_id_foreign` (`status_id`),
  KEY `status_task_task_id_foreign` (`task_id`),
  CONSTRAINT `status_task_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`), --Foreign key constraint
  CONSTRAINT `status_task_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) --Foreign key constraint
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `task_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

/*
    This table exists as a pivot table so that not only the current user can be retrieved but also the change history.
    User_id is nullable because a task may be not assigned to any team member.
*/
CREATE TABLE `task_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT, --Primary key (Perhaps could be replaced by a composite primary key)
  `task_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL, --Foreign key (Uuid)
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL, --Foreign key (Uuid)
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_user_task_id_foreign` (`task_id`),
  KEY `task_user_user_id_foreign` (`user_id`),
  CONSTRAINT `task_user_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `task_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

/*
    Users table with unique fields email and API Token.
*/
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL, --Primary key (Uuid)
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, --Unique
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL, --Nullable
  `token_expiration` timestamp NULL DEFAULT NULL, --Timestamp for token expiration
  `created_at` timestamp NULL DEFAULT NULL, --Default Lumen timestamp
  `updated_at` timestamp NULL DEFAULT NULL, --Default Lumen timestamp
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*
 Insert the migrations that have already been run
 */

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2024_02_10_152704_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2024_02_10_172109_create_status_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2024_02_10_172240_create_tasks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2024_02_10_174624_create_status_task_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2024_02_10_174906_create_task_user_table',1);
