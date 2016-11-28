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


<!DOCTYPE html>
<html>
<head>
  <title>WhatToWatch</title>
  <!-- core CSS -->
  <link href="css/bootstrap1.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>

<header id="header">
  <nav id="main-nav" class="navbar navbar-default navbar-fixed-top" role="banner">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><span style="font-size: 35px;color: #FFF;line-height: 1em;font-weight: bold;">WhatToWatch</span></a>
      </div>

      <div class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav">
          <li class="scroll"><a href="index.php">Home</a></li>
          <li class="scroll"><a href="movielist.php">Movie List</a></li>
          <li class="scroll"><a href="login.php">Login</a></li>
		  <li class="scroll"><a href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!--/header-->
<H2> You're sucessfully logged out.</H2>
<div>    
	<div style=" background-color : black;position : fixed;text-align : center;bottom: 5px; width :100%;font-size : 20px">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
</div>
</body>
</html>