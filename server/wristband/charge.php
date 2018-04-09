<?php
 // Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys

// include "stripe-php-3.9.1";
 // require_once('vendor/autoload.php');
require_once('stripe-php-3.9.1/init.php');
\Stripe\Stripe::setApiKey("sk_test_7KM9LLHBNo4cmL1IgSkqwHWW");


if($_GET['mode'] == 0){
  $token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
$password = $_POST['stripePassword'];
  $customer = \Stripe\Customer::create(array(
  "source" => $token,
  "email" => $email)
);
  $customerID = $customer->id;
   echo "
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js'></script>
<script>
  var ref = new Firebase('https://blistering-fire-195.firebaseio.com');
  ref.authWithPassword({
  email: '" . $email . "',
  password: '" . $password . "'
}, function(error, authData) {
  if (error) {

  } else {
     var ref2 = new Firebase('https://blistering-fire-195.firebaseio.com/users/'+authData.uid+'');
    ref2.update({
    customer: '" . $customerID . "'
});
  }
});
</script>
  ";
}

// Get the credit card details submitted by the form
if($_GET['mode'] == 1){
$email = $_POST['stripeEmail'];
$amount = $_POST['stripeAmount'];
$bar = $_POST['stripeBar'];
$password = $_POST['stripePassword'];
$customerID = $_POST['customer'];
// Create a Customer

// if($bar != -1){
header('Location: add.php?stripeCustomer='.$customerID.'&stripeEmail='.$email.'&stripeAmount='.$amount.'&stripeBar='.$bar.'&stripePassword='.$password);
// }
}


// try {
//   $charge = \Stripe\Charge::create(array(
//     "amount" => 52, // amount in cents, again
//     "currency" => "usd",
//     "id" => $token,
//     "description" => "Example charge"
//     ));
// } catch(\Stripe\Error\Card $e) {
//   // The card has been declined
// }


if($_GET['mode'] == 2){
$customer = $_GET['id'];
$amount = $_GET['amount'];
$bar = $_GET['bar'];
$email = $_GET['email'];
//$descr = $_GET['descr'];
//Charge the Customer instead of the card
try{
\Stripe\Charge::create(array(
  "amount" => $amount, // amount in cents, again
  "currency" => "usd",
  "description" => "testing",
  "customer" => $customer,
   "destination" => $bar,
  "application_fee" => 36)
);
echo "
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js'></script>
<div id='body1'>
<script>
 var ref = new Firebase('https://blistering-fire-195.firebaseio.com/paid/');
  ref.authWithPassword({
 email    : 'sgrutman978@gmail.com',
  password : '1234'
}, function(error, authData) {
  if (error) {
    //alert('Login Failed!', error);
  } else {
 var scoresRef = new Firebase('https://blistering-fire-195.firebaseio.com/paid/'+authData.uid+'/');
 scoresRef.push({
    id: '".$customer."',
     amount: ".$amount.",
      email: '".$email."',
      time: Date.now(),
     bar: '".$bar."'
}, function(){
	//alert();
	document.getElementById('body1').innerHTML = '';
});
}
});
</script>a
</div>";
echo "<div style='background-color:green;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Wristband</span></br>Approved</div>";
} catch(\Stripe\Error\InvalidRequest $e) {
 echo "<div style='background-color:red;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Wristband</span></br>Denied</div>";
}catch(\Stripe\Error\Card $e) {
 echo "<div style='background-color:red;width:100%;height:100%;position:fixed;top:0px;left:0px;font-size:150px;text-align:center;padding-top:200px;color:white'><span style='color:yellow'>Card</span></br>Denied</div>";
}
}

// YOUR CODE: Save the customer ID and other info in a database for later!

// YOUR CODE: When it's time to charge the customer again, retrieve the customer ID!

// \Stripe\Charge::create(array(
//   "amount"   => 1500, // $15.00 this time
//   "currency" => "usd",
//   "customer" => $customerId // Previously stored, then retrieved
//   ));
?>




<!--   -->

