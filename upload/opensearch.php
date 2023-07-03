<?php
require 'includes/config.inc.php';
header("Content-type: text/xml; charset=utf-8");
?>
<? xml version = "1.0" encoding = "utf-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
    <ShortName><?php echo TITLE; ?></ShortName>
    <Description><?php echo $row['description']; ?></Description>
    <Url type="text/html" method="get" template="<?php echo cblink(['name' => 'search_result']); ?>?query={searchTerms}"/>
    <Image width="16" height="16">/favicon.ico</Image>
    <InputEncoding>UTF-8</InputEncoding>
    <SearchForm><?php echo BASEURL; ?></SearchForm>
</OpenSearchDescription>