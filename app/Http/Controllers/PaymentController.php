<?php

namespace App\Http\Controllers;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;


class PaymentController extends Controller
{
    public function execute()
    {
        //info
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUeKrqJZVm74a0AK5fIjLWMw0jGFovurDTBqo0Kzk_INEwGgylhsFpyoWso2XVLr64y95-tw45-Son_Y',     // ClientID
                'EAWjZT0uu7dY2TVUwopNEkhxWN18jbudTNZSjnNa3j_JBBg9tx1U4G7dYcmFoJR0Tr1WQZYca4WBMWoI'      // ClientSecret
            )
    );

    //get the details from the request we make
    $paymentId = request('paymentId');
    $payment = Payment::get($paymentId, $apiContext);

    //execute the payment
    $execution = new PaymentExecution();
    $execution->setPayerId(request('PayerID'));

    $transaction = new Transaction();
    $amount = new Amount();
    $details = new Details();

    //details about the transaction
    $details->setShipping(1.2)
        ->setTax(1.3)
        ->setSubtotal(17.50);
    $amount->setCurrency('USD');
    $amount->setTotal(20);
    $amount->setDetails($details);
    $transaction->setAmount($amount);

    //execute the transaction
    $execution->addTransaction($transaction);
    $result = $payment->execute($execution, $apiContext);

       return $result;
    }
}
