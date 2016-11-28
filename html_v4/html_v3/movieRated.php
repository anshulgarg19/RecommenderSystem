<!DOCTYPE html>
<html>
<head>
  <title>WhatToWatch</title>
  <!-- core CSS -->
  <link href="css/bootstrap1.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
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
          <li class="scroll"><a href="ratingInput.php">Rate More</a></li>
	  <li class="scroll"><a href="recommendation.php">Recommendations</a></li>
          <li class="scroll"><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    <!--/.container-->
  </nav>
  <!--/nav-->
</header>
<!--header end-->

<?php
	session_start();
	include_once 'dbconnect.php';
	$userId = $_SESSION['user'];
	$totalMovies = 1000;

	/*fetch details of movies rated by user*/
	$query_ratedIds = mysql_query("select movieId,rating from ratingDetails where userId = '$userId' and movieId <= '$totalMovies';");
	$ratedIds = array();
	
	$mappedRatings = array();

	$i = 0;
	while( $line = mysql_fetch_assoc($query_ratedIds))
	{
		$ratedIds[$i] = $line['movieId'];
		$mappedRatings[$line['movieId']] = $line['rating'];
		$i++;
	}

	$movieCount = count($ratedIds);
     	if( $movieCount > 0 ){
	 $ratedIds = implode(",",$ratedIds);

	 $sql = "Select count(*) from movieList where movieId in ($ratedIds)";
	 $query_movieCount = mysql_query($sql);
	 $row = mysql_fetch_array( $query_movieCount);
	 $movieCount = $row[0];
		
	 $rec_limit = 10;
         $rec_count = $movieCount;
         if( isset($_GET{'page'} ) )
         {
            $page = $_GET{'page'} + 1;
            $offset = $rec_limit * $page ;
         }
         else
         {
            $page = 0;
            $offset = 0;
         }

         $left_rec = $rec_count - (($page + 1) * $rec_limit);
	 
         $sql = "SELECT * FROM movieList where movieId in ($ratedIds) LIMIT $offset, $rec_limit;";
         $query_movieDetails = mysql_query( $sql );
         if(! $query_movieDetails )
            die('Could not get data: ' . mysql_error());


	?>	

	<!-- display movies in tabular form -->
	<?php while($movie = mysql_fetch_array($query_movieDetails, MYSQL_ASSOC))
              { ?>
		<div class="well well-small">
		<article>
			<header>
				<h4> <?php echo $movie['title']?> </h4> 
			</header>

		   <div>
			 <div class="row-fluid">
			 <div class="span12">
				<div class="span2">
					<img src="<?php if( is_null($movie['posterUrl'])) echo "./hollywood.gif"; else echo $movie['posterUrl']; ?> " height = "113" width = "150" class="img-polaroid poster">
				</div>
				<div class="span8">
				    <div class="row-fluid">
						<div class="span2">
						   <strong> Director: </strong>
						</div>
						<div class="span10">
							<?php echo $movie['director']?>
						</div>
					</div>

					<div class="row-fluid">
						<div class="span2">
							<strong>My Rating: </strong>
						</div>
						<div class="span10">
							<?php echo $mappedRatings[$movie['movieId']]; ?>
						</div>
					</div>

					<div class="row-fluid">
						<div class="span2">
							<strong> Runtime:</strong>
						</div>
						<div class="span10">
							<?php echo $movie['runtime'] ?>
						</div>
					 </div>

					<div class="row-fluid">
						<div class="span2">
						   <strong>  Plot:</strong>
						</div>
						<div class="span10">
							<?php echo $movie['plot'] ?>
						</div>
					</div>
				</div>
			</div>
		  	</div> <!-- extra movie data div -->
		</div>
		</article>
		</div>

	        <?php 	} 

	}
	else echo 'Please rate movies first.';

	//pagenation code continued
	if( $left_rec > 0 ){
		if( $page > 0 )
                {
                    $last = $page - 2;
                    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
                    echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a><br/>";
                }
                else if( $page == 0 )
                {
                    echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a><br/>";
                }
                else if( $left_rec < $rec_limit )
                {
                    $last = $page - 2;
                    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a><br/>";
                }
	}
	else
	{
		$last = $page -2;
		echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a><br/>";
	}
	?>
        
    
	<!-- footer start -->
	<div id="footerRelative">
	Developed by 
		<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
		<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
	<!-- footer end -->
</body>
</html>

