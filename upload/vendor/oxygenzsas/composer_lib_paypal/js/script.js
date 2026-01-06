class PaypalCustom {
    constructor({ paypal_sdk_url, client_id, currency, attributes, url_paiement, buttonStyle, boutonContainerSelector }) {
        this.paypal_sdk_url = paypal_sdk_url;
        this.client_id = client_id;
        this.currency = currency;
        this.attributes = attributes;
        this.url_paiement = url_paiement;
        this.buttonStyle = buttonStyle; // Ajouter le style des boutons en tant que paramètre
        this.boutonContainerSelector = boutonContainerSelector; // Ajouter le sélecteur dynamique
        this.init();
    }

    init = function () {
        let instance = this;
        // Charger le SDK PayPal
        instance.url_to_head(instance.paypal_sdk_url + "?client-id=" + instance.client_id + "&currency=" + instance.currency + "&intent=capture&commit=true&components=card-fields")
            .then(() => {
                instance.afterInitSDK();
            })
            .catch((error) => {
                instance.triggerEvent('paypalError', { message: error });
            });
    }

    afterInitSDK() {
        let instance = this;

        const cardFields = paypal.CardFields({

            createOrder: function (data, actions) {
                return fetch(instance.url_paiement, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({action: 'create_order', attributes: JSON.stringify(instance.attributes) }).toString()
                })
                    .then((response) => response.json())
                    .then((order) => {
                        instance.triggerEvent('paypalOrderCreated', { order });
                        return order.id;
                    })
                    .catch((error) => {
                        instance.triggerEvent('paypalError', { message: error });
                    });
            },
            onApprove: function (data, actions) {
                let order_id = data.orderID;
                return fetch(instance.url_paiement, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({action: 'complete_order', order_id: order_id}).toString()
                })
                    .then((response) => response.json())
                    .then((order_details) => {
                        let intent_object = "captures";
                        instance.triggerEvent('paypalOrderCompleted', {
                            amount: order_details,
                        });
                        paypal_buttons.close();
                    })
                    .catch((error) => {
                        instance.triggerEvent('paypalError', { message: error });
                    });
            },

            onCancel: function (data) {
                instance.triggerEvent('paypalOrderCancelled', data);
            },

            onError: function (err) {
                instance.triggerEvent('paypalError', { message: err });
            }
        });

        if (cardFields.isEligible()) {
            cardFields.NameField().render('#card-name');
            cardFields.NumberField().render('#card-number');
            cardFields.ExpiryField().render('#card-expiry');
            cardFields.CVVField().render('#card-cvv');

            document
                .getElementById('card-submit')
                .addEventListener('click', () => cardFields.submit());

        }

        // Déclenchement de l'événement après l'initialisation des boutons
        instance.triggerEvent('paypalButtonsInitialized');
    }

    // Méthode pour déclencher des événements personnalisés
    triggerEvent(eventName, detail = {}) {
        const event = new CustomEvent(eventName, { detail });
        document.dispatchEvent(event);
    }

    url_to_head = (url) => {
        return new Promise(function (resolve, reject) {
            let script = document.createElement('script');
            script.src = url;
            script.onload = function () {
                resolve();
            };
            script.onerror = function () {
                reject('Error loading script.');
            };
            document.head.appendChild(script);
        });
    }

}
