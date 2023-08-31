$(function () {
    $('#list_tags').tagit({
        singleField:true,
        fieldName:"collection_tags",
        readOnly:false,
        singleFieldNode:$('#collection_tags'),
        animate:true,
    });
})
