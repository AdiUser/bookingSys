<!DOCTYPE html>
<html>
<head>
	<title>Book Now</title>
  <meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <script src= "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

<style type="text/css">
  input[type=text]:disabled+label, input[type=number]:disabled+label {
    color: rgba(18, 17, 17, 0.81);
  }

  input[type=text]:disabled, input[type=number]:disabled {
    color: rgba(0, 0, 0, 0.77);
    border-bottom: 1px dotted rgba(0,0,0,0.26);
  }

  .btn {
    background-color: green !important;
  }

</style>


</head>
<body>

<?php
  
  include('rates.php');

	$_date = $rafting_people = $rafting_strech = null;
	$date_in = $date_out =  $mode = null;
	$len = $_people = null; // denotes length for an activity and #people respectively.
  $_roomsORpeople = $t = null;
  $_days = $sites = null;


	if (isset($_POST['rafting_btn'])){

    $type = "Rafting";

		if (isset($_POST['rafting_date']))
			$_date = $_POST['rafting_date'];

		if (isset($_POST['rafting_people']))
			$_people = $_POST['rafting_people'];
		
		if (isset($_POST['rafting_strech']))
			$len = $_POST['rafting_strech'];
		

		loadRafting($type, $_date, $len, $_people, getRaftingRate($len, $_people));

	}

	elseif (isset($_POST['hotel_btn'])){

    $type = "Hotels";

		
		if (isset($_POST['hotel_in']))
			$date_in = $_POST['hotel_in'];

		if (isset($_POST['hotel_rooms']))
			$_rooms = $_POST['hotel_rooms'];
		
		if (isset($_POST['hotel_out']))
			$date_out = $_POST['hotel_out'];

    if (isset($_POST['hotel_type']))
      $t = $_POST['hotel_type'];

    if (isset($_POST['days']))
      $_days = $_POST['days'];
		
   loadCampingORHotel($type, $date_in, $date_out, $_rooms,$_days, $t ); 
	
	}

  elseif (isset($_POST['camping_btn'])){

    $type = "Camping";
    
    if (isset($_POST['camping_in']))
      $date_in = $_POST['camping_in'];

    if (isset($_POST['camping_people']))
      $_roomsORpeople = $_POST['camping_people'];
    
    if (isset($_POST['camping_out']))
      $date_out = $_POST['camping_out'];

    if (isset($_POST['camping_type']))
      $t = $_POST['camping_type'];

    if (isset($_POST['camping_days']))
      $_days = $_POST['camping_days'];
    
   loadCampingORHotel($type, $date_in, $date_out, $_roomsORpeople, $_days, $t); 
  
  }

	elseif (isset($_POST['trekking_btn'])) {

    $type = "Trekking";

		if (isset($_POST['trekking_people']))
			$_people = $_POST['trekking_people'];

		if (isset($_POST['mode']))
			$mode = $_POST['mode'];
		
		loadTrekking($type, $_people, $mode);

	}

  elseif (isset($_POST['site_btn'])) {

    $type = 'Sightseeing';
      
      if (isset($_POST['site_people']))
        $_people = $_POST['site_people'];

      if (isset($_POST['site_in']))
        $date_in = $_POST['site_in'];

      if (isset($_POST['sites']))
        $sites = $_POST['sites']; # $sites is an array!

      loadSigthSeeing($type,$sites, $date_in, $_people, getSightSeeingRate($sites, $_people));
  }

	elseif (isset($_POST['homestay_btn'])) {

		$type = "Homestay";

    if (isset($_POST['homestay_in']))
      $date_in = $_POST['homestay_in'];

    if (isset($_POST['homestay_out']))
      $date_out = $_POST['homestay_out'];

    if (isset($_POST['homestay_rooms']))
      $_roomsORpeople = $_POST['homestay_rooms'];

    if(isset($_POST['homestay_days']))
      $_days = $_POST['homestay_days'];

    loadHomestay($type, $date_in, $date_out, $_roomsORpeople, getHomeStayRate($_roomsORpeople, $_days));

	}


