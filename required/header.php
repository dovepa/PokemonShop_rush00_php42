<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>Pokemon Shop</title>
	<link rel="stylesheet" href="pokeshop.css">
</head>
<body>
	<div class="containerall">
		<div class="containerheader">
			<a href="index.php"><img src="img/pokehead.png" class="imgheader" alt=""></a>
			<div class="menud">
				<div class="menu">
				<div class="title"><a href="index.php">Produits</a></div>
					<div class="menu-content">
						<?php
							require_once 'database.php';
							if (mysqli_connect_errno()) {
								echo "Could  not connect to database: Error: ".mysqli_connect_error();
								exit();
							}
							if ($req = mysqli_query($mysqli, 'SELECT * FROM categories_ref'))
							{
								while ($row = mysqli_fetch_assoc($req))
								{
									echo '<a href="index.php?cat='.$row['id'] .'">'.$row['name'].'</a>';
								}
							}
						?>
					</div>
				</div>


				<div class="menu">
				<?php
				if (isset($_SESSION['auth']['id'])){ ?>
					<div class="title"><a href="required/logout.php">Déconnection</a></div>
				<?php }
				else{ ?>
					<div class="title"><a href="login.php">Mon Compte</a></div>
					<div class="menu-content">
						<a href="login.php">Connexion</a>
						<a href="nwaccount.php">Inscription</a>
					</div>
				<?php } ?>
				</div>

				<div class="menu">
				<?php
					if (isset($_SESSION['cart']))
					{
						foreach ($_SESSION['cart'] as $val)
							$i++;
						$pro = "(".$i.")";
					}
				?>
				<div class="title"><a href="cart.php">Pannier <?php echo $pro ?></a></div>
				</div>
			</div>
		</div>
