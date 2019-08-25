<?php

session_start();
unset($_SESSION['Firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['id']);
if (session_destroy()) {
    header("Location: index.html");
}
?>