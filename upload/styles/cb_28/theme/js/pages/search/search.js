$(document).ready(function(){
    $("#cbsearchtype a").on({
        click: function(e){
            e.preventDefault();
            var searchtype = $("#SearchType").val();
            var buttonText = $(this).text().toLowerCase();
            if($("#SearchType option[value='"+ buttonText +"']").length > 0)
            {
                $("#SearchType option:selected").removeAttr("selected");
                $("#SearchType option[value='"+ buttonText +"']").attr("selected" , "selected");
                $(this).parents("ul").find(".active").removeClass("active");
                $(this).parent().addClass("active");
            }
        }
    });
});