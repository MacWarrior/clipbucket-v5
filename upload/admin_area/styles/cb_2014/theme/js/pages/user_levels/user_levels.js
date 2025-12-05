document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete').forEach(function (el) {
        el.addEventListener('click', function () {
            if (el.hasAttribute('disabled')) {
                return;
            }
            const id = el.dataset.id;
            const confirmRequired = el.dataset.confirm;

            if (confirmRequired) {
                if (confirm(lang['confirm_delete_user_level'])) {
                    window.location.href = `?action=delete&lid=${id}`;
                }
            } else {
                window.location.href = `?action=delete&lid=${id}`;
            }
        });
    });

    document.querySelectorAll('.user_level_active').forEach(function (el) {
        el.addEventListener('change', function () {
            const id = el.dataset.id;
            const checked = el.checked;

            const params = new URLSearchParams();
            params.append('user_level_id', id);
            params.append('active', checked);

            fetch(admin_url + 'actions/user_level_activate.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: params
            })
                .then(response => response.json())
                .then(response => {
                    document.querySelector('.page-content').insertAdjacentHTML('afterbegin', response['msg']);

                    const defaultEl = document.querySelector(`.user_level_is_default[data-id="${id}"]`);
                    if (defaultEl) {
                        if (checked) {
                            defaultEl.disabled = false;
                            defaultEl.title = '';
                        } else {
                            defaultEl.disabled = true;
                            defaultEl.title = lang['cannot_be_default_until_activated'];
                        }
                        const defaultDeleteButton = document.querySelector(`.delete[data-id="${id}"]`);
                        if (defaultDeleteButton) {
                            if (defaultEl.disabled === false) {
                                defaultDeleteButton.disabled = false;
                                defaultDeleteButton.title = '';
                            } else {
                                defaultDeleteButton.disabled = true;
                                defaultDeleteButton.title = lang['default_userlevel_cannot_be_deleted'];
                            }
                        }
                    }
                })
                .finally(() => {
                    hideSpinner();
                });
        });
    });

    document.querySelectorAll('.user_level_is_default').forEach(function (el) {
        el.addEventListener('change', function () {
            const id = el.dataset.id;
            showSpinner();

            const params = new URLSearchParams();
            params.append('user_level_id', id);

            fetch(admin_url + 'actions/user_level_set_default.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: params
            })
                .then(response => response.json())
                .then(response => {
                    document.querySelector('.page-content').insertAdjacentHTML('afterbegin', response['msg']);
                    if (response.success) {
                        window.location.reload();
                    }
                })
                .finally(() => {
                    hideSpinner();
                });
        });
    });
});
