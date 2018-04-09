<?php

require_once('stripe-php-3.9.1/init.php');
\Stripe\Stripe::setApiKey("sk_test_7KM9LLHBNo4cmL1IgSkqwHWW");

// $bar = \Stripe\Account::create(
//   array(
//     "country" => "US",
//     "managed" => true
//   )
// );
// echo $bar->id;

\Stripe\Charge::create(array(
  "amount" => 500, // amount in cents, again
  "currency" => "usd",
   "description" => "hi",
  "customer" => "cus_8DqXxSzS0h9f8q",
  "destination" => "acct_180j6TJUS76q8G4i",
  "application_fee" => 47)
);

?>