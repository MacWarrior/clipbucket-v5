function display_tab(divId) {
    $('ul.nav-tabs:not(.resolutions,.interfaces) li').removeClass('active');
    $('ul.nav-tabs:not(.resolutions,.interfaces) li > a[href=\'' + divId + '\'').parent().addClass('active');
    $('div.tab-content div:not(.resolutions,.interfaces)').removeClass('active');
    $(divId).addClass('active');
    setHash(divId);
}

function setHash(hash) {
    window.location.hash = hash;
    $("#main_form").attr("action", hash);
}

$(document).ready(function () {
    if (window.location.hash === '') {
        setHash($('ul.nav-tabs:not(.resolutions) li:first a').attr('href'));
    } else {
        display_tab(window.location.hash);
    }

    $('ul.nav-tabs:not(.resolutions) li a').click(function () {
        setHash($(this).attr('href'));
    });

    // Hack : Bootstrap 3.X won't work with tabs in tabs
    $('ul.nav-tabs.resolutions a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            let href = $(this).attr('href');
            $('#' + href).addClass('active').siblings().removeClass('active');
        }
    });
    $('ul.nav-pills.interfaces a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            let href = $(this).attr('href');
            $('#' + href).addClass('active').siblings().removeClass('active');
        }
    });

    $("#mail_type").change(function () {
        if ($(this).val() === 'mail') {
            $('.config_smtp').hide();
        } else {
            if ($("#smtp_auth:checked").length === 0) {
                $('.config_smtp:not(.config_smtp_auth)').show();
            } else {
                $('.config_smtp').show();
            }
        }
    });

    const autoDisabled = [
        'video'
        ,'photo'
        ,'channel'
        ,'collection'
    ];

    autoDisabled.forEach(function (elem) {
        $('#display_'+elem+'_comments').change(function () {
            let parent = $('#'+elem+'_comments');
            if (!$(this).prop('checked')) {
                parent.prop('checked',false).prop('disabled',true);
            } else {
                parent.prop('disabled',false);
            }
        });
    });

    $("#smtp_auth").change(function () {
        if ($("#smtp_auth:checked").length === 1) {
            $('.config_smtp_auth').show();
        } else {
            $('.config_smtp_auth').hide();
        }
    });

    $("input[name='conversion_type']").change(function () {
        let inputs_mp4 = ['stay_mp4', 'keep_audio_tracks', 'keep_subtitles'];
        if (this.value === 'mp4') {
            inputs_mp4.forEach(function (input) {
                $('#' + input).prop('disabled', false);
                $('#' + input + '_hidden').prop('disabled', true);
            });
        } else {
            inputs_mp4.forEach(function (input) {
                $('#' + input).prop('disabled', true);
                $('#' + input + '_hidden').prop('disabled', false);
            });
        }
    });

    $('#discord_error_log').change(function () {
        let parent = $('#discord_webhook_url');
        if (!$(this).prop('checked')) {
            parent.prop('disabled',true);
        } else {
            parent.prop('disabled',false);
        }
    });
    $('#enable_tmdb').change(function () {
        let button = $('#tmdb_token_test');
        if (!$(this).prop('checked')) {
            button.addClass('disabled');
        } else {
            button.removeClass('disabled').attr('title','');
        }
    });

    $('#tmdb_token').keyup(function(){
        $('#tmdb_token_test').removeClass('glyphicon-ok glyphicon-remove').addClass('glyphicon-refresh');
    });

    $('#tmdb_token_test').click(function (e) {
        if( $(this).hasClass('disabled') ){
            return;
        }
        e.preventDefault();
        $.ajax({
            url: admin_url + 'actions/tmdb_test.php',
            type: "POST",
            data: {token: $('#tmdb_token').val()},
            dataType: 'json',
            beforeSend : function(){
                $('#tmdb_token_test').removeClass('glyphicon-ok glyphicon-remove glyphicon-refresh').html(loading_img);
            },
            success: function (result) {
                if( result['msg'] === 'OK' ){
                    $('#tmdb_token_test').html('').removeClass('glyphicon-remove glyphicon-refresh').addClass('glyphicon-ok');
                } else {
                    $('#tmdb_token_test').html('').removeClass('glyphicon-refresh glyphicon-ok').addClass('glyphicon-remove');
                }
            }
        });
    });

    $.each({
        'enable_video_genre': 'tmdb_get_genre'
        , 'enable_video_actor': 'tmdb_get_actors'
        , 'enable_video_producer': 'tmdb_get_producer'
        , 'enable_video_executive_producer': 'tmdb_get_executive_producer'
        , 'enable_video_director': 'tmdb_get_director'
        , 'enable_video_crew': 'tmdb_get_crew'
        , 'enable_video_poster': 'tmdb_get_poster'
        , 'enable_video_backdrop': ['tmdb_get_backdrop', 'use_backdrop_as_default_thumb']
        , 'enable_tmdb': 'tmdb_token'
        , 'enable_tmdb_mature_content': 'tmdb_mature_content_age'
        , 'control_bar_logo' : ['player_logo_url','upload_player-logo']
        , 'keep_ratio_photo': 'ratio_photo'
        , 'enable_profiling' : ['profiling_db_host','profiling_db_name','profiling_db_user','profiling_db_password','profiling_db_port']
        , 'enable_external_rate_field' : 'enable_external_rate_from_tmdb'
        , 'enable_external_ratings_field' : 'enable_external_ratings_from_tmdb'
        , 'enable_video_categories_as_submenu' : 'enable_all_categ_for_video'
        , 'enable_photo_categories_as_submenu' : 'enable_all_categ_for_photo'
        , 'enable_collection_categories_as_submenu' : 'enable_all_categ_for_collection'
        , 'enable_channel_categories_as_submenu' : 'enable_all_categ_for_channel'

    }, function (index, value) {

        $('#'+index).on('change',function () {
            const input_to_disable = Array.isArray(value) ? value : [value];
            const initial_input = $(this)
            $(input_to_disable).each( function( index, elem) {
                if (initial_input.prop('checked')) {
                    $('#' + elem).prop('disabled', false).attr('title', '');
                    $('#' + elem + '_hidden').prop('disabled', true);
                } else {
                    $('#' + elem).prop('disabled', true);
                    $('#' + elem + '_hidden').prop('disabled', false);
                }
            })
        })
    });

    function copyTextToClipboard(text) {
        var textArea = document.createElement("textarea");

        // Place in the top-left corner of screen regardless of scroll position.
        textArea.style.position = 'fixed';
        textArea.style.top = 0;
        textArea.style.left = 0;

        // Ensure it has a small width and height. Setting to 1px / 1em
        // doesn't work as this gives a negative w/h on some browsers.
        textArea.style.width = '2em';
        textArea.style.height = '2em';

        // We don't need padding, reducing the size if it does flash render.
        textArea.style.padding = 0;

        // Clean up any borders.
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';

        // Avoid flash of the white box if rendered for any reason.
        textArea.style.background = 'transparent';

        textArea.value = text;

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
        } catch (err) {
            console.log('Oops, unable to copy');
        }

        document.body.removeChild(textArea);
    }

    $('#automate_launch_mode').change(function(){
        if($(this).val() === 'crontab') {
            $('#crontab_details_block').show();
        } else {
            $('#crontab_details_block').hide();
        }
    });
    $('#automate_launch_mode').change();

    $('.btn_copy_clipboard').click(function(event){
       let value = $(this).closest('.input-group').find('input').val();
        copyTextToClipboard(value);

        const messageDiv = document.getElementById('floatingMessage');
        let timeout;

        // Positionner le div à côté de la souris
        messageDiv.style.left = event.pageX + 10 + 'px';
        messageDiv.style.top = event.pageY + 10 + 'px';

        // Afficher le message
        messageDiv.style.display = 'block';

        // Réinitialiser le timeout à chaque mouvement
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            messageDiv.style.display = 'none';
        }, 300);

    });

    var select_timezone = $('.check_timezone');
    if (select_timezone.length > 0) {
        select_timezone.on('change', function (event) {
            $('.btn-primary').prop('disabled', true);
            $('.alert-dismissable').remove();
            $(select_timezone).removeClass('has-error');
            $('#spinner-content').show();
            $.post(admin_url + 'actions/timezone_check.php',{timezone: $(this).val()} ,function(data) {
                if (data.success) {
                    $('.btn-primary').prop('disabled', false);
                } else {
                    $(select_timezone).addClass('has-error');
                    $(".page-content").prepend(data.msg);
                    $('.btn-primary').prop('disabled', true);
                }
                $('#spinner-content').hide();
            }, 'JSON');
        });
    }

    $('#timezone').select2();

    $('input[name^="gen_"]').on('change', function (event) {
        var elem = $(this);
        if ($('input[name^="gen_"]:checked').length < 1) {
            event.preventDefault();
            alert(lang['at_least_one_resolution']);
            elem.prop('checked', true);
        }
    });

    $('.delete_conversion_lock').on('click', function (e) {
        e.preventDefault();
        var button = $(this);
        showSpinner();
        $.post({
            url:admin_url + 'actions/conversion_delete_lock.php',
            dataType: 'json',
            success: function (response) {
                $(".page-content").prepend(response.msg);
                button.prop('disabled', true).prop('title', response.lang_title);
                hideSpinner();

            }
        })
    });

    $('#update').on('click',function (e) {
        var base_url = $('#base_url');
        if (base_url.val().trim() === '') {
            $('a[href="#config_hosting"]').trigger('click');
            base_url.trigger('focus');
        }
    });

    updateMainMenuOrder();

    $('#interfaces_main_menu .main-menus-sortable').sortable({
        items: '.main-menu-sortable',
        update: function () {
            updateMainMenuOrder();
        }
    });
    updateDisplayWhenSectionToggle();
});
function updateMainMenuOrder() {
    var section = $('#interfaces_main_menu .main-menu-order').parent()
    var sectionIds = section.find('.main-menu-sortable').map(function () {
        return $(this).data('section-id');
    }).get();
    section.find('.main-menu-order').val(sectionIds.join(','));
}

