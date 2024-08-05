$(document).ready(function () {
    $('.checkall').change(function () {
        var id_cat = this.value;
        var to_check = this.checked;

        $(".categories input").each(function () {
            if (this.value == id_cat)
                this.checked = to_check;
        });
    });

    $('#massUploadSelect').change(function () {
        var to_check = this.checked;

        $(".checkboxMassImport").each(function () {
            this.checked = to_check;
            $(this).trigger("change");
        });
    });

    $(".display_toggle").click(function () {
        $(this).next().toggle();

        var chevron = $(this).prev();
        if (chevron.hasClass('glyphicon-chevron-right')) {
            chevron.removeClass('glyphicon-chevron-right');
            chevron.addClass('glyphicon-chevron-down');
        } else if (chevron.hasClass('glyphicon-chevron-down')) {
            chevron.removeClass('glyphicon-chevron-down');
            chevron.addClass('glyphicon-chevron-right');
        }
    });

    $('.checkboxMassImport').change(function () {
        if ($(this).is(':checked')) {
            $(this).parent().find(':input').prop('disabled', false);
            $(this).parent().find('div.note-editable').attr('contenteditable', 'true');
            $(this).parent().find('.tagit-close').show();
            $(this).parent().find('.tagit-choice').addClass('tagit-choice-editable').removeClass('tagit-choice-read-only');
        } else {
            $(this).parent().find(':input').not('.checkboxMassImport').prop('disabled', true);
            $(this).parent().find('div.note-editable').attr('contenteditable', 'false');
            $(this).parent().find('.tagit-close').hide();
            $(this).parent().find('.tagit-choice').removeClass('tagit-choice-editable').addClass('tagit-choice-read-only');
        }
    });

    $('.cbform').find(':input').not('.checkboxMassImport').not('#mass_upload_video').prop('disabled', true);
    $('.cbform').find('div.note-editable').attr('contenteditable', 'false');

    $('[id^="list_tags"]').each(function () {
        var id = $(this).data('id');
        $(this).tagit({
            singleField: true,
            fieldName: "tags",
            readOnly: false,
            singleFieldNode: $('#tags_video' + id),
            animate: true,
            caseSensitive:false
        });
        setTimeout(function(){
           $('#list_tags'+id).find(':input').prop('disabled', true);
        }, 200);
    });
});

