
class Payment {

    id_user_membership = null;
    amount = null;
    currency = null;
    symbol = null;

    /** capture le click sur les bouton de validation dans la page de seelction des abonnements  */
    capture_select_membership = function() {
        let instance = this;

        document.querySelectorAll('.btn_subscribe').forEach(function (elem) {
            elem.addEventListener('click', function(event){

                /** conserver l'id_membership selectionné */
                let id_membership = elem.dataset.id_membership;

                /** init de la commande dans la bdd */
                fetch("/actions/set_membership.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        id_membership: id_membership
                    })
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

                        /** recup l'id_user_membership */
                        instance.id_user_membership = result.id_user_membership;
                        instance.amount = result.amount;
                        instance.currency = result.currency;
                        instance.symbol = result.symbol;

                        /** passer a l'étape suivante */
                        document.dispatchEvent(new CustomEvent('payment:gotoStep2'));
                    })
                    .catch(error => {

                        let msg = lang_unable_to_set_membership;
                        if (error instanceof ClientVisibleError) {
                            msg = error.message;
                        }

                        _cb?.showMeTheMsg?.(
                            '<div class="error">' + msg + '</div>'
                        );

                    });

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
                fetch("/actions/user_set_billing_adress.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        id_user_membership: instance.id_user_membership ?? null
                        ,billing_name: document.getElementById('address_name').value
                        ,billing_address_line_1: document.getElementById('address_line_1').value
                        ,billing_address_line_2: document.getElementById('address_line_2').value
                        ,billing_admin_area_1: document.getElementById('admin_area_1').value
                        ,billing_admin_area_2: document.getElementById('admin_area_2').value
                        ,billing_postal_code: document.getElementById('postal_code').value
                        ,billing_country_code: document.getElementById('country_code').value
                    })
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

                        /** passer a l'étape suivante */
                        document.dispatchEvent(new CustomEvent('payment:gotoStep3'));
                    })
                    .catch(error => {
                        let msg = lang_unable_to_set_membership;
                        if (error instanceof ClientVisibleError) {
                            msg = error.message;
                        }

                        _cb?.showMeTheMsg?.(
                            '<div class="error">' + msg + '</div>'
                        );
                    });

            });
        });
    }

    go_to_step_3 = function() {
        document.querySelector('#stepper-step-2').style.display = 'none';
        document.querySelectorAll('.payment-stepper .step')[1].classList.add('completed');
        document.querySelectorAll('.payment-stepper .step')[2].classList.add('active');
        document.querySelector('#stepper-step-3').style.display = 'block';
    }

    loadJsFiles = function() {
        let url = '/actions/payment.php?action=js_files';
        Payment.urlToHead(url, 'js')
            .then(() => {})
            .catch((error) => {
                _cb?.showMeTheMsg?.(
                    '<div class="error">' + lang_error_loading_script_file + '</div>'
                );
            });

        url = '/actions/payment.php?action=css_files';
        Payment.urlToHead(url, 'css')
            .then(() => {})
            .catch((error) => {
                _cb?.showMeTheMsg?.(
                    '<div class="error">' + lang_error_loading_css_file + '</div>'
                );
            });
    }

    /**
     * Charge dynamiquement un fichier dans le <head>
     * @static
     * @param {string} url - URL du fichier à charger
     * @param {string} [forceType] - Force le type : 'js' ou 'css'. Auto-detect si omis
     * @returns {Promise<void>}
     */
    static urlToHead(url, forceType = null) {
        return new Promise((resolve, reject) => {
            // Détermine le type
            const isCss = forceType === 'css' || (!forceType && url.match(/\.css(\?.*)?$/i));
            const isJs = forceType === 'js' || (!forceType && !isCss);

            // Vérifie si déjà chargé
            const selector = isCss ? `link[href="${url}"]` : `script[src="${url}"]`;
            if (document.querySelector(selector)) {
                resolve();
                return;
            }

            // Crée l'élément
            const el = document.createElement(isCss ? 'link' : 'script');

            if (isCss) {
                el.rel = 'stylesheet';
                el.href = url;
            } else {
                el.src = url;
                el.async = true;
            }

            el.onload = () => resolve();
            el.onerror = () => reject(new Error(`Failed to load: ${url}`));

            document.head.appendChild(el);
        });
    }

    /** capture les event custom de paiement et les redirige vers les methode adapté */
    enable_step_payment = function() {
        let instance = this;

        document.addEventListener('payment:gotoStep2', function (event) {
            instance.go_to_step_2();
        });

        document.addEventListener('payment:gotoStep3', function (event) {
            instance.go_to_step_3();

            document.dispatchEvent(new CustomEvent('payment:initPaiementBloc', {
                detail: {
                    id_user_membership: instance.id_user_membership,
                    amount: instance.amount,
                    currency: instance.currency,
                    symbol: instance.symbol
                }
            }));
        });

        document.addEventListener('payment:captureSaveBillingAdress', function (event) {
            instance.capture_save_billing_adress();
        });

    }

    capture_cancel_membership() {
        let instance = this;
        /** passer a l'étape suivante */
        document.querySelectorAll('#cancelMembership').forEach(function (elem) {
            elem.addEventListener('click', function(event){

                /** @todo add comfirm popup before canceled memebrship */

            fetch("/actions/user_cancel_membership.php", {
                method: "POST",
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

                    /** passer a l'étape suivante */
                    document.dispatchEvent(new CustomEvent('payment:canceled'));
                })
                .catch(error => {
                    let msg = lang_unable_to_set_membership;
                    if (error instanceof ClientVisibleError) {
                        msg = error.message;
                    }

                    _cb?.showMeTheMsg?.(
                        '<div class="error">' + msg + '</div>'
                    );
                });

            });
        });

        document.querySelectorAll('#reEnableMembership').forEach(function (elem) {
            elem.addEventListener('click', function(event){

                fetch("/actions/user_reenable_membership.php", {
                    method: "POST",
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

                        /** passer a l'étape suivante */
                        document.dispatchEvent(new CustomEvent('payment:reEnabled'));
                    })
                    .catch(error => {
                        let msg = lang_unable_to_set_membership;
                        if (error instanceof ClientVisibleError) {
                            msg = error.message;
                        }

                        _cb?.showMeTheMsg?.(
                            '<div class="error">' + msg + '</div>'
                        );
                    });

            });
        });

    }
}
