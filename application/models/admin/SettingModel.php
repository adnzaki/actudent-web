<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingModel extends CI_Model
{
    /**
     * Tabel tb_setting
     * 
     * @var string
     */
    private $setting = 'tb_settings';

    /**
     * Mengambil pengaturan
     * 
     * @return void
     */
    public function getSettings()
    {
        return $this->db->get($this->setting)->result();
    }

    /**
     * Set warna tema aplikasi
     * 
     * @param string $theme 
     * @return void
     */
    public function setTheme($theme)
    {
        $template = $this->themeComponents($theme);
        foreach($template as $key)
        {
            $this->db->update($this->setting, [
                'settingValue' => $key['settingValue']
            ], ['settingKey' => $key['settingKey']]);
        }
    }

    /**
     * Komponen tema 
     * 
     * @param string $theme
     * @return array
     */
    private function themeComponents($theme)
    {
        $template = [
            // Semi Dark theme
            'semi-dark' => [
                [
                    'settingKey'    => 'menuColor',
                    'settingValue'  => 'menu-dark',
                ],
                [
                    'settingKey'    => 'navbarColor',
                    'settingValue'  => 'navbar-semi-dark',
                ],
                [
                    'settingKey'    => 'navbarContainerColor',
                    'settingValue'  => 'bg-dark',
                ],
                [
                    'settingKey'    => 'modalHeaderColor',
                    'settingValue'  => 'bg-dark',
                ],
                [
                    'settingKey'    => 'navlinkColor',
                    'settingValue'  => 'nav-link-white',
                ],
            ],
            // Light Blue theme
            'light-blue' => [
                [
                    'settingKey'    => 'menuColor',
                    'settingValue'  => 'menu-light',
                ],
                [
                    'settingKey'    => 'navbarColor',
                    'settingValue'  => 'navbar-semi-light',
                ],
                [
                    'settingKey'    => 'navbarContainerColor',
                    'settingValue'  => '',
                ],
                [
                    'settingKey'    => 'modalHeaderColor',
                    'settingValue'  => 'bg-info',
                ],
                [
                    'settingKey'    => 'navlinkColor',
                    'settingValue'  => '',
                ],
            ]
        ];
        
        return $template[$theme];
    }
}