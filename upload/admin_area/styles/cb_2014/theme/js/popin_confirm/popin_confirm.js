var popinConfirm = {
    confirm_modal: $('#confirm_modal'),
    init_confirm: function (message, title, text_button_confirm, text_button_cancel) {
        popinConfirm.confirm_modal.modal();
        if (title !== '') {
            popinConfirm.confirm_modal.find('.modal-title').html(title);
        }
        if (message !== '') {
            popinConfirm.confirm_modal.find('.modal-body').html(message);
        }
        if (text_button_confirm !== '') {
            popinConfirm.confirm_modal.find('#button_confirm').html(text_button_confirm);
        }
        if (text_button_cancel !== '') {
            popinConfirm.confirm_modal.find('#button_cancel').html(text_button_cancel);
        }
    },
    _waitEventOnce: function ($el, eventName) {
        return new Promise(resolve => $el.one(eventName, resolve));
    },

    _confirm_it: async function (info) {
        const confirm_modal = this.confirm_modal;
        const title = info.title ?? '';
        const message = info.message ?? '';
        const text_button_confirm = info.text_button_confirm ?? '';
        const text_button_cancel = info.text_button_cancel ?? '';
        confirm_modal.off('click', '.confirm_btn');
        confirm_modal.off('click', '.cancel_btn');
        popinConfirm.init_confirm(message, title, text_button_confirm, text_button_cancel);

        // Ouvre le modal
        confirm_modal.modal('show');

        const choice = await new Promise(resolve => {
            confirm_modal.one('click', '.confirm_btn', () => resolve(true));
            confirm_modal.one('click', '.cancel_btn', () => resolve(false));
        });

        confirm_modal.modal('hide');
        await this._waitEventOnce(confirm_modal, 'hidden.bs.modal');
        return choice;
    }
}
