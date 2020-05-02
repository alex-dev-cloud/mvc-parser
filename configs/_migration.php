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
          `token_email` varchar(256) DEFAULT NULL,
          `reg_date` VARCHAR(45) DEFAULT NULL,
          `reg_ip` varchar(45) DEFAULT NULL,
          `reg_uagent` varchar(256) DEFAULT NULL,
           PRIMARY KEY (`id`),
           UNIQUE KEY `id_UNIQUE` (`id`),
           UNIQUE KEY `login_UNIQUE` (`login`),
           UNIQUE KEY `email_UNIQUE` (`email`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8;',

    'movies' =>
          'CREATE TABLE IF NOT EXISTS `movies` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `movie_id` INT NOT NULL,
          `name` VARCHAR(256) NOT NULL,
          `image` VARCHAR(128) NOT NULL,
          `description` MEDIUMTEXT NULL,
           PRIMARY KEY (`id`),
           UNIQUE INDEX `id_UNIQUE` (`id` ASC));',

    ));


