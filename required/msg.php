<?php
    if(session_status() == PHP_SESSION_NONE){ session_start(); }

    if($_SESSION['msg'] != NULL)
    {
        foreach($_SESSION['msg'] as $value)
        {
            echo '<div class="msgdiv"><p class="msg">'.$value.'</p></div>';
        }
        unset($_SESSION['msg']);
    }
?>
