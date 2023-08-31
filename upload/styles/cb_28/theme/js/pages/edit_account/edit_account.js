$(function () {
    $('#list_tags').tagit({
        singleField:true,
        fieldName:"profile_tags",
        readOnly:false,
        singleFieldNode:$('#profile_tags'),
        animate:true,
    });
})
