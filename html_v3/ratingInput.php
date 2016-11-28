<!DOCTYPE html>
<html>
    <head>
        <title>WhatToWatch</title>
	<link href="css/bootstrap1.min.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css2/stylerating.css">
        <link type="text/css" rel="stylesheet" href="css2/example.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
           
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
			  <li class="scroll"><a href="#home">Home</a></li>
			  <li class="scroll"><a href="recommendation.php">My Recommendations</a></li>
			  <li class="scroll"><a href="movieRated.php">My Ratings</a></li>
			  <li class="scroll"><a href="logout.php">Logout</a></li>
			</ul>
		  </div>
		</div>
		<!--/.container-->
	  </nav>
	  <!--/nav-->
	</header>
	
	
    <?php  
		session_start();
		include_once 'dbconnect.php';
		$totalMovies = 1000;
		$userid = $_SESSION['user'];
		$q = mysql_query("(SELECT posterUrl,title,movieId from movieList where  movieId <= '$totalMovies' and movieId not in(SELECT movieId from ratingDetails where userId = '$userid' and movieId <= '$totalMovies'))");
		
//		$q = mysql_query("select posterUrl,title,movieId from movieList where movieId < 1000 limit 20;")		
		?> 
		<div class="pageDiv" >
		<table style="width:100%; align:center ">
		<?php $i=1; 
		      $movieIds = array();
		      while($row = mysql_fetch_assoc($q))
		{ 
			$movieIds[$i] = $row['movieId'];
		//	echo $row['movieId']." ";
		?>
		
		<tr style="margin-bottom:10px;">
		<td><img src="<?php   if( is_null($row['posterUrl'])) echo "./hollywood.gif"; else echo $row['posterUrl']; ?>" height="120" width="100"</td>
	        <td>
                        
			<b>Title: <?php echo $row['title'];?></b><br/>

			<div  id="<?php echo $i; ?>" class="rate-ex2-cnt">
	
			<?php $star1 = "rate-btn-1".(string)$i." rate-btn";
			      $star2 = "rate-btn-2".(string)$i." rate-btn"; 
			      $star3 = "rate-btn-3".(string)$i." rate-btn"; 
                              $star4 = "rate-btn-4".(string)$i." rate-btn"; 
			      $star5 = "rate-btn-5".(string)$i." rate-btn";  
			      $id1 = (string)$i."1";
				$id2 = (string)$i."2"; 
				$id3 = (string)$i."3"; 
				$id4 = (string)$i."4"; 
				$id5 = (string)$i."5"; 	?>
                        <div id="<?php echo $id1; ?>" class= "<?php echo $star1; ?>" ></div>
                        <div id=" <?php echo $id2; ?>" class= "<?php echo $star2; ?>" ></div>
                        <div id= "<?php echo $id3; ?>" class= "<?php echo $star3; ?>" ></div>
                        <div id="<?php echo $id4; ?>" class=" <?php echo $star4; ?>" ></div>
                        <div id="<?php echo $id5; ?>" class=" <?php echo $star5; ?>" ></div>
                	</div>
	<br/>
	</td>
    	</tr>
        <?php 
		$i++;
	}
	      
        ?>
        </table>
	</div>

<script>
        // rating script
        $(function(){
	    $('.pageDiv').hover(
		function(){
			var temp = ($this).attr('id');
			window.alert('a');
			for(var i=5; i>0;i--)
			{
				$('.rate-btn-'+i.toString()+temp.toString()).removeClass('rate-btn-hover');
				$('.rate-btn-'+i.toString()+temp.toString()).addClass('rate-btn');
			};
//			$('rate-btn').addClass('rate-btn-hover');
		}
		);	
 
            $('.rate-btn').hover(function(){
                $('.rate-btn').removeClass('rate-btn-hover');
                var therate = $(this).attr('id');
		var starNum = therate % 10;
		
		var rowNum = (therate -starNum)/10;
		
                for (var i = starNum ; i > 0; i--) {
                    $('.rate-btn-'+i.toString()+rowNum.toString()).addClass('rate-btn-hover');
                }; /*}, function(){
		var therate = $(this).attr('id');
		for( var i= therate;i>=0 ;i--){
			$('.rate-btn-'+i).removeClass('rate-btn-hover');
		};
		$('.rate-btn').addClass('rate-btn-hover');*/
            });
                            
            $('.rate-btn').click(function(){    
                var therate = $(this).attr('id');
		var starNum = therate % 10;
		var rowNum = (therate - starNum )/10;
		
		window.location.href = "ajax.php?movieId=" + rowNum+"&userId="+<?php echo $userid ?>+"&rating="+starNum; 
                var dataRate = 'act=rate&user_id=<?php echo $userid; ?>&movieId=<?php echo $movieIds[$_GET['index']];?>&rate='+starNum; //
                $('.rate-btn').removeClass('rate-btn-active');
                for (var i = starNum; i > 0; i--) {
                    $('.rate-btn-'+i.toString()+rowNum.toString()).addClass('rate-btn-active');
                };
                $.ajax({
                    type : "POST",
                    url : "ajax.php",
                    data: dataRate,
                    success:function(){}
                });
                
            });
        });
    </script>


</body>
</html>
