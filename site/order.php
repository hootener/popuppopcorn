<?php

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://manage.stripe.com/account
Stripe::setApiKey("4VgBCX2ZnQyEITwx04tka8pAzG9IdOFX");

// Get the credit card details submitted by the form
print_r($_POST);

$token = $_POST['stripeToken'];
$bsc = $_POST['bsc'];
$k = $_POST['k'];
$wc = $_POST['wc'];
$c = $_POST['c'];

$name = $_POST['name'];
$email = $_POST['email'];

$bsc_total = 6000 * (int)$bsc;
$c_total = 6000 * (int)$c;
$wc_total = 6000 * (int)$wc;
$k_total = 6000 * (int)$k;

$total = $bsc_total + $c_total + $wc_total +$k_total;


// Create the charge on Stripe's servers - this will charge the user's card
try {
  $charge = Stripe_Charge::create(array(
              "amount" => $total, // amount in cents, again
              "currency" => "usd",
              "card" => $token,
              "description" => $email)
  );
  
  print_r($charge);
  
} catch (Stripe_CardError $e) {
  // The card has been declined
  
  echo "card declined";
}
