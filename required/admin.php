<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (empty($_SESSION['auth']['id']))
{
	header('Location: index.php');
	exit();
}

require_once 'required/database.php';
$id = $_SESSION['auth']['id'];
if ($req = mysqli_query($mysqli, "SELECT * FROM manager WHERE user_id='" .intval($id) ."'"))
{
	while ($user = mysqli_fetch_assoc($req))
	{
		if (isset($user))
		{
			$i = 1;
		}
	}
	if (($i != 1))
	{
		header('Location: login.php');
		exit();
	}
}
else
	{
		header('Location: login.php');
		exit();
	}

	//mettre un user admin
	if ($_POST['adbtn'] === "OK")
	{
		if (!empty($_POST['aduser']) && is_numeric($_POST['aduser']))
		{
			require_once 'required/database.php';
			$req = mysqli_query($mysqli, "SELECT id FROM manager WHERE id='" .intval($_POST['aduser']) ."';");
			if ($user = mysqli_fetch_assoc($req))
			{
				$j = 1;
			}
			if ($j > 0)
			{
				$_SESSION['msg'][] = "Ce user est deja admin";
				header('Location: manager.php');
				exit();
			}
		}
	}


	//ajouter un produit
	if ($_POST['addbtn'] === "OK")
	{
		if(!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['img']))
		{
			$img = pathinfo($_POST['img']);
			if ($img['extension'] != "png")
			{
				$_SESSION['msg'][] = "Image en png svp";
				header('Location: manager.php');
				exit();
			}
			if (is_numeric($_POST['price']) == FALSE)
			{
				$_SESSION['msg'][] = "Le prix doit etre un nombre";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$name = mysqli_real_escape_string($mysqli, $_POST['name']);
			$price = mysqli_real_escape_string($mysqli, intval($_POST['price']));
			$img = mysqli_real_escape_string($mysqli, $_POST['img']);
			$req = mysqli_query($mysqli, "INSERT INTO `products` (`name`, `price`, `img`) VALUES
								('$name', $price, '$img');");
			$_SESSION['msg'][] = "Produit ajouter";
			header('Location: manager.php');
			exit();
		}
		else
		{
			$_SESSION['msg'][] = "Erreur dans les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//Modif un produit
	if ($_POST['modbtn'] === "OK")
	{
		if (!empty($_POST['modid']) && !empty($_POST['modprice']))
		{
			if (is_numeric($_POST['modid']) == FALSE || is_numeric($_POST['modprice']) == FALSE)
			{
				$_SESSION['msg'][] = "Le prix et l'id doit etre un nombre";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$id = mysqli_real_escape_string($mysqli, $_POST['modid']);
			$price = mysqli_real_escape_string($mysqli, intval($_POST['modprice']));
			$req = mysqli_query($mysqli, "SELECT id FROM products WHERE id='" .intval($id) ."';");
			$prod = mysqli_fetch_assoc($req);
			if ($prod)
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "UPDATE products SET price='".floatval($price)."' WHERE id='".intval($id) ."';;");
				$_SESSION['msg'][] = "Modif OK";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "Erreur produit introuvable";
				header('Location: manager.php');
				exit();
			}

		}
		else
		{
			$_SESSION['msg'][] = "Erreur dans les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//Assigner un produit a une categorie
	if ($_POST['rcbtn'] === "OK")
	{
		if (!empty($_POST['catid']) && !empty($_POST['prodid']))
		{
			if (is_numeric($_POST['catid']) == FALSE || is_numeric($_POST['prodid']) == FALSE)
			{
				$_SESSION['msg'][] = "Merci d'utiliser des chiffres";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$catid = mysqli_real_escape_string($mysqli, $_POST['catid']);
			$prodid = mysqli_real_escape_string($mysqli, intval($_POST['prodid']));
			$req = mysqli_query($mysqli, "SELECT id FROM prod_categorie WHERE prod_id='" .intval($prodid) ."' AND cat_id='" .intval($catid) ."';;");
			$result = mysqli_fetch_assoc($req);
			if ($result)
			{
				$_SESSION['msg'][] = "Le produit est deja dans la categorie";
				header('Location: manager.php');
				exit();
			}
			else
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "INSERT INTO `prod_categorie` (`prod_id`, `cat_id`) VALUES (" .intval($prodid) .", " .intval($catid) .");");
				$_SESSION['msg'][] = "Modif OK";
				header('Location: manager.php');
				exit();
			}

		}
		else
		{
			$_SESSION['msg'][] = "Erreur merci de remplir tout les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//Reitrer produit de cat
	if ($_POST['dcbtn'] === "OK")
	{
		if (!empty($_POST['delprodid']) && !empty($_POST['delcatid']))
		{
			if (is_numeric($_POST['delprodid']) == FALSE || is_numeric($_POST['delcatid']) == FALSE)
			{
				$_SESSION['msg'][] = "Merci d'utiliser des chiffres";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$catid = mysqli_real_escape_string($mysqli, $_POST['delcatid']);
			$prodid = mysqli_real_escape_string($mysqli, intval($_POST['delprodid']));
			$req = mysqli_query($mysqli, "SELECT id FROM prod_categorie WHERE prod_id='" .intval($prodid) ."' AND cat_id='" .intval($catid) ."';");
			$result = mysqli_fetch_assoc($req);
			if ($result)
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "DELETE FROM prod_categorie WHERE prod_id='" .intval($prodid) ."' AND cat_id='" .intval($catid) ."';");
				$_SESSION['msg'][] = "Modif OK";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "Le produit est n'est pas dans la categorie";
				header('Location: manager.php');
				exit();
			}

		}
		else
		{
			$_SESSION['msg'][] = "Erreur merci de remplir tout les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//Supprimer un produit
	if ($_POST['dellbtn'] === "OK")
	{
		if (!empty($_POST['delproductid']))
		{
			if (is_numeric($_POST['delproductid']) == FALSE)
			{
				$_SESSION['msg'][] = "Merci d'utiliser des chiffres";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$delproductid = mysqli_real_escape_string($mysqli, intval($_POST['delproductid']));
			$req = mysqli_query($mysqli, "SELECT id FROM products WHERE id='" .intval($delproductid)."';");
			$result = mysqli_fetch_assoc($req);
			if ($result)
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "DELETE FROM products WHERE id ='" .intval($delproductid) ."';");
				$req = mysqli_query($mysqli, "DELETE FROM prod_categorie WHERE prod_id='" .intval($delproductid)."';");
				$_SESSION['msg'][] = "Supression OK";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "Le produit est n'existe pas";
				header('Location: manager.php');
				exit();
			}

		}
		else
		{
			$_SESSION['msg'][] = "Erreur merci de remplir tout les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//Ajouter une categorie
	if ($_POST['addcbtn'] === "OK")
	{
		if (!empty($_POST['addcname']))
		{
			require_once 'required/database.php';
			$addcname = mysqli_real_escape_string($mysqli, $_POST['addcname']);
			$req = mysqli_query($mysqli, "INSERT INTO `categories_ref` (`name`) VALUES ('".$addcname."');");
			$_SESSION['msg'][] = "La categorie est ajouter";
			header('Location: manager.php');
			exit();
		}
		else
		{
			$_SESSION['msg'][] = "Erreur merci de remplir tout les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//supprimer une categorie
	if ($_POST['rmcbtn'] === "OK")
	{
		if (!empty($_POST['rmcid']))
		{
			if (is_numeric($_POST['rmcid']) == FALSE)
			{
				$_SESSION['msg'][] = "Merci d'utiliser des chiffres";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$rmcid = mysqli_real_escape_string($mysqli, $_POST['rmcid']);
			$req = mysqli_query($mysqli, "SELECT * FROM categories_ref WHERE id='" .intval($rmcid)."';");
			$result = mysqli_fetch_assoc($req);
			if ($result)
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "DELETE FROM prod_categorie WHERE cat_id='" .intval($rmcid) ."';");
				$req = mysqli_query($mysqli, "DELETE FROM categories_ref WHERE id ='" .intval($rmcid) ."';");
				$_SESSION['msg'][] = "La categorie est supprimer";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "La categorie n existe pas ";
				header('Location: manager.php');
				exit();
			}
		}
		else
		{
			$_SESSION['msg'][] = "Erreur merci de remplir tout les champs";
			header('Location: manager.php');
			exit();
		}
	}

	//modif categorie
	if ($_POST['modcbtn'] === "OK")
	{
		if (!empty($_POST['idcat']) && !empty($_POST['modcat']))
		{
			if (is_numeric($_POST['idcat']) == FALSE)
			{
				$_SESSION['msg'][] = "L'id doit etre un nombre";
				header('Location: manager.php');
				exit();
			}
			require_once 'required/database.php';
			$idcat = mysqli_real_escape_string($mysqli, intval($_POST['idcat']));
			$modcat = mysqli_real_escape_string($mysqli, $_POST['modcat']);
			$req = mysqli_query($mysqli, "SELECT id FROM categories_ref WHERE id='" .intval($idcat) ."';");
			$prod = mysqli_fetch_assoc($req);
			if ($prod)
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "UPDATE categories_ref SET name='".$modcat."' WHERE id='".intval($idcat) ."';;");
				$_SESSION['msg'][] = "Modif OK";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "Erreur categorie introuvable";
				header('Location: manager.php');
				exit();
			}

		}
		else
		{
			$_SESSION['msg'][] = "Erreur dans les champs";
			header('Location: manager.php');
			exit();
		}
	}


	// New User
	if ($_POST['newuserbtn'] === "OK")
	{
		if (!empty($_POST['newuserid']) && !empty($_POST['newuserpasswd']))
		{
			require_once 'required/makeaccount.php';
		}
		else
		{
			$_SESSION['msg'][] = "Merci de tout remplir";
			header('Location: manager.php');
			exit();
		}
	}

	//mettre un user admin
	if ($_POST['adbtn'] === "OK")
	{
		$testid = $_POST['aduser'];
		if (!empty($testid) && is_numeric($testid))
		{

			require_once 'required/database.php';
			$testid = mysqli_real_escape_string($mysqli, intval($testid));
			$req = mysqli_query($mysqli, "SELECT id FROM manager WHERE user_id='$testid';");
			if ($user = mysqli_fetch_assoc($req))
			{
				$_SESSION['msg'][] = "Ce user est deja admin";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$req = mysqli_query($mysqli, "SELECT * FROM users WHERE id='$testid'");
				if ($user = mysqli_fetch_assoc($req))
				{
					$req = mysqli_query($mysqli, "INSERT INTO `manager` (`user_id`) VALUES ('$testid');");
					$_SESSION['msg'][] = "Ce user a ete ajouter";
					header('Location: manager.php');
					exit();
				}
				else
				{
					$_SESSION['msg'][] = "Ce user n'existe pas";
					header('Location: manager.php');
					exit();
				}
			}
		}
		else
		{
			$_SESSION['msg'][] = "Merci de tout remplir";
			header('Location: manager.php');
			exit();
		}
	}

	//del un user
	if ($_POST['deluserbtn'] === "OK")
	{
		$idtest = $_POST['deluser'];
		if (!empty($idtest))
		{
			require_once 'required/database.php';
			$testid = mysqli_real_escape_string($mysqli, intval($testid));
			$req = mysqli_query($mysqli, "SELECT * FROM users WHERE id='$idtest'");
			if ($user = mysqli_fetch_assoc($req))
			{
				require_once 'required/database.php';
				$req = mysqli_query($mysqli, "DELETE FROM users WHERE id='$idtest'");
				$req = mysqli_query($mysqli, "DELETE FROM manager WHERE user_id='$idtest'");
				$_SESSION['msg'][] = "Le compte a ete suprimer ";
				header('Location: manager.php');
				exit();
			}
			else
			{
				$_SESSION['msg'][] = "Ce user n'existe pas";
				header('Location: manager.php');
				exit();
			}
		}
		else
		{
			$_SESSION['msg'][] = "Merci de tout remplir";
			header('Location: manager.php');
			exit();
		}
	}

?>
