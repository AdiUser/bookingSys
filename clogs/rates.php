<?php 
	
	$delux = 'dlx';
	$luxary = 'lxry';
	$super_delux = 'sdlx';
	$super_luxary = 'slxry';
	$rate_homestay = 6000;
	$rishikesh = '01';
	$haridwar = '02';

	function getRaftingRate($s, $people) {

		if ($s == 9)
			return (500*$people)/2;
		if ($s == 16)
			return (800*$people)/2;
		if ($s == 26)
			return (700*$people)/2;
		if ($s == 36)
			return (1200*$people)/2;

		return -1;

	}

	function getCampingRate($t, $days, $people) {

		$rate_dlx = 2000;
		$rate_lxry = 2500;
		$rate_sdlx = 3000;
		$rate_slxry = 3500; 

		if ($t == $GLOBALS['delux'])
			return ($days*$people*$rate_dlx)/2;

		if ($t == $GLOBALS['super_delux'])
			return ($days*$people*$rate_sdlx)/2;

		if ($t == $GLOBALS['luxary'])
			return ($days*$people*$rate_lxry)/2;

		if ($t == $GLOBALS['super_luxary'])
			return ($days*$people*$rate_slxry)/2;

		return -1;

	}


	function getHotelRate($t, $rooms, $days) {

         $rate_bgd = 1500;
         $rate_ac = 2000;
         $rate_lxry = 2500;
         $rate_slxry = 3000;

         if (empty($days) || !isset($days))
         	$days = 2;

		if ($t == 'bgd')
			return ($rate_bgd*$days*$rooms)/2;

		elseif ($t == 'ac')
			return ($rate_ac*$days*$rooms)/2;

		elseif ($t == 'lxry')
			return ($rate_lxry*$days*$rooms)/2;

		elseif ($t == 'slxry')
			return ($rate_slxry*$days*$rooms)/2;
		else
			return -1;
	}

	function getHomeStayRate($_rooms, $days) {

			return ($_rooms*$days*$GLOBALS['rate_homestay'])/2;

	}

	function getSightSeeingRate($sites, $grp) {

		$cost = 0;
		$rate_rishikesh = 1000;
		$rate_haridwar = 1500;
		$rate_spritual_tour = 3500;

		foreach ($sites as $site) {

			if ($site == $GLOBALS['rishikesh'])
				$cost += $rate_rishikesh;

			elseif ($site == $GLOBALS['haridwar'])
				$cost += $rate_haridwar;

			else 
				$cost += $rate_spritual_tour;
		}

		return ($cost*$grp)/2;

	}

 ?>

 