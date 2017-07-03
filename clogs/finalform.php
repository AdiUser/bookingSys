<?php
// Merchant key here as provided by Payu

// initiating the session!
  session_start();

  function ifset($a){

    if (  !empty($a) 
          && isset($a) 
          && strlen($a) > 0
          ) {

      return $a;
    }

    return 0;
  }

$MERCHANT_KEY = "WmQOXyix";

// Merchant Salt as provided by Payu
$SALT = "6xh8BIXTiG";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://secure.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}



$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));

	$hashVarsSeq = explode('|', $hashSequence);
  $hash_string = '';	

	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
 ?>
<html>
  <head>
  <meta name="viewport" content="width=device-width ,initial-scale= 1.0">
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
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
  <body onload="submitPayuForm()">
    <br/>
    <?php if($formError) { ?>
	
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
        <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <div class = "container">
  <form action="booking.php" method="POST">
  <div class="row">
  <div class="col s12 l6 push-l3 btn" style="text-align: center;"> PayU Form </div>
  </div>
  <div class="row">
  <div class="input-field col s6 l3 push-l3">
      <input name="firstname" type="text" id="firstname" value="<?php echo ifset($_SESSION['f_name']); ?>"  readonly/>
          <label for="full_name">First Name</label>
    </div>
    <div class="input-field col s6 l3 push-l3">
      <input id="last_name" type="text" class="validate" name="last_name" value="<?php echo $_SESSION['last_name']?>" readonly>
          <label for="last_name">Last Name</label>
    </div>
  </div>

<div class="row">
  <div class="input-field col s12 l6 push-l3">
    <input name="email" id="email" type="text" value="<?php echo ifset($_SESSION['email']); ?>"  readonly/>
          <label for="Mobile">Email</label>
  </div>
    </div>

  <div class="row">
  <div class="input-field col s6 l3 push-l3">
   <input name="phone" type="text" value="<?php echo ifset($_SESSION['ph_number']); ?>"  readonly/>
          <label for="Mobile">Mobile No.</label>
  </div>
    <div class="input-field col s6 l3 push-l3">
          <input name="amount" type="text" value="<?php echo ifset($_SESSION['cost']); ?>"  readonly/>
          <label for="Ammount">Ammount</label>
    </div>
    </div>
    <div class="row">
     <div class="input-field col s12 l6 push-l3">
          <textarea class="materialize-textarea" type="text"  name="productinfo"> <?php  echo ifset($_SESSION['booking_type']); ?></textarea>
          <label for="Product_Info">Product Info</label>
    </div>
    </div>
    <div class="row" hidden="hidden">
  <div class="input-field col s6 l3 push-l3">
   <input name="surl" readonly value="http://realhappiness.org/" > type="text" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" />
          <label for="Succes">Succes URL</label>
  </div>
    <div class="input-field col s6 l3 push-l3">
          <input name="furl" value="http://realhappiness.org/"  type="text"  readonly value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" />
          <label for="Failure">Failure URL</label>
    </div>
    </div>
    <div class="row">
    <div class="col s12 l6 push-l3">
      <button class="btn waves-effect waves-light" style="width: 100%" type="submit" name="action">Submit
      </button>
    </div>
    <form>
    </div>
    </form>
  </body>
</html>
