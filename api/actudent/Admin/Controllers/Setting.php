<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Libraries\Uploader;
use Actudent\Admin\Models\SettingModel;

class Setting extends \Actudent
{
    private $model;

    public function __construct()
    {
        $this->model = new SettingModel;
    }

    public function setSignSetting($value, $type)
    {
        if(is_admin()) {
            $this->model->setSignSetting($value, $type);
            return $this->response->setJSON(['status' => 'OK']);
        } else {
            return $this->response->setJSON(['status' => 'Failed', 'reason' => 'Invalid credential']);
        }
    }

    public function getSignSetting($type)
    {
        return $this->createResponse($this->model->getSignSetting($type), 'is_admin');
    }

    public function uploadLetterhead()
    {
        if(is_admin()) {
            $config = [
                'file'      => 'letterhead_image',
                'width'     => 2400,
                'height'    => 500,
                'dir'       => 'kop',
                'maxSize'   => 4096,
                'crop'      => 'fit'
            ];

            $uploader = new Uploader;
            $uploaded = $uploader->uploadImage($config);
            $this->model->updateLetterhead($uploaded['filename']);

            return $this->response->setJSON($uploaded);
        }
    }

    public function setLanguage()
    {
        if(valid_token()) {
            $lang = $this->request->getPost('lang');
            $userData = $this->getDataPengguna();
            $path = $this->userLangPath().$userData->user_id.'.json';
            if(file_exists($path)) {
                $settings = json_decode(file_get_contents($path));
                $settings->lang = $lang;
            } else {
                // check if the directory exist or not
                // if not, create it
                if(! is_dir($this->userLangPath()) ) {
                    mkdir($this->userLangPath());
                }

                $settings = ['lang' => $lang];
            }

            // write settings to the file...
            file_put_contents($path, json_encode($settings));

            return $this->response->setJSON(['msg' => 'Language setting updated']);
        }
    }
}
