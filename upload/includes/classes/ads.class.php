<?php

class AdsManager
{
    /**
     * Function used to add new advertisment in ClipBucket
     *
     * @param : Array
     *
     * @return null
     * @throws Exception
     */
    function AddAd($array = null)
    {
        if (!$array) {
            $array = $_POST;
        }

        $name = mysql_clean($array['name']);
        $code = mysql_clean($array['code']);
        $placement = mysql_clean($array['placement']);
        $status = mysql_clean($array['status']);

        if (empty($name)) {
            return e(lang('ad_name_error'));
        }

        $count = Clipbucket_db::getInstance()->count(tbl('ads_data'), 'ad_id', ' ad_name=\'$name\'');

        if ($count > 0) {
            return e(lang('ad_exists_error2'));
        }
        Clipbucket_db::getInstance()->insert(tbl('ads_data'), ['ad_name', 'ad_placement', 'ad_code', 'ad_status', 'date_added'], [$name, $placement, $code, $status, now()]);
        return e(lang('ad_add_msg'), 'm');
    }

    /**
     * Function used to set advertisment status
     * 1, to set as activate
     * 0, to set as deactivate
     *
     * @param $status
     * @param $id
     * @throws Exception
     */
    function ChangeAdStatus($status, $id)
    {
        if ($status > 1) {
            $status = 1;
        }
        if ($status < 0) {
            $status = 0;
        }

        if ($this->ad_exists($id)) {
            Clipbucket_db::getInstance()->update(tbl("ads_data"), ["ad_status"], [$status], " ad_id='" . mysql_clean($id) . "'");
            if ($status == '0') {
                $show_status = lang('ad_deactive');
            } else {
                $show_status = lang('ad_active');
            }
            e(lang('ad_msg') . $show_status, "m");
        } else {
            e(lang("ad_exists_error1"));
        }
    }

    /**
     * Function used to edit advertisment
     *
     * @params Array
     * @param null $array
     * @throws Exception
     */
    function EditAd($array = null)
    {
        if (!$array) {
            $array = $_POST;
        }

        $placement = mysql_clean($array['placement']);
        $name = mysql_clean($array['name']);
        $code = mysql_clean($array['code']);
        $id = mysql_clean($array['ad_id']);
        $status = mysql_clean($array['status']);

        if (!$this->ad_exists($id)) {
            e(lang("ad_exists_error1"));
        } elseif (empty($name)) {
            e(lang('ad_name_error'));
        } else {
            Clipbucket_db::getInstance()->update(tbl("ads_data"), ["ad_placement", "ad_name", "ad_code", "ad_status"], [$placement, $name, "|no_mc|" . $code, $status, $id], " ad_id='$id' ");
            e(lang('ad_update_msg'), "m");
        }
    }

