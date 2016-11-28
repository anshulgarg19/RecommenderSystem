<!DOCTYPE html>
<html>
<head>
  <title>WhatToWatch</title>
  <!-- core CSS -->
  <link href="css/bootstrap1.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
</head>

<body>

<!-- header start -->
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

      <!--menu items -->	
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
<!--/header end -->

      <!--pagenation start-->

      <?php
         include_once 'dbconnect.php';
         
         /* Get total number of records */
         $sql = "SELECT count(*) FROM movieList; ";
	 $rec_limit = 10;
         $retval = mysql_query( $sql );
         if(! $retval )
            die('Could not get data: ' . mysql_error());
         
         $row = mysql_fetch_array($retval, MYSQL_NUM );
         $rec_count = $row[0];
         
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

         $left_rec = $rec_count - ($page * $rec_limit);
         $sql = "SELECT * FROM movieList LIMIT $offset, $rec_limit";            
         $retval = mysql_query( $sql );
         
         if(! $retval )         
            die('Could not get data: ' . mysql_error());
       
         
      ?>

      	 <?php while($movie = mysql_fetch_array($retval, MYSQL_ASSOC))
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

	<?php }
	if( $left_rec < $rec_limit )
	{
	    $last = $page - 2;
	    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a><br/>";
	}
        else if( $page > 0 )
	{	
            $last = $page - 2;
	    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
            echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a><br/>";
        }
        else if( $page == 0 )
        {
	    echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a><br/>";
	}	
        	   
      	?>
      
	<!--footer start -->
	<div id ="footerRelative">
		Developed by 
			<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
			<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
	</div>
	<!-- footer end -->

</body>
</html>
