<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['auth']['id']))
{
	$_SESSION['msg'][] = "Vous êtes deja connecter";
	header('Location: index.php');
	exit();
}
if (!empty($_POST) && ($_POST['submit'] === "OK"))
{
		if(empty($_POST['login']) && empty($_POST['passwd'])){
            $_SESSION['msg'][] = "Merci de mettre un identifiant et un mot de passe";
            header('Location: login.php');
            exit();
	    }
        require_once 'data/database.php';
        $passwd = hash('whirlpool', $_POST['passwd']."jesuisunecledekryptageyoloetjaimeleslikornes");
	    $login = mysqli_real_escape_string($mysqli, $_POST['login']);
	    $passwd = mysqli_real_escape_string($mysqli, $passwd);
        if ($req = mysqli_query($mysqli, "SELECT * FROM users WHERE username='".$login."'"))
        {
            $user = mysqli_fetch_assoc($req);
            if($passwd === $user['password'])
            {
                $_SESSION['auth'] = $user;
                $_SESSION['msg'][] = "Vous etes connecter !";
                if ( $_SESSION['buy'] === 1)
                    require_once('data/buy.php');
                else {
                header('Location: index.php');
                exit(); }
            }else{
                $_SESSION['msg'][] = "Mauvais mot de passe ou login";
                header('Location: login.php');
                exit();
            }
    	}
    	else
    	{
    		$_SESSION['msg'][] = "Ce login n'existe pas";
            header('Location: login.php');
            exit();
    	}
}
?>

<?php require_once('data/header.php'); ?>
		<div class="containermiddle">
            <?php require_once('data/msg.php'); ?>
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
<?php require_once('data/footer.php'); ?>

