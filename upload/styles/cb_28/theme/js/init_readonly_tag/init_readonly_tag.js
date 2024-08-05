    function init_readonly_tags(id_input, list_tag) {
        if (typeof list_tag == 'undefined') {
            list_tag = '#list_tags';
        }
        if (typeof id_input == 'undefined') {
            id_input = 'tags';
        }
        $(list_tag).tagit({
            singleField: true,
            fieldName: "tags",
            readOnly: true,
            singleFieldNode: $('#' + id_input),
            animate: false,
            caseSensitive: false
        });

        if (link_type !== undefined && link_type) {
            var labels = $(list_tag + ' .tagit-label');
            labels.each(function () {
                $(this).parent().first().wrap('<a href="/search_result.php?query=' + $(this).html() + '&type=' + link_type + '"></a>');
            });
        }
    }
