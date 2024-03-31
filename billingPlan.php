<?php
require_once("includes/paypalConfig.php");

use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

// Create a new billing plan
$plan = new Plan();
$plan->setName('Mkplay Monthly Subscription')
    ->setDescription('Gets you all the features of our site.')
    ->setType('INFINITE');

// Set payment definition
$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Regular Payments')
    ->setType('REGULAR')
    ->setFrequency('Month')
    ->setFrequencyInterval('1')
    ->setAmount(new Currency(['value' => 9.99, 'currency' => 'GBP']));

// Set merchant preferences
$merchantPreferences = new MerchantPreferences();
$merchantPreferences->setReturnUrl(getReturnUrl(true))
    ->setCancelUrl(getReturnUrl(false))
    ->setAutoBillAmount('yes')
    ->setInitialFailAmountAction('CONTINUE')
    ->setMaxFailAttempts('0')
    ->setSetupFee(new Currency(['value' => 9.99, 'currency' => 'GBP']));

// Set payment definition and merchant preferences
$plan->setPaymentDefinitions([$paymentDefinition]);
$plan->setMerchantPreferences($merchantPreferences);

try {
    // Create the plan
    $createdPlan = $plan->create($apiContext);

    // Activate the plan
    $patch = new Patch();
    $value = new PayPalModel('{"state":"ACTIVE"}');
    $patch->setOp('replace')
        ->setPath('/')
        ->setValue($value);
    $patchRequest = new PatchRequest();
    $patchRequest->addPatch($patch);
    $createdPlan->update($patchRequest, $apiContext);
    $plan = Plan::get($createdPlan->getId(), $apiContext);

    // Output plan id
    echo "Plan ID: " . $plan->getId();
} catch (Exception $ex) {
    // Handle exceptions
    echo "Error: " . $ex->getMessage();
}

// Function to get return URL based on success parameter
function getReturnUrl($success) {
    $baseUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $redirectPage = $success ? "profile.php" : "billing.php";
    return str_replace("billing.php", $redirectPage, $baseUrl);
}
?>
