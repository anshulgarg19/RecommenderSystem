<html>
	<head>
		<title>Rated Movies</title>
	</head>
	<body>
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
<div style=" text-align : center;bottom: 5px; width :100%;font-size : 20px">
Developed by
<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
</div>
</div>

</body>
</html>

