<?php 

  include_once 'db.php';
  $user_id = $_GET['id'];
  
  $post_sql = "DELETE FROM adopt_pets WHERE id=$user_id";
  $post_qs = mysqli_query( $con, $post_sql );
  if( $post_qs ) {
    header( 'location:adopting-ads.php' );
  }

?>