<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (empty($_SESSION['auth']['id']))
{
	$_SESSION['msg'][] = "Vous etes deconnecter";
	header('Location: index.php');
	exit();
}
if (!empty($_POST) && ($_POST['submit'] === "OK"))
{
		if(empty($_POST['login']) && empty($_POST['passwd'])){
            $_SESSION['msg'][] = "Merci de mettre un identifiant et un mot de passe";
            header('Location: delaccount.php');
            exit();
	    }
        require_once 'required/database.php';
        $passwd = hash('whirlpool', $_POST['passwd']."jesuisunecledekryptageyoloetjaimeleslikornes");
	    $login = mysqli_real_escape_string($mysqli, $_POST['login']);
	    $passwd = mysqli_real_escape_string($mysqli, $passwd);
        if ($req = mysqli_query($mysqli, "SELECT * FROM users WHERE username='".$login."'"))
        {
            $user = mysqli_fetch_assoc($req);
            if($passwd === $user['password'])
            {
				require_once 'required/database.php';
                $id = mysqli_real_escape_string($mysqli, $_SESSION['auth']['id']);
				$req = mysqli_query($mysqli, "DELETE FROM users WHERE id='".$id."'");
                $_SESSION['msg'][] = "Votre compte a ete suprimer !";
                header('Location: logout.php');
                exit();
            }else{
                $_SESSION['msg'][] = "Mauvais mot de passe ou login";
                header('Location: delaccount.php');
                exit();
            }
    	}
    	else
    	{
    		$_SESSION['msg'][] = "Erreur login n'existe pas";
            header('Location: delaccount.php');
            exit();
    	}
}
?>

<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
            <?php require_once('required/msg.php'); ?>
            <div class="help">
                <p>Merci de vous identifier a nouveau afin de supprimer votre compte.</p>
                <p>Besoin d'Assistance ?</p>
                <p>Hotline 24/24 7j/7 au +33(0)1.23.45.67.89</p>
            </div>
            <div class="coform">
                <form action="delaccount.php" method="POST">
                <p>Identifiant:<input type="text" name="login" value="" /></p>
                <p>Mot de passe: <input type="password" name="passwd" value="" /></p>
                <input type="submit" name="submit" value="OK"/>
                </form>
            </div>
		</div>
<?php require_once('required/footer.php'); ?>
