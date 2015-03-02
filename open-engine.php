<?php

if((isset($_COOKIE['log-id-cookie'])) && $_COOKIE['log-statue-cookie'] == 1) {
   
       $id = $_COOKIE['log-id-cookie'];
		 
      
       $connect=mysql_connect("magic.philosophy.ubc.ca", "root", "PhiloMagic2015!") or die(mysql_error());
       
	   mysql_select_db("whately", $connect) or die(mysql_error());

       // check connection 
       if (mysqli_connect_errno()) {
       printf("Connect failed: %s\n", mysqli_connect_error());
       exit();
                            }
							
	  
	  $qu = "SET NAMES 'utf8'";
	  
	  mysql_query($qu, $connect);
	  
	  $query = "SELECT `graph`, `title` FROM `graph` WHERE (`id`='$id')";
	  
	  
	  $result = mysql_query($query, $connect);
       
	  
	
	while($row = mysql_fetch_array($result))
    {
	
	$var[] = $row;
	
}

echo '{"graphs":'.json_encode($var).'}';

    
   
   } 

?>