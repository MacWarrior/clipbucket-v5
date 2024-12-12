$(document).ready(function() {
    $('body').keyup(function(e)
    {
        if( $(document.activeElement).is('body') ||
            $(document.activeElement).is('button.vjs-fullscreen-control') ||
            $(document.activeElement).is('div.vjs-volume-menu-button') ||
            $(document.activeElement).is('video') )
        {
            if( e.keyCode === 0 || e.keyCode === 32 )
                e.preventDefault();
        }
    });
});

// Header
function clipbucket_header(params)
{
    var CbVjsHeader = document.createElement("div");
    CbVjsHeader.id = "vjs-cb-header";
    CbVjsHeader.className = "vjs-cb-header-caption";
    CbVjsHeader.innerHTML = "<div class='captionBlock'><div class='vidTitle col'><a target='_blank' href='"+"/watch_video.php?v="+params.videoid+"'>"+params.videotitle+"</a></div><div class='uploaderName col'>"+ lang_by + ' ' +params.uploader+"</div></div>";

    var BigPlayButton =this.getChild('bigPlayButton').el_;
    this.el_.insertBefore(CbVjsHeader, BigPlayButton);
}
videojs.registerPlugin('clipbucket_header', clipbucket_header);

// Controlbar Logo
function clipbucket_controlbar_logo(params)
{
    var CbLogoBrand = document.createElement("div");
    CbLogoBrand.id = "vjs-cb-logo";
    CbLogoBrand.className = "vjs-cblogo-brand vjs-menu-button vjs-control vjs-button";
    CbLogoBrand.innerHTML = '<a href="'+params.product_link+'" target="_blank" style="background-image:url('+params.branding_logo+');"></a>';

    this.controlBar.el_.appendChild(CbLogoBrand);
}
videojs.registerPlugin('clipbucket_controlbar_logo', clipbucket_controlbar_logo);

// Volume
function clipbucket_volume()
{
    var Currvol = "";
    var Muted = "";
    var vol_cookie = $.cookie("cb_volume");

    if (vol_cookie){
        if (vol_cookie === "muted"){
            this.muted(true);
        } else {
            this.volume(vol_cookie);
        }
    }
    this.on('volumechange',function()
    {
        Currvol = this.volume();
        Muted = this.muted();

        if (Muted === true || Currvol === 0 ){
            set_cookie_secure("cb_volume","muted");
        } else {
            set_cookie_secure("cb_volume", Currvol);
        }
    });
}
videojs.registerPlugin('clipbucket_volume', clipbucket_volume);
