function delete_thumb(id_collection_image) {
    $.ajax({
        url: admin_url + 'actions/collection_thumbs_delete.php',
        type: "post",
        dataType: 'json',
        data: {
            collection_id: collection_id,
            type: image_type,
            id_collection_image: id_collection_image
        }
    }).done(function (result) {
        if (result['success']) {
            $('#thumb_list').html(result['template']);
        }
        $('.page-content').prepend(result['msg']);
    });
}
