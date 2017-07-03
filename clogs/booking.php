<?php 

	include ('linkDB.php');
	session_start();

	$f_name = $l_name = $age = $_people = $email = $ph_number = $date_in = $date_out = $len = $_people = null;
	$error = 0;
	$booking_type = null;
	$cost = 0;
	$table_users = 'userinfo';
	$table_rafting = 'rafting_orders';
	$table_camping = 'camping_orders';
	$table_hotel = 'hotel_orders';
	$rafting = 'Rafting';
	$camping = 'Camping';
	$hotels = 'Hotels';
	$homestay = 'Homestay';
	$sightseeing = 'Sightseeing';
	$table_homestay = 'homestay_orders';
	$trekking = 'Trekking';
	$table_trekking = 'trekking_orders';
	$table_sightseeing = 'sightseeing_orders';
	$site_str = "";
	$success_flag = false;

	$cat = ['rafting', 'trekking', 'camping']; // more to come!
	
	if (isset($_POST['first_name'])){
		$f_name = $_POST['first_name'];
		$_SESSION['f_name'] = $f_name;
	}
	else 
		$error = 1;

	if (isset($_POST['last_name'])){
		$l_name = $_POST['last_name'];
		$_SESSION['last_name'] = $l_name;
	}
	else
		$error = 2;

	if (isset($_POST['email'])){
		$email = $_POST['email'];
		$_SESSION['email'] = $email;
	}
	else
		$error = 3;
	
	if (isset($_POST['ph_number'])){
		$ph_number = $_POST['ph_number'];
		$_SESSION['ph_number'] = $ph_number;
	}
	else
		$error = 4;

	if (isset($_POST['age'])){
		$age = $_POST['age'];
		$_SESSION['age'] = $age;
	}
	else
		$error = 4;
	
	if (isset($_POST['booking_type'])){
		$booking_type = $_POST['booking_type'];
		$_SESSION['booking_type'] = $booking_type;
	}
	else
		$error = 6;
	
	if (isset($_POST['total_cost'])){
		$cost = $_POST['total_cost'];
		$_SESSION['cost'] = $cost;
	}
	else
		$error = 7;

	if (isset($_POST['trip_people'])){
		$_people = $_POST['trip_people'];
		$_SESSION['trip_people'] = $_people;
	}
	else
		$error = 7;

	if ($booking_type == $rafting){

		if (isset($_POST['trip_date_arr']))
			$date_in = $_POST['trip_date_arr'];
		else
			$error = 8;
		
		if (isset($_POST['trip_stretch']))
			$len = $_POST['trip_stretch'];
		else
			$error = 9;
	}

	elseif ($booking_type == $camping || $booking_type == $hotels) {
	
		if (isset($_POST['trip_date_arr']))
			$date_in = $_POST['trip_date_arr'];

		if (isset($_POST['trip_date_dpr']))
			$date_out = $_POST['trip_date_dpr'];

	}

	elseif ($booking_type == $trekking) {

	}

	elseif ($booking_type == $sightseeing) {

		if (isset($_POST['trip_sites']))
			$site_str = $_POST['trip_sites'];
  		

  		if (isset($_POST['trip_date_arr']))
			$date_in = $_POST['trip_date_arr'];


  }

  elseif ($booking_type == $homestay) {
  		if (isset($_POST['trip_date_arr']))
			$date_in = $_POST['trip_date_arr'];

		if (isset($_POST['trip_date_dpr']))
			$date_out = $_POST['trip_date_dpr'];

  }

	
		$query = "INSERT INTO  $table_users (first_name, last_name,age,ph_number,email,trip_type) 
		VALUES ('$f_name', '$l_name', '$age', '$ph_number', '$email', '$booking_type')";

		if (mysqli_query($link, $query)){
			//echo "Saved Successfully";

			$sql_query = "SELECT id from userinfo where first_name = '$f_name' AND ph_number = '$ph_number' ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($link, $sql_query);

			if ($result){
				
				$user_id = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$user_id_ = $user_id['id'];
				$_SESSION['user_id'] = $user_id_;

				if ($booking_type == $rafting) {

					$sql_query_2 = "INSERT INTO $table_rafting (user_id,trip_date_arr, trip_stretch, trip_people, trip_total_cost ) 
					VALUES ('$user_id_', '$date_in', '$len','$_people', '$cost')";

					if (mysqli_query($link, $sql_query_2))
						$success_flag = true;
					

						/*NOTE: Redirect the user to payment portal! */
					else
						die(mysqli_error($link));
				}

				elseif ($booking_type == $camping || $booking_type == $hotels) {

					if ($booking_type == $camping)
						$table_name = $table_camping;
					else
						$table_name = $table_hotel;

					$sql_query_2 = "INSERT INTO $table_name (user_id,trip_date_arr, trip_date_dpr, trip_people, trip_total_cost ) 
					VALUES ('$user_id_', '$date_in', '$date_out','$_people', '$cost')";

					if (mysqli_query($link, $sql_query_2))
						$success_flag = true;
					

						/*NOTE: Redirect the user to payment portal! */
					else
						die(mysqli_error($link));

				}

				elseif ($booking_type == $sightseeing) {
					$query = "INSERT INTO $table_sightseeing (user_id, trip_date_arr, trip_sites, trip_groups) 
					VALUES ('$user_id_','$date_in','$site_str','$_people')";

					if (mysqli_query($link, $query)) {
						$success_flag = true;
					}
					else
						die(mysqli_error($link));	
				}

				elseif ($booking_type == $homestay) {

					$query = "INSERT INTO $table_homestay (user_id, trip_date_arr, trip_date_dpr, trip_rooms) 
						VALUES ('$user_id_','$date_in','$date_out','$_people')";
						/*
						   ===============================================================
						   ===============================================================
						   || note:: here '$people' means #rooms demanded by the user!! ||
						   ===============================================================
						   ===============================================================
						*/

					if (mysqli_query($link, $query)) 
						$success_flag = true;
					else
						die(mysqli_error($link));	



				}

			}
			else
				echo "No Result";
			// NOTE:: Redirect to the error page if data not saved successfully!

		}
		else
			echo "Could not save data!".mysqli_error($link);
		// NOTE:: Redirect to the error page if data not saved successfully!


	if ($success_flag){
		
		header('location: finalform.php');
		die('successfully redirected!');
	}


	/*
		Database connection CLOSED!
	*/
	mysqli_close($link);


	?>