<?php namespace Actudent\Core\Models;

use Actudent\Core\Models\AuthModel;

class SettingModel extends \Actudent\Core\Models\Connector
{
    /**
     * tb_setting table builder
     * 
     * @var string
     */
    private $setting;

    /**
     * tb_user_themes table builder
     * 
     * @var string 
     */
    private $userThemes;

    /**
     * Auth Model 
     * 
     * @var object
     */
    private $auth;

    public function __construct()
    {
        parent:: __construct();
        $this->setting = $this->db->table('tb_settings');
        $this->userThemes = $this->db->table('tb_user_themes');
        $this->auth = new AuthModel;
    }

    /**
     * Get settings
     * 
     * @return array
     */
    public function getSettings(): array
    {
        return $this->setting->getResult();
    }

    /**
     * Set app theme
     * 
     * @param string $username
     * @param string $selectedTheme
     * 
     * @return void
     */
    public function setTheme(string $username, string $selectedTheme): void
    {
        $theme = $this->auth->getUserThemes($username);
        $this->userThemes->update([
            'theme' => $selectedTheme,
        ], ['user_id' => $theme[0]->user_id]);
    }

    /**
     * Set app language
     * 
     * @param string $username
     * @param string $selectedLanguage
     * 
     * @return void
     */
    public function setUserLanguage(string $username, string $selectedLanguage): void
    {
        $lang = $this->auth->getUserLanguage($username);
        $this->auth->userLanguage->update([
            'user_language' => $selectedLanguage,
        ], ['user_id' => $lang[0]->user_id]);
    }

    /**
     * The theme components
     * 
     * @param string $theme
     * 
     * @return array
     */
    public function themeComponents(string $theme): array
    {
        $template = [
            // Semi Dark theme
            // Empty setingValue = using default template color
            'semi-dark' => [
                [
                    'settingKey'    => 'bodyColor',
                    'settingValue'  => '',
                ],
                [
                    'settingKey'    => 'footerColor',
                    'settingValue'  => 'footer-light',
                ],
                [
                    'settingKey'    => 'footerTextColor',
                    'settingValue'  => 'lighten-2',
                ],
                [
                    'settingKey'    => 'cardColor',
                    'settingValue'  => '', 
                ],
                [
                    'settingKey'    => 'cardTitleColor',
                    'settingValue'  => '', 
                ],
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
            // Empty setingValue = using default template color
            'light-blue' => [
                [
                    'settingKey'    => 'bodyColor',
                    'settingValue'  => '',
                ],
                [
                    'settingKey'    => 'footerColor',
                    'settingValue'  => 'footer-light',
                ],
                [
                    'settingKey'    => 'footerTextColor',
                    'settingValue'  => 'lighten-2',
                ],
                [
                    'settingKey'    => 'cardColor',
                    'settingValue'  => '', 
                ],
                [
                    'settingKey'    => 'cardTitleColor',
                    'settingValue'  => '', 
                ],
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
            ],
            // Night Vision theme 
            'night-vision' => [
                [
                    'settingKey'    => 'bodyColor',
                    'settingValue'  => 'night-body', //#606371 !important
                ],
                [
                    'settingKey'    => 'footerColor',
                    'settingValue'  => 'footer-dark',
                ],
                [
                    'settingKey'    => 'footerTextColor',
                    'settingValue'  => 'lighten-3',
                ],
                [
                    'settingKey'    => 'cardColor',
                    'settingValue'  => 'night-card', //#2C303B !important
                ],
                [
                    'settingKey'    => 'cardTitleColor',
                    'settingValue'  => 'night-card-title', //#f5f5f5 !important
                ],
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
            'soft-touch' => [
                [
                    'settingKey'    => 'bodyColor',
                    'settingValue'  => 'night-body', //#606371 !important
                ],
                [
                    'settingKey'    => 'footerColor',
                    'settingValue'  => 'footer-dark',
                ],
                [
                    'settingKey'    => 'footerTextColor',
                    'settingValue'  => 'lighten-3',
                ],
                [
                    'settingKey'    => 'cardColor',
                    'settingValue'  => 'gradient-card', //#2C303B !important
                ],
                [
                    'settingKey'    => 'cardTitleColor',
                    'settingValue'  => 'night-card-title', //#f5f5f5 !important
                ],
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
                    'settingValue'  => 'bg-gradient',
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
        ];
        
        return $template[$theme];
    }
}