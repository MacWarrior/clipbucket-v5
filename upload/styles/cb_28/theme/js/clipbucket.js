(function(window){
	var _cb = function(){
		var self = this;
		// bootstrapping
		this.baseurl = baseurl;
		this.imageurl = '';
		this.page = baseurl+'actions/ajax.php';
		this.loading_img = "<img alt='loading' style='vertical-align:middle' src='" + imageurl + "/ajax-loader-big.gif'/>";
		this.loading = this.loading_img+' Loading...';
		this.download = 0;
		this.count = 0;

		this.hasLoaded = false;
		this.current_menu = '';

		this.collectionID = false;
		this.ua = navigator.userAgent.toLowerCase();

		this.Confirm_Delete = function(delUrl){
			if (confirm('Are you sure you want to delete')) {
				document.location = delUrl;
			}
		};

		this.Confirm_Uninstall = function(delUrl) {
			if (confirm('Are you sure you want to uninstall this plugin ?')) {
				document.location = delUrl;
			}
		};

		this.confirm_it = function(msg){
			var action = confirm(msg);
			if(action){
				return true;
			}
			return false;
		};

		this.reloadImage = function(captcha_src,imgid){
			img = document.getElementById(imgid);
			img.src = captcha_src+'?'+Math.random();
		};

		this.randomString = function(){
			var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
			var string_length = 8;
			var randomstring = '';
			for (var i=0; i<string_length; i++) {
				var rnum = Math.floor(Math.random() * chars.length);
				randomstring += chars.substring(rnum,rnum+1);
			}
			return randomstring;
		};

		/**
		 * Function used to delete any item with confirm message
		 */
		this.delete_item = function(obj,id,msg,url){
			$('#'+obj+'-'+id).click(function () {
				if (confirm(msg)) {
					document.location = url;
				}
			});
		};

		this.delete_video = function(obj,id,msg,url){
			return delete_item(obj,id,msg,url);
		};

		/**
		 * Function used to load editor's pic video
		 */
		this.get_video = function(type,div){
			$(div).css('display','block');
			$(div).html(this.loading);
			$(div).html(this.loading);
			$.post(page, {
					mode : type
				},
				function(data){
					$(div).html(data);
				},'text');
		};



		this.rating_over = function(msg,disable){
			if(disable !== 'disabled'){
				$('#rating_result_container').html(msg);
			}
		};

		this.rating_out = function(msg,disable){
			if(disable !== 'disabled'){
				$('#rating_result_container').html(msg);
			}
		};

		this.submit_share_form = function(form_id,type){
			$('#share_form_results').css('display','block').html(this.loading);
			$.post(page,
				{
					mode : 'share_object',
					type : type,
					users : $('#ShareUsers').val(),
					message : $('#message').val(),
					id : $('#objectid').val()
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#share_form_results').html(data);
					}
				},'text');
		};

		this.flag_object = function(form_id,id,type){
			$('#flag_form_result').css('display','block').html(this.loading);
			$.post(page,
				{
					mode : 'flag_object',
					type : type,
					flag_type : $('#'+form_id+' select option:selected').val(),
					id : id
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#flag_form_result').css('display','block').html(data);
					}
				},'text');
		};

		this.slide_up_watch_video = function(nodiv){
			if($('.video_action_result_boxes '+nodiv).css('display') !== 'block'){
				$('.video_action_result_boxes > *').slideUp();
			}
		}

		this.add_to_fav = function(type,id){
			$('#video_action_result_cont').css('display','block').html(this.loading);

			$.post(page,
				{
					mode : 'add_to_fav',
					type : type,
					id : id
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#video_action_result_cont').css('display','block').html(data);
					}
				},'text');
		};

		this.subscriber = function(user,type,result_cont){
			$('#'+result_cont).css('display','block').html(this.loading);

			$.post(page,
				{
					mode : type,
					subscribe_to : user
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#'+result_cont).css('display','block').html(data);
					}
				},'text');
		};

		this.add_friend = function (uid,result_cont){
			$('#'+result_cont).css('display','block').html(this.loading);

			$.post(page,
				{
					mode : 'add_friend',
					uid : uid
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#'+result_cont).css('display','block').html(data);
					}
				},'text');
		};

		this.block_user = function (user,result_cont){
			$('#'+result_cont).css('display','block').html(this.loading);

			$.post(page,
				{
					mode : 'ban_user',
					user : user
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#'+result_cont).css('display','block').html(data);
					}
				},'text');
		};

		this.delete_comment = function (cid){
			$.post(page,
				{
					mode : 'delete_comment',
					cid : cid
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						if(data.msg) {
							alert(data.msg);
							$('#comment_'+cid).fadeOut('slow');
							$('#spam_comment_'+cid).fadeOut('slow');
						}
						if(data.err){
							alert(data.err);
						}
					}
				},'json');
		};

		this.add_playlist = function (mode,vid,form_id,objtype){
			$('#playlist_form_result').css('display','block').html(this.loading);
			switch(mode)
			{
                case 'add':
                    $.post(page, {
                            mode: 'add_playlist',
                            id: vid,
                            objtype: objtype,
                            pid: $('#playlist_id option:selected').val()
                        },
                        function (data) {
                            if (!data) {
                                alert('No data');
                            } else {
                                if (data.err !== '') {
                                    $('#playlist_form_result').css('display', 'block').html(data.err);
                                }

                                if (data.msg !== '') {
                                    $('#playlist_form_result').css('display', 'block').html(data.msg);
                                    $('#' + form_id).css('display', 'none');
                                }
                            }
                        }, 'json');
                    break;

				case 'new':
					$.post(page,
						{
							mode : 'add_new_playlist',
							id : vid,
							objtype : objtype,
							plname : $('#playlist_name').val()
						},
						function(data)
						{
							if(!data){
								alert('No data');
							} else  {
								if(data.err ) {
									$('#playlist_form_result').css('display','block').html(data.err);
								}

								if(data.msg) {
									$('#playlist_form_result').css('display','block').html(data.msg);
									$('#'+form_id).css('display','none');
								}
							}
						},'json');
					break;
			}
		};

		this.get_group_info = function(Div,li){
			if( $(Div).css('display') === 'none') {
				$('#group_info_cont > div').slideUp();
				$('#group_info_cont '+Div).slideDown();
				$('.group_detail_tabs .selected').removeClass('selected');
				$(li).addClass('selected');
			}
		};

		this.show_menu = function(menu,load_from_hash){
			if(window.location.hash && load_from_hash)
			{
				var thehash = window.location.hash;
				show_menu(thehash.substr(9),false);
				return false;
			}
			window.location.hash = 'current_'+menu;
			if(this.current_menu !== menu){
				hide_menu()
			}
			$('#'+menu).show()
			this.current_menu = menu;
			$('.'+menu).addClass('selected');
		};

		this.hide_menu = function(){
			if(this.current_menu !== '')
			{
				$('#'+this.current_menu).hide();
				$('.'+this.current_menu).removeClass('selected');
				return true;
			}
		};

		this.to_reply = function(cid){
			$('#reply_to').val(cid);
			window.location = '#add_comment';
		};

		this.spam_comment = function(cid,type,typeid){
			$.post(page,
				{
					mode : 'spam_comment',
					cid : cid,
					type : type,
					typeid : typeid
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						if(data.msg) {
							$('#comment_'+cid).hide();
							$('#spam_comment_'+cid).fadeIn('slow');
						}

						if(data.err) {
							alert(data.err);
						}
					}
				},'json');
		};

		/**
		 * Function autplay playlist
		 */
		this.swap_auto_play = function(){
			if($.cookie('auto_play_playlist') === 'true')
			{
				set_cookie_secure('auto_play_playlist','false');
				window.location = document.location;
				$('#ap_status').html('off');
			} else {
				$.cookie('auto_play_playlist','true',{path:'/'});
				window.location = document.location;
				$('#ap_status').html('on');
			}
		};

		this.collection_actions = function(form,mode,objID,result_con,type,cid)
		{
			$(result_con).css('display','block');
			$(result_con).html(this.loading);

			switch(mode)
			{
				case 'add_new_item':
					$.post(page,
						{
							mode: mode,
							cid: $('#'+form+' #collection').val(),
							obj_id: objID,
							type: type
						},
						function(data)
						{
							if(!data){
								alert('No Data returned');
							} else {
								if(data.msg){
									$(result_con).html(data.msg);
								}

								if(data.err){
									$(result_con).html(data.err);
								}
							}
						},'json')
					break;

				case 'remove_collection_item':
					$('#'+form).hide();
					$.post(page,
						{
							mode: mode,
							obj_id: objID,
							type: type,
							cid: cid
						},
						function(data)
						{
							if(!data) {
								alert('No Data Returned');
								$(result_con+'_'+objID).hide();
								$('#'+form).show();
							} else {
								if(data.err) {
									alert(data.err);
									$(result_con+'_'+objID).hide();
									$('#'+form+objID).show();
								}

								if(data.msg){
									$(result_con).html(data.msg);
									$('#'+form+'_'+objID).slideUp(350);
								}

							}
						},'json')
			}
			return false;
		};

		// Simple function to open url with javascript
		this.openURL = function(url) {
			document.locati= url;
		};

		this.construct_url = function(jsArr){
			var url;
			if(Seo === 'yes')
			{
				url = '#!/item/'+jsArr[0]+'/'+jsArr[1]+'/'+jsArr[2];
				window.location.hash = url
			} else {
				url	= '#!?item='+jsArr[2]+'&type='+jsArr[0]+'&collection='+jsArr[1];
				window.location.hash = url
			}
		};

		this.onReload_item = function(){
			var comURL, regEX;
			if(window.location.hash)
			{
				comURL = window.location.href;
				if(Seo === 'yes')
				{
					regEX = RegExp('\/item.+#!');
					if(regEX.test(comURL)) {
						comURL = comURL.replace(regEX,'');
						window.location.href = comURL;
					}
				} else {
					regEX = RegExp('\\\?item.+#!');
					if(regEX.test(comURL)) {
						comURL = comURL.replace(regEX,'')
						window.location.href = comURL;
					}
				}
			}
		};

		this.pagination = function(object,cid,type,pageNumber){
			var self = this;
			var obj = $(object)
				, objID = obj.id
				, paginationParent = obj.parent()
				, paginationParentID
				, paginationInnerHTML = obj.html();

			if(paginationParent.attr('id')){
				paginationParentID = parent.attr('id')
			} else {
				paginationParent.attr('id','loadMoreParent');
				paginationParentID = paginationParent.attr('id');
			}

			var newCall = $.ajax({
				url: self.page,
				type: 'post',
				dataType: 'json',
				data: {
					mode: 'more_items',
					page : pageNumber,
					cid: cid,
					type: type
				},
				beforeSend: function() { obj.removeAttr('onClick'); obj.html(self.loading) },
				success : function(data) {
					if(data['error'])
					{
						if(object.tagName === 'BUTTON'){
							obj.attr('disabled','disabled');
						}
						obj.removeAttr('onClick'); obj.html('No more '+type);
					} else {
						$('#collectionItemsList').append(data['content']);
						$('#NewPagination').html(data['pagination']);
						obj.html(paginationInnerHTML);
					}
				}
			});
		};

		this.ajax_add_collection = function(obj){
			var self = this;
			var formID = obj.form.id, Form = $('#'+formID),
				This = $(obj), AjaxCall, ButtonHTML = This.html(),
				Result = $('#CollectionResult');
			AjaxCall = $.ajax({
				url: self.page,
				type: 'post',
				dataType: 'json',
				data: 'mode=add_collection&'+Form.serialize(),
				beforeSend: function() {
					if(Result.css('display') === 'block'){
						Result.slideUp('fast');
					}
					This.attr('disabled','disabled');
					This.html(this.loading);
				},
				success: function(data) {
					if(data.msg) {
						$('#CollectionDIV').slideUp('fast');
						Result.html(data['msg']).slideDown('fast');
						this.collectionID = data['id'];
					} else {
						Result.html(data['err']).slideDown('fast');
						This.removeAttr('disabled'); This.html(ButtonHTML);
					}
				}
			});
		};

		this.getName = function(File){
			return File.substring(File.lastIndexOf('/')+1);
		};

		this.viewRatings = function(object,pid){
			var obj = $(object), innerHTML = obj.html();
			if(document.getElementById('RatingStatContainer')){
				$('#RatingStatContainer').toggle();
			} else {
				loadAjax = $.ajax({
					url:page,
					type: 'post',
					dataType: 'text',
					data: { mode:'viewPhotoRating', photoid:pid },
					beforeSend: function() { obj.html(this.loading); },
					success:function(data) {
						obj.html(innerHTML);
						if(data) {
							$('<div/>').attr('id','RatingStatContainer')
								.addClass('clearfix')
								.css({
									'padding' : '8px',
									'font' : 'normal 11px Tahoma',
									'border' : '1px solid #ccc',
									'backgroundColor' : '#FFF'
								}).html(data).fadeIn(350).insertAfter(obj);
						} else {
							obj.removeAttr('onclick');
							alert('Photo has not recieved any rating yet.');
						}
					}
				});
			}
		};

		this.showAdvanceSearch = function(simple,advance,expandClass,collapseClass){
			var simpleObj = $('#'+simple); var advanceObj = $('#'+advance);
			var	value = $('#SearchType').val();
			advanceObj.toggle();
			if(advanceObj.css('display') === 'block'){
				advanceObj.children().hide().filter('#'+value).show();
			}
			$('.'+expandClass).toggleClass(collapseClass);
		};

		this.toggleCategory = function(object,perPage){
			var obj = $(object), childTarget = obj.attr('alt'), child = $('#'+childTarget),
				childparts = childTarget.split('_'), childID = childparts[0];
			var browser = $.browser.msie; var browserVersion = $.browser.version;

			if(child.css('display') === 'none')
			{
				child.slideDown(350);
				if(browser && browserVersion === '7.0'){
					child.addClass('internetExplorer7CategoryToggleFix');
				}
				set_cookie_secure(childID,'expanded');
				obj.removeClass('none').addClass('block');
			} else {
				child.slideUp(350);
				if(browser && browserVersion === '7.0'){
					child.removeClass('internetExplorer7CategoryToggleFix');
				}
				set_cookie_secure(childID,'collapsed');
				obj.removeClass('block').addClass('none');
			}
		};

		var comments_voting = 'no';

		this.checkUncheckAll = function(theElement) {
			var theForm = theElement.form, z = 0;

			for(z=0; z<theForm.length;z++){
				if(theForm[z].type === 'checkbox' && theForm[z].name !== 'checkall'){
					theForm[z].checked = theElement.checked;
				}
			}
		};

		/**
		 * Function used to rate object
		 */
		this.rate = function(id,rating,type){
			var page = baseurl+'actions/ajax.php';
			$.post(page,
				{
					mode : 'rating',
					id:id,
					rating:rating,
					type:type
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#rating_container').html(data);
					}
				},'text');
		};

		this.setPageHash = function(Page){
			// Removing this.baseurl
			var hashPart = Page.replace(this.baseurl,'');
			var prevHash = window.location.hash.replace('#!','');
			{
				window.location.hash = '#!'+hashPart;
			}
		};

		this.callURLParser = function(){
			var expression = /(\#![/a-zA-Z0-9=\.\&\-\_\?]*)/g,
				location = window.location.href,
				returned = location.match(expression),
				lastVisited;
			if(returned)
			{
				lastVisited = returned[returned.length - 1];
				if(lastVisited){
					window.location.href = this.lastVisited.replace('#!','');
				}
			}
		};

		this.getAllComments = function(type,type_id,last_update,pageNum,total,object_type,admin){
			$('#userCommentsList').html("<div style='padding:5px 0;'>"+loading+'</div>');
			$.ajax({
				type: 'POST',
				url: page,
				data: {
					mode:'getComments',
					page:pageNum,
					type:type,
					type_id:type_id,
					object_type : object_type,
					last_update : last_update,
					total_comments : total,
					comments_voting : comments_voting,
					admin : admin
				},
				success: function(comments){
					$('#userCommentsList').html(comments);
				},
				dataType: 'text'
			});
		};


		this.addToFav = function(type,id){
			$('#messageFav').show();
			$.post(page, {
					mode : 'add_to_fav',
					type : type,
					id : id
				},
				function(data){
					if(!data){
						alert('No data');
					} else {
						$('#messageFav').html(data);
						setTimeout(function(){
							$('#messageFav').hide();
						}, 5000);
					}
				},'text');
		};

		this.subscribeToChannel = function(user,type,result_cont){
			$('#messageFav').show();
			$.post(page, {
					mode : type,
					subscribe_to : user
				},
				function(data){
					if(!data){
						alert('No data');
					} else {
						$('#messageFav').html(data);
						setTimeout(function(){
							$('#messageFav').hide();
						}, 5000);
					}
				},'text');
		};

		this.debounce = function(func, wait, immediate){
			var timeout;
			return function() {
				var context = this, args = arguments;
				var later = function() {
					timeout = null;
					if (!immediate){
						func.apply(context, args);
					}
				};
				var callNow = immediate && !timeout;
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow){
					func.apply(context, args);
				}
			};
		}

		this.throwHeadMsg = function(tclass, msg, hideAfter) {
			$(document).find('#headErr').remove();
			hideAfter = parseInt(hideAfter);

			if (hideAfter < 10) {
				hideAfter = 3000;
			}

			if (tclass.length < 3) {
				tclass = 'info';
			}

			$('<div id="headErr" class="alert_messages_holder" style="display:none;"><div class="alert alert-'+tclass+' alert-messages alert-ajax" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+msg+'</div></div>').insertAfter('#header').fadeIn('slow').delay(hideAfter).fadeOut();
		};
		this.throwHeadDivMsg = function(msg, hideAfter) {
			$(document).find('#headErr').remove();
			hideAfter = parseInt(hideAfter);
			if (hideAfter < 10) {
				hideAfter = 3000;
			}
			$('<div id="headErr" class="alert_messages_holder alert-ajax" style="display:none;">'+msg+'</div>').insertAfter('#header').fadeIn('slow').delay(hideAfter).fadeOut();
		};

		/**
		 * New improved version of ClipBucket rating system
		 * @since: 8th, April 2016 ClipBucket 2.8.1
		 * @author: Saqib Razzaq
		 */

        this.rateNew = function (id, rating, type) {
            curObj = this;
            var page = baseurl + 'actions/rating_update.php';
            $.post(page, {
                    id: id,
                    rating: rating,
                    type: type
                },
                function (data) {
                    if (!data.success) {
                        alert('No data');
                    } else {
                        const currLikes = parseInt($('.likes').find('span:nth-child(2)').html());
                        const currDislikes = parseInt($('.dislikes').find('span:nth-child(2)').html());
                        let newRating;
                        if (rating == 5) {
                            if ($('.likes').hasClass('rated')) {
                                newRating = currLikes - 1;
                                if (newRating < 0) {
                                    newRating = 0;
                                }
                                $('.likes').removeClass('rated').find('span:nth-child(2)').html(newRating);
                            } else {
                                newRating = currLikes + 1;
                                $('.likes').addClass('rated').find('span:nth-child(2)').html(newRating);
                                if ($('.dislikes').hasClass('rated')) {
                                    newRating = currDislikes - 1;
                                    if (newRating < 0) {
                                        newRating = 0;
                                    }
                                    $('.dislikes').removeClass('rated').find('span:nth-child(2)').html(newRating);
                                }
                            }
                        } else {
                            if ($('.dislikes').hasClass('rated')) {
                                newRating = currDislikes - 1;
                                if (newRating < 0) {
                                    newRating = 0;
                                }
                                $('.dislikes').removeClass('rated').find('span:nth-child(2)').html(newRating);
                            } else {
                                newRating = currDislikes + 1;
                                $('.dislikes').addClass('rated').find('span:nth-child(2)').html(newRating);
                                if ($('.likes').hasClass('rated')) {
                                    newRating = currLikes - 1;
                                    if (newRating < 0) {
                                        newRating = 0;
                                    }
                                    $('.likes').removeClass('rated').find('span:nth-child(2)').html(newRating);
                                }
                            }
                        }
                    }
                    curObj.throwHeadDivMsg(data.msg, 5000, true);
                }, 'json'
            );
        }

		this.showMeTheMsg = function(data, alertDiv) {
			let curObj = this;
			let isOk;
			if (alertDiv == true) {
				isOk = $(data).filter('div.msg').find('div.alert').html();
			} else {
				isOk = $(data).filter('div.msg').html();
			}
			let isError = $(data).filter('div.error').html();

			if (isError) {
				if (isError.length > 2) {
					curObj.throwHeadMsg('danger',isError, 5000, true);
				}
			} else if (isOk) {
				if (isOk.length > 2) {
					curObj.throwHeadMsg('success',isOk, 5000, true);
				}
			}
		}

		this.add_friendNew = function (uid,result_cont){
			curObj = this;
			$('#'+result_cont).css('display','block').html(this.loading);

			$.post(page
				, {mode : 'add_friend', uid : uid}
				,function(data) {
					if(!data){
						alert('No data');
					} else {
						$('#'+result_cont).html(data['html']);
						curObj.showMeTheMsg(data['msg']);
					}
				}
				,'json'
			);
		};

        this.add_to_favNew = function (type, id) {
            return this.manage_fav('add', type, id);
        };
        this.remove_from_fav = function (type, id) {
            return this.manage_fav('remove', type, id);
        };
        this.manage_fav = function (action, type, id) {
            var curObj = this;
            let url = '';
            if (action == 'remove') {
                url = baseurl + 'actions/favorite_remove.php';
            } else if (action == 'add') {
                url = baseurl + 'actions/favorite_add.php';
            } else {
                return false;
            }
            $('#video_action_result_cont').css('display', 'block').html(curObj.loading);

            return new Promise((resolve, reject) => {
                $.post(url, {
                    type: type,
                    id: id
                }, function (data) {
                    if (!data.success) {
                        reject(data);
                    } else {
                        $('#video_action_result_cont').hide();
                        resolve(data);
                    }
                    curObj.throwHeadDivMsg(data.msg, 5000, true)
                }, 'json');
            });
        }

		this.flag_objectNew = function(form_id,id,type){
			var curObj = this;
			$('#flag_form_result').css('display','block').html(this.loading);
			$.post(page,
				{
					mode : 'flag_object',
					type : type,
					flag_type : $('#'+form_id+' select option:selected').val(),
					id : id
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#flag_form_result').hide();
						curObj.showMeTheMsg(data);
					}
				},'text');
		};

        this.addToPlaylist = function (vid, form_id, objtype) {
            curObj = this;
            var val = $('#playlist_id option:selected').val()
            if (val == '0' || val == '' || val == null) {
                curObj.throwHeadMsg('danger', please_select_playlist , 5000, true);
            } else {
                $('#playlist_form_result').html(loading).show();
                $.post(page,
                    {
                        mode: 'add_playlist',
                        id: vid,
                        objtype: objtype,
                        pid: val
                    },
                    function (data) {
                        if (!data) {
                            alert('No data');
                        } else {
                            if (data.err.length > 2) {
                                cleanedHtml = $.parseHTML(data.err);
                                var msg = $(cleanedHtml).html();
                                curObj.throwHeadMsg('danger', msg, 5000, true);
                            }

                            if (data.msg.length > 2) {
                                cleanedHtml = $.parseHTML(data.msg);
                                var msg = $(cleanedHtml).find('div.alert').html();
                                curObj.throwHeadMsg('success', msg, 5000, true);
                                $('#addPlaylistCont').toggle();
                            }
                            if (typeof data.total_items !== 'undefined') {
                                $('#option_playlist_' + val).html(data.total_items);
                            }
                        }
                        $('#playlist_form_result').hide();
                    }, 'json'
                );
            }
        };

		this.createPlaylist = function (vid,form_id,objtype){
			curObj = this;
			$('#playlist_form_result').html(loading).show();
			$.post(page, {
					mode : 'add_new_playlist',
					id : vid,
					objtype : objtype,
					plname : $('#playlist_name').val()
				},
				function(data) {
					if(!data){
						alert('No data');
					} else {
						if(data.err.length > 2) {
							cleanedHtml = $.parseHTML(data.err);
							var msg = $(cleanedHtml).html();
							curObj.throwHeadMsg('danger',msg, 5000, true);
						}

						if(data.msg) {
							cleanedHtml = $.parseHTML(data.msg);
							var msg = $(cleanedHtml).find('div.alert').html();
							curObj.throwHeadMsg('success',msg, 5000, true);
							$('#'+form_id).html(data.html);
						}
					}
					$('#playlist_form_result').hide();
				},'json'
			);
		};

		this.getModalVideo = function(video_id){
			$.ajax({
				type: 'post',
				url: baseurl+'actions/commonAjax.php',
				data: { videoid : video_id , mode : 'get_video'},
				dataType: 'json',
				beforeSend: function (data) {
					$('.my-modal-content').html('<div style="color:#fff;font-size:25px;padding:10px 10px 10px 10px;">'+loadingImg+'</div>');
				},
				success: function (data) {
					if( data.success ){
						let vData = data.video_details;

						$('.my-modal-content').attr('id',vData.videoid).html(data.video).promise().done(function(){
							let videoplayer = $('.my-modal-content').find('video')[0];
							$('.cd-popup').addClass('is-visible');

							document.querySelector('.player-holder video').addEventListener( "loadedmetadata", function (e) {
								adaptRatioPlayer();

								let playPromise = videoplayer.play();
								if (playPromise !== null){
									playPromise.catch(() => {
										videoplayer.play();
									})
								}
							});

							let domVideos = $(document).find('video');
							if (domVideos.length > 0){
								for (let i = 0 ; i < domVideos.length ; i++) {
									let id = $(domVideos[i]).attr('id');
									let video_id = id.split('_');
									video_id = video_id[3];
									if (vData.videoid !== video_id){
										$(domVideos[i])[0].pause();
									}
								}
							}
						});
					}else if(data.failure){
						$('.my-modal-content').html('<div class="alert alert-warning">'+data.message+'</div>');
					}
				}
			});
		}

		this.getPlayerEl = function(videoid){
			var player = $(document).find('.cb_video_js_'+videoid+'-dimensions');
			if (player){
				return player[0];
			}
			return false;
		}

		this.unsubscribeToChannel = function(user,type){
			curObj = this;
			var elems = document.getElementsByClassName('subs_'+user);
			if(elems.length>0){
				Array.prototype.forEach.call(elems, function(el) {
					el.disabled = true;
				});
			}
			$.post(page, {mode : type,subscribe_to : user},function(data){
				if(!data){
					alert('No data');
				} else {
					data = JSON.parse(data);
					if(data.typ === 'err') {
						curObj.showMeTheMsg('<div class="error">' + data.msg + '</div>');
						Array.prototype.forEach.call(elems, function(el) {
							el.disabled = false;
						});
						return false;
					} else {
						curObj.showMeTheMsg('<div class="msg">' + data.msg + '</div>');
					}

					if(data.severity<2){
						// for channels page
						if(elems.length>0){
							Array.prototype.forEach.call(elems, function(el) {
								el.innerHTML=lang_subscribe;
								el.setAttribute('onclick','_cb.subscribeToChannelNew('+user+",'subscribe_user');");
								el.disabled = false;
								curObj.updateSubscribersCount(user);
							});
						}
					} else {
						Array.prototype.forEach.call(elems, function(el) {
							el.disabled = false;
						});
					}
				}
			},'text');
		};

		this.subscribeToChannelNew = function(user,type){
			var curObj = this;

			var elems = document.getElementsByClassName('subs_'+user);
			if(elems.length>0){
				Array.prototype.forEach.call(elems, function(el) {
					el.disabled = true;
				});
			}
			$.post(page, { mode : type,subscribe_to : user },function(data){
				if(!data){
					alert('No data');
				} else {
					data = JSON.parse(data);
					if(data.typ === 'err'){
						curObj.showMeTheMsg('<div class="error">'+data.msg+'</div>');
						Array.prototype.forEach.call(elems, function(el) {
							el.disabled = false;
						});
						return false;
					} else {
						curObj.showMeTheMsg('<div class="msg">'+data.msg+'</div>');
					}

					if(data.severity<2){
						// for channels page
						if(elems.length>0){
							Array.prototype.forEach.call(elems, function(el) {
								el.innerHTML=lang_unsubscribe;
								el.setAttribute('onclick','_cb.unsubscribeToChannel('+user+",'unsubscribe_user');");
								el.disabled = false;
								curObj.updateSubscribersCount(user);
							});
						}
					}else{
						Array.prototype.forEach.call(elems, function(el) {
							el.disabled = false;
						});
					}
				}
			},'text');
		};

		this.updateSubscribersCount = function(userid){
			$.post(page, {
					mode : 'get_subscribers_count',
					userid : userid
				},
				function(data) {
					if(!data){
						alert('No data');
					} else {
						subsObj = JSON.parse(data);
						$('#user_subscribers_'+userid).html(subsObj.subscriber_count);
					}
				},'text'
			);
		};

        this.listener_favorite = function (type, id) {
            const curObj = this;
            $('.manage_favorite').on('click', function (e) {
                let button = $(this);
                if (button.hasClass('glyphicon-heart')) {
                    button.removeClass('glyphicon-heart').html(curObj.loading_img);
                    //remove fav
                    curObj.remove_from_fav(type, id).then(function (data) {
                        button.html('').addClass('glyphicon-heart-empty');
                        button.attr('title', lang['remove_from_favorites']);
                    }).catch(function (error) {
                        button.addClass('glyphicon-heart').html('');
                    });
                } else {
                    button.removeClass('glyphicon-heart-empty').html(curObj.loading_img);
                    curObj.add_to_favNew(type, id).then(function (data) {
                        button.html('').addClass('glyphicon-heart');
                        button.attr('title', lang['add_to_my_favorites']);
                    }).catch(function (error) {
                        button.addClass('glyphicon-heart-empty').html('');
                    });
                }
            });
        }

        this.listener_favorite_only_remove = function (type) {
            const curObj = this;
            $('.manage_favorite').on('click', function () {
                const button = $(this);
                button.removeClass('glyphicon-heart').html(curObj.loading_img);
                curObj.remove_from_fav(type, button.data('id')).then(function (data) {
                    button.remove();
                }).catch(function (err) {
                    button.addClass('glyphicon-heart').html('');
                });
            });
        }
    };

	window._cb = new _cb();

})(window);
