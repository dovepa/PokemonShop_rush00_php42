<?php
	require_once 'database.php';
	if ($_GET['cat'] == NULL)
	{
		if ($req = mysqli_query($mysqli, 'SELECT * FROM products'))
		{
			while ($row = mysqli_fetch_assoc($req)) {
				echo '<li>
				<img class="product-img" src="' .$row['img'] .'">
				<p>'.$row['name'] .'</p>
				<p >'.$row['price'].' € </p>
				<a href="add_to_cart.php?id=' .intval($row['id']).'&name='.$row['name'].'"><p>Ajouter au panier</p></a>
			</li>';
			}
		}
	}
	else if ($_GET['cat'] != NULL)
	{
		if ($req = mysqli_query($mysqli, "SELECT * FROM prod_categorie WHERE cat_id='" .intval($_GET['cat']) ."'"))
		{
			while ($row = mysqli_fetch_assoc($req))
			{
				if ($reqprod = mysqli_query($mysqli, "SELECT * FROM products WHERE id='" .intval($row['prod_id']) ."'"))
				{
					while ($row = mysqli_fetch_assoc($reqprod))
					{
						echo '<li>
						<img class="product-img" src="' .$row['img'] .'">
						<p>'.$row['name'] .'</p>
						<p >'.$row['price'].' € </p>
						<a href="add_to_cart.php?id=' .intval($row['id']).'&name='.$row['name'].'"><p>Ajouter au panier</p></a>
					</li>';
					$valpro++;
					}
				}
			}
		}
		if ($valpro == 0)
		{
			$_SESSION['msg'][] = "La categorie est vide dsl";
			header('Location: index.php');
			exit();
		}
	}
?>
