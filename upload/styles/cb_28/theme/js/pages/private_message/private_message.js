var alert_shown = false;
var skipBeforeTagAdded = false;
var alert_user_tested = '';
document.addEventListener("DOMContentLoaded", function () {
    init_tags_to('to');

});

function init_tags_to(id_input, available_tags, list_tag) {
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
        allowSpaces: allow_tag_space,
        beforeTagAdded: function (event, info) {
            if (info.tagLabel.length <= 2) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(tag_too_short);
                }
                return false;
            }
            alert_shown = false;
            debugger
            if (skipBeforeTagAdded) {
                return true;
            }
            showSpinner();
            addUsernameTag(info.tagLabel);
            return false;
        }
    });
}
async function addUsernameTag(value) {
    const params = new URLSearchParams();
    params.append('username', value);
    const response = await fetch('actions/user_check.php', {
        method: 'POST', headers: { 'Accept': 'application/json' }, body: params
    });
    const data = await response.json();
    hideSpinner();
    debugger;
    if (!data.success && (alert_user_tested === '' || alert_user_tested !== value)) {
        alert_user_tested = value;
        document.querySelector('.manage-page').insertAdjacentHTML('afterbegin', data.msg);
        skipBeforeTagAdded = false;
    } else if(data.success) {
        alert_user_tested = '';
        skipBeforeTagAdded = true;
        $('#list_tags').tagit('createTag', value); // ajout manuel
        skipBeforeTagAdded = false;
    }
}