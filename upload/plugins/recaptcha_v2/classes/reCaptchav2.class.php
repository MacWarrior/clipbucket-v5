<?php
class reCaptchav2
{
	function __construct(){}

	function update_recaptcha_confs($param)
	{
		global $db;
		
		$sitekey   = $param['recaptcha_v2_site_key'];
		$secretkey = $param['recaptcha_v2_secret_key'];

		if($sitekey==NULL || empty($sitekey)){
			throw new Exception("Please add recapcha's site key!");
		} else if($sitekey==NULL || empty($sitekey)) {
			throw new Exception("Please add recapcha's secret key!");
		} else {
			$sitekey = mysql_clean($sitekey);
			$secretkey = mysql_clean($secretkey);

			$db->update(tbl('config'),array('value'),array($sitekey)," name='recaptcha_v2_site_key'");
			$db->update(tbl('config'),array('value'),array($secretkey)," name='recaptcha_v2_secret_key'");

			$response="reCaptchav2 configurations Updated!";
		}
		return $response;
	}

	function get_recaptcha_confs()
	{
		global $Cbucket;

		$rec_config = $Cbucket->configs;
		if(!empty($rec_config)){
			return $rec_config;
		}
		throw new Exception("There was an error getting reCaptchav2 configs!");
	}

}
