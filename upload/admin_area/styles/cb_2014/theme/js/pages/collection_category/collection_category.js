$(function () {

    var button = document.getElementById('hideshow'); // Assumes element with id='button'

    button.onclick = function () {
        var div = document.getElementById('content');
        if (div.style.display !== 'none') {
            div.style.display = 'none';
        } else {
            div.style.display = 'block';
        }
    };
});
