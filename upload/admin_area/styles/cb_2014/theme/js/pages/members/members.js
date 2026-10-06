$(function () {
    $('.inputs input[type="submit"]').on('click', function () {
        $('[name="user_manage"]').append('<input type="hidden" name="'+$(this).attr('name')+'" value="'+$(this).val()+'">').submit();
    });
});