function updateDisplayWhenSectionToggle() {
    $.each([
        'videosSection'
        , 'collectionsSection'
        , 'photosSection'
        , 'channelsSection'

    ], function (index, value) {

        $('#' + value).on('change', function () {
            const type = value.match(/(\w+)sSection/)[1];
            const input_to_disable = [
                'enable_' + type + '_categories_as_submenu',
                'enable_all_categ_for_' + type
            ];
            const initial_input = $(this)
            $(input_to_disable).each(function (index, elem) {
                if (initial_input.prop('checked')) {
                    $('#' + elem).prop('disabled', false).attr('title', '');
                    $('#' + elem + '_hidden').prop('disabled', true);
                } else {
                    $('#' + elem).prop('disabled', true);
                    $('#' + elem + '_hidden').prop('disabled', false);
                }
            });
            if (!$('#videosSection').prop('checked') && !$('#photosSection').prop('checked') && $('#collectionsSection').prop('checked')) {
                $('#collectionsSection').prop('checked', false).trigger('change');
            }
            //drag menu lines to hide
            $('.main-menus-sortable li[data-section-id="' + type + '"]').toggle();
            if ($('.main-menus-sortable li:not([style*="display: none"])').length === 0) {
                $('.main-menus-sortable').parents('.row').first().hide();
            }
        });
    });
}

