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

<?php require_once('required/header.php'); ?>
<div class="containermiddle">
<?php require_once('required/msg.php'); ?>
	<div class="admdiv">
		<p>Mettre un utilisateur Admin</p>
		<form method="POST">
			<p>User ID <input type="text" name="aduser"></p>
			<input type="submit" name="adbtn" value="OK">
		</form>
		<p>Cree un utilisateur</p>
		<form method="POST">
			<p>User Login <input type="text" name="newuserid"></p>
			<p>User Password <input type="text" name="newuserpasswd"></p>
			<input type="submit" name="newuserbtn" value="OK">
		</form>
		<p>Supprimer un utilisateur</p>
		<form method="POST">
			<p>User ID <input type="text" name="deluser"></p>
			<input type="submit" name="deluserbtn" value="OK">
		</form>
	</div>

	<div  class="admdiv">
		<p>Ajouter un Produit</p>
		<form method="POST">
		<p>Nom <input type="text" name="name"></p>
		<p>Prix	<input type="text" name="price"></p>
		<p>Image lien (uniquement en png au fomat 250*250)	<input type="text" name="img" placeholder="ex: img/file.png 250*250"></p>
			<input type="submit" name="addbtn" value="OK">
		</form>

		<p>Modif Produit</p>
		<form method="POST">
		<p>ID du produit <input type="text" name="modid"></p>
		<p>Nouveau Prix<input type="text" name="modprice"></p>
			<input type="submit" name="modbtn" value="OK">
		</form>

		<p>Assigner un produit a une categorie</p>
		<form method="POST">
		<p>ID produit<input type="text" name="prodid"></p>
		<p>ID categorie	<input type="text" name="catid"></p>
			<input type="submit" name="rcbtn" value="OK">
		</form>

		<p>Retirer un produit a une categorie</p>
		<form method="POST">
		<p>ID produit	<input type="text" name="delprodid"></p>
		<p>ID categorie	<input type="text" name="delcatid"></p>
			<input type="submit" name="dcbtn" value="OK">
		</form>

		<p>Supprimer un Produit</p>
		<form method="POST">
		<p>ID produit	<input type="text" name="delproductid"></p>
			<input type="submit" name="dellbtn" value="OK">
		</form>
	</div>

	<div class="admdiv">
		<p>Ajouter une categorie</p>
		<form method="POST">
		<p>Nom	<input type="text" name="addcname"></p>
			<input type="submit" name="addcbtn" value="OK">
		</form>

		<p>Supprimer une categorie</p>
		<form method="POST">
		<p>ID categorie	<input type="text" name="rmcid"></p>
			<input type="submit" name="rmcbtn" value="OK">
		</form>

		<p>Modifier une categorie</p>
		<form method="POST">
		<p>ID categorie	<input type="text" name="idcat"></p>
		<p>Nouveau Nom	<input type="text" name="modcat"></p>
			<input type="submit" name="modcbtn" value="OK">
		</form>
	</div>
	<div class="admdiv">
		<table>
			<p>Produits</p>
			<thead>
				<tr>
					<th><p>Id</p></th>
					<th><p>nom</p></th>
					<th><p>prix</p></th>
				</tr>
			</thead>
			<tbody>
				<?php
					require_once 'required/database.php';
					$req = mysqli_query($mysqli, 'SELECT * FROM products');
					while ($row = mysqli_fetch_assoc($req)) {
						echo "<tr><th><p>" .$row['id'] ."</p></th><th><p>" .$row['name'] ."</p></th><th><p>" .$row['price'] ."</p></th></tr>";
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="admdiv">
		<table>
			<p>Assignations categoriey</p>
			<thead>
				<tr>
					<th><p>Id Produit</p></th>
					<th><p>Id Categorie</p></th>
				</tr>
			</thead>
			<tbody>
				<?php
					require_once 'required/database.php';
					$req = mysqli_query($mysqli, 'SELECT * FROM prod_categorie');
					while ($row = mysqli_fetch_assoc($req)) {
						echo "<tr><th><p>" .$row['prod_id'] ."</p></th><th><p>" .$row['cat_id'] ."</p></th></tr>";
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="admdiv">
		<table>
			<p>Categories</p>
			<thead>
				<tr>
					<th><p>id</p></th>
					<th><p>Nom</p></th>
				</tr>
			</thead>
			<tbody>
				<?php
					require_once 'required/database.php';
					$req = mysqli_query($mysqli, 'SELECT * FROM categories_ref');
					while ($row = mysqli_fetch_assoc($req)) {
						echo "<tr><th><p>" .$row['id'] ."</p></th><th><p>" .$row['name'] ."</p></th></tr>";
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="admdiv">
		<table >
			<p>Utilisateurs</p>
			<thead>
				<tr>
					<th><p>id</p></th>
					<th><p>Login</p></th>
				</tr>
			</thead>
			<tbody>
				<?php
					require_once 'required/database.php';
					$req = mysqli_query($mysqli, 'SELECT * FROM users');
					while ($row = mysqli_fetch_assoc($req)) {
						echo "<tr><th><p>" .$row['id'] ."</p></th><th><p>" .$row['username'] ."</p></th></tr>";
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="admdiv">
		<table >
			<p>Commandes</p>
			<thead>
				<tr>
					<th><p>Id</p></th>
					<th><p>CLientId</p></th>
					<th><p>Resume de commande</p></th>
					<th><p>Total</p></th>
				</tr>
			</thead>
			<tbody>
				<?php
					require_once 'required/database.php';
					$req = mysqli_query($mysqli, 'SELECT * FROM orders');
					while ($row = mysqli_fetch_assoc($req)) {
						$order_id = substr($row['id'], 0, 5);
						echo "<tr><th><p>" .$order_id ."</p></th><th><p>" .$row['buyer_id'] ."</p></th><th><p>" .$row['cmd_data'] ."</p></th><th><p>" .$row['total_cmd'] ."</p></th></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php require_once('required/footer.php'); ?>
