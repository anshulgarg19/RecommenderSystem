<!DOCTYPE html>
<html>
<head>
  <title>WhatToWatch</title>
  <!-- core CSS -->
  <link href="css/bootstrap1.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
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
		  <li class="scroll"><a href="recommendation.php">Recommendations</a></li>
          <li class="scroll"><a href="logout.php">Login</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!--/header-->

<?php
	session_start();
	include_once 'dbconnect.php';
	$userId = $_SESSION['user'];
	$totalMovies = 1000;
	
	$query_ratedIds = mysql_query("select movieId from ratingDetails where userId = '$userId' and movieId <= '$totalMovies' limit 10;");
	$ratedIds = array();
	$i = 0;
	while( $line = mysql_fetch_assoc($query_ratedIds))
	{
		$ratedIds[$i] = $line['movieId'];
		$i++;
	}
	$ratedIds = implode(",",$ratedIds);
	
	$query_movieDetails = mysql_query("select * from movieList where movieId in ($ratedIds);");

	?>	
	 <table style="width:100%; align:center ">
         <?php while($movie = mysql_fetch_array($query_movieDetails, MYSQL_ASSOC))
         { ?>
        <tr>
        <td><img src="<?php if( is_null($movie['posterUrl'])) echo "./hollywood.gif"; else echo $movie['posterUrl']; ?>" height="120" width="100"</td>
        <td>
                        Title: <?php echo $movie['title'];?><br/>
                        Runtime: <?php echo $movie['runtime'];?><br/>
                        Director: <?php echo $movie['director'];?><br/>
                        Plot: <?php echo $movie['plot'];?> <br/><br/><br/>
        </td>
        </tr>
        <?php } ?>
        </table>

<div>    
	<div style=" background-color : black;position : absolute;bottom: 0; width :100%;height:30px;font-size : 20px">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
</div>

</body>
</html>

