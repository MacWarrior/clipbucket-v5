var alert_shown = false;
document.addEventListener("DOMContentLoaded", function () {
    init_tags_to('to');

    const managePages = document.querySelectorAll('.manage-page');
// Pour chaque div, on installe un observer
    managePages.forEach((targetNode) => {
        const config = {childList: true, subtree: true};

        const observer = new MutationObserver((mutationsList) => {
            for (const mutation of mutationsList) {
                // On vérifie les nouveaux éléments ajoutés
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1 && node.classList.contains('alert')) {
                        setTimeout(function () {
                            $(node).slideUp(500, function () {
                                $(this).remove();
                            });
                        }, 5000);
                    }
                });
            }
        });

        observer.observe(targetNode, config);
    });

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
        allowSpaces: is_space_in_username,
        beforeTagAdded: function (event, info) {
            if (info.tagLabel.length <= 2) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(tag_too_short);
                }
                return false;
            }
            alert_shown = false;
        },
        afterTagAdded: function (event, info) {
            const params = new URLSearchParams();
            var value = info.tagLabel;
            params.append('username', info.tagLabel);
            putSpinnerOnTag(info.tag);
            fetch(baseurl + 'actions/user_check.php', {
                method: 'POST', headers: {'Accept': 'application/json'}, body: params
            })
                .then(response => response.json())
                .then((data) => {
                    if (!data.success) {
                        document.querySelector('.manage-page').insertAdjacentHTML('afterbegin', data.msg);
                        info.tag.addClass('danger-important');
                        info.tag.find('span.tagit-label').append('<i class="fa fa-warning" aria-hidden="true"></i>');
                        info.tag.prop('title', data.text_msg);
                        setTimeout(function () {
                            info.tag.fadeOut(500, function () {
                                info.tag.find('a').trigger('click');
                            })
                        }, 5000)
                    } else if (data.success) {
                        info.tag.addClass('success-important');
                        info.tag.find('span.tagit-label').append('<i class="fa fa-check"  aria-hidden="true"></i>');
                        info.tag.find('a').show();
                        info.tag.prop('title', lang['checked_user']);
                    }
                    removeSpinnerOnTag(info.tag);
                })
        }
    });

}

function putSpinnerOnTag(tag) {
    tag.append('<i class="fa fa-spinner fa-spin"></i>');
    tag.find('a').hide();
    tag.prop('title',lang['running_verification']);
}

function removeSpinnerOnTag(tag) {
    tag.find('i.fa-spinner').remove();
}

