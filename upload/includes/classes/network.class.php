<?php
class Network{

    // Cloudflare IPv4 : https://www.cloudflare.com/ips-v4
    private static $cloudflare_ipv4 = [
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '103.31.4.0/22',
        '141.101.64.0/18',
        '108.162.192.0/18',
        '190.93.240.0/20',
        '188.114.96.0/20',
        '197.234.240.0/22',
        '198.41.128.0/17',
        '162.158.0.0/15',
        '104.16.0.0/13',
        '104.24.0.0/14',
        '172.64.0.0/13',
        '131.0.72.0/22'
    ];

    // Cloudflare IPv6 : https://www.cloudflare.com/ips-v6
    private static $cloudflare_ipv6 = [
        '2400:cb00::/32',
        '2606:4700::/32',
        '2803:f800::/32',
        '2405:b500::/32',
        '2405:8100::/32',
        '2a06:98c0::/29',
        '2c0f:f248::/32'
    ];

    private static function is_ipv4_in_range(string $ip, string $range): bool
    {
        if (strpos($range, '/') === false){
            $range .= '/32';
        }

        list($range, $netmask) = explode('/', $range, 2);

        $ip_bin_string = sprintf('%032b', ip2long($ip));
        $net_bin_string = sprintf('%032b', ip2long($range));
        return (substr_compare($ip_bin_string, $net_bin_string, 0, $netmask) === 0);
    }

    private static function is_ipv6_in_range(string $ip, string $range): bool
    {
        if (strpos($range, '/') === false){
            $range .= '/32';
        }

        list($range, $netmask) = explode('/', $range, 2);

        $subnet = inet_pton($range);
        $ip = inet_pton($ip);

        $binMask = str_repeat('f', $netmask / 4);
        switch ($netmask % 4) {
            case 0:
                break;
            case 1:
                $binMask .= '8';
                break;
            case 2:
                $binMask .= 'c';
                break;
            case 3:
                $binMask .= 'e';
                break;
        }
        $binMask = str_pad($binMask, 32, '0');
        $binMask = pack('H*', $binMask);

        return ($ip & $binMask) == $subnet;
    }

