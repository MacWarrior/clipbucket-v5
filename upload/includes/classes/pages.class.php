<?php

class pages
{
    var $url_page_var = 'page';
    var $pre_link = '';
    var $next_link = '';
    var $first_link = '';
    var $last_link = '';
    var $pagination = '';

    public static function getInstance()
    {
        global $pages;
        return $pages;
    }

    function GetServerUrl(): string
    {
        $serverName = null;
        if (isset($_SERVER['SERVER_NAME'])) {
            $serverName = $_SERVER['SERVER_NAME'];
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $serverName = $_SERVER['HTTP_HOST'];
        } elseif (isset($_SERVER['SERVER_ADDR'])) {
            $serverName = $_SERVER['SERVER_ADDR'];
        } else {
            $serverName = 'localhost';
        }

        $serverProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
        $serverPort = null;
        if (isset($_SERVER['SERVER_PORT']) && !strpos($serverName, ':') &&
            (($serverProtocol == 'http' && $_SERVER['SERVER_PORT'] != 80) ||
                ($serverProtocol == 'https' && $_SERVER['SERVER_PORT'] != 443))) {
            $serverPort = $_SERVER['SERVER_PORT'];
            $serverPort = ":" . $serverPort;
        }

        return $serverProtocol . '://' . $serverName . $serverPort;
    }

    function GetCurrentUrl(): string
    {
        global $in_bg_cron;
        if (!$in_bg_cron) {
            $serverURL = $this->GetServerUrl();
            $requestURL = $_SERVER['REQUEST_URI'];

            return $serverURL . $requestURL;
        }
        return '';
    }

    //This Function Set The PageDirect
    function page_redir()
    {
        set_cookie_secure('pageredir', display_clean($this->GetCurrentUrl()), time() + 7200);
        Assign('pageredir', @$_COOKIE['pageredir']);
    }

    //Redirects page to without www.
    function redirectOrig()
    {
        $curpage = $this->GetCurrentUrl();
        $newPage = preg_replace('/:\/\/www\./', '://', $curpage);
        if ($curpage != $newPage) {
            header("location:$newPage");
        }
    }

    /**
     * Function used to create link
     *
     * @param        $page
     * @param null $link
     * @param null $extra_params
     * @param string $tag
     * @param bool $return_param
     *
     * @return string|string[]|null
     */
    function create_link($page, $link = null, $extra_params = null, $tag = ' <a #params#>#page#</a> ', $return_param = false)
    {
        if (($link == null || $link == 'auto') && $_SERVER['QUERY_STRING']) {
            $link = '?' . $_SERVER['QUERY_STRING'];
        }

        $page_pattern = '#page#';
        $param_pattern = '#params#';
        $page_url_param = $this->url_page_var;
        $page_link_pattern = $page_url_param . '=' . $page_pattern;
        $link = preg_replace(['/(\?page=[0-9]+)/', '/(&page=[0-9]+)/', '/(page=[0-9+])+/'], '', $link);

        preg_match('/\?/', $link, $matches);

        if (!empty($matches[0])) {
            $page_link = '&' . $page_link_pattern;
        } else {
            $page_link = '?' . $page_link_pattern;
        }

        //Now checking if url is using & and ? then do not apply PAGE using slash instead use & or ?
        $current_url = $_SERVER['REQUEST_URI'];

        $has_amp = $has_php = $has_q = false;
        preg_match('/\?/', $current_url, $cur_matches);
        if (count($cur_matches)) {
            $has_q = true;
        }
        preg_match('/\.php/', $current_url, $cur_matches);
        if (count($cur_matches)) {
            $has_php = true;
        }
        preg_match('/&/', $current_url, $cur_matches);
        if (count($cur_matches)) {
            $has_amp = true;
        }

        if (strpos($link,'javascript:') !== 0 ) {
            $link = $link . $page_link;
        }
        $params = 'href="' . $link . '"';
        $params .= ' ' . $extra_params;

        if ($has_php && ($has_amp || $has_q)) {
            $use_seo = false;
        } else {
            $use_seo = true;
        }

        if (SEO == 'yes' && THIS_PAGE != 'search_result' && !BACK_END && $use_seo && count($_GET) != 0 && (count($_GET) != 3 || !isset($_GET['page']))) {
            $params = 'href="./' . $page . '"';
        }

        $final_link = preg_replace(["/$page_pattern/i", "/$param_pattern/i"], [$page, $params], $tag);
        $final_link = preg_replace(["/$page_pattern/i", "/$param_pattern/i"], [$page, $params], $final_link);

        if ($return_param) {
            return preg_replace("/$page_pattern/i", $page, $params);
        }

        return ' ' . $final_link . ' ';
    }

