$(document).ready(function() {
    $('#desc').summernote();
    $('form').on('submit', function (e) {
        $('#desc').summernote('code', $('#desc').summernote('code'));
    });
});