    private static function is_ip_cloudflare(string $ip): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            foreach (self::$cloudflare_ipv4 as $ipv4) {
                if (self::is_ipv4_in_range($ip, $ipv4)) {
                    return true;
                }
            }
        } else if (defined('AF_INET6') && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            foreach (self::$cloudflare_ipv6 as $ipv6) {
                if (self::is_ipv6_in_range($ip, $ipv6)) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function is_header_cloudflare(): bool
    {
        $header_list = ['HTTP_CF_CONNECTING_IP','HTTP_CF_IPCOUNTRY','HTTP_CF_RAY','HTTP_CF_VISITOR'];
        $flag = true;

        foreach($header_list as $header){
            if( !isset($_SERVER[$header]) ){
                $flag = false;
            }
        }

        return $flag;
    }

    public static function is_cloudflare(): bool
    {
        $check_ip = self::is_ip_cloudflare(self::get_ip_standard());
        $check_headers = self::is_header_cloudflare();
        return ($check_ip && $check_headers);
    }

    private static function get_ip_standard(): string
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? $_SERVER['HTTP_CLIENT_IP']
            ?? '';
    }

    public static function get_remote_ip(): string
    {
        if(self::is_cloudflare()) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? self::get_ip_standard();
        } else {
            $ip = self::get_ip_standard();
        }

        if( filter_var($ip, FILTER_VALIDATE_IP) ){
            return $ip;
        }

        if( in_dev() ){
            $msg = 'IP detection error : ' . $ip;
            error_log($msg);
            \DiscordLog::sendDump($msg);
        }
        return '';
    }

    public static function get_ip_infos(string $type)
    {
        $ip = self::get_remote_ip();
        if( empty($ip) ){
            return '';
        }

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://www.geoplugin.net/json.gp?ip=' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        if( empty($data) ){
            return '';
        }

        $data = json_decode($data, true);
        switch ($type) {
            case 'location':
                $continents = [
                    'AF' => 'Africa',
                    'AN' => 'Antarctica',
                    'AS' => 'Asia',
                    'EU' => 'Europe',
                    'OC' => 'Australia (Oceania)',
                    'NA' => 'North America',
                    'SA' => 'South America'
                ];

                return [
                    'city'           => $data['geoplugin_city'] ?? '',
                    'state'          => $data['geoplugin_regionName'],
                    'country'        => $data['geoplugin_countryName'],
                    'country_code'   => $data['geoplugin_countryCode'],
                    'continent'      => $continents[strtoupper($data['geoplugin_continentCode'])],
                    'continent_code' => $data['geoplugin_continentCode']
                ];

            case 'address':
                $address = [$data['geoplugin_countryName']];
                if (strlen($data['geoplugin_regionName']) >= 1) {
                    $address[] = $data['geoplugin_regionName'];
                }
                if (strlen($data['geoplugin_city']) >= 1) {
                    $address[] = $data['geoplugin_city'];
                }
                return implode(', ', array_reverse($address));

            case 'city':
                return $data['geoplugin_city'] ?? '';

            case 'state':
            case 'region':
                return $data['geoplugin_regionName'] ?? '';

            case 'country':
                return $data['geoplugin_countryName'] ?? '';

            case 'countrycode':
                return $data['geoplugin_countryCode'] ?? '';

            default:
                $msg = 'Wrong $type for Network::get_ip_infos : ' . $type;
                error_log($msg);
                if( in_dev() ){
                    \DiscordLog::sendDump($msg);
                }
        }

    }

    public static function is_current_url($needed): bool
    {
        return strpos($_SERVER['REQUEST_URI'], $needed) !== false;
    }

    /**
     * @param string $format
     * @param string $timeout
     * @return resource
     */

    public static function get_proxy_settings(string $format = '', string $timeout = '')
    {
        switch ($format) {
            default:
            case 'file_get_contents':
            case 'fopen':
                $context = null;
                if (function_exists('config') && config('proxy_enable') == 'yes') {
                    $context = [
                        'http' => [
                            'proxy'           => 'tcp://' . config('proxy_url') . ':' . config('proxy_port'),
                            'request_fulluri' => true
                        ]
                    ];

                    if (config('proxy_auth') == 'yes') {
                        $context['http']['header'] = 'Proxy-Authorization: Basic ' . base64_encode(config('proxy_username') . ':' . config('proxy_password'));
                    }
                }
                if (!empty($timeout)) {
                    $context['http']['timeout'] = (int)$timeout;
                }

                return stream_context_create($context);
        }
    }

    public static function download_file($url_source, $filepath_destination)
    {
        file_put_contents($filepath_destination . '_ongoing', '');

        $fp = fopen($filepath_destination,'w+');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_source);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if( config('proxy_enable') == 'yes' ){
            curl_setopt($ch, CURLOPT_PROXY, 'tcp://' . config('proxy_url') . ':' . config('proxy_port'));
            if (config('proxy_auth') == 'yes') {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, config('proxy_username') . ':' . config('proxy_password'));
            }
        }
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        unlink($filepath_destination . '_ongoing');
    }

    public static function get_server_url(): string
    {
        if( function_exists('config') && !empty(trim(config('base_url'))) && filter_var(config('base_url'), FILTER_VALIDATE_URL) ){
            return rtrim(config('base_url'), '/') . '/';
        }
        
        $port = '';
        if( !in_array($_SERVER['SERVER_PORT'], [80, 443]) ){
            $port = ':' . $_SERVER['SERVER_PORT'];
        }

        $subdir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        // Exclure cb_install s'il est dans le chemin
        if (preg_match('#/cb_install(/|$)#', $subdir)) {
            $subdir = preg_replace('#/cb_install(/|$)#', '/', $subdir);
        }

        if ($subdir === '/' || $subdir === '\\') {
            $subdir = '';
        }

        return rtrim(self::get_server_protocol() . $_SERVER['HTTP_HOST'] . $port . $subdir, '/') . '/';
    }

    private static function get_server_protocol(): string
    {
        if (self::is_ssl()) {
            return 'https://';
        }

        $protocol = preg_replace('/^([a-z]+)\/.*$/', '\\1', strtolower($_SERVER['SERVER_PROTOCOL']));
        $protocol .= '://';
        return $protocol;
    }

    private static function is_ssl(): bool
    {
        if (isset($_SERVER['HTTPS'])) {
            if ('on' == strtolower($_SERVER['HTTPS'])) {
                return true;
            }
            if ('1' == $_SERVER['HTTPS']) {
                return true;
            }
        }
        if (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            return true;
        }
        return false;
    }
}