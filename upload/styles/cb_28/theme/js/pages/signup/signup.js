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

$(document).ready(function(){
    jQuery('#dob').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat:format_date_js,
        changeYear: true,
        yearRange: "-99:+0",
        regional:language
    });

    $('input#username').on('keyup', function() {
        let userSect = $('#username'),
            usernameVal = userSect.val().trim(),
            usernameRegex = config_username_spaces ? /^[A-Za-z0-9_. ]+$/ : /^[A-Za-z0-9_.]+$/;

        if (usernameVal.length === 0) {
            addErrClass(userSect, errors["empty_name"], true, false);
        } else if (usernameVal.length <= config_min_username || usernameVal.length >= config_max_username) {
            addErrClass(userSect, errors["name_length"], true, false);
        } else if (!config_username_spaces && userSect.val().indexOf(' ') >= 0) {
            addErrClass(userSect, errors["username_spaces"], true, false);
        } else if(!userSect.val().match(usernameRegex)) {
            addErrClass(userSect, errors["name_invalid_chars"], true, false);
        } else {
            $.ajax({
                url: baseurl+"ajax/commonAjax.php",
                type: "post",
                dataType: "html",
                data: {
                    "mode":'userExists',
                    "username":usernameVal
                },
                beforeSend: function() {
                    $(document).find('#more-view-channel').text('Loading videos..')
                },

                success: function(data) {
                    data = $.trim(data);
                    if (data === 'NO') {
                        removeErrClass(userSect);
                    } else {
                        addErrClass(userSect, errors['user_exists'], true, false)
                    }
                }
            });
        }
    });

    $('input#email').on('keyup change', function() {
        let emailSec = $('#email'),
            email = emailSec.val().trim();

        if (email.length === 0) {
            addErrClass(emailSec, errors["empty_email"], true, false);
        } else if (!isValidEmail(email)) {
            addErrClass(emailSec, errors["invalid_email"], true, false);
        } else {
            $.ajax({
                url: baseurl+"ajax/commonAjax.php",
                type: "post",
                dataType: "html",
                data: {
                    "mode":'check_email',
                    "email":email
                },
                success: function(data) {
                    data = $.trim(data);
                    if (data === 'OK') {
                        removeErrClass(emailSec);
                    } else if( data === 'emailExists' ) {
                        addErrClass(emailSec, errors['email_exists'], true, false)
                    } else if( data === 'unauthorized' ) {
                        addErrClass(emailSec, errors['email_unauthorized'], true, false)
                    } else {
                        addErrClass(emailSec, data, true, false)
                    }
                }
            });
        }
    });

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

    $('#login_btn').on("click",function(e){
        e.preventDefault();
        $('#login_form').submit();
    });

    $('#signup_submit').on("click",function(e){
        e.preventDefault();
        $('.help-block').remove();
        $('div').removeClass('invalid-error');
        let emailSect = $('#email'),
            email = emailSect.val().trim(),
            passwordSect = $('#password'),
            password = passwordSect.val(),
            cpasswordSect = $('#cpassword'),
            cpassword = cpasswordSect.val(),
            goodToGo = true,
            userSect = $('#username'),
            usernameVal = userSect.val().trim(),
            usernameRegex = config_username_spaces ? /^[A-Za-z0-9_. ]+$/ : /^[A-Za-z0-9_.]+$/;

        if (usernameVal.length === 0) {
            addErrClass(userSect, errors["empty_name"], true, false);
            goodToGo = false;
        } else if (usernameVal.length <= config_min_username || usernameVal.length >= config_max_username) {
            addErrClass(userSect, errors["name_length"], true, false);
            goodToGo = false;
        } else if (!config_username_spaces && userSect.val().indexOf(' ') >= 0) {
            addErrClass(userSect, errors["username_spaces"], true, false);
            goodToGo = false;
        } else if(!userSect.val().match(usernameRegex)) {
            addErrClass(userSect, errors["name_invalid_chars"], true, false);
            goodToGo = false;
        }

        if (email.length === 0) {
            addErrClass(emailSect, errors["empty_email"]);
            goodToGo = false;
        } else if (!isValidEmail(email)) {
            addErrClass(emailSect, errors["invalid_email"]);
            goodToGo = false;
        }

        if (password.length === 0)  {
            addErrClass(passwordSect, errors["empty_pass"]);
            goodToGo = false;
        }

        if (password !== cpassword) {
            addErrClass(cpasswordSect, errors["pass_mismatch"]);
            goodToGo = false;
        }

        if (goodToGo === true) {
            $('#signup_form').submit();
        }
    });
});