<?php require_once('data/admin.php'); ?>
<?php require_once('data/header.php'); ?>
<div class="containermiddle">
<?php require_once('data/msg.php'); ?>
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
					require_once 'data/database.php';
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
					require_once 'data/database.php';
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
					require_once 'data/database.php';
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
					require_once 'data/database.php';
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
					require_once 'data/database.php';
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
<?php require_once('data/footer.php'); ?>
