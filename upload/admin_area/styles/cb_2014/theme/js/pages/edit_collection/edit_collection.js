$(function () {
    $('#list_tags').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#collection_tags'),
        animate: true,
    });
});