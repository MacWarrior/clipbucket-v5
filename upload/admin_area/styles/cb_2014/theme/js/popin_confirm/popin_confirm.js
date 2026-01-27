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
    _waitEventOnce: function ($el, eventName) {
        return new Promise(resolve => $el.one(eventName, resolve));
    },

    _confirm_it: async function (info) {
        const confirm_modal = this.confirm_modal;
        const title = info.title ?? '';
        const message = info.message ?? '';
        confirm_modal.off('click', '.confirm_btn');
        confirm_modal.off('click', '.cancel_btn');
        popinConfirm.init_confirm(message, title);

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
