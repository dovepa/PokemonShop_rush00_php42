<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>Arrow Shop</title>
	<link rel="stylesheet" href="arrowshop.css">
</head>
<body>
	<div class="containerall">
		<div class="containerheader">
			<a href="index.php"><img src="img/arrow.jpg" class="imgheader" alt=""></a>
			<div class="menud">
				<div class="menu">
				<div class="title"><a href="https://www.societe.com/societe/sas-tir-a-l-arc-amenagement-843894163.html">Qui sommes Nous ?</a></div>
					<div class="menu-content">
						<a href="https://www.societe.com/societe/sas-tir-a-l-arc-amenagement-843894163.html">Notre Entreprise</a>
						<a href="https://www.ffta.fr/">La Fédération</a>
						<a href="https://fr.wikipedia.org/wiki/Tir_%C3%A0_l%27arc_aux_Jeux_olympiques">Les J.O.</a>
					</div>
				</div>

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
			/////////////////////////////////////////////////	unset($_SESSION['auth']);
				if (isset($_SESSION['auth']['id'])){ ?>
					<div class="title"><a href="required/logout.php">Déconnection</a></div>
				<?php }
				else{ ?>
					<div class="title"><a href="connexion.php">Mon Compte</a></div>
					<div class="menu-content">
						<a href="connexion.php">Connexion</a>
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
