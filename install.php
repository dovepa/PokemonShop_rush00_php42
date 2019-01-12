<?php
	$host = "localhost";
	$user = "root";
	$password = "123456";

	$mysqli   = mysqli_connect($host, $user, $password);

	if (mysqli_connect_errno($mysqli)) {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$req = mysqli_query($mysqli, "DROP DATABASE IF EXISTS 'rush00';");
	$req = mysqli_query($mysqli, "CREATE DATABASE rush00 DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci");
	$req = mysqli_query($mysqli, 'use rush00;');
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `categories_ref`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `categories_ref` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `categories_ref` (`id`, `name`) VALUES
									(1, 'Type Eau'),
									(2, 'Type Feu'),
									(3, 'Type Plante');");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `manager`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `manager` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `user_id` int(11) NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `orders`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `orders` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `buyer_id` int(11) NOT NULL,
							  `cmd_id` varchar(255) NOT NULL,
							  `product` int(11) NOT NULL,
							  `qty` int(11) NOT NULL,
							  `total_cmd` float NOT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `products`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `products` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` varchar(255) NOT NULL,
								  `price` float(10,2) NOT NULL,
								  `img` varchar(255) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES
								(1, 'Bulbizarre', 40.65, 'img/bulbizarre.png'),
								(2, 'Dracofeu', 3.99, 'img/dracofeu.png'),
								(3, 'Dracolosse', 78.6, 'img/dracolosse.png'),
								(4, 'Evoli', 4.50, 'img/evoli.png'),
								(5, 'Minidraco', 8.33, 'img/minidraco.png'),
								(6, 'Philali', 17.20, 'img/philali.png'),
								(7, 'Reptincel', 10.00, 'img/reptincel.png'),
								(8, 'Roserade', 10.00, 'img/roserade.png');");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `prod_categorie`;");
	$req = mysqli_query($mysqli, "CREATE TABLE IF NOT EXISTS `prod_categorie` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `prod_id` int(11) NOT NULL,
								  `cat_id` int(11) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	$req = mysqli_query($mysqli, "INSERT INTO `prod_categorie` (`prod_id`, `cat_id`) VALUES
								(1, 3),
								(2, 2),
								(3, 1),
								(4, 1),
								(4, 2),
								(4, 3),
								(5, 1),
								(6, 3),
								(7, 2),
								(8, 3);");
	$req = mysqli_query($mysqli, "DROP TABLE IF EXISTS `users`;");
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
