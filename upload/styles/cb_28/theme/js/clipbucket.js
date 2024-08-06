(function(window){
	var _cb = function(){
		var self = this;
		// bootstrapping
		this.baseurl = baseurl;
		this.imageurl = '';
		this.page = '/ajax.php';
		this.loading_img = "<img alt='loading' style='vertical-align:middle' src='" + imageurl + "/ajax-loader-big.gif'/>";
		this.loading = this.loading_img+' Loading...';
		this.download = 0;
		this.total_size = 0;
		this.cur_speed = 0;

		this.status_refesh = 1 //in seconds
		this.result_page = '/actions/file_results.php';
		this.download_page = '/actions/file_downloader.php';
		this.count = 0;

		this.hasLoaded = false;
		this.perc_download = 0;


		this.force_stop = false;
		this.remoteObjID = '';

		this.current_menu = '';

		this.collectionID = false;

		this.keyStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

		this.ua = navigator.userAgent.toLowerCase();

		if (this.ua.indexOf(' chrome/') >= 0 || this.ua.indexOf(' firefox/') >= 0 || this.ua.indexOf(' gecko/') >= 0) {
			var StringMaker = function () {
				this.str = '';
				this.length = 0;
				this.append = function (s) {
					this.str += s;
					this.length += s.length;
				}
				this.prepend = function (s) {
					this.str = s + this.str;
					this.length += s.length;
				}
				this.toString = function () {
					return this.str;
				}
			}
		} else {
			var StringMaker = function () {
				this.parts = [];
				this.length = 0;
				this.append = function (s) {
					this.parts.push(s);
					this.length += s.length;
				}
				this.prepend = function (s) {
					this.parts.unshift(s);
					this.length += s.length;
				}
				this.toString = function () {
					return this.parts.join('');
				}
			}
		}

		this.setRemoteId = function(){
			this.remoteObjID = this.randomString();
		};

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

		this.check_remote_url = function(){
			var self = this;
			var file = $('#remote_file_url').val();
			var $uploadButton = $('#remoteUploadBttn'); // upload button
			var $cancelButton = $('#remoteUploadBttnStop'); // cancel upload button
			this.force_stop = false;
			if(file.match(/^e.g/) || typeof file === 'undefined' || file.length === 0){
				// given url is not valid
				$('#error_msgs').html('<div class="alert alert-danger" role="alert">Given URL is invalid!</div>');
				return false;
			}

			// these functions will only be used in remote upload
			// they manage the UI changes
			var remoteUploadStart = function(){
				$('.downloadStatusContainer').removeClass('hidden');
				$uploadButton.attr('disabled','disabled').hide();
				$cancelButton.show();
			};

			var remoteUploadStop = function(){
				$('.downloadStatusContainer').addClass('hidden');
				$cancelButton.removeAttr('disabled').hide();
				$uploadButton.removeAttr('disabled').show();
			};

			remoteUploadStart();

			var ajaxCall = $.ajax({
				url: self.download_page,
				type: 'post',
				data: ({file:file,file_name:file_name}),
				dataType : 'JSON',
				beforeSend : function(){
					self.remoteUploadStatusUpdate();
					var remoteFileName = self.getName(file);
					$('#loading').html('Downloading');
					$('#remoteFileName').replaceWith('"'+remoteFileName+'"');
				},
				success: function(data){
					self.force_stop = true;
					if(data.error){
						remoteUploadStop();
						$('#error_msgs').html('<div class="alert alert-danger" role="alert"> File Type Not Allowed!</div>');
						return false;
					}
					remoteUploadStop();
					$('#loading').html('');
					var vid = data.vid;
					$.post('/actions/getVideoDetails.php', {
						'file_name':file_name,
						'vid' : vid,
					},function(data){
						var oneFileForm = $('#updateVideoInfoForm').clone();
						$(oneFileForm).find('input[name=title]').val(data.title);
						$(oneFileForm).find('textarea#desc').val(data.description);
						$(oneFileForm).find("input[name='category[]']:first").attr('checked', 'checked');

						// creating the hidden form fields
						var hiddenVideoIdField = document.createElement('input');
						hiddenVideoIdField.name = 'videoid';
						hiddenVideoIdField.type = 'hidden';
						hiddenVideoIdField.value = vid;

						$(oneFileForm).append(hiddenVideoIdField);

						$('#remoteForm').html('');
						$(oneFileForm).removeClass('hidden')
							.attr('id', 'uploadFormContainer_remote')
							.appendTo('#remoteForm');
						$(oneFileForm).find('form').on({
							submit: function(e){
								e.preventDefault();

								var form = $(this);

								var formData = $(form).serialize();
								formData += '&updateVideo=yes';

								$.ajax({
									url : '/actions/file_uploader.php',
									type : 'post',
									data : formData,
									success: function(data){
										msg = $.parseJSON(data);
										$('#uploadMessage').removeClass('hidden');
										if(msg.error){
											$('#uploadMessage').html(msg.error).attr('class', 'alert alert-danger');
										}else{
											$('#uploadMessage').html(msg.msg).attr('class', 'alert alert-success');
										}
										setTimeout(function(){
											$('#uploadMessage').addClass('hidden');
										}, 5000);
									}
								});
							}
						});
						$('.formSection h4').on({
							click: function(e){
								e.preventDefault();
								if($(this).find('i').hasClass('glyphicon-chevron-down')){
									$(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
									$(this).next().toggleClass('hidden');
								}else{
									$(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
									$(this).next().toggleClass('hidden');
								}
							}
						});
						$(oneFileForm).on({
							submit: function(e){
								e.preventDefault();
								var data = $(this).serialize();
								data += '&updateVideo=yes';
								$.ajax({
									url : '/actions/file_uploader.php',
									type : 'post',
									data : data,
									dataType: 'json',
									success: function(msg){
										$('#uploadMessage').removeClass('hidden');
										if(msg.error){
											$('#uploadMessage').html(msg.error).attr('class', "alert alert-danger");
										} else {
											$('#uploadMessage').html(msg.msg).attr('class', "alert alert-success");
										}
										setTimeout(function(){
											$('#uploadMessage').addClass('hidden');
										}, 5000);
									}
								}).fail(function(err){
									console.log(err);
								});
							}
						});
					},'json');
				}
			});

			$('#remoteUploadBttnStop').click(function() {
				ajaxCall.abort();
				this.force_stop=true;
				$('#loading').html('');
				$('#remoteDownloadStatus').hide();
				$(this).hide();
				$('#remoteUploadBttn').attr('disabled','').show();
			});
		};

		this.remoteUploadStatusUpdate = function(){
			var self = this;
			var ajaxCall = $.ajax({
				url: self.result_page,
				type: 'post',
				data:({file_name:file_name}),
				dataType: 'json',
				success: function(serverResponse){
					if(false === self.force_stop){
						self.updateProgress(serverResponse);
						setTimeout(function(){
							self.remoteUploadStatusUpdate();
						}, self.status_refesh*1000);
					}
				}
			});
		};

		this.updateProgress = function(serverResponse){
			if(typeof serverResponse !== 'undefined' && serverResponse !== null){
				var downloaded = (serverResponse.downloaded/1048576).toFixed(2);
				var total = (serverResponse.total_size/1048576).toFixed(2);
				var progress = (serverResponse.downloaded/serverResponse.total_size) * 100;
				$('#downloadStatus').find('#downloaded').text(downloaded+' Mb');
				$('#downloadStatus').find('#totalSize').text(total+' Mb');
				$('#prog_bar').css('width', progress+'%');
			}
		};

		this.status_update = function(){
			var self = this;
			var ajaxCall = $.ajax({
				url: self.result_page,
				type: 'post',
				data:({file_name:file_name}),
				dataType: 'json',
				success: function(data){
					if(data){
						var total = parseFloat(data.total_size);
						var download = parseFloat(data.downloaded);
						var total_fm = parseFloat(data.total_size_fm);
						var download_fm = parseFloat(data.downloaded_fm);
						var speed = parseFloat(data.speed_download);
						var eta = parseFloat(data.time_eta);
						var eta_fm = parseFloat(data.time_eta_fm);
						var time_took = parseFloat(data.time_took);
						var time_took_fm = parseFloat(data.time_took_fm);
						var theSpeed;
						if(speed/1024/1024 > 1){
							theSpeed = Math.round(speed / 1024/1024) + ' Mbps';
						} else {
							theSpeed = Math.round(speed/ 1024 ) + ' Kbps';
						}
						self.perc_download = Math.round(download/total*100);
						if(isNaN(download_fm)){
							$('#remoteDownloadStatus').show();
							$('#prog_bar').html('Loading');
							$('#dspeed').html('Loading');
							$('#eta').html('Loading');
							$('#status').html('Loading');
						} else {
							$('#remoteDownloadStatus').show();
							//$('#prog_bar').width(this.perc_download+'%');
							$('#prog_bar').html(self.perc_download+'%').animate({width:self.perc_download+'%'},1000);
							$('#dspeed').html(theSpeed);
							$('#eta').html(eta_fm);
							$('#status').html(download_fm+' of '+total_fm);
						}
					}
					var intval = self.status_refesh*1000;
					if(self.perc_download > 99){
						self.force_stop = true;
					}
					if(!self.force_stop){
						setTimeout(function(){
							self.status_update()
						},intval);
					} else if(self.perc_download==100 && total>1){
						$('#time_took').html('Time Took : '+ time_took_fm);
					}
				}
			});
		};

		this.upload_file = function(Val,file_name){
			var page ='/actions/file_downloader.php';
			$.post(page, {
					file_url : Val,
					file_name : file_name
				},
				function(data){
					if(!data){
						alert('No data');
					} else {
						submit_upload_form();
					}
				},'text');
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

		/**
		 * functio used to get photos through ajax
		 */
		this.getAjaxPhoto = function(type,div){
			var self = this;
			$(div).css('display','block');
			var preservedHTML = $(div).html();
			$.ajax({
				url : self.page,
				type : 'POST',
				dataType : 'json',
				data : ({ mode : 'loadAjaxPhotos', 'photosType' : type }),
				beforeSend : function ()
				{
					$(div).html(this.loading);
				},
				success : function (data)
				{
					if(data['failed']) {
						$(div).html(preservedHTML);
					}

					if(data['completed']) {
						$(div).html(data['photoBlocks']);
					}
				}
			});
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
					$.post(page,
						{
							mode : 'add_playlist',
							id : vid,
							objtype : objtype,
							pid : $('#playlist_id option:selected').val()
						},
						function(data)
						{
							if(!data){
								alert('No data');
							} else {
								if(data.err !== '') {
									$('#playlist_form_result').css('display','block').html(data.err);
								}

								if(data.msg !== '') {
									$('#playlist_form_result').css('display','block').html(data.msg);
									$('#'+form_id).css('display','none');
								}
							}
						},'json');
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

		this.get_item = function(obj,ci_id,cid,type,direction){
			var btn_text = $(obj).html();
			$(obj).html(this.loading);

			$.post(page,
				{
					mode : 'get_item',
					ci_id: ci_id,
					cid : cid,
					type: type,
					direction: direction
				},
				function(data)
				{
					if(!data)
					{
						alert('No '+type+' returned');
						$(obj).text(btn_text);
					} else {
						var jsArray = new Array(type,data['cid'],data['key']);
						construct_url(jsArray);
						$('#collectionItemView').html(data['content']);
					}
				},'json')
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
					mode: 'moreItems',
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

		this.getDetails = function(obj){
			var forms = getInputs(obj), ParamArray = new Array(forms.length);

			$.each(forms,function(index,form) {
				query = $('#'+form.id+' *').serialize();
				query += '&mode=ajaxPhotos';
				ParamArray[index] = query;
			})

			return ParamArray;
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

		this.loadObject = function(currentDOM,type,objID,container){
			var self = this;
			var object = new Array(4);
			object['this'] = currentDOM, object['type'] = type,
				object['objID'] = objID, object['container'] = container;

			var obj = $(object['this']);

			{
				obj.parent().css('position','relative');

				$.ajax({
					url : self.page,
					type : 'POST',
					dataType : 'json',
					data  : ({ mode : 'channelFeatured',
						contentType : object['type'],
						objID : object['objID']
					}),
					beforeSend : function()
					{
						obj.find('img').animate({ opacity : .5 });
						$('#'+object['container']).animate({ opacity : .5 });
					},
					success : function(data)
					{
						if(data['error']) {
							obj.find('img').animate({ opacity : 1 });
							$('#'+object['container']).animate({ opacity : 1 });
							alert(data['error']);
						} else {
							obj.parent().children('.selected').removeClass('selected');
							obj.addClass('selected');
							obj.find('img').animate({ opacity : 1 });
							$('#'+object['container']).html(data['data']).animate({ opacity : 1 });
						}
					}
				})
			}
		};

		var comments_voting = 'no';
		this.getComments = function(type,type_id,last_update,pageNum,total,object_type,admin){
			var self = this;
			$('#comments').html("<div style='padding:5px 0;'>"+this.loading+'</div>');
			$.ajax({
				type: 'POST',
				url: self.page,
				data:  {mode:'getComments',
					page:pageNum,type:type,
					type_id:type_id,
					object_type : object_type,
					last_update : last_update,
					total_comments : total,
					comments_voting : comments_voting,admin : admin},
				success: function(data)
				{
					$('#comments').hide().html(data).fadeIn('slow');
				},
				dataType: 'text'
			});
		};

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
			var page = '/ajax.php';
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

		this.getCommentsNew = function(type,type_id,last_update,pageNum,total,object_type,admin){
			$.ajax({
				type: 'POST',
				url: page,
				data: {
					mode:'getCommentsNew',
					page:pageNum,
					type:type,
					type_id:type_id,
					object_type : object_type,
					last_update : last_update,
					total_comments : total,
					comments_voting : comments_voting,
					admin : admin
				},
				beforeSend: function() {
					$(document).find('#load-more-comments').text(lang_loading);
				},
				success: function(comments){
					if (comments === 'none') {
						$('#load-more-comments').text('End of comments list').attr('disabled','disabled');
					} else {
						$('#userCommentsList').append(comments);
						$(document).find('#load-more-comments').text(lang_load_more);
					}
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

		this.throwHeadMsg = function(tclass, msg, hideAfter,scroll) {
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

		/**
		 * New improved version of ClipBucket rating system
		 * @since: 8th, April 2016 ClipBucket 2.8.1
		 * @author: Saqib Razzaq
		 */

		this.rateNew = function (id,rating,type) {
			curObj = this;
			var page = '/ajax.php';
			$.post(page, {
					mode : 'rating',
					id:id,
					rating:rating,
					type:type
				},
				function(data)
				{
					if(!data) {
						alert('No data');
					} else {
						likesSect = $('.likes').find('span:nth-child(2)').html();
						dislikesSect = $('.dislikes').find('span:nth-child(2)').html();
						currLikes = parseInt(likesSect);
						currDislikes = parseInt(dislikesSect);

						isError = $(data).find('span.error').html();
						isOk = $(data).find('span.msg').html();
						if (isError) {
							if (isError.length > 2) {
								curObj.throwHeadMsg('danger',isError, 5000, true);
							}
						} else if (isOk) {
							if (isOk.length > 2) {
								if (rating == 5) {
									newRating = currLikes + 1;
									$('.likes').addClass('rated').find('span:nth-child(2)').html(newRating);
								} else {
									newRating = currDislikes + 1;
									if (newRating < 0) {
										newRating = 0;
									}
									$('.dislikes').addClass('rated').find('span:nth-child(2)').html(newRating);
								}
								curObj.throwHeadMsg('success',isOk, 5000, true);
							}
						}
					}
				},'text');
		}

		this.showMeTheMsg = function(data, alertDiv) {
			curObj = this;
			if (alertDiv == true) {
				isOk = $(data).filter('div.msg').find('div.alert').html();
			} else {
				isOk = $(data).filter('div.msg').html();
			}
			isError = $(data).filter('div.error').html();

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

			$.post(page,
				{
					mode : 'add_friend',
					uid : uid
				}
				,function(data)
				{
					if(!data){
						alert('No data');
					} else {
						$('#'+result_cont).css('display','none');
						curObj.showMeTheMsg(data);
					}
				}
				,'text'
			);
		};

		this.add_to_favNew = function(type,id){
			var curObj = this;
			$('#video_action_result_cont').css('display','block').html(curObj.loading);

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
						$('#video_action_result_cont').hide();
						curObj.showMeTheMsg(data, true);
					}
				},'text');
		};

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

		this.uploadSubtitle = function(videoid, lang, honeyAjax) {
			if (honeyAjax.length < 5) {
				return false;
			}

			//return true;
			var file_data = $('#captions').prop('files')[0];
			var form_data = new FormData();
			form_data.append('subtitle_lang',lang);
			form_data.append('file', file_data);
			form_data.append('videoid', videoid);
			$.ajax({
				type:'post',
				cache: false,
				contentType: false,
				processData: false,
				url: honeyAjax,
				data: form_data,

				beforeSend: function() {},
				success: function(data) {}
			});
		}

		this.addToPlaylist = function (vid,form_id,objtype){
			curObj = this;
			$('#playlist_form_result').html(loading).show();
			$.post(page,
				{
					mode : 'add_playlist',
					id : vid,
					objtype : objtype,
					pid : $('#playlist_id option:selected').val()
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						if(data.err.length > 2) {
							cleanedHtml = $.parseHTML(data.err);
							var msg = $(cleanedHtml).html();
							curObj.throwHeadMsg('danger',msg, 5000, true);
						}

						if(data.msg.length > 2) {
							cleanedHtml = $.parseHTML(data.msg);
							var msg = $(cleanedHtml).find('div.alert').html();
							curObj.throwHeadMsg('success',msg, 5000, true);
							$('#addPlaylistCont').toggle();
						}
					}
					$('#playlist_form_result').hide();
				},'json'
			);
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
							$('#'+form_id)[0].reset();
							$('#addPlaylistCont').toggle();
							$('#add_playlist_form').css('display','block');
							$('#new_playlist_form').css('display','none')
						}
					}
					$('#playlist_form_result').hide();
				},'json'
			);
		};

		this.getModalVideo = function(video_id){
			$.ajax({
				type: 'post',
				url: '/ajax/commonAjax.php',
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
			$.post(page,
				{
					mode : 'get_subscribers_count',
					userid : userid
				},
				function(data)
				{
					if(!data){
						alert('No data');
					} else {
						subsObj = JSON.parse(data);
						$('#user_subscribers_'+userid).html(subsObj.subscriber_count);
					}
				},'text');
		};
	};

	window._cb = new _cb();
	window._cb.setRemoteId();

})(window);