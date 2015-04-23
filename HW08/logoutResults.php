<?php
    /* Unset user, desotroy previous user's session, redirect to login page */
    session_start();
    unset($_SESSION['name']);
    session_destroy();
    header("Location: credentials.php");
?>
