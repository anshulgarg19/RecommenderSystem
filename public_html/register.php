<?php
session_start();
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
 $email = mysql_real_escape_string($_POST['email']);
// echo $email;	
 /*if( !$email){
    die(mysql_error());
 }*/
 //die(mysql_error()) ;
 $upass = (mysql_real_escape_string($_POST['password']));
/* if( !$upass ){
  die(mysql_error());
} */
 
 /*if( mysql_query("SELECT * FROM userProfile where emailId = '$email'"))  
 {
  ?>
	<script>alert('email id already registered');</script>	
	<?php
 }
 else*/ if(mysql_query("INSERT INTO userProfile(gender,age,occupation,zipcode,emailId,password) VALUES(NULL,NULL,NULL,NULL,'$email','$upass')"))

  //if( mysql_query("INSERT INTO temp(email,password) VALUES('$email','$upass')") === TRUE)	
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
<title>Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
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
</div>
</center>

<div>    
<div style=" position : fixed;text-align : center;bottom: 5px; width :100%;font-size : 20px">
Developed by 
<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
</div>
</div>
</body>
</html>
