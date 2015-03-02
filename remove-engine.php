<?php

if((isset($_COOKIE['log-id-cookie'])) && $_COOKIE['log-statue-cookie'] == 1) {
   
       $id = $_COOKIE['log-id-cookie'];
	   $title = $_POST['title-remove'];
	   $connect=mysql_connect("magic.philosophy.ubc.ca", "root", "PhiloMagic2015!") or die(mysql_error());
       mysql_select_db("whately", $connect) or die(mysql_error());

       // check connection 
       if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
                            }
							
	  
	  $qu = "SET NAMES 'utf8'";
	  
	  mysql_query($qu, $connect);
	  
	  //$query = "SELECT `graph`, `title` FROM `graph` WHERE (`id`='$id')";
	  $query = "DELETE FROM `graph` WHERE `id`='$id' AND `title`='$title'";
	  
	  mysql_query($query, $connect);
	  
	  
	  
	  setcookie('remove-graph-cookie', 1, time() + 10, '/'); 
	  
      echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";
    
   
   
   } 


?>