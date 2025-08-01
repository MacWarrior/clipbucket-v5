var ajax_url = './ajax.php';

function dbconnect() {
    $('#loading').html('<img src="./images/loading.gif"/>');
    var formData = $('#installation').serialize();

    $.post(ajax_url,formData,function(data) {
        if(data.err) {
            $('#dbresult').show().html(data.err)
            $('#loading').html('');
        } else {
            $('#installation').submit();
        }
    },"json");
}

function dodatabase(step) {
    var formData = $('#installation').serialize();

    formData += '&step='+step;
    $.post(ajax_url,formData,function(data) {
        if(data.msg){
            $('#dbresult').show().append(data.msg);
        }
        if(data.err){
            $('.errorDiv').show().append(data.err);
            $('#loading').attr('src','images/cross_arrow.png');
        }
        if(data.status){
            $('#current').html(data.status);
        }
        if(data.step == 'forward') {
            $('#installation').submit();
        }
        if(data.step && data.step != 'forward'){
            dodatabase(data.step);
        }
    },"json");
}

function password(length, special) {
    var iteration = 0;
    var password = "";
    var randomNumber;
    if(special == undefined){
        var special = false;
    }
    while(iteration < length){
        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
        if(!special){
            if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
            if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
            if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
            if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
        }
        iteration++;
        password += String.fromCharCode(randomNumber);
    }
    return password;
}

function newpassword() {
    var pass = password(8,true);

    $('#genPass').html(pass);
    $('#password').val(pass);
}

$( document ).ready(function() {
    $("[id^='skip_']").change(function(){
        if (this.checked) {
            $(this).parent().find("[id$='_filepath']").val('').prop('disabled', true);
            $(this).parent().find("[id$='_filepath_test']").addClass('disabled');
        } else {
            $(this).parent().find("[id$='_filepath']").prop('disabled', false);
            $(this).parent().find("[id$='_filepath_test']").removeClass('disabled');
        }
    });

    $("[id$='_filepath_test']").click(function(){
        $('#mode').val('precheck');
        $('#installation').submit();
    });

    var select_timezone = $('.check_timezone');
    if (select_timezone.length > 0) {
        $('.btn-primary').prop('disabled', true);
        select_timezone.on('change', function (event) {
            $('.alert-dismissable').remove();
            $(select_timezone).removeClass('has-error');
            $('#timezone').next('.select2-container').removeClass('has-error');
            $('#spinner-content').show();
            $.post('./check_timezone.php',{timezone: $(this).val()} ,function(data) {
                if (data.success) {
                    $('.btn-primary').prop('disabled', false);
                } else {
                    $(select_timezone).addClass('has-error');
                    $('#timezone').next('.select2-container').addClass('has-error');
                    $('#sub_container').prepend(data.msg);
                    $('.btn-primary').prop('disabled', true);
                }
                $('#spinner-content').hide();
            }, 'JSON');
        });
    }

    $('#submit_update').on('click', function (e){
        e.preventDefault();
        checkBeforeSubmit(need_update);
    });
    $('.update_core').on('click', function () {
        var button = $(this);
        $('.btn').prop('disabled', 'disabled');
        $('.text').hide();
        $('.spinner-content').show();
        $.post({
            url: './update_core.php',
            dataType: "json",
            success: (data) => {
                $('.btn').prop('disabled', '');
                $('.text').show();
                $('.spinner-content').hide();
                if (data.msg) {
                    $('#resultDiv').show().html(data.msg);
                    $('.errorDiv').hide().html('');
                    button.parent().parent().remove();
                    need_update = false;
                }
                if (data.err) {
                    $('.errorDiv').show().html(data.err);
                    $('#resultDiv').hide().html('');
                    $('#loading').attr('src', 'images/cross_arrow.png');
                }
            }
        })
    });

    $('#timezone').select2();
    $('#timezone').next('.select2-container').addClass('has-error');

});

function checkBeforeSubmit(check) {
    var go_submit = false;
    if (check) {
        if (confirm('Do you really want do go further without updating ?')) {
            go_submit = true;
        }
    } else {
        go_submit = true;
    }
    if (go_submit) {
        $('#installation').trigger("submit");
    } else {
        return false;
    }
}
