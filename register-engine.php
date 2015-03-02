<?php


$mysqli= new mysqli('magic.philosophy.ubc.ca', 'root', 'PhiloMagic2015!', 'whately');
// check connection 
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
                            }

if((!empty($_POST['name'])) and (!empty($_POST['e-mail'])) and (!empty($_POST['user-name2'])) and (!empty($_POST['password2'])))
{
	$name = $_POST['name']; 
    $email = $_POST['e-mail'];
    $username = $_POST['user-name2'];
    $password = $_POST['password2'];	
}	
        $name = mb_convert_encoding ( $name, "UTF-8",mb_detect_encoding($name));
		$email = mb_convert_encoding ( $email, "UTF-8",mb_detect_encoding($email));
		$username = mb_convert_encoding ( $username, "UTF-8",mb_detect_encoding($username));
		$password = mb_convert_encoding ( $password, "UTF-8",mb_detect_encoding($password));
        
		$stmt1 = $mysqli -> prepare("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
   	    $stmt1 -> execute();
		
        //Check if the email or the username already exists.
        $stmt = $mysqli -> prepare("SELECT `name` FROM `users` WHERE (`e-mail` = ?) OR (`username` = ?)");
   		$stmt -> bind_param('ss', $email, $username); 
   		$stmt -> execute();
		$stmt->bind_result($nameRe);
        /* fetch value */
        $stmt->fetch();
        
		
	
		if((empty($nameRe))){
	
           $stmt = $mysqli -> prepare("INSERT INTO `users`( `name`, `e-mail`, `username`, `password`) VALUES (?, ?, ?, ?)");
   		    $stmt -> bind_param('ssss', $name, $email, $username, $password); 
   		    $stmt -> execute();
   		    
		
            $stmt->close();
            
			$registerMessage = 1;
		    $registerMessageCookie = 'register-Message-cookie';
		    setcookie($registerMessageCookie, $registerMessage, time() + 10, '/'); 
			
			echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";
			
           
            $mysqli->close();
			
      } else {
		  
		  $registerMessage = 0;
		  $registerMessageCookie = 'register-Message-cookie';
		  setcookie($registerMessageCookie, $registerMessage, time() + 10, '/'); 
	      echo "<script>window.location.href='http://magic.philosophy.ubc.ca/argumentMapping/graph.php';</script>";
	  }
?>