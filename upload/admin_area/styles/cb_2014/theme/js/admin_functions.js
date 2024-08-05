//include('popup_image.js');
var page = '/actions/admin.php';

function admin_spam_comment(cid)
{
	$.post(page, {
		mode : 'spam_comment',
		cid : cid
	},
	function(data) {
		if(!data){
			alert('No data');
		} else {
			if(data.msg) {
				$('#comment_'+cid).css({'backgroundColor' : '#ffd7d7'});
				$('#spam_comment_'+cid).fadeOut(350, function() {
						$('#remove_spam_comment_'+cid).fadeIn(350);
				});
			}
			if(data.err) {
				alert(data.err);
			}
		}
	},'json');
}
	
function admin_remove_spam(cid)
{
	$.post(page, {
		mode : 'remove_spam',
		cid : cid
	},
	function(data) {
		if(!data){
			alert('No data');
		} else {
			if(data.msg) {
				$('#comment_'+cid).css({'backgroundColor' : '#f3f3f3'});
				$('#remove_spam_comment_'+cid).fadeOut(350, function() {
					$('#spam_comment_'+cid).fadeIn(350);
				});
			}
			if(data.err) {
				alert(data.err);
			}
		}
	},'json');
}
