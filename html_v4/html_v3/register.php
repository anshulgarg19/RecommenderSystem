<?php
	session_start();
	include_once 'dbconnect.php';

	if(isset($_POST['btn-signup']))
	{
		$email = mysql_real_escape_string($_POST['email']);
		$upass = (mysql_real_escape_string($_POST['password']));
 	     	if(mysql_query("INSERT INTO userProfile(gender,age,occupation,zipcode,emailId,password) VALUES(NULL,NULL,NULL,NULL,'$email','$upass')"))
 		{
?>
		        <script>alert('successfully registered ');</script>
<?php
			header("Location: login.php");
 		}
 		else
		{
?>
	        <script>alert('error while registering you...');</script>
<?php
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WhatToWatch: Register</title>
<link href="css/bootstrap1.min.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<!--header start -->
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

      <!-- menu items -->
      <div class="collapse navbar-collapse navbar-right">
        <ul class="nav navbar-nav">
          <li class="scroll"><a href="index.php">Home</a></li>
          <li class="scroll"><a href="login.php">Login</a></li>
          <li class="scroll"><a href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!-- header end -->

<br><br><br>


<div id="login-form">
<center>
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="password" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</center>
</div>

	<!-- footer start -->
	<div id ="footerAbsolute">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
	<!--footer end -->
</body>
</html>
