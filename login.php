
<?php
session_start();
include_once 'dbconnect.php';

/*if(isset($_SESSION['user'])!="")
{
 header("Location: index.php");
}*/
if(isset($_POST['btn-login']))
{
 $email = mysql_real_escape_string($_POST['email']);
 $upass = mysql_real_escape_string($_POST['pass']);
 $res=mysql_query("SELECT * FROM userProfile WHERE emailId='$email'");
 $row=mysql_fetch_array($res);
 if($row['password']==($upass))
 {
  $_SESSION['user'] = $row['userId'];
  header("Location: recommendation.php");
//  header("Location: movieRated.php");	
 }
 else
 {
  ?>
        <script>alert('wrong details');</script>
        <?php
 }
 
}
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
          <li class="scroll"><a href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!--/header-->

<br><br>

<div id="login-form">
<center>
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>
</center>
</div>


<div>    
	<div style=" background-color : black;position : absolute;bottom: 0; width :100%;height:30px;font-size : 20px">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
</div>
</body>
</html>