// Shared by basic and advanced settings. Descriptions are search-only metadata.
function initSettingsSearch() {
    const search = document.getElementById('settings-search');
    const form = document.getElementById('main_form');
    if (!search || !form) {
        return;
    }
    const input = document.getElementById('settings-search-input');
    const previous = document.getElementById('settings-search-previous');
    const reset = document.getElementById('settings-search-reset');
    const next = document.getElementById('settings-search-next');
    const status = document.getElementById('settings-search-status');
    const anchor = document.getElementById('settings-search-anchor');
    let floatingEnabled = false;
    function floatingTop() {
        const navbar = document.querySelector('.navbar-fixed-top');
        return Math.max(12, navbar ? navbar.getBoundingClientRect().bottom + 12 : 12);
    }
    function updateFloatingSearch() {
        const rect = anchor.getBoundingClientRect();
        const top = floatingTop();
        const fixed = floatingEnabled && rect.top < top;
        search.classList.toggle('settings-search-fixed', fixed);
        search.style.top = fixed ? top + 'px' : '';
        search.style.left = fixed ? Math.max(8, Math.min(rect.left, window.innerWidth - rect.width - 8)) + 'px' : '';
        search.style.width = fixed ? rect.width + 'px' : '';
    }
    window.addEventListener('scroll', updateFloatingSearch, {passive: true});
    window.addEventListener('resize', updateFloatingSearch);
    const normalize = text => text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().replace(/\s+/g, ' ').trim();
    const descriptions = new Map(Array.from(search.querySelectorAll('[data-settings-name]'), node => [node.dataset.settingsName, node.dataset.settingsDescription]));
    const links = Array.from(form.querySelectorAll('[data-toggle="tab"]'));
    const linkFor = pane => links.find(link => link.getAttribute('href').replace(/^#/, '') === pane.id);
    const panesFor = node => $(node).parents('.tab-pane').get().reverse();
    const groups = new Map();
    const aliases = {upload_logo: 'logo_name', upload_favicon: 'favicon_name', 'upload_player-logo': 'player-logo_name'};

    form.querySelectorAll('input[name], select[name], textarea[name]').forEach(control => {
        if (['submit', 'button', 'reset'].includes(control.type) || (control.type === 'hidden' && control.name !== 'main_menu_order')) {
            return;
        }
        const name = control.name;
        const key = aliases[name] || (name.startsWith('gen_') ? 'resolution_enabled' : name.startsWith('vbrate_') ? 'resolution_bitrate' : name);
        if (!descriptions.has(key)) {
            return;
        }
        if (!groups.has(name)) {
            groups.set(name, {name, controls: [], description: descriptions.get(key)});
        }
        groups.get(name).controls.push(control);
    });

    const entries = Array.from(groups.values()).map(entry => {
        entry.panes = panesFor(entry.controls[0]);
        entry.labels = Array.from(form.querySelectorAll('label, [data-settings-label]')).filter(label =>
            label.dataset.settingsLabel === entry.name || entry.controls.some(control => control.id && label.htmlFor === control.id));
        entry.title = entry.labels.map(label => label.textContent).join(' ').trim();
        entry.text = normalize(entry.title + ' ' + entry.description);
        entry.highlights = entry.labels.concat(entry.controls);
        entry.controls.forEach(control => {
            // ACE switches are drawn by their adjacent .lbl, tag-it by its list.
            const sibling = control.nextElementSibling;
            if (sibling && (sibling.classList.contains('lbl') || sibling.classList.contains('select2-container'))) {
                entry.highlights.push(sibling);
            }
            if (control.name === 'main_menu_order') {
                const sortable = control.parentElement.querySelector('.main-menus-sortable');
                if (sortable) entry.highlights.push(sortable);
            }
            const tagList = document.getElementById('list_' + control.name);
            if (tagList) entry.highlights.push(tagList);
        });
        return entry;
    }).filter(entry => entry.panes.length);

    // Sort by the navigation's visual order, including nested interface/ratio tabs.
    entries.sort((a, b) => {
        const aPath = a.panes.map(pane => links.indexOf(linkFor(pane)));
        const bPath = b.panes.map(pane => links.indexOf(linkFor(pane)));
        for (let i = 0; i < Math.min(aPath.length, bPath.length); i++) {
            if (aPath[i] !== bPath[i]) return aPath[i] - bPath[i];
        }
        return 0;
    });
    let matches = [];
    let cursor = -1;
    let timer;
    let generation = 0;
    let navigation = Promise.resolve();
    let notice;
    const tabTitles = new Map();

    function visibleOutsideTabs(node) {
        // Inactive tabs are navigable; hidden conditional branches are not results.
        for (let current = node; current && current !== form; current = current.parentElement) {
            const style = window.getComputedStyle(current);
            if (current.hidden || style.visibility === 'hidden' || style.visibility === 'collapse' ||
                (style.display === 'none' && !current.classList.contains('tab-pane'))) {
                return false;
            }
        }
        return true;
    }

    function isSearchable(entry) {
        return entry.controls.some(control => {
            // Hidden backing inputs of visible widgets are not hidden settings.
            let widget;
            if (entry.name === 'main_menu_order') {
                widget = control.parentElement.querySelector('.main-menus-sortable');
            } else if (control.classList.contains('select2-hidden-accessible')) {
                widget = $(control).next('.select2-container')[0];
            } else {
                widget = document.getElementById('list_' + entry.name);
            }
            return visibleOutsideTabs(widget || control);
        });
    }

    function clearNotice() {
        if (notice) notice.remove();
        notice = null;
        form.querySelectorAll('.settings-search-current').forEach(node => node.classList.remove('settings-search-current'));
    }

    async function openEntry(entry, token) {
        for (const pane of entry.panes) {
            if (token !== generation) return false;
            if (pane.classList.contains('active')) continue;
            const link = linkFor(pane);
            if (!link) continue;
            if (link.getAttribute('href').startsWith('#')) {
                await new Promise(resolve => {
                    $(link).one('shown.bs.tab', resolve).tab('show');
                });
            } else {
                // The application's nested tabs intentionally use bare IDs.
                $(pane).addClass('active').siblings('.tab-pane').removeClass('active');
                $(link).parent().addClass('active').siblings().removeClass('active');
            }
        }
        return token === generation;
    }

    function availableControl(entry) {
        const available = entry.controls.filter(control => !control.disabled && $(control).is(':visible'));
        return available.find(control => control.type === 'radio' && control.checked) || available[0];
    }

    function reasonFor(entry) {
        // A dependency title may live on the disabled input, a wrapping label or its container.
        for (const control of entry.controls) {
            if (!control.disabled && $(control).is(':visible')) continue;
            if (control.title) return control.title;
            let parent = control.parentElement;
            while (parent && !parent.classList.contains('tab-pane')) {
                if (parent.title) return parent.title;
                parent = parent.parentElement;
            }
        }
        const label = entry.labels.find(label => label.title && normalize(label.title) !== normalize(label.textContent));
        return label ? label.title : '';
    }

    function focusEntry(entry) {
        let target = availableControl(entry);
        if (!target) {
            // Use widget inputs where the original form control is intentionally hidden.
            const tagList = document.getElementById('list_' + entry.name);
            if (tagList) target = $(tagList).find('input:visible:enabled')[0];
            const select = entry.controls.find(control => !control.disabled && control.classList.contains('select2-hidden-accessible'));
            if (select) target = $(select).next('.select2-container').find('.select2-selection')[0];
            if (entry.name === 'main_menu_order') target = entry.labels.find(label => $(label).is(':visible'));
        }
        if (!target) {
            target = entry.labels.find(node => $(node).is(':visible')) || entry.controls[0].parentElement;
            const reason = reasonFor(entry);
            if (reason) {
                notice = document.getElementById('settings-search-unavailable-template').content.firstElementChild.cloneNode(true);
                notice.querySelector('.settings-search-reason').textContent = reason;
                target.parentElement.appendChild(notice);
            }
        }
        if (!target.hasAttribute('tabindex') && !target.matches('input, select, textarea, button, a[href]')) {
            target.setAttribute('tabindex', '-1');
        }
        entry.highlights.forEach(node => node.classList.add('settings-search-current'));
        target.classList.add('settings-search-current');
        const rect = target.getBoundingClientRect();
        if (rect.top < floatingTop() + search.offsetHeight + 16 || rect.bottom > window.innerHeight) {
            target.scrollIntoView({block: 'center', behavior: 'auto'});
        }
        updateFloatingSearch();
        target.focus({preventScroll: true});
    }

    function clearResults() {
        clearNotice();
        tabTitles.forEach((title, link) => {
            if (title === null) link.removeAttribute('title');
            else link.setAttribute('title', title);
        });
        tabTitles.clear();
        form.querySelectorAll('.settings-search-match').forEach(node => node.classList.remove('settings-search-match'));
        form.querySelectorAll('.settings-search-count').forEach(node => node.remove());
        matches = [];
        cursor = -1;
        status.textContent = '';
        previous.disabled = next.disabled = true;
    }

    async function searchNow(token) {
        if (token !== generation) return;
        clearResults();
        const query = normalize(input.value);
        if (!query) return;
        const terms = query.split(' ');
        matches = entries.filter(entry => isSearchable(entry) && terms.every(term => entry.text.includes(term)));
        if (!matches.length) {
            status.textContent = search.dataset.empty;
            return;
        }
        const counts = new Map();
        const leafPanes = new Set();
        matches.forEach(entry => {
            entry.highlights.forEach(node => node.classList.add('settings-search-match'));
            leafPanes.add(entry.panes[entry.panes.length - 1]);
            entry.panes.forEach(pane => counts.set(pane, (counts.get(pane) || 0) + 1));
        });
        if (leafPanes.size > 1) {
            counts.forEach((count, pane) => {
                const link = linkFor(pane);
                if (!link) return;
                link.classList.add('settings-search-match');
                tabTitles.set(link, link.getAttribute('title'));
                link.title = (count === 1 ? search.dataset.tabResult : search.dataset.tabResults).replace('%s', count);
                const badge = document.getElementById('settings-search-count-template').content.firstElementChild.cloneNode(true);
                badge.textContent = count;
                link.appendChild(badge);
            });
        }
        await openEntry(matches[0], token);
        updateFloatingSearch();
        if (token === generation) previous.disabled = next.disabled = false;
        // Opening tabs never transfers focus from the search field.
    }

    function scheduleSearch() {
        clearTimeout(timer);
        reset.disabled = input.value.length === 0;
        const token = ++generation;
        previous.disabled = next.disabled = true;
        timer = setTimeout(() => {
            navigation = navigation.then(() => searchNow(token));
        }, 500);
    }
    input.addEventListener('input', scheduleSearch);
    reset.addEventListener('click', () => {
        clearTimeout(timer);
        ++generation;
        input.value = '';
        reset.disabled = true;
        clearResults();
        input.focus({preventScroll: true});
    });
    form.addEventListener('change', () => {
        if (normalize(input.value)) scheduleSearch();
    });
    input.addEventListener('keydown', event => {
        if (event.key === 'Enter') event.preventDefault();
    });

    function move(direction) {
        const token = generation;
        navigation = navigation.then(async () => {
            if (token !== generation || !matches.length) return;
            if (matches.some(entry => !isSearchable(entry))) {
                await searchNow(token);
                if (token !== generation || !matches.length) return;
            }
            clearNotice();
            floatingEnabled = true;
            cursor = cursor < 0 ? (direction > 0 ? 0 : matches.length - 1) : (cursor + direction + matches.length) % matches.length;
            if (!await openEntry(matches[cursor], token)) return;
            focusEntry(matches[cursor]);
            status.textContent = direction > 0 && cursor === matches.length - 1 ? search.dataset.last :
                direction < 0 && cursor === 0 ? search.dataset.first : '';
        });
    }
    next.addEventListener('click', () => move(1));
    previous.addEventListener('click', () => move(-1));
}

$(initSettingsSearch);
