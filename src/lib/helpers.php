<?php

/**
 * Get an item from an array using "dot" notation.
 * @param $array
 * @param $key
 * @param null $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
    if (is_null($key)) return $array;

    if (isset($array[$key])) return $array[$key];

    foreach (explode('.', $key) as $segment)
    {
        if ( ! is_array($array) || ! array_key_exists($segment, $array))
        {
            return value($default);
        }

        $array = $array[$segment];
    }
}

/**
 * @param $value
 * @return mixed
 */
function value($value)
{
    return $value instanceof \Closure ? $value() : $value;
}

/**
 * check and see if array key exists in array and is not empty. not for use with multidimensional arrays.
 * @param $array
 * @param $key
 * @return bool
 */
function array_found( $array, $key )
{
    return ( array_key_exists( $key, $array )
        && ( trim( (string) $array[$key] ) !== '' ) );
}

/**
 * Check if an item exists in an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @return bool
 */
function array_has($array, $key)
{
    if (empty($array) || is_null($key)) return false;

    if (array_key_exists($key, $array)) return true;

    foreach (explode('.', $key) as $segment)
    {
        if ( ! is_array($array) || ! array_key_exists($segment, $array))
        {
            return false;
        }

        $array = $array[$segment];
    }

    return true;
}

/**
 * Get a subset of the items from the given array.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return array
 */
function array_only($array, $keys)
{
    return array_intersect_key($array, array_flip((array) $keys));
}

/**
 * Get all of the given array except for a specified array of items.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return array
 */
function array_except($array, $keys)
{
    return array_diff_key($array, array_flip((array) $keys));
}