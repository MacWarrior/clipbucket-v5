document.addEventListener("DOMContentLoaded", function() {

    try {

        /** donnée pour identifier le paiement dans la classe paypal */
        let id_transaction = 45623;

        if(
            Paypal === undefined
            || Paypal.client_id === undefined || Paypal.client_id.length <= 0
            || Paypal.paypal_sdk_url === undefined || Paypal.paypal_sdk_url.length <= 0
            || Paypal.currency === undefined || Paypal.currency.length <= 0
            || Paypal.url_paiement === undefined || Paypal.url_paiement.length <= 0
        ) {
            throw new Error("Parameter missing !");
        }

        new PaypalCustom( {
            paypal_sdk_url: Paypal.paypal_sdk_url
            ,client_id: Paypal.client_id
            ,currency: Paypal.currency
            ,attributes: {id_transaction: id_transaction}
            ,url_paiement: Paypal.url_paiement
            ,boutonContainerSelector: "#payment_options"
            ,buttonStyle: {
                shape: 'rect'
                ,color: 'gold'
                ,layout: 'vertical'
                ,label: 'paypal'
            }
        });

        document.addEventListener('paypalOrderCreated', (event) => {
            console.log('Order created:', event.detail.order);
        });

        document.addEventListener('paypalOrderCompleted', (event) => {
            console.log(`Thank you for your payment of ${event.detail.amount.value} ${event.detail.amount.currency_code}`);
        });

        document.addEventListener('paypalOrderCancelled', (event) => {
            console.log('Order cancelled!');
        });

        document.addEventListener('paypalError', (event) => {
            console.error('PayPal Error:', event.detail.message);
        });

        document.addEventListener('paypalButtonsInitialized', () => {
            console.log('PayPal buttons have been initialized and are ready for interaction.');
        });

    }catch (e) {

        let msg_error = lang_paypal_init_issue;

        /** error message on frontend */
        if(_cb !== undefined && _cb.showMeTheMsg !== undefined) {
            _cb.showMeTheMsg('<div class="error">'+msg_error+'</div>');
        }

        /** remove html content and add message */
        let main_plans_html = document.querySelector('.plans-main-container');
        main_plans_html.innerHTML = lang_no_subscription_found;
    }

});
