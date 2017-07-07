<?php
/* 
 *****************************************************************
 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.	
 | @ Author : tangi											
 | @ Software : ClipBucket , &#169; PHPBucket.com						
 ******************************************************************
*/
require 'includes/config.inc.php';
header("Content-Type: text/xml charset=utf-8");

$limit = 100;
$videos = get_videos(array('limit'=>$limit,'active'=>'yes','order'=>'date_added DESC'));

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<!-- by fjulio ( tangi @ clipbucket dev. ) -->
<?php
    foreach($videos as $video)
	{
?>
<url>
<loc><?php echo video_link($video); ?></loc>
<video:video>
<video:content_loc><?php echo get_video_file($video); ?></video:content_loc>
<video:player_loc allow_embed="yes"><?php echo BASEURL; ?>/player/old_players/embed_player.swf?file=<?php echo get_video_file($video); ?></video:player_loc>
<video:thumbnail_loc><?php echo get_thumb($video); ?></video:thumbnail_loc>
<video:title><![CDATA[<?php echo substr($video['title'],0,500); ?>]]></video:title>
<video:description><![CDATA[<?php echo substr($video['description'],0,300); ?>]]></video:description>
<video:rating><?php 
$vrating = $video['rating'] / 2;
$findcond = strpos($vrating,'.');
if ($findcond == "1"){
    $firstrating = str_replace(',','.',$vrating);
    echo $firstrating;
}
else { echo $vrating.'.0'; }
?></video:rating>
<video:view_count><?php echo $video['views']; ?></video:view_count>
<video:publication_date><?php
echo cbdate("Y-m-d\TH:i:s",strtotime($video['date_added'])).'+00:00';
?></video:publication_date>
<?php
$vtags = strip_tags(tags($video['tags'],'video'));
$vtableau = explode (",",$vtags);
for($i=0;$i<sizeof($vtableau);$i++)
    {
    echo '<video:tag><![CDATA['.trim($vtableau[$i]).']]></video:tag>';
    }
?>
<video:category><?php echo strip_tags(categories($video['category'],'video')); ?></video:category>
<video:family_friendly>yes</video:family_friendly>
<video:duration><?php
$defaultime = $video['duration'];
$dotfixed = explode (".",$defaultime);
echo $dotfixed[0].$dotfixed[1];
?></video:duration>
</video:video>
</url>
<?php
	}
?>
</urlset>