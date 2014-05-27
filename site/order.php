<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once('./lib/Stripe.php');
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://manage.stripe.com/account
Stripe::setApiKey("sk_live_YvIO200r6Y26gASwSuQjg1Mq");

//echo "stuff";
// Get the credit card details submitted by the form


$token = $_POST['stripeToken'];
$bsc = $_POST['bsc'];
$k = $_POST['k'];
$wc = $_POST['wc'];
$c = $_POST['c'];

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];

$bsc_total = 600 * (int)$bsc;
$c_total = 600 * (int)$c;
$wc_total = 600 * (int)$wc;
$k_total = 600 * (int)$k;

$total = $bsc_total + $c_total + $wc_total +$k_total;


// Create the charge on Stripe's servers - this will charge the user's card
try {
  $charge = Stripe_Charge::create(array(
              "amount" => $total, // amount in cents, again
              "currency" => "usd",
              "card" => $token,
              "description" => "Email: $email, Name: $name, Address: $address")
  );
  
  header('Location: http://popuppopcorn.com/thanks.html');
  
} catch (Stripe_CardError $e) {
  // The card has been declined
  
  header('Location: http://popuppopcorn.com/card_error.html');
}
