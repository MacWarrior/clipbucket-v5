<?php
/* 
**********************************************************
| Copyright (c) 20010 Clip-Bucket.com. All rights reserved.
| @ Author : Murat Esgin (lavinya http://www.videoizlepaylas.com )       
| @ Software : Video Media Sitemap for ClipBucket , © PHPBucket.com 
**********************************************************
*/
require 'includes/config.inc.php';
'<?xml version="1.0" encoding="utf-8"?>' . "\n";

header ("Content-type: text/xml; charset=utf-8");
?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
<ShortName><?php echo TITLE; ?></ShortName>
<Description><?php echo $row['description']; ?></Description>
<Url type="text/html" method="get" template="<?php echo cblink(array('name'=>'search_result')); ?>?query={searchTerms}"/>
<Image width="16" height="16"><?php echo BASEURL; ?>/favicon.ico</Image>
<InputEncoding>UTF-8</InputEncoding>
<SearchForm><?php echo BASEURL; ?></SearchForm>
</OpenSearchDescription>