
class Payment {

    id_user_membership = null;

    /** capture le click sur les bouton de validation dans la page de seelction des abonnements  */
    capture_select_membership = function() {
        let instance = this;

        document.querySelectorAll('.btn_subscribe').forEach(function (elem) {
            elem.addEventListener('click', function(event){

                /** conserver l'id_membership selectionné */
                let id_membership = elem.dataset.id_membership;

                /** creer la ligne dans user_membership
                 * si elle existe deja
                 *      si meme abonement => la conserver
                 *          sinon si aucune transaction => update
                 *          sinon si transaction => la mettre en canceled et en creer une nouvelle
                 * */

                /** recup l'id_user_membership */
                instance.id_user_membership = 123547;

                /** passer a l'étape suivante */
                document.dispatchEvent(new CustomEvent('payment:gotoStep2'));
            });
        });

    }

    go_to_step_2 = function() {

         document.dispatchEvent(new CustomEvent('payment:captureSaveBillingAdress'));

        document.querySelector('#stepper-step-1').style.display = 'none';
        document.querySelectorAll('.payment-stepper .step')[0].classList.add('completed');
        document.querySelectorAll('.payment-stepper .step')[1].classList.add('active');
        document.querySelector('#stepper-step-2').style.display = 'block';
    }

    /** capture le click sur les save du bloc de saisie de l'adresse de facturation */
    capture_save_billing_adress = function() {
        let instance = this;
        /** passer a l'étape suivante */
        document.querySelectorAll('.btn-save-billing-adress').forEach(function (elem) {
            elem.addEventListener('click', function(event){

                /** enregistrer en ajax la mise a jour du billing adress
                 * puis update user_membership pour save l'id_billing_adress utilisé
                 */
                
                /** passer a l'étape suivante */
                document.dispatchEvent(new CustomEvent('payment:gotoStep3'));
            });
        });
    }

    go_to_step_3 = function() {

        document.dispatchEvent(new CustomEvent('payment:initPaiementBloc', {
            detail: {
                Paypal: Paypal ?? null
            }
        }));

        document.querySelector('#stepper-step-2').style.display = 'none';
        document.querySelectorAll('.payment-stepper .step')[1].classList.add('completed');
        document.querySelectorAll('.payment-stepper .step')[2].classList.add('active');
        document.querySelector('#stepper-step-3').style.display = 'block';

        /** cacher le bloc avec les input iframe de paypal tant que pas init */
        document.querySelector('#paypal-card-form').style.display = 'none';
    }

    /** capture les event custom de paiement et les redirige vers les methode adapté */
    enable_step_payment = function() {
        let instance = this;

        document.addEventListener('payment:gotoStep2', function (event) {
            instance.go_to_step_2();
        });

        document.addEventListener('payment:gotoStep3', function (event) {
            instance.go_to_step_3();
        });

        document.addEventListener('payment:initPaiementBloc', function (event) {
            instance.init_paiement_bloc(event.detail.Paypal);
        });

        document.addEventListener('payment:captureSaveBillingAdress', function (event) {
            instance.capture_save_billing_adress();
        });

    }

    init_paiement_bloc = function(Paypal){
        let instance = this;
        instance.init_paiment_bloc_switch_card_saved_and_new_card();
        instance.init_paypal(Paypal);

        /** aficher le bloc avec les input iframe de paypal apres init de paypal completed */
        document.addEventListener('paypalButtonsInitialized', () => {
            document.querySelector('#paypal-card-form').style.display = 'block';
        });

    }

    init_paypal = function(Paypal){
        let instance = this;

        try {

            /** si la variable Paypal n'est pas init alors on stop tout avec une erreur */
            if( typeof Paypal === 'undefined') {
                throw new Error("Variable Paypal missing !");
            }

            /** donnée pour identifier la commande dans la classe paypal */
            let id_user_membership = instance.id_user_membership;

            /** Init la calsse de paiement de la lib */
            let paypalInstance = new PaypalCustom( {
                paypal_sdk_url: Paypal.paypal_sdk_url
                ,client_id: Paypal.client_id
                ,currency: Paypal.currency
                ,attributes: {id_user_membership: id_user_membership}
                ,url_paiement: Paypal.url_paiement
            });

            /** ajouter la checkbox pour enregistrer la carte dans les attributes */
            document.querySelector('#saveCard').addEventListener('change', (e) => {
                paypalInstance.attributes.saveCard = e.target.checked
            })

            /** ajouter la checkbox pour enregistrer la carte dans les attributes */
            document.querySelector('#renewAuto').addEventListener('change', (e) => {
                paypalInstance.attributes.renewAuto = e.target.checked
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

}
