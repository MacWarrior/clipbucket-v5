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
function preLoadingBlock(){
	//two videos in a row
	var ftthumbWidth = $('.featured-videos .thumb-video').width();
	var	ftthumbHeight = ftthumbWidth * (10/16);
	$(".featured-videos .thumb-video").css('height', ftthumbHeight+'px');
	//three videos in a row
	var thumbWidth = $('.videos .thumb-video').width();
	var	thumbHeight = thumbWidth * (10/16);
	$(".videos .thumb-video").css('height', thumbHeight+'px');
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


function homePageVideos(qlist_items) {
	$('#container').on("click","#recent_load_more, #featured_load_more",function(){
		var loadLink = baseurl + '/ajax/home.php',
		main_object = $(this),
		sendType = 'post',
		dataType = 'html',
		loadType = $(main_object).attr('loadtype'),
		loadMode = $(main_object).attr('loadmode'),
		loadLimit = $(main_object).attr('loadlimit'),
		loadHit = $(main_object).attr('loadhit'),
		newloadHit = parseInt(loadHit) + 1;
		$.ajax({
			url: loadLink,
			type: sendType,
			dataType: dataType,
			data: {
				"load_type":loadType,
				"load_mode":loadMode,
				"load_limit":loadLimit,
				"load_hit":loadHit
			},

			beforeSend: function() {
				// setting a timeout
				$(main_object).text("Loading..");
				if (loadType != 'count') {
					if (loadMode == 'featured') {
						$(document).find('#featured_vid_sec').append('<div id="featured_pre"><div class="item-video col-lg-6 col-md-6 col-sm-6 col-xs-12"><div style="height:200px" class="thumb-video background-masker clearfix"></div></div><div class="item-video col-lg-6 col-md-6 col-sm-6 col-xs-12"><div style="height:200px" class="thumb-video background-masker clearfix"></div></div></div>');
					} else {
						for (var i = 0; i < 6; i++) {
							$(document).find('#recent_pre').append('<div class="item-video col-lg-4 col-md-4 col-sm-4 col-xs-6"><div class="thumb-video background-masker clearfix"></div><div class="loadingInfo video-info relative clearfix"><div class="background-masker heading clearfix"></div><div class="background-masker paragraph clearfix"></div><div class="background-masker clearfix views-date"></div></div></div>');
						}
						preLoadingBlock();
					}
				}
			},

			success: function(data) {
				$(main_object).text("Load More");
				if (data === '') {
					$(main_object).remove();
					return true;
				}
				if (loadType == 'video') {
					if (loadMode == 'recent') {
						$('#recent_load_more').remove();
						$('#recent_pre').html('');
						$('#recent_vids_sec').append(data);
						$(document).find('#recent-loadmore').append('<button id="recent_load_more" class="btn btn-loadmore" loadtype="video" loadmode="recent" loadlimit="6" loadhit="'+newloadHit+'">Load More</button>');
					} else {
						$('#featured_load_more').remove();
						$('#featured_pre').remove();
						$('#featured_vid_sec').append(data);
						$(document).find('#featured-loadmore').append('<button id="featured_load_more" class="btn btn-loadmore" loadtype="video" loadmode="featured" loadlimit="2" loadhit="'+newloadHit+'">Load More</button>');
					}
				} 
			}
		});

		$.ajax({
			url: loadLink,
			type: sendType,
			dataType: dataType,
			data: {
				"load_type":'count',
				"load_mode":loadMode,
				"load_limit":loadLimit,
				"load_hit": parseInt(loadHit) + 1
			},

			beforeSend: function() {
				// setting a timeout
				
			},

			success: function(data) {
				var jsonData = $.parseJSON(data);
				num = jsonData.more_vids;
				if (num == 'none') {
					if (loadMode == 'recent') {
						$('#recent_load_more').remove();
					} else {
						$('#featured_load_more').remove();
					}
				}
			}
		});
	});

	// trigger clicks on doc load to get
	// initial videos

	$(document).ready(function(){

		$('#featured_load_more').trigger("click");
		$('#featured_load_more').hide();
		$('#recent_load_more').trigger("click");
		$('#recent_load_more').hide();

	});
}

//on resize functions
$(window).resize(function(){
 	headerFooter();
 	preLoadingBlock();
 	responsiveFixes();
});