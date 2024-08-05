var alert_shown = false;
function init_tags(id_input, available_tags, list_tag) {
    if (typeof list_tag == 'undefined') {
        list_tag = '#list_tags';
    }
    $(list_tag).tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#' + id_input),
        animate: true,
        caseSensitive: false,
        availableTags: available_tags,
        beforeTagAdded: function (event,info) {
            if (info.tagLabel.length <= 2) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(tag_too_short);
                }
                return false;
            }
            alert_shown = false;
        }
    });
}