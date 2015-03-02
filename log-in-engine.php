<?php
    
	$connect=mysql_connect("magic.philosophy.ubc.ca", "root", "PhiloMagic2015!") or die(mysql_error());
    
    mysql_select_db("whately", $connect) or die(mysql_error());

    // check connection 
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }


    if((!empty($_POST['email-login'])) and (!empty($_POST['password1'])))
    {
        $email = $_POST['email-login'];
        $password = $_POST['password1'];	
		
        }

    $email = mb_convert_encoding ( $email, "UTF-8",mb_detect_encoding($email));
    $password = mb_convert_encoding ( $password, "UTF-8",mb_detect_encoding($password));	
	
	$query1 = "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'";
   	mysql_query($query1, $connect);

    $query = "SELECT `id`, `username` FROM `users` WHERE (`e-mail` = '$email') AND (`password` = '$password')";
   

    $result = mysql_query($query, $connect);
    $row = mysql_fetch_array($result);

    $log = 0;  

    if (!empty($row['id']))
    {
        $id = $row['id'];
	    $username = $row['username'];
	    $log = 1;
		
		$logIdCookie = 'log-id-cookie';
		$logInCookie = 'log-in-cookie';
		$logStatueCookie = 'log-statue-cookie';
		
        setcookie($logIdCookie , $id);     
        setcookie($logInCookie , $username); 
        setcookie($logStatueCookie , $log);
		
		
        echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";  
    }
    else
    {
		
		
       
        $log = 0;
	    $logStatueCookie = 'log-statue-cookie';
        setcookie($logStatueCookie, $log, time() + 10, '/'); 
		$logInError = 1;
		$logInErrorCookie = 'log-in-error-cookie';
		setcookie($logInErrorCookie, $logInError, time() + 10, '/'); 
		
		echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";
    }

  
?>