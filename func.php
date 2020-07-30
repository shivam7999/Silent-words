<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
  include_once 'includes/dbh.inc.php';
  if(isset($_SESSION['user_uid']))
    {
      session_destroy();
      echo "<script>location.href='index.html'</script>";
    }
    else{
       echo "<script>location.href='detail.htm'</script>";
    }

?>