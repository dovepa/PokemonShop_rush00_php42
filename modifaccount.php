<?php
    if (session_status() == PHP_SESSION_NONE) { session_start(); }

    if (!empty($_POST) && ($_POST['submit'] === "OK"))
    {
        if(empty($_POST['login']) || empty($_POST['passwdold']) || empty($_POST['passwdnew']) || empty($_POST['passwdnew2'])){
            $_SESSION['msg'][] = "Merci de mettre un identifiant et un mot de passe";
            header('Location: modifaccount.php');
            exit();
        }
        if ($_POST['passwdold'] === $_POST['passwdnew'])
        {
            $_SESSION['msg'][] = "Votre nouveau mot de passe doit etre different de l'ancien.";
            header('Location: modifaccount.php');
            exit();
        }
        if ($_POST['passwdnew'] !== $_POST['passwdnew2'])
        {
            $_SESSION['msg'][] = "Vos nouveaux mots de passe sont different.";
            header('Location: modifaccount.php');
            exit();
        }
        require_once 'data/database.php';
        $passwd = hash('whirlpool', $_POST['passwdold']."jesuisunecledekryptageyoloetjaimeleslikornes");
        $login = mysqli_real_escape_string($mysqli, $_POST['login']);
        $passwd = mysqli_real_escape_string($mysqli, $passwd);
        $passwdnew = mysqli_real_escape_string($mysqli, $passwdnew);
        if ($req = mysqli_query($mysqli, "SELECT * FROM users WHERE username='".$login."'"))
        {
            $user = mysqli_fetch_assoc($req);
            if($passwd === $user['password'])
            {
                require_once 'data/database.php';
                $passwdnew = hash('whirlpool', $_POST['passwdnew']."jesuisunecledekryptageyoloetjaimeleslikornes");
                $req = mysqli_query($mysqli, "UPDATE users SET password='".$passwdnew."' WHERE id='".$user['id']."';");
                $_SESSION['msg'][] = "Votre mot de passe a ete modifier";
                header('Location: login.php');
                exit();
            }
            else{
                $_SESSION['msg'][] = "Mauvais mot de passe ou login";
                header('Location: modifaccount.php');
                exit();
            }
        }
        else
        {
            $_SESSION['msg'][] = "Ce login n'existe pas";
            header('Location: modifaccount.php');
            exit();
        }
    }
?>
<?php require_once('data/header.php'); ?>
		<div class="containermiddle">
        <?php require_once('data/msg.php'); ?>
            <div class="help">
                <p>Vous modifiez votre mot de passe,</p>
                <p>Besoin d'Assistance ?</p>
                <p>Hotline 24/24 7j/7 au +33(0)1.23.45.67.89</p>
            </div>
            <div class="coform">
                <form action="modifaccount.php" method="POST">
                <p>Identifiant:<input type="text" name="login" value="" /></p>
                <p>Ancien Mot de passe: <input type="password" name="passwdold" value="" /></p>
                <p>Nouveau Mot de passe: <input type="password" name="passwdnew" value="" /></p>
                <p>Nouveau Mot de passe (vérification): <input type="password" name="passwdnew2" value="" /></p>
                <input type="submit" name="submit" value="OK"/>
                </form>
                <a href="nwaccount.php"><p>Pas de compte: créer son compte</p></a>
            </div>
		</div>
<?php require_once('data/footer.php'); ?>
