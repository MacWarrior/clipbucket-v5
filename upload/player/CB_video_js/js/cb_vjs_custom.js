function new_player_height (argument) {
	var player_ratio = 1.77777;

	var native_player = $(".video-js"); 
	var embed_player = $("#cb_player");

	var native_player_width = native_player.width();
	var player_container_width = embed_player.width();
	
	var native_player_height  = native_player_width/player_ratio;
	var embed_player_height = player_container_width/player_ratio;

	native_player.css("height",native_player_height+"px");
	embed_player.css("height",embed_player_height+"px");
}

$(window).load(function(){
	new_player_height();
});

$(document).ready(function() {
	new_player_height();
	$(".video-js").on("contextmenu",function() {
       return false;
    });

    $('body').keydown(function(e)
    {
        if( $(document.activeElement).is('body') ||
            $(document.activeElement).is('button.vjs-fullscreen-control.vjs-control.vjs-button') ||
            $(document.activeElement).is('div.vjs-volume-menu-button.vjs-menu-button.vjs-menu-button-inline.vjs-control.vjs-button.vjs-volume-menu-button-horizontal.vjs-vol-0') )
        {
            if( e.keyCode == 0 || e.keyCode == 32 )
            {
                e.preventDefault();
                if( cb_player.paused() )
                    cb_player.play();
                else
                    cb_player.pause()
            }
        }
    });

    $('body').keyup(function(e)
    {
        if( $(document.activeElement).is('body') ||
            $(document.activeElement).is('button.vjs-fullscreen-control.vjs-control.vjs-button') ||
            $(document.activeElement).is('div.vjs-volume-menu-button.vjs-menu-button.vjs-menu-button-inline.vjs-control.vjs-button.vjs-volume-menu-button-horizontal.vjs-vol-0') )
        {
            if( e.keyCode == 0 || e.keyCode == 32 )
                e.preventDefault();
        }
    });
});

$(window).resize(function(event) {
	new_player_height();
});

$(document).ready(function(){
    
});