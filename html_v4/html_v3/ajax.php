<?php
//require_once 'settings.ini';
	include_once 'dbconnect.php';
	session_start();

//    if($_POST['act'] == 'rate'){
    	//search if the user(ip) has already gave a note
    	
    //	$therate = $_POST['rate'];
//	echo '1';
    	$userId = $_GET['userId'];
	$rowNum = $_GET['movieId'];
	$rating = $_GET['rating'];
	$totalMovies = 1000;

	$q = mysql_query("SELECT movieId from movieList where  movieId <= '$totalMovies' and movieId not in(SELECT movieId from ratingDetails where userId = '$userId' and movieId <= '$totalMovies') limit 20");

	$i = 1;
	while($row = mysql_fetch_assoc($q))
	{
		if( $i == $rowNum){
			$movieId = $row['movieId'];
			break;
		}
		$i++;
	}
	//$movieId = $row['movieId'];
	
//	echo $movieId;
    	$query = mysql_query("insert into ratingDetails(userId,movieId,rating,created) values('$userId','$movieId','$rating','') "); 
//	echo '3';
	header( "Location: /ratingInput.php");
//	echo '4';	
/*    	while($data = mysql_fetch_assoc($query)){
    		$rate_db[] = $data;
    	}

    	if(@count($rate_db) == 0 ){
    		mysql_query("INSERT INTO wcd_rate (id_post, ip, rate)VALUES('$thepost', '$ip', '$therate')");
    	}else{
    		mysql_query("UPDATE wcd_rate SET rate= '$therate' WHERE ip = '$ip'");
    	}*/
  //  } 
?>
