<?php

 $server = "localhost";
 $user = "organize_usr1";
 $dbName = "organize_booking"; 
 $pass = "usr@123";
	
	$link = mysqli_connect($server, $user, $pass, $dbName);
		if(!$link)
			die("Error connecting database"); 

		// NOTE :: Redirect to the error page if connection not successful!
		




?>