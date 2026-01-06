
function refund(id_paypal_transaction, montant) {
    showSpinner();
    $.ajax({
        url: "/actions/admin_refund_transaction.php",
        type: "POST",
        data: {id_paypal_transaction: id_paypal_transaction, montant: montant},
        dataType: 'json',
        success: function (result) {
            console.log(result);
            console.log('refund terminé');
            window.location.reload();
            hideSpinner();
        }
    });
}
function renew(id_paypal_transaction, montant) {
    showSpinner();
    $.ajax({
        url: "/actions/admin_renew_transaction.php",
        type: "POST",
        data: {id_paypal_transaction: id_paypal_transaction, montant: montant},
        dataType: 'json',
        success: function (result) {
            console.log(result);
            console.log('renew terminé');
            window.location.reload();
            hideSpinner();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.refund').forEach(function (elem) {
        elem.addEventListener('click', function(event){
            let id_paypal_transaction = elem.dataset.id_paypal_transaction;
            refund(id_paypal_transaction, 10)
        });
    });

    document.querySelectorAll('.renew').forEach(function (elem) {
        elem.addEventListener('click', function(event){
            let id_paypal_transaction = elem.dataset.id_paypal_transaction;
            renew(id_paypal_transaction, 100)
        });
    });

});