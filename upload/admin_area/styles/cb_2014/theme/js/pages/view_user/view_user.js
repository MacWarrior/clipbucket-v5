
$(function () {
    $('#list_tags').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#profile_tags'),
        animate: true,
    });
});
