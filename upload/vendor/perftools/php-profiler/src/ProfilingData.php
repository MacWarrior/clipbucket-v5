<?php

namespace Xhgui\Profiler;

/**
 * @internal
 */
final class ProfilingData
{
    /** @var array */
    private $excludeEnv;
    /** @var callable|null */
    private $simpleUrl;
    /** @var callable|null */
    private $replaceUrl;

    public function __construct(Config $config)
    {
        $this->excludeEnv = isset($config['profiler.exclude-env']) ? (array)$config['profiler.exclude-env'] : array();
        $this->simpleUrl = isset($config['profiler.simple_url']) ? $config['profiler.simple_url'] : null;
        $this->replaceUrl = isset($config['profiler.replace_url']) ? $config['profiler.replace_url'] : null;
    }

    /**
     * @return array
     */
    public function getProfilingData(array $profile)
    {
        $url = $this->getUrl();

        $requestTimeFloat = explode('.', sprintf('%.6F', $_SERVER['REQUEST_TIME_FLOAT']));
        $sec = $requestTimeFloat[0];
        $usec = isset($requestTimeFloat[1]) ? $requestTimeFloat[1] : 0;

        $allowedServerKeys = array(
            'DOCUMENT_ROOT',
            'HTTPS',
            'HTTP_HOST',
            'HTTP_USER_AGENT',
            'PATH_INFO',
            'PHP_AUTH_USER',
            'PHP_SELF',
            'QUERY_STRING',
            'REMOTE_ADDR',
            'REMOTE_USER',
            'REQUEST_METHOD',
            'REQUEST_TIME',
            'REQUEST_TIME_FLOAT',
            'SERVER_ADDR',
            'SERVER_NAME',
            'UNIQUE_ID',
        );

        $serverMeta = array_intersect_key($_SERVER, array_flip($allowedServerKeys));

        $meta = array(
            'url' => $url,
            'get' => $_GET,
            'env' => $this->getEnvironment($_ENV),
            'SERVER' => $serverMeta,
            'simple_url' => $this->getSimpleUrl($url),
            'request_ts_micro' => array('sec' => $sec, 'usec' => $usec),
            // these are superfluous and should be dropped in the future
            'request_ts' => array('sec' => $sec, 'usec' => 0),
            'request_date' => date('Y-m-d', $sec),
        );

        $data = array(
            'profile' => $profile,
            'meta' => $meta,
        );

        return $data;
    }

    /**
     * @param array $env
     * @return array
     */
    private function getEnvironment(array $env)
    {
        foreach ($this->excludeEnv as $key) {
            unset($env[$key]);
        }

        return $env;
    }

    /**
     * Creates a simplified URL given a standard URL.
     * Does the following transformations:
     *
     * - Remove numeric values after =.
     *
     * @param string $url
     * @return string
     */
    private function getSimpleUrl($url)
    {
        if (is_callable($this->simpleUrl)) {
            return call_user_func($this->simpleUrl, $url);
        }

        return preg_replace('/=\d+/', '', $url);
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        $url = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : null;
        if (!$url && isset($_SERVER['argv'])) {
            $cmd = basename($_SERVER['argv'][0]);
            $url = $cmd . ' ' . implode(' ', array_slice($_SERVER['argv'], 1));
        }

        if (is_callable($this->replaceUrl)) {
            $url = call_user_func($this->replaceUrl, $url);
        }

        return $url;
    }
}
