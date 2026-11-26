$(function () {
    const selector = '.video-translations';

    function refreshFlags(translations) {
        translations.querySelectorAll('.video-translation-fields').forEach(function (fields) {
            const values = Array.from(fields.querySelectorAll('[data-field]'), field => field.value.trim() !== '');
            const flag = translations.querySelector('.flag_language[data-id="' + fields.dataset.id + '"]');
            const status = values.every(Boolean) ? 'specified' : values.some(Boolean) ? 'partial' : 'empty';
            flag.querySelector('img').classList.toggle('grey_filter', status === 'empty');
            flag.title = flag.dataset.languageName + ' — ' + translations.dataset[status];
        });
    }

    function selectLanguage(translations, id) {
        translations.querySelector('[name="selected_video_language"]').value = id;
        translations.querySelectorAll('.flag_language').forEach(function (flag) {
            const selected = flag.dataset.id === id;
            flag.setAttribute('aria-current', selected);
            flag.querySelector('img').classList.toggle('selected', selected);
        });
        translations.querySelectorAll('.video-translation-fields').forEach(function (fields) {
            fields.hidden = fields.dataset.id !== id;
        });
        translations.querySelectorAll('[data-field]').forEach(field => field.setCustomValidity(''));
    }

    function validate(form) {
        const translations = form.querySelector(selector);
        if (!translations) {
            return true;
        }
        for (const fields of translations.querySelectorAll('.video-translation-fields')) {
            const inputs = Array.from(fields.querySelectorAll('[data-field]'));
            const required = fields.dataset.default === 'true' || inputs.some(field => field.value.trim() !== '');
            for (const field of inputs) {
                const filled = field.value.trim() !== '';
                const length = Array.from(field.value).length;
                let message = '';
                if (required && !filled) {
                    message = field.dataset.requiredMessage;
                } else if (filled && (length < Number(field.dataset.min) || length > Number(field.dataset.max))) {
                    const flag = translations.querySelector('.flag_language[data-id="' + fields.dataset.id + '"]');
                    message = flag.dataset.languageName + ' — ' + field.dataset.lengthMessage;
                }
                if (message) {
                    selectLanguage(translations, fields.dataset.id);
                    const tab = $(translations).closest('#videoinfos');
                    if (tab.length && !tab.hasClass('active')) {
                        $('a[href="#videoinfos"]').tab('show');
                    }
                    field.setCustomValidity(message);
                    field.focus();
                    field.reportValidity();
                    return false;
                }
            }
        }
        return true;
    }

    $(document).on('click', selector + ' .flag_language', function (event) {
        event.preventDefault();
        selectLanguage(this.closest(selector), this.dataset.id);
    }).on('input', selector + ' [data-field]', function () {
        const translations = this.closest(selector);
        translations.querySelectorAll('[data-field]').forEach(field => field.setCustomValidity(''));
        refreshFlags(translations);
    });

    // Capture submission before the upload page's AJAX handlers build the request.
    document.addEventListener('submit', function (event) {
        if (!validate(event.target)) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }, true);

    const remoteForm = document.getElementById('remote_play_form');
    const remoteSave = document.getElementById('remote_play_submit_form2');
    if (remoteSave) {
        remoteSave.addEventListener('click', function (event) {
            if (!validate(remoteForm)) {
                event.preventDefault();
                event.stopImmediatePropagation();
            }
        }, true);
    }

    const uploadForms = document.getElementById('allUploadForms');
    if (uploadForms) {
        function prepareUploadForms() {
            uploadForms.querySelectorAll(selector + ' [name="title"], ' + selector + ' [name="description"]').forEach(function (field) {
                const id = field.closest('.video-translation-fields').dataset.id;
                field.name = 'video_translations[' + id + '][' + field.dataset.field + ']';
                refreshFlags(field.closest(selector));
            });
        }

        // The uploader fills its template's title and description before appending each clone.
        new MutationObserver(prepareUploadForms).observe(uploadForms, {childList: true, subtree: true});
        prepareUploadForms();
    }

    $(document).ajaxComplete(function (event, response, settings) {
        const result = response.responseJSON;
        const action = settings.url.split('?')[0].split('/').pop();
        if (action === 'remote_play_send_form.php' && remoteForm) {
            if (result && result.filename) {
                const translations = remoteForm.querySelector(selector);
                if (translations) {
                    translations.querySelectorAll('[data-default="true"] [data-field]').forEach(field => field.value = result.filename);
                    refreshFlags(translations);
                }
            } else if (!result || result.error) {
                $(remoteSave).prop('disabled', false).html(remote_play_lang_submit_now);
            }
            return;
        }

        if (action === 'file_uploader.php' && settings.data instanceof FormData && settings.data.has('updateVideo') && (!result || result.error)) {
            const videoId = settings.data.get('videoid');
            $('.updateVideoInfoForm').has('[name="videoid"][value="' + videoId + '"]').find('.saveVideoDetails, #button_info_tmdb').prop('disabled', false);
            return;
        }
        if (action !== 'tmdb_import.php' || !result || !result.translation || !result.translation.language_id) {
            return;
        }

        const form = $('input[name="videoid"][value="' + result.id + '"]').closest('form')[0];
        const fields = form && form.querySelector(selector + ' .video-translation-fields[data-id="' + result.translation.language_id + '"]');
        if (fields) {
            fields.querySelectorAll('[data-field]').forEach(function (field) {
                if (Object.hasOwn(result.translation.fields, field.dataset.field)) {
                    field.value = result.translation.fields[field.dataset.field];
                    field.setCustomValidity('');
                }
            });
            refreshFlags(fields.closest(selector));
        }
    });
});
