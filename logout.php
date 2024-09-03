<?php
	include "includes/functions.php";
    unset($_SESSION['user']);
	session_destroy();
	header("location: index.php");
?>