<?php
	require_once('database.php');
	if ($_SESSION['cart'] != NULL)
	{
		foreach ($_SESSION['cart'] as $val)
			$tab[$val] += 1;
		foreach ($tab as $val => $exp)
		{
			if ($req = mysqli_query($mysqli, 'SELECT * FROM products'))
			{
				while ($row = mysqli_fetch_assoc($req))
				{
					if ($row['id'] == $val)
					{
						$i = $row['price'] * $exp;
						$cmd_data .= "- Produit : ".$row['id']." En ".$exp." exemplaire(s) Soit : ".$i." Euros -";
						$total += $i;
					}
				}
			}
		}
		$id = $_SESSION['auth']['id'];
		require_once('database.php');
		$req = mysqli_query($mysqli, "INSERT INTO `orders` (`buyer_id`, `cmd_data`, `total_cmd`) VALUES ('$id', '$cmd_data', '$total');");
		unset($_SESSION['cart']);
		$_SESSION['msg'][] = "Votre commande est archiver!";
		header('Location: index.php');
		exit();
	}


?>
