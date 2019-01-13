<?php require_once('data/header.php'); ?>
		<div class="containermiddle">
			<?php
				require_once('data/msg.php');
				require_once('data/database.php');

				if ($_GET["submit"] === "Vider mon Pannier")
				{
					unset($_SESSION['cart']);
					$_SESSION['msg'][] = "Votre panier est vide!";
					header('Location: index.php');
					exit();
				}
				if ($_SESSION['cart'] == NULL)
				{
					$_SESSION['msg'][] = "Votre panier est vide!";
					header('Location: index.php');
					exit();
				}
				if ($_GET["submit"] === "Archiver la commande")
				{
					if (!isset($_SESSION['auth']['id']))
					{
						$_SESSION['msg'][] = "Merci de vous connecter ou de cree un compte pour archiver votre commande !";
						$_SESSION['buy'] = 1;
						header('Location: login.php');
						exit();
					}
					require_once('data/buy.php');
				}
				if ($_SESSION['cart'] != NULL)
				{
					echo '<div class="centerdiv"><form method="GET" action="cart.php">
					<input class="button buttondel" type="submit" name="submit" value="Vider mon Pannier">
					</form></div>';

					foreach ($_SESSION['cart'] as $val)
						$tab[$val] += 1;
					echo '<div class="centerdiv"><ul class="products">';
					foreach ($tab as $val => $exp)
					{
						if ($req = mysqli_query($mysqli, 'SELECT * FROM products'))
						{
							while ($row = mysqli_fetch_assoc($req))
							{
								if ($row['id'] == $val)
								{
									$i = $row['price'] * $exp;
									$total += $i;
									echo
									'<li>
										<img class="product-img" src="' .$row['img'] .'">
										<p>'.$row['name'] .'</p>
										<p >'.$row['price'].' €  unité</p>
										<p>vous en avez choisi '.$exp.'</p>
									</li>';
								}
							}
						}
					}
					echo '</ul></div>';
					echo '<div class="centerdiv"><p>Le total de vos produits est de '.$total.' € veuillez valider votre panier :</p>
					<form method="GET" action="cart.php">
					<input class="button buttonpay" type="submit" name="submit" value="Archiver la commande">
					</form></div>';
				}
			?>
		</div>
<?php require_once('data/footer.php'); ?>
