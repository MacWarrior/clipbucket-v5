<?php
/**
 * Register a clipbucket function
 *
 * @param String $func_name
 * @param String $place
 * @param Array $extra_params
 * @param Array $scope
 */
function cb_register_action($func_name, $place, $extra_params = [], $scope = ['global']): void
{
    if (isset(ClipBucket::getInstance()->actions_list)) {
        $actions_list = ClipBucket::getInstance()->actions_list;
        $actions_list[$place][] = [
            'action' => $func_name,
            'params' => $extra_params,
            'scope'  => $scope
        ];

        ClipBucket::getInstance()->actions_list = $actions_list;
    }
}

/**
 * Call a register function and returns output if available.
 *
 * @param String $place
 * @param Array $params
 * @param Array $scope
 *
 * @return mixed
 */
function cb_do_action($place, $params = [], $scope = ['global'])
{

    $actions = cb_get_actions($place, $scope);

    if ($actions) {
        foreach ($actions as $action) {
            if (isset($output)) {
                unset($output);
            }

            if (function_exists($action['action'])) {
                if ($params && $action['params']) {
                    $params = array_merge($params, $action['params']);
                } elseif ($action['params']) {
                    $params = $action['params'];
                }

                if ($params) {
                    $output = $action['action']($params);
                } else {
                    $output = $action['action']();
                }
            }
            if (isset($output) && $output) {
                return $output;
            }
        }
    }

}

/**
 * get list of functions available for specific place under defined scope (default:global)
 *
 * @param String $place
 * @param Array $scope
 *
 * @return mixed|void
 */
function cb_get_actions($place, $scope = ['global'])
{
    if (isset(ClipBucket::getInstance()->actions_list) && isset(ClipBucket::getInstance()->actions_list[$place])) {
        return ClipBucket::getInstance()->actions_list[$place];
    }
}