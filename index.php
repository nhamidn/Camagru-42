<?php
	session_start();
	if (!empty($_SESSION[username]))
		header('Location: /explorer/posts.php');
	else if ($_SESSION[username])
		
?>
