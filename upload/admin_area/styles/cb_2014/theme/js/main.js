window.onload = init;

function init(){

    for (var i=0; i < localStorage.length; i++){
        var key = localStorage.key(i);
        if (key.substring(0, 6) === 'note'){ //will explain this
            var value = localStorage.getItem(key);
            addStickiesToPage(value); //we will create this one
        }
    }

    $('.changelog .arrow').click(function(){
        if( $(this).parent().next().is(':visible') ){
            $(this).parent().next().css('display','none');
            $(this).removeClass('icon-angle-up').addClass('icon-angle-down');
        } else {
            $(this).parent().next().css('display','block');
            $(this).removeClass('icon-angle-down').addClass('icon-angle-up');
        }
    });

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