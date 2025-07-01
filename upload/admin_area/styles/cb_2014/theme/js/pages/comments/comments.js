$(document).ready(function(){
    if( visual_editor_comments_enabled ){
        Array.from(document.querySelectorAll('.page-content .table .alert.alert-info,.page-content .table .alert.alert-danger')).forEach((comment,index) => {
            new toastui.Editor.factory({
                el: comment,
                viewer: true,
                usageStatistics: false,
                initialValue: comment.innerHTML
            });
        });
    }
});