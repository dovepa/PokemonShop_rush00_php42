<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
			<?php require_once('required/msg.php'); ?>
			<div id="indexpub">
			<?php
				if ($_GET['cat'] == NULL)
				{
					echo '<p class="ipub">40 ans d’expérience, ça compte ! C’est le temps qu’il faut pour se forger l’expérience nécessaire,
					pour définir ce qu’est « le bon arc de chasse». Nous vous proposons dans cette rubrique notre sélection
					d’arcs traditionnels ou à poulies. Nous avons fait le choix audacieux de nous inviter à vous assister en
					plaçant les produits de cette rubrique dans un devis avant de valider votre achat. Nous pourrons de cette
					manière, nous assurer que votre choix est le plus adapté à vos besoins.</p>';
				}
			?>
			</div>
			<ul class="products">
				<?php require_once('required/product.php'); ?>
			</ul>
		</div>
<?php require_once('required/footer.php'); ?>
