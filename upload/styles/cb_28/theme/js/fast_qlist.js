
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
						$('#recent_vids_sec').append(data);
						$('#recent-loadmore').append('<button id="recent_load_more" class="btn btn-loadmore" loadtype="video" loadmode="recent" loadlimit="8" loadhit="'+newloadHit+'">Load More</button>');
					} else {
						$('#featured_load_more').remove();
						$('#featured_vid_sec').append(data);
						$('#featured-loadmore').append('<button id="featured_load_more" class="btn btn-loadmore" loadtype="video" loadmode="featured" loadlimit="2" loadhit="'+newloadHit+'">Load More</button>');
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
	
	$(document).find('#qlist_main').hide();		
	//alert(fastQitems);
	if (fastQitems == 'yes') {
		//alert("HERE");
		$(document).find('#qlist_main').show();
	}
	var notInList = false;
	function pushToQlist(obj, id) {
		id = parseInt(id);
		$.cookie("btn-q-"+id, "yes", { expires : 10 });
		currentList = $.cookie("fast_qlist");
		cleanList = currentList;
		//console.log(cleanList);
		if (cleanList != null) {
			notInList = true;
			index = cleanList.indexOf(id);
			if (index == '-1') {
				cleaned = cleanList.replace(/\[/g, '');
				cleaned = cleaned.replace(/\]/g, '');	
				newCookie = "[" + cleaned + ',' + id + ']';
			} else {
				return false;
			}
		} else {
			//console.log("Really");
			notInList = true;
			newCookie = "[" + id + "]";
		}

		$.cookie("fast_qlist", newCookie, { expires : 10 });
		var vtitle = $(obj).attr("vtitle"),
		vtitle = vtitle.split(0,10);
		thevid = $(obj).attr("v-id"),
		vlink = $(obj).attr("vlink"),
		vthumb = $(obj).attr("vthumb"),
		vduration = $(obj).attr("vduration");
		
		if (notInList == true) {
			$('#my_quicklist').append('<div class="qlist_item clearfix" style="background-color:#fff; "  id="quicklist_playlist_cont_'+thevid+'"><div class="pl_num"></div><div class="pl_thumb"><a href="'+obj.attr("vlink")+'" target="blank"><img src="'+vthumb+'"/></a><span class="pl_duration">'+vduration+'</span></div><div class="pl_details" "><p><a href="'+vlink+'" target="blank" >'+vtitle+'</a></p></div><button todel="'+thevid+'" class="ql_delete glyphicon glyphicon-trash btn btn-danger btn-sm"  title="remove '+vtitle+' from qucklist" alt="quicklist"></button></div>');
		}

		$.cookie("quick_list_box", "show", { expires : 10 });
		$('#qlist_main').show();
		$('.quicklist_cont').css("display","block");
	}

	$(document).ready(function(){
		$(".ql_show-hide1").click(function(){
			$(this).toggleClass('glyphicon-minus glyphicon-plus');
		});
	});

	$(document).on("click",".cb_quickie",function(){
		obj = $(this);
		$(this).addClass('check_icon');
		id = $(this).attr('v-id');
		title = $(this).attr('vtitle');
		thumb = $(this).attr('vthumb');
		link = $(this).attr('vlink');
		vdur = $(this).attr('vduration');
		pushToQlist(obj, id);
	});

	$(document).on("click",".ql_delete",function(){
		vid = $(this).attr('todel');
		$(this).removeClass("check_icon");
		currentList = $.cookie("fast_qlist");
		cleaned = currentList.replace(vid, '');
		console.log(cleaned);
		$.cookie("fast_qlist", cleaned, { expires : 10 });
		$(this).closest('.qlist_item').remove();
	});

	$(document).on("click",".ql_rem",function(e){
		e.preventDefault();
		$.cookie("fast_qlist", null, { expires : 10 });
		$('#qlist_main').remove();
	});
	