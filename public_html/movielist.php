<html>
   
   <head>
      <title>Movie List</title>
   </head>
   
   <body>
      <?php
         $dbhost = 'localhost';
         $dbuser = 'root';
         $dbpass = 'thisisubuntu';
         
         $rec_limit = 10;
         $conn = mysql_connect($dbhost, $dbuser, $dbpass);
         
         if(! $conn )
         {
            die('Could not connect: ' . mysql_error());
         }
         mysql_select_db('movieLens');
         
         /* Get total number of records */
         $sql = "SELECT count(*) FROM movieList ";
         $retval = mysql_query( $sql, $conn );
         
         if(! $retval )
         {
            die('Could not get data: ' . mysql_error());
         }
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
         $sql = "SELECT * ".
            "FROM movieList ".
            "LIMIT $offset, $rec_limit";
            
         $retval = mysql_query( $sql, $conn );
         
         if(! $retval )
         {
            die('Could not get data: ' . mysql_error());
         }
         
	?>
	<table style="width:100%; align:center ">
         <?php while($movie = mysql_fetch_array($retval, MYSQL_ASSOC))
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

	<?php
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
         
         mysql_close($conn);
      ?>
      
   
<div>    
<div style="text-align : center;bottom: 5px; width :100%;font-size : 20px">
Developed by 
<b><a href = "https://www.facebook.com/anshul.garg.52643?fref=ts">Anshul Garg</a> & 
<a href="https://www.facebook.com/pulkit.aggarwal.9?fref=ts">Pulkit Aggarwal</a></b>
</div>
</div>
   </body>
</html>
