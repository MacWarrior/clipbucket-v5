<?php

class reCaptchav2
{
    function __construct()
    {
    }

    /**
     * @throws Exception
     */
    function update_recaptcha_confs($param)
    {
        $sitekey = $param['recaptcha_v2_site_key'];
        $secretkey = $param['recaptcha_v2_secret_key'];

        if ($sitekey == null || empty($sitekey)) {
            throw new \Exception("Please add recapcha's site key!");
        } else {
            if ($sitekey == null || empty($sitekey)) {
                throw new \Exception("Please add recapcha's secret key!");
            } else {
                $sitekey = mysql_clean($sitekey);
                $secretkey = mysql_clean($secretkey);

                Clipbucket_db::getInstance()->update(tbl('config'), ['value'], [$sitekey], " name='recaptcha_v2_site_key'");
                Clipbucket_db::getInstance()->update(tbl('config'), ['value'], [$secretkey], " name='recaptcha_v2_secret_key'");

                $response = "reCaptchav2 configurations Updated!";
            }
        }
        return $response;
    }

    /**
     * @throws Exception
     */
    function get_recaptcha_confs()
    {
        $rec_config = ClipBucket::getInstance()->configs;
        if (!empty($rec_config)) {
            return $rec_config;
        }
        throw new \Exception("There was an error getting reCaptchav2 configs!");
    }

}
