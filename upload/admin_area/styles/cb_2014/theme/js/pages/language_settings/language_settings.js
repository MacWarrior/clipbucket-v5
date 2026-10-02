function initListenerList() {

    $('input[name="make_default"]').change(function () {
        $('input[name="make_default"]').not(this).prop('checked', false);
        $.ajax({
            url: admin_url + 'actions/language_make_default.php',
            type: "POST",
            data: $('#default_lang').serialize(),
            dataType: 'json',
            success: function (result) {
                $('#language_list').html(result['template']);
                $('.close').click();
                $('.page-content').prepend(result['msg']);
                initListenerList();
            }
        });
    });

    $('#formAdd').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: admin_url + 'actions/language_add.php',
            type: "POST",
            data: $('#formAdd').serialize(),
            dataType: 'json',
            success: function (result) {
                $('#language_list').html(result['template']);
                $('.close').click();
                $('.page-content').prepend(result['msg']);
                initListenerList();
            }
        });
    });

    $('#formRestore').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: admin_url + 'actions/language_restore.php',
            type: "POST",
            data: $('#formRestore').serialize(),
            dataType: 'json',
            success: function (result) {
                $('.close').click();
                $('#language_list').html(result['template']);
                $('.page-content').prepend(result['msg']);
                updateRestoreList();
                initListenerList();
            }
        });
    });
}
function formatOption(option) {
    if (!option.id) {
        return option.text;
    }

    const image = $(option.element).data('image');

    return $('<span> <img src="' + image + '" style="width:20px;height:20px;margin-right:8px;vertical-align:middle;">' + option.text + '</span>');
}
function initListenerEdit() {
    $('#form1').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: admin_url + 'actions/language_update.php',
            type: "POST",
            data: $('#form1').serialize(),
            dataType: 'json',
            success: function (result) {
                $('.close').click();
                $('#language_edit').html(result['template']);
                $('.page-content').prepend(result['msg']);
                $('#flag').select2({
                    templateResult: formatOption,      // options de la liste
                    templateSelection: formatOption,   // valeur sélectionnée
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                });
                initListenerEdit();
            }
        });
    });
}

function updateRestoreList() {
    $.ajax({
        url: admin_url + 'actions/language_restorable_list.php',
        type: "POST",
        dataType: 'json',
        success: function (result) {
            $('#div_restore_lang').html(result['template']);
            $('.page-content').prepend(result['msg']);
            initListenerList();
        }
    });
}

function deleteLanguage(language_id, language_name) {
    if (confirm_it('Are you sure you want to delete ' + language_name)) {
        $.ajax({
            url: admin_url + 'actions/language_delete.php',
            type: "POST",
            data: {language_id: language_id},
            dataType: 'json',
            success: function (result) {
                $('.close').click();
                $('#language_list').html(result['template']);
                $('.page-content').prepend(result['msg']);
                updateRestoreList();
            }
        });
    }
}

$(document).ready(function () {
    initListenerList();
    initListenerEdit();
    $('.edit_translation').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('#input-' + id).show();
        $('#ok-' + id).show();
        $('#remove-' + id).show();
        $('#edit-' + id).hide();
    });

    $('.cancel_translation').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('#input-' + id).hide();
        $('#ok-' + id).hide();
        $('#remove-' + id).hide();
        $('#edit-' + id).show();
    });

    $('.confirm_update_translation').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        var value = $('#input-' + id).val();
        var language_id = $('#language_id').val();
        $.ajax({
            url: admin_url + 'actions/update_phrase.php',
            type: "post",
            data: {id_language_key: id, translation: value, language_id: language_id},
            success: function () {
                $('#' + id).html(value);
                $('#input-' + id).hide();
                $('#ok-' + id).hide();
                $('#remove-' + id).hide();
                $('#edit-' + id).show();
            }
        });
    });



    $('#flag').select2({
        templateResult: formatOption,      // options de la liste
        templateSelection: formatOption,   // valeur sélectionnée
        escapeMarkup: function (markup) {
            return markup;
        }
    });
});
