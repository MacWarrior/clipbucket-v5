<?php
define('THIS_PAGE', 'updateVideoViews');
require_once("../includes/config.inc.php");

global $db;

$query = "SELECT * FROM " . tbl("video_views") . " ORDER BY last_updated DESC LIMIT 100";
$result = $db->execute($query);
while ($row = $result->fetch_assoc()) {
    $query = "update " . tbl("video") . " set views = {$row['video_views']} where videoid = {$row['video_id']}";
    $db->execute($query);
}