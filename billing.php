<?php
require_once("includes/paypalConfig.php");
require_once("billingPlan.php"); // Assuming $plan variable is defined in this file

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;

try {
    // Get the plan ID
    $planId = isset($plan) ? $plan->getId() : null;

    // Check if plan ID is available
    if (!$planId) {
        throw new Exception("Plan ID is not available.");
    }

    // Create a new agreement
    $agreement = new Agreement();
    $agreement->setName('Subscription to Mkplay')
        ->setDescription('£9.99 setup fee and then recurring payments of £9.99 to Mkplay')
        ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month", time())));

    // Set the plan ID
    $plan = new Plan();
    $plan->setId($planId);
    $agreement->setPlan($plan);

    // Set payer details
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');
    $agreement->setPayer($payer);

    // Create the agreement
    $agreement = $agreement->create($apiContext);

    // Extract approval URL to redirect user
    $approvalUrl = $agreement->getApprovalLink();
    header("Location: $approvalUrl");
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    // Handle PayPal connection exceptions
    echo "PayPal Connection Exception: " . $ex->getMessage();
} catch (Exception $ex) {
    // Handle other exceptions
    echo "Exception: " . $ex->getMessage();
}
?>
