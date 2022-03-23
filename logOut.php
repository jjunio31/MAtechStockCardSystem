<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["pword"]);
header("Location:index.php");
?>