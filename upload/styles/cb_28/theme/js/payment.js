document.addEventListener("DOMContentLoaded", function() {

    new PaypalCustom( {
        paypal_sdk_url: Paypal.paypal_sdk_url
        ,client_id: Paypal.client_id
        ,currency: Paypal.currency
        ,attributes: {id_transaction: 45623} /** donnée pour identifier le paiement dans la classe paypal */
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

});
