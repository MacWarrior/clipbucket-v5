var popinConfirm = {
    confirm_modal: $('#confirm_modal'),
    init_confirm: function (message, title) {
        popinConfirm.confirm_modal.modal();
        if (title !== '') {
            popinConfirm.confirm_modal.find('.modal-title').html(title);
        }
        if (message !== '') {
            popinConfirm.confirm_modal.find('.modal-body').html(message);
        }
    },
    _confirm_it: async function (info) {
        const title = info.title ?? '';
        const message = info.message ?? '';
        return new Promise((resolve, reject) => {
            popinConfirm.init_confirm(message, title);
            popinConfirm.confirm_modal.on('click', '.confirm_btn', () => resolve(true));
            popinConfirm.confirm_modal.on('click', '.cancel_btn', () => resolve(false));
        });
    }
}
