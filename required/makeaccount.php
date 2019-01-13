<?php
    if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['newuserid']))
     {
         $_SESSION['msg'][] = "Merci de n'utiliser que des chiffres et des lettres dans le login.";
         header('Location: manager.php');
         exit();
     }
     if (strlen($_POST['newuserpasswd']) < 4 || strlen($_POST['newuserpasswd']) > 15)
     {
         $_SESSION['msg'][] = "Le mot de passe doit etre entre 5 et 15 caracteres";
         header('Location: manager.php');
         exit();
     }
     if (strlen($_POST['newuserid']) < 3 || strlen($_POST['newuserpasswd']) > 35)
     {
         $_SESSION['msg'][] = "Le login doit etre entre 4 et 35 caracteres";
         header('Location: manager.php');
         exit();
     }

     require_once 'required/database.php';
     $pusername = mysqli_real_escape_string($mysqli, $_POST['newuserid']);
     $req = mysqli_query($mysqli, "SELECT id FROM users WHERE username='" .$pusername ."'");
     $user = mysqli_fetch_assoc($req);
     if($user)
     {
         $_SESSION['msg'][] = "Ce pseudo existe déjà.";
         header('Location: manager.php');
         exit();
     }
     require_once 'required/database.php';
     $password = hash('whirlpool', $_POST['newuserpasswd']."jesuisunecledekryptageyoloetjaimeleslikornes");
     $password = mysqli_real_escape_string($mysqli, $password);
     $req = mysqli_query($mysqli, "INSERT INTO users SET username ='" .$pusername ."', password ='" .$password ."'");
     $_SESSION['msg'][] = "Le compte a bien etait créé";
     header('Location: manager.php');
     exit();
?>
