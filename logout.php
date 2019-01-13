<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	if (!isset($_SESSION['auth']))
	{
		$_SESSION['msg'][''] = "Vous n'etes pas connecter.";
	}
	else
	{
		unset($_SESSION['auth']);
		unset($_SESSION['cart']);
		session_destroy();
	}
	$_SESSION['msg'][] = "Vous etes bien deconnecter";
	header('Location: index.php');
	exit();
?>
