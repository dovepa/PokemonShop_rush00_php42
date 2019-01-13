<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['auth']->id))
{
    $_SESSION['msg'][] = "You cannot acces this page.";
    header('Location: index.php');
    exit();
}
if (!empty($_POST) && ($_POST['submit'] === "OK"))
{
    if (empty($_POST['newlogin']) || empty($_POST['newpasswd']) || empty($_POST['newpasswd2']))
    {
        $_SESSION['msg'][] = "Merci de remplier tout les champs.";
        header('Location: nwaccount.php');
        exit();
    }
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['newlogin']))
    {
        $_SESSION['msg'][] = "Merci de n'utiliser que des chiffres et des lettres dans le login.";
        header('Location: nwaccount.php');
        exit();
    }
    if ($_POST['newpasswd'] != $_POST['newpasswd2'])
    {
        $_SESSION['msg'][] = "Les mot de passes sont different.";
        header('Location: nwaccount.php');
        exit();
    }
    if (strlen($_POST['newpasswd']) < 4 || strlen($_POST['newpasswd']) > 15)
    {
        $_SESSION['msg'][] = "Le mot de passe doit etre entre 5 et 15 caracteres";
        header('Location: nwaccount.php');
        exit();
    }
    if (strlen($_POST['newlogin']) < 3 || strlen($_POST['newpasswd']) > 35)
    {
        $_SESSION['msg'][] = "Le login doit etre entre 4 et 35 caracteres";
        header('Location: nwaccount.php');
        exit();
    }
    require_once 'required/database.php';
    $pusername = mysqli_real_escape_string($mysqli, $_POST['newlogin']);
    $req = mysqli_query($mysqli, "SELECT id FROM users WHERE username='" .$pusername ."'");
    $user = mysqli_fetch_assoc($req);
    if($user)
    {
        $_SESSION['msg'][] = "Username already taken.";
        header('Location: nwaccount.php');
        exit();
    }
    require_once 'required/database.php';
    $password = hash('whirlpool', $_POST['newpasswd']."jesuisunecledekryptageyoloetjaimeleslikornes");
    $password = mysqli_real_escape_string($mysqli, $password);
    $req = mysqli_query($mysqli, "INSERT INTO users SET username ='" .$pusername ."', password ='" .$password ."'");
    $_SESSION['msg'][] = "Bravo tu as cree un compte, maintenant logue toi !";
    header('Location: login.php');
    exit();
}
?>

<?php require_once('required/header.php'); ?>
		<div class="containermiddle">
        <?php require_once('required/msg.php'); ?>
            <div class="help">
                <p>Merci de vous inscrire sur notre site.</p>
                <p>Besoin d'Assistance ?</p>
                <p>Hotline 24/24 7j/7 au +33(0)1.23.45.67.89</p>
            </div>
            <div class="coform">
                <form action="nwaccount.php" method="POST">
                <p>Identifiant:<input type="text" name="newlogin" value="" /></p>
                <p>Mot de passe: <input type="password" name="newpasswd" value="" /></p>
                <p>Mot de passe (vérification): <input type="password" name="newpasswd2" value="" /></p>
                <input type="submit" name="submit" value="OK"/>
                </form>
                <a href="login.php"><p>Vous avez deja un compte : connexion</p></a>
                <a href="modifaccount.php"><p>modifier son mot de passe</p></a>
            </div>
		</div>
<?php require_once('required/footer.php'); ?>

