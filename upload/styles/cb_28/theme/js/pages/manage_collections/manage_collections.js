$(function () {
    init_tags('collection_tags', available_tags);

    $('.formSection h4').on({
        click: function(e){
            e.preventDefault();
            if($(this).find('i').hasClass('glyphicon-chevron-down')){
                $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                $(this).next().toggleClass('hidden');
            }else{
                $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(this).next().toggleClass('hidden');
            }
        }
    });

    $('select#type').on('change', function () {
        showSpinner();
        $.post({
            url: '/actions/get_collection_update.php',
            dataType: 'json',
            data: {type: $(this).val()},
            success: function (data) {
                if (data.msg) {
                    $('.page-content').prepend(data.msg);
                }
                if (Object.keys(data.sort_types).length > 0) {
                    $('#sort_type option').remove();
                    for (const key in data.sort_types) {
                        $('#sort_type').append('<option value="' + key + '">' + data.sort_types[key] + '</option>');
                    }
                }
                if (Object.keys(data.parents).length > 0) {
                    $('#collection_id_parent option').remove();
                    for (const key in data.parents) {
                        $('#collection_id_parent').append('<option value="' + key + '">' + data.parents[key] + '</option>');
                    }
                }
            }
        }).always(hideSpinner);
    });
})
