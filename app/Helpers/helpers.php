<?php

if (!function_exists('convertToCamelCase')) {
    /**
     * Convert key name to camel case words.
     *
     * @param string $key
     * @return string
     */
    function convertAsLabel($key)
    {
        $words = explode('_', $key);
        $camelCaseWords = array_map('ucfirst', $words);

        return implode(' ', $camelCaseWords);
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $settings = cache('settings');
        return $settings->get($key, $default);
    }
}

if (!function_exists('formatedSize')) {
    function formatedSize($bytes, $precision = 1)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('active_link')) {
    function active_link($routeNames,$msg='active')
    {
        $routeNames = is_array($routeNames) ? $routeNames : [$routeNames];

        foreach ($routeNames as $routeName) {
            if (request()->routeIs($routeName . '*')) {
                return $msg;
            }
        }

        return '';
    }
}
