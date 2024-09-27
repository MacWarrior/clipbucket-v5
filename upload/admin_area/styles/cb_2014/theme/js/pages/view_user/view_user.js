$(function () {
    init_tags('profile_tags', available_tags);

    $('[name="disabled_channel"]').on('change', function (e) {
        var inputs = $(this).parents('table').find('input, textarea').not('#disabled_channel');
        inputs.each( (i,e)=> $(e).prop('disabled', ($(this).val() === 'yes')))
    });
});
