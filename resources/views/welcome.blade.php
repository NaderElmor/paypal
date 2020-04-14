<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox: 'AUeKrqJZVm74a0AK5fIjLWMw0jGFovurDTBqo0Kzk_INEwGgylhsFpyoWso2XVLr64y95-tw45-Son_Y',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({

          //added by me
          redirect_urls{
            return_url :'http://localhost:8000/execute-payment'
          },
        transactions: [{
          amount: {
            total: '30',
            currency: 'USD'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // // Show a confirmation message to the buyer
        // window.alert('Thank you for your purchase!');

        return actions.redirect();
      });
    }
  }, '#paypal-button');

</script>