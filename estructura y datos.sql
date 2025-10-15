DROP TABLE IF EXISTS `dominios`;
CREATE TABLE `dominios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dominio` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `dominios` WRITE;
INSERT INTO `dominios` VALUES
(1,'CORE_NAME','GERARDO´S ESCUELA DE MANEJO','GERARDO´S ESCUELA DE MANEJO','GERARDO´S - ESCUELA DE MANEJO',1,'2025-10-12 12:40:52');
UNLOCK TABLES;


DROP TABLE IF EXISTS `uc_actions`;
CREATE TABLE `uc_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `crud` varchar(255) NOT NULL,
  `search_key` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name_action` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `uc_page`;
CREATE TABLE `uc_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `menu` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `uc_page` WRITE;
INSERT INTO `uc_page` VALUES
(1,'index','Inicio','Inicio','Inicio',1,'2023-04-05 17:17:14'),
(2,'perfil','Inicio','Perfil','Inicio',1,'2023-04-05 17:17:14'),
(3,'usuarios','Catalogos','Usuarios del sistema','Catalogos',1,'2023-04-05 17:17:14');
UNLOCK TABLES;


DROP TABLE IF EXISTS `uc_permission`;
CREATE TABLE `uc_permission` (
  `id_rol` int(11) NOT NULL,
  `id_page` int(11) NOT NULL,
  `crud_create` int(11) NOT NULL DEFAULT 0,
  `crud_read` int(11) NOT NULL DEFAULT 0,
  `crud_update` int(11) NOT NULL DEFAULT 0,
  `crud_delete` int(11) NOT NULL DEFAULT 0,
  KEY `fk_perm_rol` (`id_rol`),
  KEY `fk_perm_page` (`id_page`),
  CONSTRAINT `fk_perm_page` FOREIGN KEY (`id_page`) REFERENCES `uc_page` (`id`),
  CONSTRAINT `fk_perm_rol` FOREIGN KEY (`id_rol`) REFERENCES `uc_rol` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `uc_permission` WRITE;
INSERT INTO `uc_permission` VALUES
(1,1,1,1,1,1),
(1,2,1,1,1,1),
(1,3,1,1,1,1);
UNLOCK TABLES;

DROP TABLE IF EXISTS `uc_rol`;
CREATE TABLE `uc_rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `uc_rol` WRITE;
INSERT INTO `uc_rol` VALUES
(0,'superadmin','superadmin',1,'2024-03-04 04:58:06'),
(1,'Admin','Admin',1,'2024-04-19 05:15:53');
UNLOCK TABLES;


DROP TABLE IF EXISTS `uc_user`;
CREATE TABLE `uc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_lastname` varchar(255) NOT NULL,
  `second_lastname` varchar(255) NOT NULL,
  `alias` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL DEFAULT '',
  `img` varchar(255) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT 1,
  `creation` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `uc_user` WRITE;
INSERT INTO `uc_user` VALUES
(0,'juanm','$2y$10$xYRTpud17zhfLlL.vE6KHOCyJMlIPU2jTjCsivmQvwoOcXjdd3HGu','juan','trini','may','juancho','juantrinidadmayo@outlook.es','993102999','1688167417.png',1,'2023-04-05 17:17:49'),
(1,'admin','$2y$10$xYRTpud17zhfLlL.vE6KHOCyJMlIPU2jTjCsivmQvwoOcXjdd3HGu','juan','trini','may','','juantrinidadmayo@outlook.es','','',1,'2024-04-19 06:07:53');
UNLOCK TABLES;


DROP TABLE IF EXISTS `uc_user_rol`;
CREATE TABLE `uc_user_rol` (
  `id_user` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  KEY `fk_uc_user` (`id_user`),
  KEY `fk_uc_rol` (`id_rol`),
  CONSTRAINT `fk_uc_rol` FOREIGN KEY (`id_rol`) REFERENCES `uc_rol` (`id`),
  CONSTRAINT `fk_uc_user` FOREIGN KEY (`id_user`) REFERENCES `uc_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


LOCK TABLES `uc_user_rol` WRITE;
INSERT INTO `uc_user_rol` VALUES
(1,1),
(0,0);
UNLOCK TABLES;


DROP TABLE IF EXISTS `v_uc_permissions`;
/*!50001 DROP VIEW IF EXISTS `v_uc_permissions`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_uc_permissions` AS SELECT
 1 AS `id_user`,
  1 AS `id_rol`,
  1 AS `rol`,
  1 AS `username`,
  1 AS `page`,
  1 AS `controller`,
  1 AS `description`,
  1 AS `create`,
  1 AS `read`,
  1 AS `update`,
  1 AS `delete`,
  1 AS `menu`,
  1 AS `search_key` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_uc_user`
--

DROP TABLE IF EXISTS `v_uc_user`;
/*!50001 DROP VIEW IF EXISTS `v_uc_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_uc_user` AS SELECT
 1 AS `id`,
  1 AS `username`,
  1 AS `name`,
  1 AS `first_lastname`,
  1 AS `second_lastname`,
  1 AS `alias`,
  1 AS `email`,
  1 AS `phone`,
  1 AS `img`,
  1 AS `status`,
  1 AS `creation`,
  1 AS `rol` */;
SET character_set_client = @saved_cs_client;

-- Final view structure for view `v_uc_permissions`
--

/*!50001 DROP VIEW IF EXISTS `v_uc_permissions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_uc_permissions` AS select `ur`.`id_user` AS `id_user`,`ur`.`id_rol` AS `id_rol`,`r`.`name` AS `rol`,`u`.`username` AS `username`,`pg`.`name` AS `page`,`pg`.`controller` AS `controller`,`pg`.`description` AS `description`,`p`.`crud_create` AS `create`,`p`.`crud_read` AS `read`,`p`.`crud_update` AS `update`,`p`.`crud_delete` AS `delete`,`pg`.`menu` AS `menu`,concat(`pg`.`controller`,`pg`.`name`) AS `search_key` from ((((`uc_user_rol` `ur` left join `uc_rol` `r` on(`r`.`id` = `ur`.`id_rol`)) left join `uc_user` `u` on(`u`.`id` = `ur`.`id_user`)) left join `uc_permission` `p` on(`p`.`id_rol` = `r`.`id`)) left join `uc_page` `pg` on(`pg`.`id` = `p`.`id_page`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_uc_user`
--

/*!50001 DROP VIEW IF EXISTS `v_uc_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_uc_user` AS select `usr`.`id` AS `id`,`usr`.`username` AS `username`,`usr`.`name` AS `name`,`usr`.`first_lastname` AS `first_lastname`,`usr`.`second_lastname` AS `second_lastname`,`usr`.`alias` AS `alias`,`usr`.`email` AS `email`,`usr`.`phone` AS `phone`,`usr`.`img` AS `img`,`usr`.`status` AS `status`,`usr`.`creation` AS `creation`,`rol`.`name` AS `rol` from ((`uc_user` `usr` left join `uc_user_rol` `pvt` on(`pvt`.`id_user` = `usr`.`id`)) left join `uc_rol` `rol` on(`rol`.`id` = `pvt`.`id_rol`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-10-12  0:24:04
