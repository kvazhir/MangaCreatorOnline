<?php 
include '/include/include.all';
// function fetch_array($query){
//   $arr = [];
//   while($row = mysql_fetch($query)){
//    $arr[] = $row;
//   }
//   return $arr;
//  }
$mysql = mysql::get_instance();
 $user_movies = $mysql->fetch_array();
$sql = 'select * from user_movie where user="'.$_GET['user'].'"'; 
$query=mysql_query($sql);
 foreach($user_movies as $movie){
$sql2 = 'select * from movies where id=$movie['id']';
$query2 = mysql_query($sql);
while($d = mysql_fetch_array($query2)){
echo $d['name'];
} 
}  
?>