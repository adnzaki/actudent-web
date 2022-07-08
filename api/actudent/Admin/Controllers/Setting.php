<?php namespace Actudent\Admin\Controllers;

use CodeIgniter\Files\FileCollection;

class Setting extends \Actudent
{
    public function setWarnaTema($tema)
    {
        $this->setting->setTheme($_SESSION['email'], $tema);
        return redirect()->to(base_url('admin/pengaturan-aplikasi'));
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