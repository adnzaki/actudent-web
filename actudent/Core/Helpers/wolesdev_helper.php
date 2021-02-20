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
     * @author Adnan Zaki
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

if ( ! function_exists('access_denied'))
{
    /**
     * Tell users that the page they try to access is denied
     * 
     * @return string
     */
    function access_denied()
    {
        $style = [
            'div' => [
                'padding' => '5px',
                'background-color' => 'yellow',
                'border' => 'solid 3px',
                'font-family' => 'Arial',
                'text-align' => 'center',
            ],
        ];

        $text = 'You do not have access to this page.';
        return html_text($text, 'div > h2 > i', $style);
    }
}

if ( ! function_exists('html_text'))
{
    /**
     * A simple HTML element generator
     * Outer HTML can be passed by using its tag name
     * Example outer HTML creation: "p > i"
     * will generate <p><i></i></p>
     * 
     * @author Adnan Zaki
     * 
     * @param string $inner
     * @param string $outer
     * @param array $style
     * 
     * @return string
     */
    function html_text(string $inner, string $outer = 'h2', array $style = [])
    {    
        function createStyle($outer, $style)    
        {
            $styleStr = '';
            if(isset($style[$outer]))
            {
                $styleStr = 'style="';
                $closeStyle = '';
                $i = 1;
                foreach($style[$outer] as $k => $v)
                {                            
                    if($i === count($style[$outer]))
                    {
                        $closeStyle = '"';
                    }
                    $styleStr .= $k .': ' . $v . ';' . $closeStyle;
                    $i++;
                }

                return $styleStr;
            }
        }

        if(strpos($outer, '>') === false)
        {
            $styleStr = createStyle($outer, $style);
            return '<'.$outer. ' ' .$styleStr.'>'. $inner .'</'.$outer.'>';
        }
        else
        {
            $removeSpace = str_replace(' ', '', $outer);
            $elems = explode('>', $removeSpace);
            $outerOpen = '';
            $outerClose = '';
            $outerCloseWrapper = [];
            foreach($elems as $val)
            {
                $styleStr = createStyle($val, $style);
                $outerOpen .= '<' . $val . ' ' . $styleStr . '>';
                $outerCloseWrapper[] = '</' . $val . '>';
            }

            $outerClose = implode('', array_reverse($outerCloseWrapper));

            return $outerOpen . $inner . $outerClose;            
        }
    }
}

if ( ! function_exists('db_installed'))
{
    /**
     * Check if Actudent's database has been installed properly
     * 
     * @return boolean
     */
    function db_installed()
    {
        $conn = new \Actudent\Core\Models\Connector;
        if(count($conn->db->listTables()) >= 20)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}