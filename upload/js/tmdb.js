/* Shared TMDB navigation for the front office and administration. */
$(function () {
    'use strict';

    window.openCollectionTmdb = function (button) {
        var trigger = $(button);
        if (trigger.prop('disabled')) return;
        trigger.prop('disabled', true);
        showSpinner();
        $.ajax({
            url: trigger.data('url') + 'tmdb_info.php',
            type: 'POST', dataType: 'json',
            data: {
                target: 'collection', videoid: trigger.data('id'), type: 'series',
                video_title: $('#collection_name').val(), page: 1
            }
        }).done(function (result) {
            if (result.template) $('#myModal').html(result.template).modal();
            if (result.msg) $('.page-content').prepend(result.msg);
        }).always(function () {
            trigger.prop('disabled', false);
            hideSpinner();
        });
    };

    function initTmdb() {
        var modal = $('#myModal'), body = modal.find('.tmdb');
        if (!body.length) return;
        var target = body.data('target'), url = body.data('url');
        var id = modal.find('#modal_videoid').val(), busy = false;
        var cookie = 'tmdb_new_search_' + target;
        var root = body.find('.tmdb-level'), levels = [root];
        var searchState = fields();

        function fields() {
            return {
                type: body.find('#type_tmdb').val(), video_title: body.find('#search_title').val(),
                selected_year: body.find('#selected_year').val()
            };
        }

        function restore(values) {
            body.find('#type_tmdb').val(values.type);
            body.find('#search_title').val(values.video_title);
            body.find('#selected_year').val(values.selected_year);
        }

        function lock(value) {
            busy = value;
            body.find('button, #search, .pagination a').prop('disabled', value);
            if (value) showSpinner(); else hideSpinner();
        }

        function error(result) {
            if (result && result.msg) $('.page-content').prepend(result.msg);
            else body.find('.tmdb-error').show();
        }

        function search(page, sort, order, values) {
            if (busy) return;
            lock(true);
            $.ajax({
                url: url + 'tmdb_info.php', type: 'POST', dataType: 'json',
                data: $.extend({target: target, videoid: id, page: page, sort: sort, sort_order: order}, values)
            }).done(function (result) {
                if (result.template) {
                    modal.html(result.template);
                    initTmdb();
                } else error(result);
            }).fail(function () {
                error();
            }).always(function () {
                lock(false);
            });
        }

        window.pageInfoTmdb = function (page) {
            var sort = root.find('.icon-sort-up, .icon-sort-down').first();
            search(page, sort.data('type'), sort.hasClass('icon-sort-up') ? 'ASC' : 'DESC', searchState);
        };

        function loadNavigation(series, season, page, replace) {
            if (busy) return;
            var current = levels[levels.length - 1];
            var parentFields = fields(), scroll = modal.scrollTop();
            lock(true);
            $.ajax({
                url: url + 'tmdb_info.php',
                type: 'POST',
                dataType: 'json',
                data: $.extend({
                    target: target, videoid: id, tmdb_video_id: series, page: page,
                    operation: season === undefined ? 'seasons' : 'episodes'
                }, season === undefined ? {} : {season: season})
            }).done(function (result) {
                if (!result.template) {
                    error(result);
                    return;
                }
                if (replace) {
                    current.replaceWith(result.template);
                    levels[levels.length - 1] = body.children('.tmdb-level').last();
                } else {
                    current.data({fields: parentFields, scroll: scroll}).hide();
                    current.after(result.template);
                    levels.push(current.next('.tmdb-level'));
                }
                modal.scrollTop(0);
            }).fail(function () {
                error();
            }).always(function () {
                lock(false);
            });
        }

        window.pageTmdbNavigation = function (page) {
            var current = levels[levels.length - 1];
            if (levels.length === 1) return;
            loadNavigation(current.data('series'), current.data('season'), page, true);
        };

        body.off('.tmdb');

        body.on('click.tmdb', '#search', function () {
            if (busy) return;
            if (levels.length > 1 && $.cookie(cookie) !== 'true') {
                body.find('.tmdb-confirm').show();
                return;
            }
            search(1, 'release_date', 'ASC', fields());
        });

        body.on('keydown.tmdb', '#search_title, #selected_year, #type_tmdb', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                body.find('#search').trigger('click');
            }
        });

        body.on('click.tmdb', '.tmdb-confirm-no', function () {
            body.find('.tmdb-confirm').hide();
        });

        body.on('click.tmdb', '.tmdb-confirm-yes', function () {
            if (busy) return;
            if (body.find('.tmdb-dont-ask').prop('checked')) set_cookie_secure(cookie, 'true');
            body.find('.tmdb-confirm').hide();
            search(1, 'release_date', 'ASC', fields());
        });

        body.on('click.tmdb', 'th:has([data-type])', function () {
            var sort = $(this).find('[data-type]');
            search(1, sort.data('type'), sort.hasClass('icon-sort-up') ? 'DESC' : 'ASC', searchState);
        });

        body.on('click.tmdb', '.tmdb-back', function () {
            if (busy || levels.length === 1) return;
            levels.pop().remove();
            var parent = levels[levels.length - 1];
            parent.show();
            restore(parent.data('fields'));
            modal.scrollTop(parent.data('scroll'));
            body.find('.tmdb-confirm').hide();
        });

        body.on('click.tmdb', '.tmdb-choose', function () {
            var button = $(this);
            loadNavigation(button.data('series'), button.data('season'), 1, false);
        });

        body.on('click.tmdb', '.tmdb-import', function () {
            if (busy) return;
            var button = $(this), context = {target: target};
            if (button.data('season') !== undefined) context.season = button.data('season');
            if (button.data('episode') !== undefined) context.episode = button.data('episode');
            lock(true);
            var request;
            if (target === 'video') {
                // Keep the page-specific refresh behavior (edit, upload and remote upload).
                var save = window.saveInfoTmdb || window.saveInfoTmdbRemote;
                request = save(button.data('series'), button.data('type'), id, context);
            } else {
                request = $.ajax({
                    url: url + 'tmdb_import.php', type: 'POST', dataType: 'json',
                    data: $.extend({videoid: id, tmdb_video_id: button.data('series'), type: button.data('type')}, context)
                }).done(function (result) {
                    if (result.success) {
                        var redirect = new URL(window.location.href);
                        redirect.searchParams.set('_tmdb', Date.now());
                        window.location.replace(redirect.href);
                    } else {
                        modal.modal('hide');
                        error(result);
                    }
                });
            }
            request.fail(function () {
                error();
            }).always(function () {
                lock(false);
            });
        });
    }

    $(document).on('show.bs.modal.tmdb', '#myModal', initTmdb);
});
