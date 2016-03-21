function headerFooter(){
	var headerheight = "";
	var footerheight = "";
	var search_hight = "";
	headerheight = $("#header").outerHeight();
	footerheight = $("#footer").outerHeight();
	
	$("#container").css('padding-top',headerheight+'px');
	$("#container").css('padding-bottom',footerheight+20+'px');
}
var flag = 0;
function responsiveFixes(){
	var WinWidth = $(window).width();
	var HeaderSearchDefault = $("#header ").find('.search'); 
	var searchHtml = HeaderSearchDefault.html();
	var navSearchHtml = $("#header .navbar-header");
	if(flag==0)
	{
		if (WinWidth <992)
		{
			$("<div class='search'>"+searchHtml+"</div>").appendTo(navSearchHtml);
			HeaderSearchDefault.remove();
			
		}
		else if( WinWidth <1260 )
		{
			$(".btn-newacc").html("Signup");
		}
		else
		{
			$(".btn-newacc").html("Create new account");
			$("<div class='col search'>"+searchHtml+"</div>").insertBefore("#header .btn-holder");
			HeaderSearchDefault.remove();
		}
		
	}
}

$(document).ready(function(){
	//footer at bototm
	headerFooter();
	
	responsiveFixes();

	$("body").on('click', '.btn-playlist, .close-playlists', function(){
		$(".playlists-dropdown").toggleClass('active');
		jcf.customForms.replaceAll('.custom-elements');
	});


	$(".navbar-sm-login-links a").click(function(){
		$("body").removeClass('sideactive');
	});

	var havechild = $('.adbox-holder').children().length;

	if (havechild == 0){
		$('.adbox-holder').hide();
	}

	$('#header ul li.dropdown, .search-drop').hover(function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(100);
		}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(100);
	});
	var sign_count = '';
	sign_count = $('#header').find('.navbar-sm-login-links').length;
	if(sign_count!=0){
		$('#header .btn-holder').addClass('logged-out');
	}
	else{
		$('#header .btn-holder').removeClass('logged-out');
	}
});

//on resize functions
$(window).resize(function(){
 	headerFooter();
 	responsiveFixes();
});