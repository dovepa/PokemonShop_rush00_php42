<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
            <div class="help">
                <p>Vous modifiez votre mot de passe,</p>
                <p>Besoin d'Assistance ?</p>
                <p>Hotline 24/24 7j/7 au +33(0)1.23.45.67.89</p>
            </div>
            <div class="coform">
                <p>Identifiant:<input type="text" name="login" value="" /></p>
                <p>Ancien Mot de passe: <input type="passwordold" name="passwd" value="" /></p>
                <p>Nouveau Mot de passe: <input type="passwordnw" name="passwd" value="" /></p>
                <p>Nouveau Mot de passe (vérification): <input type="passwordnw2" name="passwd2" value="" /></p>
                <input type="submit" name="submit" value="OK"/>
                </form>
                <a href="nwaccount.php"><p>Pas de compte: créer son compte</p></a>
            </div>
		</div>
<?php require_once('required/footer.php'); ?>
