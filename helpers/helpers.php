<?php

defined('MIX_MANIFEST_PATH') or define('MIX_MANIFEST_PATH', ROOT_PATH . '/public/assets/mix-manifest.json');

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'null':
            case '(null)':
                return null;

            case 'empty':
            case '(empty)':
                return '';
        }

        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}



function getDirContents($dir) {
    exec('find ' . $dir . ' -type f -print', $result);
    return $result;
}


//function for get assets url
/**
 * @param $key
 * @return mixed
 */
function getMixItem($key){
    $file = file_exists(MIX_MANIFEST_PATH) ? MIX_MANIFEST_PATH : 'http://localhost:8001/dist/mix-manifest.json';
    $content = file_get_contents($file);
    $mixItems = json_decode($content, true);
    return isset($mixItems[$key]) ? $mixItems[$key] : null;
}


function base_path($path) {
    return ROOT_PATH . '/' . $path;
}