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

if ( ! function_exists('get_host'))
{
    /**
     * Get host name
     * 
     * @author Adnan Zaki
     * 
     * @return string
     */
    function get_host()
    {        
        $uri = new \CodeIgniter\HTTP\URI(base_url());
        
        return $uri->getHost();
    }
}

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

if ( ! function_exists('copy_data'))
{
    /**
     * Copy single data into many data
     * You can create unique value for each of them
     * or make everything the same
     * Example usage:
     * $data = ['name' => 'Foo', 'id' => 100, 'age' => 25]
     * $result = copy_data($data, 2, ['age'])
     * That function call will result unique data for 'name'
     * and 'id', while 'age' will be the same value
     * 
     * @param   array $data
     * @param   int $num
     * @param   array $nonUnique
     * 
     * @return array
     */
    function copy_data(array $data, int $num, array $nonUnique = [])
    {
        $wrapper = [];
        for($i = 1; $i <= $num; $i++)
        {            
            $copy = '';
            $incArray = [];
            foreach($data as $k => $v)
            {
                if(array_search($k, $nonUnique) !== false)
                {
                    $copy = $v;
                }
                else 
                {
                    if(gettype($v) === 'string')
                    {
                        $suffix = " ({$i})";
                        $copy = $v . $suffix;
                    }
                    elseif(gettype($v) === 'integer')
                    {
                        $copy = $v + $i;
                    }               
                }
                
                $incArray[$k] = $copy;
            }

            $wrapper[] = $incArray;
        }

        return $wrapper;
    }
}

if ( ! function_exists('html_text'))
{
    /**
     * A simple HTML element generator
     * 
     * Example usage:
     * $style = ['p' => ['font-weight' => 'bold', 'text-align' => 'center']]
     * html_text('Hello world!', 'p > i', $style)
     * Result: <p style="font-weight: bold; text-align: center"><i>Hello world!</i></p>
     * You can add styles as many as you want
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
        if(count($conn->db->listTables()) >= 28)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}

if ( ! function_exists('jwt_encode'))
{
    /**
     * A shorthand to ActudentJWT::encode
     * 
     * @param array $payload
     * 
     * @return string
     */
    function jwt_encode($payload)
    {
        $jwt = new \ActudentJWT;
        return $jwt->encode($payload);
    }
}

if ( ! function_exists('jwt_decode'))
{
    /**
     * A shorthand to ActudentJWT::decode
     * 
     * @param string $token
     * @param string $alg
     * 
     * @return string
     */
    function jwt_decode($token, $alg = 'HS256')
    {
        $jwt = new \ActudentJWT;
        return $jwt->decode($token, $alg);
    }
}

if ( ! function_exists('is_admin'))
{
    /**
     * Check if user logged in has priviledge
     * to admin section or not
     * 
     * @return boolean
     */
    function is_admin()
    {
        return validate_section('1');
    }
}

if ( ! function_exists('is_teacher'))
{
    /**
     * Check if user logged in has priviledge
     * to teacher section or not
     * 
     * @return boolean
     */
    function is_teacher()
    {
        return validate_section('2');
    }
}

if ( ! function_exists('validate_section'))
{
    /**
     * Check if user logged in has priviledge
     * to a spesific section or not
     * 
     * @return boolean
     */
    function validate_section($level)
    {
        if(valid_token() !== true)
        {
            return false;
        }
        else
        {
            $token = bearer_token();
            $decoded = jwt_decode($token);
            if($decoded->userLevel === $level)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}

if ( ! function_exists('valid_token'))
{
    /**
     * A shorthand to validate token that
     * uses Bearer token Authorization header
     * 
     * @return boolean
     */
    function valid_token()
    {
        $jwt = new \ActudentJWT;
        $token = bearer_token();
        return ($jwt->isValidToken($token)) ? true : false;
    }
}


if ( ! function_exists('bearer_token'))
{
    /**
     * Get bearer token for authentication
     * with JSON Web Tokens
     * 
     * @return string
     */
    function bearer_token()
    {
        $request = \Config\Services::request();
        $getAuth = $request->getHeaderLine('Authorization');
        return str_replace('Bearer ', '', $getAuth);
    }
}