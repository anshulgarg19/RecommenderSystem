<?php
if(!mysql_connect('localhost',"root","thisisubuntu"))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("movieLens"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>
