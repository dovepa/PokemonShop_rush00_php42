<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
			<?php require_once('required/msg.php'); ?>
			<div id="indexpub">
			<?php
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
			<ul class="products">
				<?php require_once('required/product.php'); ?>
			</ul>
		</div>
<?php require_once('required/footer.php'); ?>
