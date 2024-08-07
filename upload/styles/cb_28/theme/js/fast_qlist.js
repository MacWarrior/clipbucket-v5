$(document).ready(function() {
	$(document).find('#qlist_main').hide();
	$('#quicklist_cont').hide();

	if (fastQitems === 'yes') {
		if($.cookie('quick_list_box')!='hide') {
			$('.ql_show-hide1').toggleClass('glyphicon-plus glyphicon-minus');
			$('#quicklist_cont').show();
		}
		$(document).find('#qlist_main').show();
	}
	var notInList = false;

	function pushToQlist(obj, id) {
		id = parseInt(id);
		set_cookie_secure("btn-q-" + id, "yes");
		currentList = $.cookie("fast_qlist");
		cleanList = JSON.parse(currentList);
		//console.log(cleanList);
		if (cleanList != null) {
			notInList = true;
			if (!cleanList.includes(id)) {
				cleanList.push(id);
			} else {
				return false;
			}
		} else {
			notInList = true;
			cleanList = [id];
			$('.ql_show-hide1').toggleClass('glyphicon-plus glyphicon-minus');
		}
		$('#qlist_count').html(cleanList.length);
		set_cookie_secure("fast_qlist", JSON.stringify(cleanList));
		var vtitle = $(obj).attr("vtitle"),
			thevid = $(obj).attr("v-id"),
			vlink = $(obj).attr("vlink"),
			vthumb = $(obj).attr("vthumb"),
			vduration = $(obj).attr("vduration"),
			vauthor = $(obj).attr("vauthor");

		if (notInList == true) {
			$('<div style="display:none;" class="qlist_item clearfix" id="quicklist_playlist_cont_' + thevid + '"><div class="pl_num"></div><div class="pl_thumb"><a href="' + obj.attr("vlink") + '" ><img src="' + vthumb + '" class="img-responsive"/></a><span class="pl_duration">' + vduration + '</span></div><div class="pl_details"><p><a href="' + vlink + '" >tmptitle</a></p><p>' + vauthor + '</p></div><button todel="' + thevid + '" class="ql_delete glyphicon glyphicon-trash btn btn-danger btn-sm" title="Remove ' + vtitle + ' from quicklist" alt="quicklist"></button></div>').appendTo('#my_quicklist');
			$('#my_quicklist div:last-child div.pl_details p a').text(vtitle);
			$('#my_quicklist div:last-child').fadeIn('slow');
		}

		set_cookie_secure("quick_list_box", "show");
		$('#qlist_main').show();
		$('.quicklist_cont').css("display", "block");
	}

	$(document).ready(function () {
		$(".ql_show-hide1").click(function () {
			$(this).toggleClass('glyphicon-minus glyphicon-plus');
		});
	});

	$(document).on("click", ".cb_quickie", function () {
		let obj = $(this);
		let id = $(this).attr('v-id');
		let objs = $(".cb_quickie[v-id=" + id + "]");
		objs.addClass('icon-tick');
		pushToQlist(obj, id);
	});

	$(document).on("click", ".ql_delete", function (e) {
		e.preventDefault();
		vid = $(this).attr('todel');
		$(".cb_quickie[v-id=" + vid + "]").removeClass('icon-tick');
		currentList = $.cookie("fast_qlist");
		cleanList = JSON.parse(currentList);
		var index = cleanList.indexOf(parseInt(vid));
		if (index !== -1) {
			cleanList.splice(index, 1);
		}
		$('#qlist_count').html(cleanList.length);
		$(this).closest('.qlist_item').fadeOut('slow');
		if (cleanList.length == 0) {
			set_cookie_secure("fast_qlist", null);
			$('#qlist_main').fadeOut('slow');
		} else {
			set_cookie_secure("fast_qlist", JSON.stringify(cleanList));
		}
	});

	$(document).on("click", ".ql_rem", function (e) {
		e.preventDefault();
		$('#qlist_count').html(0);
		set_cookie_secure("fast_qlist", null);
		$('.qlist_item').fadeOut('slow');
		$('#qlist_main').fadeOut('slow');
		$('.cb_quickie').removeClass('icon-tick');
	});
});

function quick_show_hide_toggle(obj)
{
	$(obj).slideToggle()

	if($.cookie("quick_list_box")=="show") {
		set_cookie_secure('quick_list_box','hide');
		$('.ql_show-hide').html('show');
	} else {
		set_cookie_secure('quick_list_box','show')
		$('.ql_show-hide').html('hide');
	}
}