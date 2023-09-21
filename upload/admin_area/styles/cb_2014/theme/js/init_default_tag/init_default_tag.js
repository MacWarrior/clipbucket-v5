function init_tags(id_input, available_tags) {
    $('#list_tags').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#' + id_input),
        animate: true,
        caseSensitive: false,
        availableTags: available_tags,
        beforeTagAdded: function (event,info) {
            if (info.tagLabel.length <= 2) {
                return false;
            }
        }
    });
}