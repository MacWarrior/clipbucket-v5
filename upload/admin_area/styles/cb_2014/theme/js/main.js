window.onload = init;
function init(){

    for (var i=0; i < localStorage.length; i++){
        var key = localStorage.key(i);
        if (key.substring(0, 6) === 'note'){ //will explain this
            var value = localStorage.getItem(key);
            addStickiesToPage(value); //we will create this one
        }
    }

}

//this function will insert the sticky notes to the DOM
//inside the <ul> element we created in the index.html file
function addStickiesToPage(value){
    var stickies = document.getElementById("note-");
    var note = document.createElement("li");
    var span = document.createElement("span");
    span.setAttribute("class", "note");
    span.innerHTML = value;
    note.appendChild(span);
    stickies.appendChild(note);
}

function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}
