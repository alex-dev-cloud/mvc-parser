<?php

define('TABLES', array(

    'users' =>
          'CREATE TABLE IF NOT EXISTS `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `login` varchar(45) NOT NULL,
          `email` varchar(45) NOT NULL,
          `password` varchar(256) NOT NULL,
          `role` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
          `is_active` enum(\'0\',\'1\') NOT NULL DEFAULT \'0\',
          `selector` varchar(45) DEFAULT NULL,
          `token` varchar(45) DEFAULT NULL,
          `reg_date` date DEFAULT NULL,
          `reg_ip` varchar(45) DEFAULT NULL,
          `reg_uagent` varchar(256) DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `id_UNIQUE` (`id`),
          UNIQUE KEY `login_UNIQUE` (`login`),
          UNIQUE KEY `email_UNIQUE` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;',

    'posts' =>
          'CREATE TABLE IF NOT EXISTS `mvc-parser`.`posts` (
          `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
          `titel` VARCHAR(45) NOT NULL,
          `body` MEDIUMTEXT NOT NULL,
          `created` DATE NOT NULL,
          `user_id` INT NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC));',

    ));


