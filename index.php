<?php require_once('data/header.php'); ?>
		<div class="containermiddle">
			<?php require_once('data/msg.php'); ?>
			<div id="indexpub">
			<?php
				$_SESSION['buy'] = 0;
				if ($_GET['cat'] == NULL)
				{
					echo "<p class='ipub'>D'accord, attraper un max de Pokémon pour remplir son Pokédex, c'est amusant.
					Mais monter une équipe formidable, à même d'affronter les Champions d'Arène et de défier d'autres
					Dresseurs (vos amis inclus), c'est encore mieux ! Pour vous lancer dans ces combats épiques,
					il vous faudra être capable d'improviser de nouvelles stratégies dans le feu de l'action. Vous devrez être prêt à tout,
					car vos adversaires ne vous laisseront pas le moindre répit !</p>";
				}
			?>
			</div>
			<div class="centerdiv">
			<ul class="products">
				<?php require_once('data/product.php'); ?>
			</ul>
			</div>
		</div>
<?php require_once('data/footer.php'); ?>
