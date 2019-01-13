<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (isset($_GET['id']))
	{
		if (is_numeric($_GET['id']) && $_GET['name'] !== NULL)
		{
			if (!isset($_SESSION['cart']))
				$_SESSION['cart'] = array();
			$place = 0;
			while (isset($_SESSION['cart'][$place]))
				$place++;
			$item = intval($_GET['id']);
			$_SESSION['cart'][$place] = $item;
			$_SESSION['msg'][] = "Produit -> ".strtoupper($_GET['name'])." <- ajouter au panier !";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		}
	}
?>
