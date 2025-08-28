$(function() {
    $('input#password').on('keyup', function() {
        let passSec = $('#password'),
            passVal = passSec.val();

        if (passVal.length === 0) {
            addErrClass(passSec, errors["empty_pass"], true, false);
        } else {
            if (passVal.length < 8) {
                addErrClass(passSec,errors["weak_pass"],true, false ,'warning-ind');
            } else {
                removeErrClass(passSec,true);
            }
        }
    });

    $('input#cpassword').on('keyup', function() {
        let cPassSec = $('#cpassword'),
            cPassVal = cPassSec.val(),
            passVal = $('#password').val();

        if (cPassVal !== passVal) {
            addErrClass(cPassSec, errors["pass_mismatch"], true, false);
        } else {
            removeErrClass(cPassSec,true);
        }
    });

});


function removeErrClass(obj, passSec = false) {
    $(obj).closest('.form-group')
        .removeClass('invalid-error')
        .removeClass('warning-ind')
        .addClass('success-ind');

    $(obj).next('span').remove();
    let value;
    if (passSec === true) {
        value = lang_password;
    } else {
        value = $(obj).val();
    }
    $('<span class="help-block"><strong>'+value+'</strong> seems good to go</span>').insertAfter(obj);
}