    /**
     * Function used to delete advertisements
     * @param integer Id
     * @throws Exception
     */
    function DeleteAd($id)
    {
        if (!$this->ad_exists($id)) {
            e(lang('ad_exists_error1'));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('ads_data') . ' WHERE ad_id=\'' . $id . '\'');
            $msg = e(lang('ad_del_msg'), 'm');
        }
    }

    /**
     * Function used to remove advertismetn placement
     *
     * @param $placement
     * @throws Exception
     */
    function RemovePlacement($placement)
    {
        if (!$this->get_placement($placement)) {
            e(lang("ad_placement_err4"));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('ads_data') . ' WHERE ad_placement=\'' . $placement . '\'');
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('ads_placements') . ' WHERE placement=\'' . $placement . '\'');
            e(lang('ad_placment_delete_msg'), 'm');
        }
    }

    /**
     * Function used to add new palcement
     * @param array
     * Array [0] => placement name
     * Array [1] => placement code
     * @throws Exception
     */
    function AddPlacement($array)
    {
        if (empty($array[0])) {
            $msg = e(lang('ad_placement_err2'));
        } elseif (empty($array[1])) {
            $msg = e(lang('ad_placement_err3'));
        }

        if (empty($msg)) {
            if ($this->get_placement($array[1])) {
                e(lang('ad_placement_err1'));
            } else {
                Clipbucket_db::getInstance()->insert(tbl("ads_placements"), ["placement_name", "placement"], [$array[0], $array[1]]);
                e(lang('ad_placement_msg'), "m");
            }
        }
    }

    /**
     * FUNCTION USED TO GET ADVERTISMENT FROM DATABSE WITH LOWEST IMPRESSION
     *
     * @param : string placement_code
     * @param int $limit
     *
     * @return string
     * @throws Exception
     */
    function getAd($placement_code, $limit = 1)
    {
        global $ads_array;
        if ($limit == 1) {
            //Creating Query, Not to select duplicate Ads
            foreach ($ads_array as $ad_id) {
                if (is_numeric($ad_id)) {
                    $query_param .= " AND ad_id <> '" . $ad_id . "' ";
                }
            }
            $limit_query = ' LIMIT 1';
            $order = ' ORDER BY ad_impressions ASC ';
            //Return Ad
            $query = "SELECT ad_id,ad_code FROM " . tbl("ads_data") . " 
			WHERE ad_placement = '" . $placement_code . "'
			AND ad_status='1'";

            $code_array = Clipbucket_db::getInstance()->GetRow($query . $query_param . $order . $limit_query);

            //Checking If there is no code, then try to get duplicate ad
            if (empty($code_array['ad_id'])) {
                $code_array = Clipbucket_db::getInstance()->GetRow($query . $order . $limit_query);
            }

            $ads_array[] = $code_array['ad_id'];

            //Incrementing Ad Impression
            $this->incrementImpression($code_array['ad_id']);
            return stripslashes($code_array['ad_code']);
        }
    }

    /**
     * FUNCTION USED TO INCREASE AD IMPRESSIONGS
     * @param integer
     * @throws Exception
     */
    function incrementImpression($ad_id)
    {
        $query = "UPDATE " . tbl("ads_data") . " SET ad_impressions = ad_impressions+1 WHERE ad_id='" . $ad_id . "'";
        Clipbucket_db::getInstance()->execute($query);
    }

    /**
     * Function usd to get all placements
     * @throws Exception
     */
    function get_placements()
    {
        $result = Clipbucket_db::getInstance()->select(tbl("ads_placements"));
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get all advertisements
     * @throws Exception
     */
    function get_advertisements()
    {
        $result = Clipbucket_db::getInstance()->select(tbl("ads_data"));
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get placement
     *
     * @param $place
     *
     * @return bool
     * @throws Exception
     */
    function get_placement($place)
    {
        $result = Clipbucket_db::getInstance()->select(tbl("ads_placements"), "*", " placement='$place' OR placement_id='$place' ");
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * Function used to create placement name
     *
     * @param $place
     *
     * @return bool
     * @throws Exception
     */
    function get_placement_name($place)
    {
        $details = $this->get_placement($place);
        if ($details) {
            return $details['placement_name'];
        }
        return false;
    }

    /**
     * Function used to get advertisement
     *
     * @param $id
     *
     * @return array|bool
     * @throws Exception
     */
    function get_ad_details($id)
    {
        $result = Clipbucket_db::getInstance()->select(tbl("ads_data"), "*", " 	ad_placement='$id' OR ad_id='$id'");
        if (count($result) > 0) {
            $result = $result[0];
            $result['ad_code'] = stripslashes($result['ad_code']);
            return $result;
        }
        return false;
    }

    /**
     * Function used to check weather advertisment exists or not
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function ad_exists($id): bool
    {
        $count = Clipbucket_db::getInstance()->count(tbl("ads_data"), "ad_id", " ad_id='$id' ");
        if ($count > 0) {
            return true;
        }
        return false;
    }

    /**
     * Count ads in a placement
     *
     * @param $place
     *
     * @return bool
     * @throws Exception
     */
    function count_ads_in_placement($place)
    {
        return Clipbucket_db::getInstance()->count(tbl("ads_data"), "ad_id", " ad_placement='$place'");
    }

    /**
     * @reason : { this method used to convert ads_placement.xml content to php array}
     * @return mixed
     * @throws Exception
     * @author : Fahad Abbas
     * @date   : 24-Feb-2016
     */
    function get_placement_xml()
    {
        if (file_exists(DirPath::get('styles') . TEMPLATE . '/ads_placement.xml')) {
            $xml_file = DirPath::get('styles') . TEMPLATE . '/ads_placement.xml';
            $xml_content = file_get_contents($xml_file);
            $xmlSimpleElement = simplexml_load_string($xml_content) or die("Error: Cannot create object");
            $jsonArray = json_encode($xmlSimpleElement);
            $results = json_decode($jsonArray, true);

            return $results;
        } else {
            e(lang("no_ads_xml_found"), "e");
        }
    }
}
