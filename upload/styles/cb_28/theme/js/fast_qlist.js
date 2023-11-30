$(document).ready(function() {
	$(document).find('#qlist_main').hide();

	if (fastQitems === 'yes') {
		$(document).find('#qlist_main').show();
	}
	var notInList = false;

	function pushToQlist(obj, id) {
		id = parseInt(id);
		set_cookie_secure("btn-q-" + id, "yes");
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

		set_cookie_secure("fast_qlist", newCookie);
		var vtitle = $(obj).attr("vtitle"),
			//vtitle = vtitle.split(0,10);
			thevid = $(obj).attr("v-id"),
			vlink = $(obj).attr("vlink"),
			vthumb = $(obj).attr("vthumb"),
			vduration = $(obj).attr("vduration");

		if (notInList == true) {
			$('<div style="display:none;" class="qlist_item clearfix" style="background-color:#fff;" id="quicklist_playlist_cont_' + thevid + '"><div class="pl_num"></div><div class="pl_thumb"><a href="' + obj.attr("vlink") + '" ><img src="' + vthumb + '" class="img-responsive" ><img src="' + '/styles/cb_28/theme/images/thumb-ratio.png" alt="" class="thumb-ratio"></a><span class="pl_duration">' + vduration + '</span></div><div class="pl_details"><p><a href="' + vlink + '" >tmptitle</a></p></div><button todel="' + thevid + '" class="ql_delete glyphicon glyphicon-trash btn btn-danger btn-sm" title="Remove ' + vtitle + ' from quicklist" alt="quicklist"></button></div>').appendTo('#my_quicklist');
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
		objs.attr('vtitle');
		objs.attr('vthumb');
		objs.attr('vlink');
		objs.attr('vduration');
		pushToQlist(obj, id);
	});

	$(document).on("click", ".ql_delete", function (e) {
		e.preventDefault();
		vid = $(this).attr('todel');
		$(".cb_quickie[v-id=" + vid + "]").removeClass('icon-tick');
		currentList = $.cookie("fast_qlist");
		cleaned = currentList.replace(vid, '');
		set_cookie_secure("fast_qlist", cleaned);
		$(this).closest('.qlist_item').fadeOut('slow');
	});

	$(document).on("click", ".ql_rem", function (e) {
		e.preventDefault();
		set_cookie_secure("fast_qlist", null);
		$('.qlist_item').fadeOut('slow');
		$('#qlist_main').fadeOut('slow');
		$('.cb_quickie').removeClass('icon-tick');
	});
});