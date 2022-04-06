<?php
/**
 * PHP API Loader for Actudent
 * 
 * This class is intended to be spesifically fetch PDF report
 * that available within Actudent API. Since we should not have to
 * expose direct API Url to user, we use cURL to fetch resources
 * from APIs. In other cases, this ApiLoader can be used as a common cURL
 * loader for Actudent API if needed
 * 
 * @package     Library
 * @author      Adnan Zaki
 * @copyright   Wolestech Devteam (c) 2021
 * @since       July 2021
 */

require 'config.php';

class ApiLoader
{
    /**
     * Run the cURL along with the configuration
     * 
     * @param string $url
     * @param string $params
     * 
     * @return mixed
     */
    public function get(string $url, string $params = '', $isPdf = false)
    {
        // persiapkan curl
        $ch = curl_init(); 

        $header = [
            'Authorization: Bearer ' . htmlspecialchars($_GET['token'])
        ];

        // set url 
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl($url . $params));

        // set header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        if($isPdf)
        {
            header('Content-type: application/pdf');
        }

        // $output contains the output string 
        $output = curl_exec($ch); 

        curl_close($ch);      

        return $output;
    }

    /**
     * The URL parameters transformer
     * is used to transform query string into
     * compatible Actudent URLs pattern.
     * Example: ?grade_id=1&teacher_id=2 into 1/2
     * 
     * @param array $params
     * 
     * @return string
     */
    public function transformParams(array $params): string
    {
        $safeParams = [];
        foreach($params as $val)
        {
            $safeParams[] = htmlspecialchars($val);
        }

        return implode('/', $safeParams);
    }

    private function baseUrl(string $url = ''): string
    {
        $protocol = MODE === 'development'
                    ? 'http://' : 'https://';

        $basePath = MODE === 'development'
                    ? '/actudent/api/public/'
                    : '/api/public/';

        $output = $protocol . $_SERVER['HTTP_HOST'] . $basePath;

        return empty($url) ? $output : $output .= $url;
    }
}