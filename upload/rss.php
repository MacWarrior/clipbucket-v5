<?php
/* 
 *****************************************************************
 | Copyright (c) 2007-2010 Clip-Bucket.com. All rights reserved.	
 | @ Author : ArslanHassan											
 | @ Software : ClipBucket , © PHPBucket.com						
 ******************************************************************
*/


define("THIS_PAGE",'rss');
require 'includes/config.inc.php';
header ("Content-type: text/xml; charset=utf-8");


$limit = 20;
$page = $_GET['page'];
if($page<1 || !is_numeric )
	$page = 1;

if($page)
{
	$from = ($page-1)*$limit;
	$limit = "$from,$limit";
}
	
$mode = $_GET['mode'];
switch($mode)
{
	case 'recent':
	default:
	{
		 $videos = get_videos(array('limit'=>$limit,'order'=>'date_added DESC'));
		 $title  = "Recently Added Videos";
	}
	break;
	
	case 'views':
	{
		
		 $videos = get_videos(array('limit'=>$limit,'order'=>'views DESC'));
		 $title = "Most Viewed Videos";
	}
	break;
	
	case 'rating':
	{
		 $videos = get_videos(array('limit'=>$limit,'order'=>'rating DESC'));
		 $title = "Top Rated Videos";
	}
	break;
	
	case 'watching':
	{
		 $videos = get_videos(array('limit'=>$limit,'order'=>'last_viewed DESC'));
		 $title = "Videos Being Watched";
	}
	break;
	case 'user':
	{
		 $user = mysql_clean($_GET['username']);
		 //Get userid from username
		 $uid = $userquery->get_user_field_only($user,'userid');
		 $uid = $uid ? $uid : 'x';
		 $videos = get_videos(array('limit'=>$limit,'user'=>$uid,'order'=>'date_added DESC'));
		 //Count Total Videos of this user
		 $total_vids = get_videos(array('count_only'=>true,'user'=>$uid));
		 $title = "Videos uploaded by ".$user;
	}
	
	break;
}

subtitle($title);
?>

<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
<title><?php echo cbtitle(); ?></title>
<link><?php echo BASEURL; ?></link>
    <image> 
        <url><?php echo website_logo(); ?></url>
        <link><?php echo BASEURL; ?></link>
        <title><?php echo cbtitle(); ?></title>
    </image>
    <description><?php echo $Cbucket->configs['description']; ?></description>
    <?php
	if($total_vids)
	{
	?>
    <total_videos><?php echo $total_vids; ?></total_videos>
    <?php
	}
	?>
    <?php
   
    foreach($videos as $video)
    {
    ?>
    <item>
        <author><?php echo $video['username']; ?></author>
        <title><?php echo substr($video['title'],0,500); ?></title>
        <link><?php echo video_link($video); ?></link>
        <description>
        <![CDATA[   
        <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="130" height="90" align="center" valign="middle"><img src="<?php echo get_thumb($video); ?>"  border="1"/></td>
        <td valign="top">
        <a href="<?php echo video_link($video); ?>"><?php echo $video['title']; ?></a><br />
        <?php echo $video['description']; ?>
        </td>
        <td width="100" valign="top" align="right">
        Rating <?php echo $video['rating']; ?>/10<br />
        Views <?php echo $video['views']; ?><br />
        Duration <?php echo SetTime($video['duration']); ?>

        </tr>
        </table>
         <hr size="1" noshade>
        ]]>           
        </description>
        <category><?php echo strip_tags(categories($video['category'],'video')); ?></category>
        <guid isPermaLink="true"><?php echo video_link($video); ?></guid>
        <pubDate><?php echo $video['date_added']; ?></pubDate>
        <media:player url="<?php echo video_link($video); ?>" />
        <media:thumbnail url="<?php echo get_thumb($video); ?>" width="120" height="90" />
        <![CDATA[<media:title><?php echo substr($video['title'],0,500); ?></media:title>
        <media:category label="Tags"><?php echo strip_tags(tags($video['tags'],'video')); ?></media:category>]]>
        <media:credit><?php echo $video['username']; ?></media:credit>
        <enclosure url="<?php echo video_link($video); ?>" type="application/x-shockwave-flash" />

    </item>
    <?php
    }
    ?>

</channel>
</rss>