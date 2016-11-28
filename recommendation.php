<?php
session_start();
include_once 'dbconnect.php';
$userid = $_SESSION['user'];
$query = array();
$totalMovies = 1000;
$query = mysql_query("SELECT movieId,rating from ratingDetails where userId = '$userid' and movieId <= '$totalMovies'");

 $i = 0;
 $res = array();
        while($row = mysql_fetch_assoc($query) )
        {
                $res[$i]['movieId'] = $row['movieId'];
                $res[$i]['rating'] = $row['rating'];
                $i++;
        }

$result = array();

if( $i == 0 )	//for a new registered user
{
	$q = mysql_query("SELECT movieTitle from movieProfile order by year DESC LIMIT 10");
	$i;
	while( $line = mysql_fetch_assoc( $q ))
	{
		$result[$i] = $line['movieTitle'];
		$i++;
	}
}
else	// for existing user
{	

	//optimized query
//	$q = mysql_query("select m.movieId as movieId,m.movieTitle as movieTitle from ratingDetails as r right outer join movieProfile as m on r.movieId = m.movieId where r.movieId is NULL and r.userId = '$userid' and m.movieId <= '$totalMovies';");
	$q = mysql_query("SELECT movieId,movieTitle from movieProfile where  movieId <= '$totalMovies' and movieId not in('SELECT movieId from ratingDetails where userId = \'$userid\' and movieId <= \'$totalMovies\'')");//list of movies not watched by that user
	
//	echo count($q);
	$i = 0;
	$col = array();	//stores movies not seen
	
	while($row = mysql_fetch_assoc($q))
	{
		$col[$i]['movieId'] = $row['movieId'];
		$col[$i]['movieTitle'] = $row['movieTitle'];
		$i++;
	}

//	echo count($col);	
	$weighted_average_array = array();
	
	for($i=0;$i < sizeof($col);$i++)
	{
		$final_score = 0;
		$total_similiarity = 0;
	
		
		for($j=0;$j < sizeof($res);$j++)
		{
			$mId1 = $col[$i]['movieId'];
			$mId2 = $res[$j]['movieId'];
			$score_query = mysql_query("SELECT score from similarityDetails where (mId1 = '$mId1' and mId2 = '$mId2') or (mId1 = '$mId2' and mId2 = '$mId1')");
		//	$score = mysql_query("SELECT score from similarityDetails where (mId1 = '$col[$i][\'movieId\']' and mId2 = '$res[$j]['movieId']\') or (mId1 = \'$res[$j]['movieId']\' and mId2 = \'$col[$i]['movieId']\')");

			$sq = mysql_fetch_array($score_query, MYSQL_NUM );
			$score = $sq[0];
			$final_score += $score*$res[$j]['rating'];
			$total_similarity += $score;
		}
	
		$final_score /= $total_similarity;
		//$weighted_average_array[$col[$i]['movieTitle']] = $final_score;
		$weighted_average_array[$col[$i]['movieId']] = $final_score;
	}
	
	array_multisort($weighted_average_array,SORT_DESC);
	
	$result = array_keys($weighted_average_array);
	$result = array_slice($result,0,20);

	$result = implode(",",$result);
	$query_movieDetails = mysql_query("select * from movieList where movieId in ($result);");
	$movieDetails = array(); //final movieDetails are stored

	$i = 0;
	while( $line = mysql_fetch_assoc($query_movieDetails) )
	{
		$movieDetails[$i]['movieTitle'] = $line['title'];
		$movieDetails[$i]['year'] = $line['year'];
		$movieDetails[$i]['plot'] = $line['plot'];
		$movieDetails[$i]['runtime'] = $line['runtime'];
		$movieDetails[$i]['director']= $line['director'];
		$movieDetails[$i]['posterUrl'] = $line['posterUrl'];
		$i++;
	}
//	echo sizeof($result);
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
          <li class="scroll"><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!--/header-->


Your Recommendations:

<table style="width:100%">
	<?php	
	foreach($movieDetails as $movie)
	{
		?>
		<tr>
		<td><img src="<?php if( is_null($movie['posterUrl'])) echo "./hollywood.gif"; else echo $movie['posterUrl']; ?>" height="120" width="100"</td>
		<td>
			Title: <?php echo $movie['movieTitle'];?><br/>
			Runtime: <?php echo $movie['runtime'];?><br/>
			Director: <?php echo $movie['director'];?><br/>
			Plot: <?php echo $movie['plot'];?> <br/>
		</td>	
		</tr>
		<?php } ?>
</table>

<br><br><br>
<div>    
	<div style=" background-color : black;position : absolute;bottom: 0; width :100%;height:30px;font-size : 20px">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
</div>
</body>
</html>
