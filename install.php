<?php
	require_once 'required/database.php';
	$req = mysqli_query($mysqli, "DROP DATABASE IF EXISTS 'rush00';");
	$req = mysqli_query($mysqli, "CREATE DATABASE rush00 DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci");
	$req = mysqli_query($mysqli, 'USE rush00;');
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `categories_ref`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `categories_ref` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `categories_ref` (`id`, `name`) VALUES
									(1, 'Arc'),
									(2, 'Fleche'),
									(3, 'Jeux Enfant');");
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `manager`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `manager` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `user_id` int(11) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `orders`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `orders` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `buyer_id` int(11) NOT NULL,
							  `cmd_id` varchar(255) NOT NULL,
							  `product` int(11) NOT NULL,
							  `qty` int(11) NOT NULL,
							  `total_cmd` float NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `products`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `products` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  `price` float(10,2) NOT NULL,
								  `img` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES
								(1, 'Arc Nerf', 40.65, 'img/arcnerf.jpg'),
								(2, 'Arc à Poulie', 3.99, 'img/arcpoulie.jpg'),
								(3, 'Arc Noir', 78.6, 'img/arcnoir.jpg'),
								(4, 'Arc Enfant', 4.50, 'img/arcenfant.jpg'),
								(5, 'Fléche Rasoir', 8.33, 'img/picrasoir.jpg'),
								(6, 'Fléche Jaune', 17.20, 'img/flechejaune.jpg'),
								(7, 'Fleche Orange', 10.00, 'img/forange.jpg');");
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `prod_categorie`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `prod_categorie` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `prod_id` int(11) NOT NULL,
								  `cat_id` int(11) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `prod_categorie` (`prod_id`, `cat_id`) VALUES
								(1, 1),
								(2, 1),
								(3, 1),
								(4, 1),
								(5, 2),
								(6, 2),
								(7, 2);");
	//$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `users`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `users` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `username` varchar(255) NOT NULL,
							  `password` varchar(255) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if ($_SESSION['auth'] != NULL)
		unset($_SESSION['auth']);
	$_SESSION['msg'][] = "OK : install bdd ok \n ->>> Maintenant crée un nouvel user avec le login : manager";
	header('Location: index.php');
	exit();

?>
