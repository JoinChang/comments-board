<?php
    session_start();
    if ($_POST['yzm'] != $_SESSION['code']) {
        echo 1;
    } else {
        echo 0;
    }
?>