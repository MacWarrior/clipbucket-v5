var inputs = document.querySelectorAll('#mfa_code input');
var modalElement = document.getElementById('enterMFACodeModal');
var confirmButton = document.getElementById('confirmMFACodeBtn');
var closeModalButton = document.querySelector('.close');
need_mfa = false;
document.addEventListener('DOMContentLoaded', function () {
    inputs = document.querySelectorAll('#mfa_code input');
    modalElement = document.getElementById('enterMFACodeModal');
    confirmButton = document.getElementById('confirmMFACodeBtn');
    closeModalButton = document.querySelector('.close');
    const form = document.querySelector('form[name="login_form"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        showSpinner();
        const username = document.getElementById('login_username_sp').value;
        const password = document.getElementById('login_password_sp').value;
        const remember_me = document.getElementById('remember_me').value;

        if (username === '' || password === '') {
            alert(lang['please_fill_all_fields']);
            hideSpinner();
            return false;
        }

        let mfa_code = '';
        if (typeof need_mfa !== 'undefined' && need_mfa) {
            if (modalElement.classList.contains('in') === false) {
                showModal();
                hideSpinner();
                return false;
            }
            inputs.forEach((input) => {
                mfa_code += input.value;
            });

            if (mfa_code.trim() === '') {
                alert(lang['please_enter_mfa_code']);
                hideSpinner();
                return false;
            }

            if (mfa_code.length !== 6) {
                alert(lang['please_enter_6_digit_mfa_code']);
                hideSpinner();
                return false;
            }
        }

        fetch(baseurl + 'actions/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                username: username,
                password: password,
                mfa_code: mfa_code,
                remember_me: remember_me
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.need_mfa) {
                    showModal();
                    need_mfa = response.need_mfa;
                    if (need_mfa === 'email') {
                        document.getElementById('email_mfa_hint').style.display = 'block';
                    }
                    hideSpinner();
                } else if (response.success) {
                    closeModalButton.click();
                    window.location.href = response.redirect;
                } else {
                    hideSpinner();
                }

                if (!need_mfa) {
                    const pageContent = document.querySelector('.account-holder');
                    if (pageContent) {
                        insertHTMLBefore(pageContent, response.msg);
                    }
                } else {
                    const pageContent = document.querySelector('#enterMFACodeModal > div > div > div.modal-body > .form-group');
                    if (pageContent) {
                        insertHTMLAfter(pageContent, response.msg);
                    }
                }
            })
            .catch(err => {
                console.error('Login error:', err);
                alert('An error occurred');
            })
    });
    if( confirmButton ){
        confirmButton.addEventListener('click', function () {
            form.requestSubmit();
        });
    }

    closeModalButton.addEventListener('click', function () {
        closeModal();
    });

    inputs.forEach((input, idx) => {
        // Passage automatique au champ suivant après un caractère
        input.addEventListener('input', () => {
            if (input.value.length === 1 && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
        });

        // Revenir au champ précédent avec "Backspace" si le champ est vide
        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && input.value === '' && idx > 0) {
                inputs[idx - 1].focus();
            }
        });

        // Coller une chaîne : remplissage automatique de tous les champs
        input.addEventListener('paste', e => {
            e.preventDefault();
            const data = e.clipboardData.getData('text');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = data[i] || '';
            }
            // Placer le focus sur le dernier caractère collé
            const next = Math.min(data.length, inputs.length) - 1;
            if (next >= 0) {
                inputs[next].focus();
            }
        });
    });

});



function closeModal() {
    modalElement.classList.remove('in');
    modalElement.style.display = 'none';
    modalElement.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
    let backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
}

function showModal() {
    modalElement.classList.add('in');
    modalElement.style.display = 'block';
    modalElement.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
    let backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade in';
    document.body.appendChild(backdrop);
    modalElement.querySelectorAll('[data-dismiss="modal"]').forEach(function (btn) {
        btn.addEventListener('click', closeModal);
    });
}

function insertHTMLAfter(referenceNode, htmlString) {
    const range = document.createRange();
    range.setStartAfter(referenceNode);
    const fragment = range.createContextualFragment(htmlString);
    referenceNode.parentNode.insertBefore(fragment, referenceNode.nextSibling);
}

function insertHTMLBefore(referenceNode, htmlString) {
    const range = document.createRange();
    range.setStartBefore(referenceNode);
    const fragment = range.createContextualFragment(htmlString);
    referenceNode.parentNode.insertBefore(fragment, referenceNode);
}