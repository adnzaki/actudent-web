<?php

/**
 * This helper is created to help Wolestech DevTeam
 * to code easier and faster while developing their apps
 * 
 * @copyright   Copyright (c) 2021, Wolestech
 * @package     Helper
 * @author      Wolestech DevTeam
 * @link        https://wolestech.com
 */

if ( ! function_exists('parse'))
{
    /**
     * An alias function to parser renderer
     * 
     * @param string $view
     * @param array $data
     * 
     * @return string
     */
    function parse(string $view, array $data)
    {
        $parser = \Config\Services::parser();

        return $parser->setData($data)->render($view);
    }
}

if ( ! function_exists('os_date'))
{
    /**
     * Replace OstiumDate object creation into callable function
     * 
     * @return object
     */
    function os_date()
    {
        return new \OstiumDate();
    }
}