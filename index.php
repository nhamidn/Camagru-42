<?php
	session_start();
	if (!empty($_SESSION[username]))
		header('Location: /explorer/posts.php');
	include_once "views/header.php";
?>
