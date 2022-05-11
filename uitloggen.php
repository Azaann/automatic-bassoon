<?php
//logout funtie
session_start();

$_SESSION = ['emailadres'];
$_SESSION = ['id'];

session_destroy();

header('location:index.php');

exit;

?>