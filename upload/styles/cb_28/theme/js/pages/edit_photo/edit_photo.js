$(function () {
    init_tags('tags', available_tags);

    $('#collection_id').select2({
        width: '100%'
    });

    $('#edit_photo').on('submit', function (e) {
        if ($('#collection_id').val() === null) {
            $('#collection_id + .select2-container .select2-selection--single').css('border-color','red') ;
            e.preventDefault();
            return false;
        } 
    });
});