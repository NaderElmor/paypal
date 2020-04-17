<?php


namespace App\Paypal;

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;



class ExecutePayment extends  Paypal
{
    public  function execute(){



        //get the details from the request we make
        $payment = $this->GetPaymentId($this->apiContext);

        //execute the payment
        $execution = $this->ExecutePayment();

        //execute the transaction
        $execution->addTransaction($this->Transaction($this->Amount($this->Details())));
        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }

    /**
     * @param $apiContext
     * @return mixed
     */
    protected function GetPaymentId($apiContext)
    {
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        return $payment;
    }

    /**
     * @return PaymentExecution
     */
    protected function ExecutePayment(): PaymentExecution
    {
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        return $execution;
    }


    /**
     * @param $amount
     * @return Transaction
     */
    protected function Transaction($amount): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        return $transaction;
    }
}