<?php
session_start();

if(!isset($_SESSION['userProfile']))
{
 header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
 session_destroy();
 unset( $_SESSION['user']);
 header("Location: index.php");
}

/*if(isset($_GET['logout']))
{
 session_destroy();
// unset($_SESSION['userProfile']);
 unset($_SESSION['user']);	
 header("Location: index.php");
}*/
?>
