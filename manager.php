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
	if (($i == 1) && isset($id))
	{
		require_once('required/header.php');
		echo '<div class="containermiddle">';
		require_once('required/msg.php');
		/// Admin Here ?>

		<div class="admdiv">
			<p>Mettre un utilisateur Admin</p>
			<form method="POST">
				<input type="text" name="aduser">
				<input type="submit" name="adbtn" value="valider">
			</form>
		</div>

		<div  class="admdiv">
			<p>Ajouter un Produit</p>
			<form method="POST">
				<input type="text" name="name">
				<input type="text" name="price">
				<input type="text" name="img" placeholder="ex: img/file.png 250*250">
				<input type="submit" name="addbtn" value="Valider">
			</form>

			<p>Modif Produitt</p>
			<form method="POST">
				<input type="text" name="modid">
				<input type="text" name="modname">
				<input type="text" name="modprice">
				<input type="submit" name="modbtn" value="Valider">
			</form>

			<p>Assigner un produit a une categorie</p>
			<form method="POST">
				<input type="text" name="prodid">
				<input type="text" name="catid">
				<input type="submit" name="rcbtn" value="Valider">
			</form>

			<p>Retirer un produit a une categorie</p>
			<form method="POST">
				<input type="text" name="delprodid">
				<input type="text" name="delcatid">
				<input type="submit" name="dcbtn" value="Valider">
			</form>

			<p>Supprimer un Produit</p>
			<form method="POST">
				<input type="text" name="delproductid">
				<input type="submit" name="dellbtn" value="Valider">
			</form>
		</div>

		<div class="admdiv">
			<p>Ajouter une categorie</p>
			<form method="POST">
				<input type="text" name="addcname">
				<input type="submit" name="addcbtn" value="Valider">
			</form>

			<p>Supprimer une categorie</p>
			<form method="POST">
				<input type="text" name="rmcid">
				<input type="submit" name="rmcbtn" value="Valider">
			</form>

			<p>Modifier une categorie</p>
			<form method="POST">
				<input type="text" name="modcname">
				<input type="text" name="modcid">
				<input type="submit" name="modcbtn" value="Valider">
			</form>
		</div>
		<div class="admdiv">
			<table>
				<caption>Produits</caption>
				<thead>
					<tr>
						<th>Id</th>
						<th>nom</th>
						<th>prix</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM products');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['name'] ."</th><th>" .$row['price'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="admdiv">
			<table>
				<caption>Assignations categoriey</caption>
				<thead>
					<tr>
						<th>Id Produit</th>
						<th>Id Categorie</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM prod_categorie');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['prod_id'] ."</th><th>" .$row['cat_id'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			</div>
			<div class="admdiv">
			<table>
				<caption>Categories</caption>
				<thead>
					<tr>
						<th>id</th>
						<th>Nom</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM categories_ref');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['name'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			</div>
			<div class="admdiv">
			<table >
				<caption>Utilisateurs</caption>
				<thead>
					<tr>
						<th>id</th>
						<th>Login</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM users');
						while ($row = mysqli_fetch_assoc($req)) {
							echo "<tr><th>" .$row['id'] ."</th><th>" .$row['username'] ."</th></tr>";
						}
					?>
				</tbody>
			</table>
			</div>
			<div class="admdiv">
			<table >
				<caption>Commandes</caption>
				<thead>
					<tr>
						<th>Id</th>
						<th>CLientId</th>
						<th>Resume de commande</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						require_once 'required/database.php';
						$req = mysqli_query($mysqli, 'SELECT * FROM orders');
						while ($row = mysqli_fetch_assoc($req)) {
							$order_id = substr($row['id'], 0, 5);
							echo "<tr><th>" .$order_id ."</th><th>" .$row['buyer_id'] ."</th><th>" .$row['cmd_data'] ."</th><th>" .$row['total_cmd'] ."</th></tr>";
						}

					?>
				</tbody>
			</table>
			</div>

		<?php /// Admin End
		require_once('required/footer.php');
		exit();
	}
	else
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
?>

