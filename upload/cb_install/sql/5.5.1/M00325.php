<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00325 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE ' . tbl('email_template') . ' SET content = \'<!DOCTYPE html>\\r\\n<html>\\r\\n<body style=\\\"margin:0; padding:0; background-color:#EEEEEE; font-family:\\\'Open Sans\\\', sans-serif;\\\">\\r\\n  <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"border-collapse:collapse; min-width:320px; font-family:\\\'Open Sans\\\', sans-serif;\\\">\\r\\n    <tr>\\r\\n      <td style=\\\"padding:0; margin:0;\\\">\\r\\n\\r\\n        <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"#0080B4\\\" style=\\\"background-color:#0080B4;\\\">\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"padding-top:20px; padding-bottom:10px;\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"background-color:#FFFFFF; border-radius:10px;\\\">\\r\\n                <tr>\\r\\n                  <td align=\\\"center\\\" style=\\\"padding:5px;\\\">\\r\\n                    <a href=\\\"{{baseurl}}\\\">\\r\\n                      <img src=\\\"{{logo_url}}\\\" alt=\\\"{{website_title}}\\\" title=\\\"{{website_title}}\\\" style=\\\"border-radius:10px; display:block; max-width:100%; height:auto;\\\">\\r\\n                    </a>\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"color:white; font-size:22px; font-family:\\\'Open Sans\\\', sans-serif; padding-bottom:40px;\\\">\\r\\n              {{website_title}}\\r\\n            </td>\\r\\n          </tr>\\r\\n        </table>\\r\\n\\r\\n        <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" bgcolor=\\\"#EEEEEE\\\" style=\\\"background-color:#EEEEEE;\\\">\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:90%; max-width:90%; background-color:#FFFFFF; border-radius:10px; min-width:320px;\\\">\\r\\n                <tr>\\r\\n                  <td style=\\\"padding:20px; font-family:\\\'Open Sans\\\', sans-serif; font-size:13px; color:#000000; min-height:100px;\\\">\\r\\n                    {{email_content}}\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n\\r\\n          <tr>\\r\\n            <td align=\\\"center\\\" style=\\\"padding-bottom:20px;\\\">\\r\\n              <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"width:90%; max-width:90%; background-color:#0080B4; border-radius:10px; margin-top:20px; min-width:320px;\\\">\\r\\n                <tr>\\r\\n                  <td style=\\\"padding:10px;\\\">\\r\\n                    <table width=\\\"100%\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\">\\r\\n                      <tr>\\r\\n                        <td width=\\\"60\\\" align=\\\"left\\\" valign=\\\"middle\\\">\\r\\n                          <table cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" border=\\\"0\\\" style=\\\"background-color:#FFFFFF; border-radius:10px;\\\">\\r\\n                            <tr>\\r\\n                              <td align=\\\"center\\\" style=\\\"padding:0;\\\">\\r\\n                                <a href=\\\"{{baseurl}}\\\">\\r\\n                                  <img\\r\\n                                    src=\\\"{{favicon_url}}\\\"\\r\\n                                    alt=\\\"{{website_title}}\\\"\\r\\n                                    title=\\\"{{website_title}}\\\"\\r\\n                                    width=\\\"50\\\"\\r\\n                                    height=\\\"50\\\"\\r\\n                                    style=\\\"width:50px; height:50px; border-radius:10px; display:block;\\\">\\r\\n                                </a>\\r\\n                              </td>\\r\\n                            </tr>\\r\\n                          </table>\\r\\n                        </td>\\r\\n                        <td align=\\\"center\\\" valign=\\\"middle\\\" style=\\\"font-family:\\\'Open Sans\\\', sans-serif; font-size:14px; color:#FFFFFF;\\\">\\r\\n                          &copy;ClipBucketV5, maintained by <a href=\\\"https://oxygenz.fr\\\" style=\\\"color:#FFFFFF; text-decoration:none;\\\">Oxygenz</a>\\r\\n                        </td>\\r\\n                      </tr>\\r\\n                    </table>\\r\\n                  </td>\\r\\n                </tr>\\r\\n              </table>\\r\\n            </td>\\r\\n          </tr>\\r\\n\\r\\n        </table>\\r\\n\\r\\n      </td>\\r\\n    </tr>\\r\\n  </table>\\r\\n</body>\\r\\n</html>\\r\\n\' WHERE id_email_template = 1';
        self::query($sql);
    }
}
