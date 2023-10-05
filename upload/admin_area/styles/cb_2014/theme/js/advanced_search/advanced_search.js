$(function () {
    $(".current").click(function() {
        $(this).toggleClass('after');
        if(!$(this).hasClass('after'))
        {
            $('.down').hide();
            $('.up').show();
        } else {
            $('.down').show();
            $('.up').hide();
        }
    });
    init_tags(id_input, available_tags);
})