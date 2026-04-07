class Paypal {

    attributes = {};

    init_paiement_bloc = function(Paypal, amount, currency, id_user_membership, symbol){
        let instance = this;
        instance.init_paiment_bloc_switch_card_saved_and_new_card();

        document.addEventListener('paypal:refresh_card_saved_return', function (event) {
            let vaults = event.detail.vaults;
            instance.renderPaymentCardsSaved(vaults);
        });
        instance.refreshCardSaved();

        instance.init_paypal(Paypal, amount, currency, id_user_membership);

        amount = parseFloat(amount).toFixed(2);
        document.querySelector('.payment-section .amount-display').innerHTML = amount+' '+symbol;

        /** afficher le bloc avec les input iframe de paypal apres init de paypal completed */
        document.addEventListener('paypalButtonsInitialized', () => {
            document.querySelector('#paypal-card-form').style.display = 'block';
        });

    }

    init_paypal = function(Paypal, amount, currency, id_user_membership){
        let instance = this;

        try {

            /** si la variable Paypal n'est pas init alors on stop tout avec une erreur */
            if( typeof Paypal === 'undefined') {
                throw new Error("Variable Paypal missing !");
            }

            /** donnée pour identifier la commande dans la classe paypal */
            let auto_renew = document.querySelector('#renewAuto').checked;
            let saveCard = document.querySelector('#saveCard').checked;

            instance.attributes = {id_user_membership: id_user_membership, amount: amount, auto_renew: auto_renew, saveCard: saveCard };

            // Charger le SDK PayPal
            Payment.urlToHead(Paypal.paypal_sdk_url + "?client-id=" + Paypal.client_id + "&currency=" + currency + "&intent=capture&commit=true&components=card-fields", 'js')
                .then(() => {
                    instance.afterInitSDK();
                })
                .catch((error) => {
                    instance.triggerEvent('paypalError', { message: error });
                });

            /** ajouter la checkbox pour enregistrer la carte dans les attributes */
            document.querySelector('#saveCard').addEventListener('change', (e) => {
                instance.attributes.saveCard = e.target.checked
            })

            /** ajouter la checkbox pour enregistrer la carte dans les attributes */
            document.querySelector('#renewAuto').addEventListener('change', (e) => {
                instance.attributes.renewAuto = e.target.checked
            })

            document.addEventListener('paypalOrderCompleted', (event) => {
                document.querySelector('#successMessage').style.display = 'block';
            });

            document.addEventListener('paypalSubmitClicked', (event) => {
                document.querySelector('#successMessage').style.display = 'none';
                document.querySelector('#errorMessage').style.display = 'none';
            });

            document.addEventListener('paypalError', (event) => {

                let description = lang_paypal_paiment_faild_generic ?? 'ERROR PAIEMENT';

                if (typeof event.detail?.message === 'string') {
                    description = event.detail.message;
                }

                if (event.detail?.message?.message) {
                    description = event.detail.message.message;
                }

                if (event.detail?.message?.data?.body?.details?.length) {
                    description = event.detail.message.data.body.details[0].description;
                }

                document.querySelector('#errorMessage').style.display = 'block';
                document.querySelector('#errorMessage div.error_msg').innerHTML = description;
            });

        }catch (e) {

            console.log(e);

            let msg_error = lang_paypal_init_issue;

            /** error message on frontend */
            if(_cb !== undefined && _cb.showMeTheMsg !== undefined) {
                _cb.showMeTheMsg('<div class="error">'+msg_error+'</div>');
            }

            /** remove html content and add message */
            let main_plans_html = document.querySelector('.plans-main-container');
            main_plans_html.innerHTML = lang_no_subscription_found;
        }

    }

    init_paiment_bloc_switch_card_saved_and_new_card = function(){

        // Gestion du basculement entre carte enregistrée et nouvelle carte
        const useSavedCardRadio = document.getElementById('useSavedCard');
        const useNewCardRadio = document.getElementById('useNewCard');
        const savedCardSection = document.getElementById('savedCardSection');
        const newCardSection = document.getElementById('newCardSection');

        useSavedCardRadio.addEventListener('change', function() {
            if (this.checked) {
                savedCardSection.style.display = 'block';
                newCardSection.style.display = 'none';
            }
        });

        useNewCardRadio.addEventListener('change', function() {
            if (this.checked) {
                savedCardSection.style.display = 'none';
                newCardSection.style.display = 'block';
            }
        });

    }

    getBrandSvg = function(brand) {

        switch (brand) {

            case 'visa':
                return `<svg width="32" height="24">
                        <rect width="32" height="24" rx="4" fill="#0066B2"></rect>
                    </svg>`;

            case 'mastercard':
                return `<svg width="32" height="24">
                        <circle cx="12" cy="12" r="8" fill="red"></circle>
                        <circle cx="20" cy="12" r="8" fill="orange"></circle>
                    </svg>`;

            default:
                return `<div class="unknown-brand"></div>`;
        }
    }

    renderPaymentCardsSaved = function(cardsData) {

        let instance = this;

        const container = document.querySelector('.cards-container');
        const addCardForm = document.querySelector('#addCardForm');

        if (!container || !addCardForm) {
            console.error('Container ou addCardForm introuvable');
            return;
        }

        // Supprime uniquement les cards existantes (pas le form)
        container
            .querySelectorAll('.payment-card:not(.add-card-form)')
            .forEach(card => card.remove());

        // 🪹 Aucun moyen de paiement
        if (!cardsData || cardsData.length === 0) {

            const emptyEl = document.createElement('div');
            emptyEl.className = 'payment-cards-empty';

            emptyEl.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">💳</div>
                <div class="empty-title">
                    Aucune carte enregistrée
                </div>
                <div class="empty-text">
                    Ajoutez une carte pour faciliter vos paiements.
                </div>
            </div>
        `;

            addCardForm.insertAdjacentElement('afterend', emptyEl);
            return;
        }

        // Ajoute les nouvelles cards après le form
        cardsData.forEach(card => {

            const cardEl = document.createElement('div');
            cardEl.className = 'payment-card';
            cardEl.dataset.cardId = card.id;

            cardEl.innerHTML = `
            <div class="card-content">

                <div class="card-radio">
                    <input 
                        type="radio" 
                        name="default-card"
                        ${card.is_default ? 'checked' : ''}
                    >
                </div>

                <div class="card-info">

                    <div class="card-brand">
                        ${instance.getBrandSvg(card.brand)}
                    </div>

                    <div class="card-details">

                        <div class="card-number">
                            •••• •••• •••• ${card.last4}
                        </div>

                        <div class="card-meta">
                            <span class="card-expiry">
                                Exp: ${card.expiry}
                            </span>
                            <span class="card-holder">
                                ${card.holder ?? ''}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="card-actions">

                    ${
                card.is_default
                    ? `<span class="default-badge">Par défaut</span>`
                    : ''
            }

                    <button class="delete-btn" title="Supprimer">
                        🗑️
                    </button>

                </div>

            </div>
        `;

            // 👉 Insert APRÈS le form
            addCardForm.insertAdjacentElement('afterend', cardEl);
        });

        instance.bindDeleteBtnVault();
    }

    bindDeleteBtnVault = function() {

        let payment_cards_section = document.querySelector('.payment-cards-section');
        let cards = payment_cards_section.querySelectorAll('.payment-card');

        cards.forEach(card => {
            let deleteBtn = card.querySelector('.delete-btn');
            if (!deleteBtn) return; // skip cards without delete button

            // Flag anti-spam
            let isDeleting = false;

            deleteBtn.addEventListener('click', (e) => {

                e.preventDefault();

                // 🚫 Bloque spam
                if (isDeleting) return;

                /** @todo add comfirm popup before remove card */
                /** confirm popup */
                if (!confirm('Delete this card ?')) return;

                isDeleting = true;

                // UI lock
                deleteBtn.disabled = true;
                deleteBtn.classList.add('is-loading');

                let vault_id = card.dataset.cardId;

                if (!vault_id) {
                    console.error('vault_id manquant sur la card');
                    return;
                }

                fetch("/actions/payment.php", {
                    method: "POST",
                    body: "action=user_remove_token&token_id="+encodeURIComponent(vault_id),
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network error');
                        }
                        return response.json();
                    })
                    .then(result => {
                        if(result.success !== true){
                            if(result.error !== undefined && result.error.length > 0){
                                throw new ClientVisibleError(result.error);
                            } else {
                                throw new Error('Server unknown error');
                            }
                        }

                        /** refresh content */
                        document.dispatchEvent(new CustomEvent('paypal:refresh_card_saved'));

                    })
                    .catch(error => {
                        let msg = lang_failed_delete_vault;
                        if (error instanceof ClientVisibleError) {
                            msg = error.message;
                        }

                        _cb?.showMeTheMsg?.(
                            '<div class="error">' + msg + '</div>'
                        );

                        // 🔓 Unlock si erreur
                        isDeleting = false;
                        deleteBtn.disabled = false;
                        deleteBtn.classList.remove('is-loading');

                        document.dispatchEvent(new CustomEvent('paypal:refresh_card_saved'));
                    });
            })
        })
    }

    refreshCardSaved = function() {
        let instance = this;
        fetch("/actions/payment.php?action=user_get_token", {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network error');
                }
                return response.json();
            })
            .then(result => {
                if(result.success !== true){
                    if(result.error !== undefined && result.error.length > 0){
                        throw new ClientVisibleError(result.error);
                    } else {
                        throw new Error('Server unknown error');
                    }
                }

                /** refresh content */
                document.dispatchEvent(new CustomEvent('paypal:refresh_card_saved_return', {
                    detail: {
                        vaults: result.vaults
                    }
                }));

            })
            .catch(error => {
                let msg = lang_failed_get_vault;
                if (error instanceof ClientVisibleError) {
                    msg = error.message;
                }

                _cb?.showMeTheMsg?.(
                    '<div class="error">' + msg + '</div>'
                );
            });

    }

    capture_crud_card_saved = function() {
        let instance = this;
        instance.refreshCardSaved();
    }

    init = function() {
        let instance = this;
        document.addEventListener('paypal:refresh_card_saved', function (event) {
            instance.refreshCardSaved();
        });
        document.addEventListener('paypal:refresh_card_saved_return', function (event) {
            let vaults = event.detail.vaults;
            instance.renderPaymentCardsSaved(vaults);
        });
        
        document.addEventListener('payment:capture_crud_card_saved', function (event) {
            instance.capture_crud_card_saved();
        });

        document.addEventListener('payment:initPaiementBloc', function (event) {
            /** cacher le bloc avec les input iframe de paypal tant que pas init */
            document.querySelector('#paypal-card-form').style.display = 'none';

            if(Paypal_config === undefined) {
                console.error('PayPal config is missing');
            }

            let amount = event.detail.amount;
            let currency = event.detail.currency;
            let id_user_membership = event.detail.id_user_membership;
            let symbol = event.detail.symbol;
            instance.init_paiement_bloc(Paypal_config, amount, currency, id_user_membership, symbol);
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
                        if (order.status == 'error') {
                            throw new Error(order.error || 'Erreur PayPal');
                        }
                        instance.triggerEvent('paypalOrderCreated', { order });
                        return order.id;
                    })
            },
            onApprove: function (data, actions) {
                let order_id = data.orderID;
                return fetch(instance.url_paiement, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({action: 'complete_order', order_id: order_id, attributes: JSON.stringify(instance.attributes)}).toString()
                })
                    .then((response) => response.json())
                    .then((order_details) => {
                        let intent_object = "captures";
                        instance.triggerEvent('paypalOrderCompleted', {
                            amount: order_details,
                        });
                    })
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
                .addEventListener('click', () => {
                    instance.triggerEvent('paypalSubmitClicked');
                    cardFields
                        .submit()
                        .catch(err => {
                            instance.triggerEvent('paypalError', { message: err });
                        });
                });
        }

        // Déclenchement de l'événement après l'initialisation des boutons
        instance.triggerEvent('paypalButtonsInitialized');
    }

    // Méthode pour déclencher des événements personnalisés
    triggerEvent(eventName, detail = {}) {
        const event = new CustomEvent(eventName, { detail });
        document.dispatchEvent(event);
    }

}

let paypal_instance = new Paypal();
paypal_instance.init();