function loadRafting($type,$a,$b,$c,$total_cost) {

  $stretch = $b." KM";
	
	$form = '<div class = "container">
  <form action="booking.php" method="POST">
	<div class="row">

	<div class="col s12 l6 push-l3 btn" style="text-align: center;"> RAFTING FORM </div>
	
	</div>
	<div class="row">
	<div class="input-field col s6 push-l3 l3">
		  <input id="full_name" type="text" class="validate" name="first_name" required>
          <label for="full_name">First Name</label>
    </div>
    <div class="input-field col s6 push-l3 l3">
      <input id="last_name" type="text" class="validate" name="last_name" required>
          <label for="last_name">Last Name</label>
    </div>
    <input style="display:none;" name="booking_type" type="text" value="'.$type.'" >
	</div>

<div class="row">
  <div class="input-field col s12 push-l3 l6">
    <input id="email" type="email" class="validate" name="email" required>
          <label for="Mobile">Email</label>
  </div>
    </div>

	<div class="row">
	<div class="input-field col s6 push-l3 l3">
		<input id="Mobile" type="number" class="validate"  name="ph_number" required>
          <label for="Mobile">Mobile No.</label>
	</div>
    <div class="input-field col s3 push-l3 l1">
          <input id="Age" type="text" class="validate" name="age" required>
          <label for="Age">Age</label>
    </div>
      <div class="input-field col s3 l2 push-l3">
          <input id="stretch" value="'.$c.'" type="number" class="validate" readonly name="trip_people">
          <label for="stretch">People</label>
    </div>
    </div>
    <div class="row">
	<div class="input-field col s4 push-l3 l2">
		<input id="date_arr" readonly value="'.$a.'" type="text" class="validate" name="trip_date_arr">
          <label for="Mobile">Arrival Date</label>
	</div>
    <div class="input-field col s4 push-l3 l2">
          <input id="stretch" value="'.$stretch.'" type="text" class="validate" readonly name="trip_stretch">
          <label for="stretch">Strech</label>
    </div>
   
     <div class="input-field col s4 push-l3 l2">
          <input id="stretch" value="'.$total_cost.'" type="number" class="validate" readonly name="total_cost">
          <label for="stretch">Advance 50% (INR)</label>
    </div>
    </div>
    <div class="row">
    <div class="col s12 l6 push-l3">
    	<button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
  		</button>
  	</div>
    <form>
    </div>
    ';

    echo $form;

}


function loadCampingORHotel($type, $date_in, $date_out, $_pORr,$_days, $t) {

  $name_form = 'Invalid Form Type';
  $field_type = 'People';
  $total_cost = 0;

  if ($type == 'Camping') {
      $field_type = 'People';
      $name_form = 'CAMPING FORM';
      $total_cost = getCampingRate($t, $_pORr, $_days);
    }
  else{ 
      $field_type = 'Rooms';
      $name_form = 'HOTEL FORM';
      $total_cost = getHotelRate($t, $_pORr, $_days, $t);
  }
  
	$form_ = '<div class = "container">
  <form action="booking.php" method="POST">
  <div class="row">
  <div class="col push-l3 s12 l6 btn" style="text-align: center;">'.$name_form.'</div>
  </div>
  <div class="row">

  <div class="input-field col s6 push-l3 l3">
      <input id="full_name" type="text" class="validate" name="first_name" required>
          <label for="full_name">First Name</label>
    </div>
   
    <div class="input-field col push-l3 s6 l3">
      <input id="last_name" type="text" class="validate" name="last_name" required>
          <label for="last_name">Last Name</label>
    </div>
    <input style="display:none;" name="booking_type" type="text" value="'.$type.'" >
  </div>

<div class="row">
  <div class="input-field col s12 l6 push-l3">
    <input id="email" type="email" class="validate" name="email" required>
          <label for="Mobile">Email</label>
  </div>
    </div>

  <div class="row">
  <div class="input-field col s6 l3 push-l3">
    <input id="Mobile" type="number" class="validate"  name="ph_number" required>
          <label for="Mobile">Mobile No.</label>
  </div>
    <div class="input-field col s3 l1 push-l3">
          <input id="Age" type="text" class="validate" name="age" required>
          <label for="Age">Age</label>
    </div>
    <div class="input-field col s3 l2 push-l3">
          <input id="stretch" value="'.$_pORr.'" type="number" class="validate" readonly name="trip_people">
          <label for="stretch">'.$field_type.'</label>
    </div>
    </div>
    <div class="row">
  <div class="input-field col s4 l2 push-l3">
    <input id="date_arr" readonly value="'.$date_in.'" type="text" class="validate" name="trip_date_arr">
          <label for="Mobile">Arrival</label>
  </div>
    <div class="input-field col s4 l2 push-l3">
          <input id="stretch" value="'.$date_out.'" type="text" class="validate" readonly name="trip_date_dpr">
          <label for="stretch">Departure</label>
    </div>
     
     <div class="input-field col s4 l2 push-l3">
          <input id="stretch" value="'.$total_cost.'" type="number" class="validate" readonly name="total_cost">
          <label for="stretch">Advance 50% (INR)</label>
    </div>
    <div class="col s3"></div>
    </div>
    <div class="row">
    <div class="col s3"></div>
    <div class="col s6">
      <button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
      </button>
    </div>
    <form>
    </div>
    ';

    echo $form_;
}