    /**
     * Function used to create pagination
     *
     * @param        $total
     * @param        $page
     * @param null $link
     * @param null $extra_params
     * @param string $tag
     *
     * @return string
     */
    function pagination($total, $page, $link = null, $extra_params = null, $tag = '<a #params#>#page#</a>')
    {
        if ($total == 0) {
            return false;
        }

        if ($page <= 0 || $page == '' || !is_numeric($page)) {
            $page = 1;
        }
        $total_pages = $total;
        $pagination_start = 14;
        $display_page = 5;
        $this->selected = $selected = $page;
        $hellip = '<li><a>&hellip;</a></li>';
        $first_hellip = '';
        $second_hellip = '';

        $start = '';
        $mid = '';
        $end = '';

        $start_last = '';
        $end_first = '';

        $mid_first = '';
        $mid_last = '';

        $differ = round(($display_page / 2) + .49, 0) - 1;

        if ($pagination_start < $total_pages) {
            //Starting First
            for ($i = 1; $i <= $display_page; $i++) {
                if ($selected == $i) {
                    $start .= ' <li class="active"><a href="#">' . $i . '</a></li> ';
                } else {
                    $start .= $this->create_link($i, $link, $extra_params, $tag);
                }
                $start_last = $i;
            }

            //Starting Last
            for ($i = $total_pages - $display_page + 1; $i <= $total_pages; $i++) {
                if ($end_first == '') {
                    $end_first = $i;
                }

                if ($selected == $i) {
                    $end .= ' <li class="active"><a href="#">' . $i . '</a></li> ';
                } else {
                    $end .= $this->create_link($i, $link, $extra_params, $tag);
                }
            }

            //Starting mid
            for ($i = $selected - $differ; $i <= $selected + $differ; $i++) {
                if ($mid_first == '') {
                    $mid_first = $i;
                }

                if ($i > $start_last && $i < $end_first) {
                    if ($selected == $i) {
                        $mid .= ' <li class="active"><a href="#">' . $i . '</a></li> ';
                    } else {
                        $mid .= $this->create_link($i, $link, $extra_params, $tag);
                    }
                }

                $mid_last = $i;
            }


            if ($start_last < $mid_first) {
                $first_hellip = $hellip;
            }
            if ($end_first > $mid_last) {
                $second_hellip = $hellip;
            }

            //Previous Page
            if ($selected - 1 > 1) {
                $this->pre_link = $this->create_link($selected - 1, $link, $extra_params, $tag, true);
            }
            //Next Page
            if ($selected + 1 < $total) {
                $this->next_link = $this->create_link($selected + 1, $link, $extra_params, $tag, true);
            }
            //First Page
            if ($selected != 1) {
                $this->first_link = $this->create_link(1, $link, $extra_params, $tag, true);
            }
            //First Page
            if ($selected != $total) {
                $this->last_link = $this->create_link($total, $link, $extra_params, $tag, true);
            }

            return $start . $first_hellip . $mid . $second_hellip . $end;
        } else {
            $pagination_smart = '';
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $selected) {
                    $pagination_smart .= '<li class="active"><a href="#">' . $i . '</a></li>';
                } else {
                    $pagination_smart .= $this->create_link($i, $link, $extra_params, $tag);
                }
            }

            //Previous Page
            if ($selected - 1 > 1) {
                $this->pre_link = $this->create_link($selected - 1, $link, $extra_params, $tag, true);
            }
            //Next Page
            if ($selected + 1 < $total) {
                $this->next_link = $this->create_link($selected + 1, $link, $extra_params, $tag, true);
            }
            //First Page
            if ($selected != 1) {
                $this->first_link = $this->create_link(1, $link, $extra_params, $tag, true);
            }
            //First Page
            if ($selected != $total) {
                $this->last_link = $this->create_link($total, $link, $extra_params, $tag, true);
            }

            return $pagination_smart;
        }
    }


    /**
     * Function used to create pagination and assign values that can bee used in template
     *
     * @param        $total
     * @param        $page
     * @param null $link
     * @param null $extra_params
     * @param string $tag
     */
    function paginate($total, $page, $link = null, $extra_params = null, $tag = '<li><a #params#>#page#</a></li>')
    {
        // One page pagination is useless
        if ($total > 1) {
            $this->pagination = $this->pagination($total, $page, $link, $extra_params, $tag);

            //Assigning Variable that can be used in templates
            assign('pagination', $this->pagination);

            assign('next_link', $this->next_link);
            assign('pre_link', $this->pre_link);

            assign('next_page', $page + 1);
            assign('pre_page', $page - 1);

            assign('first_link', $this->first_link);
            assign('last_link', $this->last_link);
        }
    }

}
