var TimeComments = function(player,settings){
	var timecomments = this;
	timecomments.player = player;
	timecomments.settings = settings || {};
	timecomments.c_fired = false;
	timecomments.currentIndex = 0;
	timecomments.init();
}
TimeComments.prototype.DummyComments = function(){
	var comments =  [
						{"id":"1", "comment" : "This is first comment","time" : "2.25635"},
					 	{"id":"2", "comment" : "This is Second comment","time" : "6.12353"},
					 	{"id":"3", "comment" : "This is Third comment","time" : "9.25635"},
					 	{"id":"4", "comment" : "This is Fourth comment","time" : "12.25635"},
					 	{"id":"5", "comment" : "This is Fifth comment","time" : "15.25635"},
					 	{"id":"6", "comment" : "This is Sixth comment","time" : "18.25635"},
					]
	return comments;
}

TimeComments.prototype.init = function(){
	var timecomments = this;
	timecomments.comments = timecomments.DummyComments();
	timecomments.Structure();
	timecomments.BindComments();
}

TimeComments.prototype.Structure = function(){
	var timecomments = this;
	var CommentsParent = document.createElement('div');
	CommentsParent.className = "cb-vjs-comments-main";
	CommentsParent.id = "cb-vjs-comments";
	var errorDisplay = timecomments.player.getChild('errorDisplay').el_;
	timecomments.player.el_.insertBefore(CommentsParent, errorDisplay);

	var UnOrderedList = document.createElement('ul');
	UnOrderedList.id = "cb-vjs-comments-list-main";
	UnOrderedList.className = "cb-vjs-comments-list";
	
	CommentsParent.appendChild(UnOrderedList);
	
	var list_comm = "";
	var iteration = "";
	for (var i = 0; i < timecomments.comments.length ; i ++ ){
		iteration = i + 1;
		//console.log("iteration"+ iteration);
		list_comm = document.createElement("li");
		list_comm.id = timecomments.comments[i].time; 
		list_comm.className = "cb-vjs-comments-list";
		if ( iteration  == 5 ){
			list_comm.className = "cb-vjs-comments-list active";
		}
		UnOrderedList.appendChild(list_comm);
	}
}

TimeComments.prototype.BindComments = function(){
	var timecomments = this;
	timecomments.player.timecomments = timecomments;
	timecomments.player.on("timeupdate",timecomments.TriggerComment);
}

TimeComments.prototype.TriggerComment = function(){
	var player = this;
	player.timecomments.c_fired = false;
	var comments = player.timecomments.comments[player.timecomments.currentIndex];
	if (typeof comments != 'undefined'){
		var CurrentTime = player.currentTime();
		if (!player.timecomments.c_fired && CurrentTime >= comments.time && player.timecomments.currentIndex < player.timecomments.comments.length){
			//console.log(comments.comment);
			player.timecomments.c_fired = true;	
			player.timecomments.currentIndex++;
		}
	}else{
		//console.log("WTH :O no comments ? ");
	}
} 




var timecomments = function(settings){
	
	myTimeComments = new TimeComments(this,settings);
	
}
videojs.plugin('timecomments',timecomments);