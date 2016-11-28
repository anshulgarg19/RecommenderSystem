<?php
	session_start();
	//include_once 'dbconnect.php';
    require_once "general.php";
	
    $userid = 6041;
	if(isset($_SESSION['user'])
	{
		$userid = $_SESSION['user'];
	}
	

    if (empty($_REQUEST['p']) or empty($_REQUEST['ppage']))
        exit;

    $page = $_REQUEST['p'];
    print 'hi';
    $movies_per_page = 10;//$_REQUEST['ppage'];
    $sort = $_REQUEST['sort'];
    
    if ($sort == 'year'){
        $sort_class_random = '';
        $sort_class_year = 'active';
    }else{
        $sort_class_random = 'active';
        $sort_class_year = '';
    }
    
    
    
    if (! empty($_REQUEST['search']))
	{
        $search = $_REQUEST['search'];
        $tot_movies = get_number_of_movies($search);
        $results_found_string = $tot_movies . ' results found.';
    }
	else
	{
        $search = '';
        $results_found_string = '';
        $tot_movies = get_number_of_movies('');
        
    }
    
    $no_pager = false;
    
    if (!valid_page($page, $movies_per_page, $tot_movies))
    {
        if ($search != ''){
            //page invalid because no results found
            $no_pager = true;
            
        }else{
            print 'Invalid page request: ' . $page;
            exit;
        }
    }   
    
?>


<ul class="nav nav-pills">
    <li class="disabled"><a>Sort by</a></li>
    <li><div class="btn-group" data-toggle="buttons-radio">
  <button type="button" class="btn <?php echo $sort_class_random; ?>" onclick='movies_sort_random()'>Random</button>
  <button type="button" class="btn <?php echo $sort_class_year; ?>"  onclick='movies_sort_by_year()'>Year</button>
</div></li>
  <li><div class="input-append movies_search_button">
  <input id='input_movies_search' type="text" value='<?php echo $search; ?>'>
   <button id='input_movies_search_btn' class="btn" type="button" onclick='search_movies()'>Search</button> 
    <button class="btn" type="button" onclick='clear_search()'>Clear</button>
</div></li>
    <li class="disabled"><a><?php echo $results_found_string; ?></a></li>
  
</ul>
<script>

     $(document).ready(function() {
        $("#input_movies_search").keyup(function(event){
            if(event.keyCode == 13){
                $("#input_movies_search_btn").click();
            }
        });
     });

    function movies_sort_random()
    {
        movies_sort_type = 'random';
        var rpp_movies = get_results_per_page('movieList');
        get_movies(1,rpp_movies, 'movieList');
    }
    
    function movies_sort_by_year()
    {
        movies_sort_type = 'year';
        var rpp_movies = get_results_per_page('movieList');
        get_movies(1,rpp_movies, 'movieList');
    }
    
    function search_movies()
    {
        var rpp_movies = get_results_per_page('movieList');
        get_movies(1,rpp_movies, 'movieList');
    }
    
    function clear_search()
    {
        $('#input_movies_search').val('');
        search_movies();
    }
    
</script>

<?php
    //pager begin
    if (!$no_pager)
        print_paging('movieList', $page, $movies_per_page,$tot_movies, 'movieList');
    
    $start_movie_number = ($page - 1) * $movies_per_page;
    
    /*
            Construct SQL based on received $_REQUEST parameters
    */
    if ($search != ''){
        $SQL_FILTER = "WHERE  `title` COLLATE UTF8_GENERAL_CI LIKE '%" . $search . "%' ";
    }else{
        $SQL_FILTER = 'WHERE 1';
    }
    if ($sort == 'year'){
        $SQL_SORT = " ORDER BY year DESC ";
    }else{
        $SQL_SORT = " ORDER BY RAND(1) ";
    }
    $sql = 'SELECT movieId,title,year FROM movieList ' . $SQL_FILTER . $SQL_SORT . "LIMIT ". $start_movie_number. $movies_per_page;
    
 
    $stat = prepareStatement($sql);
    $stat->execute();
    $rows = $stat->fetchAll();
    
    foreach ($rows as $row)
    {
        $movieid = $row['movieId'];
        $title = $row['title'];
        $year = $row['year'];
        
        $sql = "SELECT rating FROM ratingDetails WHERE movieId=? and userId=?";
    
        $stat = prepareStatement($sql);
        $stat->bindParam(1, $movieid);
        $stat->bindParam(2, $userid);
        $stat->execute();
        $res = $stat->fetchAll();
        
        $data = array('tab' => 'movieList');
        //$data['type'] = 'movie';
        
        if (empty($res)){
            $rating = -1;
            $data['rated']  = FALSE;
        }else{
            $data['rated'] = TRUE;
            $data['rating'] = $res[0]['rating'];
        }
        
        
        print 'hi';
        //print_movie($movieid, $title, $year, $data);
    }

    //pager end
    if (!$no_pager)
        print_paging('movies', $page, $movies_per_page,$tot_movies, 'movies');    
            
   
?>
