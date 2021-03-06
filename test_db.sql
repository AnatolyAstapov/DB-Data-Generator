#
# SQL Export
# Created by Querious (962)
# Created: 8 мая 2015, 02:38:35 GMT+3
# Encoding: Unicode (UTF-8)
#


DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `logs`;


CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


LOCK TABLES `logs` WRITE;
ALTER TABLE `logs` DISABLE KEYS;
ALTER TABLE `logs` ENABLE KEYS;
UNLOCK TABLES;


LOCK TABLES `users` WRITE;
ALTER TABLE `users` DISABLE KEYS;
ALTER TABLE `users` ENABLE KEYS;
UNLOCK TABLES;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


