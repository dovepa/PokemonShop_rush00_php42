<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
            <div class="help">
                <p>Merci de vous identifier afin d'accéder à votre compte.</p>
                <p>Besoin d'Assistance ?</p>
                <p>Hotline 24/24 7j/7 au +33(0)1.23.45.67.89</p>
            </div>
            <div class="coform">
                <form action="login.php" method="POST">
                <p>Identifiant:<input type="text" name="login" value="" /></p>
                <p>Mot de passe: <input type="password" name="passwd" value="" /></p>
                <input type="submit" name="submit" value="OK"/>
                </form>
                <a href="nwaccount.php"><p>créer son compte</p></a>
                <a href="modifaccount.php"><p>modifier son mot de passe</p></a>
            </div>
		</div>
<?php require_once('required/footer.php'); ?>

