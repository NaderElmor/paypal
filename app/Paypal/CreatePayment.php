<?php
namespace App\Paypal;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\RedirectUrls;


class CreatePayment extends PayPal{

  public function create()
  {
      $item1 = new Item();
    $item1->setName('Ground Coffee 40 oz')
          ->setCurrency('USD')
          ->setQuantity(1)
          ->setSku("123123") // Similar to `item_number` in Classic API
          ->setPrice(7.5);
    $item2 = new Item();
    $item2->setName('Granola bars')
          ->setCurrency('USD')
          ->setQuantity(5)
          ->setSku("321321") // Similar to `item_number` in Classic API
          ->setPrice(2);

    $itemList = new ItemList();
    $itemList->setItems(array($item1, $item2));

      $payment = $this->Payment($this->Payer(), $this->RedirectUrls(), $this->Transaction($this->Amount($this->Details()), $itemList));

        $payment->create($this->apiContext);
        $approvalUrl = $payment->getApprovalLink();

    return redirect($approvalUrl);
  }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
    }




 
    protected function Transaction($amount, $itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    protected function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost:8000/execute-payment")
            ->setCancelUrl("http://localhost:8000/cancel");
        return $redirectUrls;
    }

  
    protected function Payment($payer, $redirectUrls, $transaction): Payment
    {
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        return $payment;
    }
}