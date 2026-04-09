var alert_shown = false;
function init_tags(id_input, available_tags, list_tag, min_length) {
    if (typeof list_tag == 'undefined') {
        list_tag = '#list_tags';
    }
    if (typeof min_length == 'undefined') {
        min_length = 3;
    }
    $(list_tag).tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#' + id_input),
        animate: true,
        caseSensitive: false,
        availableTags: available_tags,
        allowSpaces: allow_tag_space,
        beforeTagAdded: function (event,info) {
            if (info.tagLabel.length < min_length) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(lang['tag_too_short_dynamic_' + min_length]);
                }
                return false;
            }
            alert_shown = false;
        }
    });
}