function loadTrekking($type,$people, $mode) {

	$form = '<div class = "container">
	<form action="booking.php" method="POST">
  <div class="row">
	<div class="col s12 l6 push-l3 btn" style="text-align: center;"> TREKKING FORM </div>
	</div>
	<div class="row">
	<div class="input-field col s6 push-l3 l3">
      <input id="full_name" type="text" class="validate" name="first_name" required>
          <label for="full_name">First Name</label>
    </div>
   
    <div class="input-field col push-l3 s6 l3">
      <input id="last_name" type="text" class="validate" name="last_name" required>
          <label for="last_name">Last Name</label>
    </div>
	</div>
	<div class="row">
	<div class="input-field col s6 l3 push-l3">
		<input id="Mobile" type="text" class="validate">
          <label for="Mobile">Mobile No.</label>
	</div>
    <div class="input-field col s6 push-l3 l3">
          <input id="Mobile_Alt" type="text" class="validate">
          <label for="Mobile_Alt">Alt. Mobile No.</label>
    </div>
    </div>
   
    
      <div class="row">
        <div class="input-field col s12 l6 push-l3">
          <textarea id="Address" class="materialize-textarea"></textarea>
          <label for="Address">Full Address</label>
        </div>
      </div>
    </form>
  
<div class="row">
     <div class="input-field col s12 l6 push-l3">
    <select>
      <option value="0" disabled selected>Choose your option</option>
      <option value="1">Customized Trip</option>
      <option value="2">Fixed Departure</option>
    </select>
    <label>Trekking Type</label>
    </div>
    </div>
   
    
    <div class="row">
    <div class="col s12 l6 push-l3">
    	<button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
  		</button>
  	</div>
    </div></div>
    <script type="text/javascript"> 
  $(document).ready(function() {
    $(\'select\').material_select();
  });
        
    </script>
';

  echo $form;

}

function loadSigthSeeing($type,$sites, $date_in, $people, $cost) {

  $site_str = "";

  foreach ($sites as $key => $site) {

    if ($site == '01')
      $site_str .= "Rishikesh";
    
    elseif ($site == '02')
      if($key == 0)
          $site_str.= "Haridwar";
        else  
          $site_str.= ", Haridwar";
    else 
      if($key == 0)
        $site_str .= "Spiritual Tour";
      else
        $site_str .= ", Spiritual Tour";
    # code...
  }


{ ?>
  <div class = "container">
  <form action="booking.php" method="POST">
  <div class="row">
  <div class="col s12 l6 push-l3 btn" style="text-align: center;">SIGHTSEEING FORM</div>
  </div>
  <div class="row">
  <div class="input-field col s6 l3 push-l3">
      <input id="full_name" type="text" class="validate" name="first_name" required>
          <label for="full_name">First Name</label>
    </div>
    <div class="input-field col s6 l3 push-l3">
      <input id="last_name" type="text" class="validate" name="last_name" required>
          <label for="last_name">Last Name</label>
    </div>
    <input style="display:none;" name="booking_type" type="text" value="<?=$type;?>" >
  
  </div>

<div class="row">
  <div class="input-field col s12 l6 push-l3">
    <input id="email" type="email" class="validate" name="email" required>
          <label for="Mobile">Email</label>
  </div>
    </div>

  <div class="row">
  <div class="input-field col s4 push-l3 l2">
    <input id="Mobile" type="number" class="validate"  name="ph_number" required>
          <label for="Mobile">Mobile No.</label>
  </div>
    <div class="input-field col s2 l1 push-l3">
          <input id="Age" type="text" class="validate" name="age" required>
          <label for="Age">Age</label>
    </div>
    <div class="input-field col s2 l1 push-l3">
          <input id="stretch" value="<?=$people;?>" type="number" class="validate" readonly name="trip_people">
          <label for="stretch">Groups</label>
    </div>
    <div class="input-field col s4 l2 push-l3">
          <input id="amount" type="text" value="<?=$cost;?>" class="validate" name="total_cost" required>
          <label for="amount">Advance 50% (INR)</label>
    </div>
    
    </div>
    <div class="row">
  <div class="input-field col s5 l2 push-l3">
    <input id="date_arr" readonly value="<?=$date_in;?>" type="text" class="validate" name="trip_date_arr">
          <label for="date_arr">Arrival</label>
  </div>
    <div class="input-field col s7 l4 push-l3">
          <input id="sites" value="<?=$site_str;?>" type="text" class="validate" readonly name="trip_sites">
          <label for="sites">Sites</label>
    </div>
     
    
    </div>
    <div class="row">
    
    <div class="col s12 l6 push-l3">
      <button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
      </button>
    </div>
    <form>
    </div>
    <script type="text/javascript"> 
  $(document).ready(function() {
    $('select').material_select();
  });
        
    </script>
<?php } 

  

}



function loadHomestay($type,$date_in, $date_out, $rooms, $cost) {


	{ ?>
  <div class = "container">
  <form action="booking.php" method="POST">
  <div class="row">
  <div class="col s12 l6 push-l3 btn" style="text-align: center;">HOMESTAY FORM</div>
  </div>
  <div class="row">
  <div class="input-field col s6 l3 push-l3 ">
      <input id="full_name" type="text" class="validate" name="first_name" required>
          <label for="full_name">First Name</label>
    </div>
    <div class="input-field col s6 l3 push-l3">
      <input id="last_name" type="text" class="validate" name="last_name" required>
          <label for="last_name">Last Name</label>
    </div>
    <input style="display:none;" name="booking_type" type="text" value="<?=$type;?>" >
  </div>

<div class="row">
  <div class="input-field col s12 l6 push-l3">
    <input id="email" type="email" class="validate" name="email" required>
          <label for="Mobile">Email</label>
  </div>
    </div>

  <div class="row">
  <div class="input-field col s6 l3 push-l3">
    <input id="Mobile" type="number" class="validate"  name="ph_number" required>
          <label for="Mobile">Mobile No.</label>
  </div>
    <div class="input-field col s3 l1 push-l3">
          <input id="Age" type="text" class="validate" name="age" required>
          <label for="Age">Age</label>
    </div>
    <div class="input-field col s3 l2 push-l3">
          <input id="stretch" value="<?=$rooms;?>" type="number" class="validate" readonly name="trip_people">
          <label for="stretch">Rooms</label>
    </div>
    </div>
    <div class="row">
  <div class="input-field col s4 l2 push-l3">
    <input id="date_arr" readonly value="<?=$date_in;?>" type="text" class="validate" name="trip_date_arr">
          <label for="Mobile">Arrival</label>
  </div>
    <div class="input-field col s4 l2 push-l3">
          <input id="stretch" value="<?=$date_out;?>" type="text" class="validate" readonly name="trip_date_dpr">
          <label for="stretch">Departure</label>
    </div>
     
     <div class="input-field col s4 l2 push-l3">
          <input id="stretch" value="<?=$cost;?>" type="number" class="validate" readonly name="total_cost">
          <label for="stretch">Advance 50% (INR)</label>
    </div>
    </div>
    <div class="row">
    <div class="col s12 l6 push-l3">
      <button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
      </button>
    </div>
    <form>
    </div>
    <script type="text/javascript"> 
  $(document).ready(function() {
    $('select').material_select();
  });
        
    </script>
<?php  }
}
 ?>

</body>
</html>