var modal;
var results;
var add;
var page = 1;
var pages = 0;
var query = '';
var request = null;
var busy = false;
var changed = false;
const selected = new Set();
$(function () {
    modal = $('#collection-items-modal');
    if (!modal.length) {
        return;
    }

    results = modal.find('.collection-items-results');
    add = modal.find('.collection-items-add');

    eventListeners();

});

function updateSelection() {
    add.prop('disabled', busy || selected.size === 0);
    add.find('span').text(selected.size);
    const boxes = results.find('input:enabled');
    const checked = boxes.filter(':checked').length;
    modal.find('.collection-items-all').prop({
        checked: boxes.length > 0 && checked === boxes.length,
        indeterminate: checked > 0 && checked < boxes.length,
        disabled: busy || boxes.length === 0
    });
}

function eventListeners() {
    modal.on('shown.bs.modal', function () {
        search(1);
        modal.find('#collection-items-query').trigger('focus');
    });
    modal.on('hide.bs.modal', function (event) {
        if (busy) {
            event.preventDefault();
        }
    });
    modal.on('hidden.bs.modal', function () {
        if (changed) {
            window.location.href = window.location.href;
        }
    });
    modal.find('.collection-items-search').on('submit', function (event) {
        event.preventDefault();
        query = modal.find('#collection-items-query').val();
        search(1);
    });
    modal.find('.collection-items-previous').on('click', function () {
        search(page - 1);
    });
    modal.find('.collection-items-next').on('click', function () {
        search(page + 1);
    });
    results.on('change', '.collection-items-check', function () {
        if (this.checked) {
            selected.add(this.value);
        } else {
            selected.delete(this.value);
        }
        updateSelection();
    });
    modal.find('.collection-items-all').on('change', function () {
        results.find('input:enabled').prop('checked', this.checked).trigger('change');
    });
    add.on('click', async function () {
        if (busy || !selected.size) {
            return;
        }
        busy = true;
        controls();
        try {
            // Keep large selections within the endpoint's batch limit.
            while (selected.size) {
                const data = await $.ajax({
                    url: modal.data('url'), method: 'POST', dataType: 'json',
                    data: {
                        action: 'add', collection_id: modal.data('collection-id'),
                        token: modal.data('token'), ids: Array.from(selected).slice(0, 100)
                    }
                });
                (data.added || []).forEach(function (id) {
                    selected.delete(String(id));
                });
                changed = changed || (data.added || []).length > 0;
                if (!data.success || !(data.added || []).length) {
                    search(page);
                    modal.find('.collection-items-message').html(data.msg || '');
                    return;
                }
            }
            window.location.href = window.location.href;
        } catch (xhr) {
            showError(xhr);
        } finally {
            if (!request) {
                busy = false;
                controls();
            }
        }
    });
}

function controls() {
    modal.find('.collection-items-search :input').prop('disabled', busy);
    modal.find('.collection-items-previous').prop('disabled', busy || page <= 1);
    modal.find('.collection-items-next').prop('disabled', busy || page >= pages);
    results.find('input').prop('disabled', function () {
        return busy || $(this).data('exists');
    });
    updateSelection();
}

function search(targetPage) {
    if (request) {
        request.abort();
    }
    busy = true;
    controls();
    results.attr('aria-busy', 'true');
    modal.find('.collection-items-message').empty();
    request = $.ajax({
        url: modal.data('url'),
        method: 'POST',
        dataType: 'json',
        data: {collection_id: modal.data('collection-id'), query: query, page: targetPage},
        success: function (data) {
            page = data.page;
            pages = data.pages;
            $('.modal-body').html(data.html);
            results.find('.collection-items-check').each(function () {
                if ($(this).data('exists')) {
                    selected.delete(this.value);
                } else {
                    $(this).prop('checked', selected.has(this.value));
                }
            });
            modal.find('.collection-items-page').text(page + ' / ' + Math.max(1, pages));

        },
        error: function (xhr, status) {
            if (status !== 'abort') {
                showError(xhr);
            }
        },
        complete: function () {
            busy = false;
            request = null;
            results.attr('aria-busy', 'false');
            controls();
        }
    });
}
