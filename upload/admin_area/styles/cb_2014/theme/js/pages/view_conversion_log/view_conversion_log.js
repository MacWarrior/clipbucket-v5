$( document ).ready(function() {
    $('.showHide .title').on({
        click: function(e){
            console.log('click');
            if($(this).hasClass('glyphicon-chevron-right')){
                $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
                $(this).next().slideDown(500);
            }else{
                $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
                $(this).next().slideUp(500);
            }
        }
    });
});