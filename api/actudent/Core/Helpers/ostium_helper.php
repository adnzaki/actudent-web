<?php

/**
 * OstiumCMS
 * A simple, fast and extensible Content Management System
 * for website made by Wolestech
 *
 * @copyright   Copyright (c) 2016-2017, Wolestech | Adnan Zaki
 * @license     MIT License | https://github.com/adnzaki/ostium_cms/blob/master/LICENSE
 * @author      Adnan Zaki
 * @link        https://wolestech.com
 */

/**
 * OstiumCMS Common Helpers
 *
 * @package		Application
 * @category	Helpers
 * @author		Adnan Zaki
 * @version     1.0
 * @link		https://github.com/adnzaki/ostium_cms/
 */

// ------------------------------------------------------------------------


if(! function_exists('multidimensional_array_unique'))
{
    /**
     * Multidimensional Array Unique
     * This function was taken from http://php.net/manual/en/function.array-unique.php
     * Thanks to Ghanshyam Katriya for creating this simple-but-cool function
     * It's used to get unique values of a multidimensional array
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    function multidimensional_array_unique($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val)
        {
            if (!in_array($val[$key], $key_array))
            {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }

        return $temp_array;
    }
}


if(! function_exists('in_assoc_array'))
{
    /**
     * In Assoc Array
     * This is a very simple function to check if a value exists in an associative array
     *
     * @param mixed $needle
     * @param array $array
     * @return bool
     */
    function in_assoc_array($needle, $array)
    {
        for($i = 0; $i < count($array); $i++)
        {
            if(in_array($needle, $array[$i]))
            {
                return TRUE;
            }
        }
    }
}

if(! function_exists('menu_active'))
{
    /**
     * A function to give a mark whether the menu item is current page or not
     *
     * @param string $uri
     * @param string $class (the CSS class you want to be added)
     * @param bool $exact if this set to false, it will use strpos() to match URI
     * 
     * @return string
     */
    function menu_active($uri, $class, $exact = true)
    {
        $request = new \CodeIgniter\HTTP\URI(current_url());
        if($exact)
        {
            if($request->getSegment($request->getTotalSegments()) !== $uri)
            {
                $class = '';
            }
        }
        else 
        {
            if(! strpos($_SERVER['PHP_SELF'], $uri))
            {
                $class = '';
            }
        }        

        return $class;
    }
}

if(! function_exists('reverse'))
{
    /**
     * Reverse words provided by user
     *
     * @param string $word
     * @param string $separator
     * @param string $newSeparator
     * 
     * @return string
     */
    function reverse($word, $separator, $newSeparator = '')
    {
        $explode = explode($separator, $word);
        $reverseWord = '';
        $lastIndex = count($explode) - 1;
        for($i = 0; $i < count($explode); $i++)
        {
            if(count($explode) === 1)
            {
                $reverseWord .= $explode[$i];
            }
            else
            {
                $i === 0 ? $j = $lastIndex : $j = $lastIndex - $i;
                $reverseWord .= $explode[$j] . $newSeparator;
            }
        }

        return substr($reverseWord, 0, strlen($reverseWord) - 1);
    }
}

if ( ! function_exists('is_https'))
{
	/**
	 * Is HTTPS?
	 *
	 * Determines if the application is accessed via an encrypted
	 * (HTTPS) connection.
     * 
     * Note: This function was taken from CodeIgniter 3 common function 
	 *
	 * @return	bool
	 */
	function is_https()
	{
		if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
		{
			return TRUE;
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
		{
			return TRUE;
		}
		elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
		{
			return TRUE;
		}

		return FALSE;
	}
}

if ( ! function_exists('resort'))
{
    /**
     * Re-sorting arrays in order to make index key
     * back to numeric index started from 0
     * This function is used to remove numeric index when
     * the array is encoded to JSON format
     * 
     * @param array $array
     * @return array
     */
    function resort(array $array)
    {
        $sort = [];
        foreach($array as $key)
        {
            $sort[] = $key;
        }

        return $sort;
    }
}