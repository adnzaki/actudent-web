<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'models/AuthModel.php';

class SettingModel extends CI_Model
{
    /**
     * Tabel tb_setting
     * 
     * @var string
     */
    private $setting = 'tb_settings';

    /**
     * Tabel tb_user_themes
     * 
     * @var string 
     */
    private $userThemes = 'tb_user_themes';

    /**
     * Auth Model 
     * 
     * @var object
     */
    private $auth;

    public function __construct()
    {
        $this->auth = new AuthModel();
    }

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
     * @param string $username
     * @param string $selectedTheme
     * @return void
     */
    public function setTheme($username, $selectedTheme)
    {
        $theme = $this->auth->getUserThemes($username);
        $this->db->update($this->userThemes, [
            'theme' => $selectedTheme,
        ], ['userID' => $theme[0]->userID]);
    }

    /**
     * Komponen tema 
     * 
     * @param string $theme
     * @return array
     */
    public function themeComponents($theme)
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