$(function () {
    init_tags('tags', available_tags);

    $('#collection_id').select2({
        width: '100%'
    });
});