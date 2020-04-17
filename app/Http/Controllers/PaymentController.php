<?php

namespace App\Http\Controllers;

use App\Paypal\CreatePayment;
use App\Paypal\ExecutePayment;


class PaymentController extends Controller
{

    public function create()
    {
        $createPayment = new CreatePayment;
        return $createPayment->create();
    }


    public function execute()
    {
        $executePayment = new ExecutePayment;
        return $executePayment->execute();
    }
}
