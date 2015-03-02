<?php
  
   
   if((isset($_COOKIE['log-id-cookie'])) && $_COOKIE['log-statue-cookie'] == 1) {
       
        $id = $_COOKIE['log-id-cookie'];
        $jGraph = $_POST['graph'];  
        $title = $_POST['title'];
        $count = $_POST['count'];		

		 
		
        $id = mb_convert_encoding ( $id, "UTF-8",mb_detect_encoding($id));
		$jGraph = mb_convert_encoding ( $jGraph, "UTF-8",mb_detect_encoding($jGraph));
		$title = mb_convert_encoding ( $title, "UTF-8",mb_detect_encoding($title));		
	   
	   $mysqli= new mysqli('magic.philosophy.ubc.ca', 'root', 'PhiloMagic2015!', 'whately');
       
       // check connection 
       if (mysqli_connect_errno()) {
           printf("Connect failed: %s\n", mysqli_connect_error());
           exit();
       }
		
       $stmt1 = $mysqli -> prepare("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
   	   $stmt1 -> execute();		
		
	   
	   $stmt = $mysqli -> prepare("UPDATE `graph` SET `id`=?,`graph`=? WHERE `title`=?");
   	   $stmt -> bind_param('sss', $id, $jGraph, $title); 
   	   $stmt -> execute();
   	   
       $stmt->close();
	   
	    setcookie('saved-graph-cookie', $count); 
		
       echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";	
       
   } 
	   
	   
   
?>