function addOrEdit(category_id) {
    $("#edit_category").trigger('reset');
    showSpinner();
    $.ajax({
        url: admin_url + 'actions/form_category.php',
        type: "post",
        data: {'category_id': category_id, 'type': type},
        dataType: 'json'
    }).done(function (result) {
        $('#content').html(result['template']);
        $('.page-content').prepend(result['msg']);
        $('#hideshow').hide();
        $('#cancel').on('click', function (e) {
            e.preventDefault();
            $('#hideshow').show();
            $('#content').html('');
        });
    }).always(hideSpinner);
    $('html, body').animate({
        scrollTop: 0
    }, 800);
}
function getCategoryLevel(item) {
    return parseInt(item.attr('data-level'), 10) || 0;
}

function setCategoryLevel(item, level) {
    level = Math.max(0, level);
    item.attr('data-level', level);
    item.children('.category-row').css('--category-level', level);
}

function getCategorySubtree(item) {
    var level = getCategoryLevel(item);
    var subtree = $();

    item.nextAll('.category-item').each(function () {
        var next_item = $(this);

        if (getCategoryLevel(next_item) <= level) {
            return false;
        }

        subtree = subtree.add(next_item);
    });

    return subtree;
}

function normalizeCategoryLevels() {
    var previous_level = 0;

    $('#category_flat_list > .category-item').each(function (index) {
        var item = $(this);
        var level = getCategoryLevel(item);

        if (index === 0) {
            level = 0;
        } else if (level > previous_level + 1) {
            level = previous_level + 1;
        }

        setCategoryLevel(item, level);
        previous_level = level;
    });
}

function updateCategoryInputs() {
    var orders_by_parent = {};
    var parents_by_level = {};

    normalizeCategoryLevels();

    $('#category_flat_list > .category-item').each(function () {
        var item = $(this);
        var level = getCategoryLevel(item);
        var parent_id = level > 0 && parents_by_level[level - 1] ? parents_by_level[level - 1] : 0;

        orders_by_parent[parent_id] = orders_by_parent[parent_id] || 0;
        item.children('.category-order-input').val(orders_by_parent[parent_id]);
        item.children('.category-parent-input').val(parent_id);
        orders_by_parent[parent_id]++;

        parents_by_level[level] = item.data('category-id');
        Object.keys(parents_by_level).forEach(function (parent_level) {
            if (parseInt(parent_level, 10) > level) {
                delete parents_by_level[parent_level];
            }
        });
    });
}

function moveCategoryHorizontally(item, left_delta) {
    var horizontal_threshold = 40;
    var level = getCategoryLevel(item);
    var new_level = level;
    var previous_item = item.prev('.category-item');
    var subtree = item.data('category-subtree') || $();

    if (left_delta >= horizontal_threshold && previous_item.length > 0) {
        new_level = Math.min(level + 1, getCategoryLevel(previous_item) + 1);
    } else if (left_delta <= -horizontal_threshold) {
        new_level = Math.max(0, level - 1);
    }

    if (new_level !== level) {
        var level_delta = new_level - level;
        setCategoryLevel(item, new_level);
        subtree.each(function () {
            var child = $(this);
            setCategoryLevel(child, getCategoryLevel(child) + level_delta);
        });
    }
}

function initCategoryDragAndDrop() {
    var list = $('#category_flat_list');

    if (categories_length <= 1) {
        return;
    }
    if (list.data('ui-sortable')) {
        list.sortable('destroy');
    }

    list.sortable({
        items: '> .category-item',
        tolerance: 'pointer',
        placeholder: 'category-drag-placeholder',
        start: function (event, ui) {
            var subtree = getCategorySubtree(ui.item);
            ui.item.data('start-page-x', event.pageX);
            ui.item.data('category-subtree', subtree);
            subtree.detach();
        },
        stop: function (event, ui) {
            var subtree = ui.item.data('category-subtree') || $();
            ui.item.after(subtree);
            var current_page_x = event.pageX || ui.position.left;
            moveCategoryHorizontally(ui.item, current_page_x - ui.item.data('start-page-x'));
            ui.item.removeData('category-subtree');
            updateCategoryInputs();
        },
        update: updateCategoryInputs
    });
    updateCategoryInputs();
}


function initListenerList() {
    $('[name="make_default"]').on('change', function (e) {
        showSpinner();
        $('input[name="make_default"]').not(this).prop('checked', false);
        $.ajax({
            url: admin_url + 'actions/category_make_default.php',
            type: "POST",
            data: {'category_id': $(this).val(), type: type},
            dataType: 'json',
            success: function (result) {
                $('#category_list').html(result['template']);
                $('.page-content').prepend(result['msg']);
                initListenerList();
                initCategoryDragAndDrop();
            }
        }).always(hideSpinner);
    });
}

$(function () {
    if (category_id !== '') {
        addOrEdit(category_id);
        $('#hideshow').hide();
    }
    $('#hideshow').on('click', function () {
        addOrEdit();
    });
    initListenerList();
    initCategoryDragAndDrop();
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

});
