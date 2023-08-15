<?php namespace Actudent\Core\Libraries;

use Config\Services;

class Uploader 
{
    private $request;

    private $validation;

    private $basePath = 'images/';

    public function __construct()
    {
        $this->request = Services::request();
        $this->validation = Services::validation();
    }

    /**
     * Upload image
     * Available configuration:
     * - file: the requested file
     * - width
     * - height
     * - dir: the target directory (must belong to "uploads" directory)
     * - maxSize: maximum size of the image
     * - crop: either to use resize(), fit() or stretch() to crop image
     * 
     * 
     * @param array $config
     * 
     * @return array
     */
    public function uploadImage(array $config)
    {
        if($this->validateFile($config['file'], $config['maxSize'])) {
            $attachment = $this->request->getFile($config['file']);
            $newFilename = $attachment->getRandomName();
            $dirPath = PUBLICPATH . $this->basePath . $config['dir'] . '/';
            $filePath = $dirPath . $newFilename;

            // check directory,
            // if it does not exist, then make it first
            if(! is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }

            $attachment->move($dirPath, $newFilename);
            $image = \Config\Services::image()->withFile($filePath);

            if($config['crop'] === 'resize') {
                $image->resize($config['width'], $config['height'], true);
            } elseif($config['crop'] === 'fit') {
                $image->fit($config['width'], $config['height']);
            }
                    
            $image->save($filePath);
           
            $response = [
                'msg'       => 'OK',
                'url'       => base_url($this->basePath . $config['dir'] .'/'. $newFilename),
                'filename'  => $newFilename,
            ];
        } else {
            $response = [
                'msg'       => 'Error',
                'error'     => $this->validation->getErrors()
            ];
        }

        return $response;
    }

    public function removeImage($targetFile)
    {
        $filePath = PUBLICPATH . $this->basePath . $targetFile;
        if(file_exists($filePath)) {
            unlink($filePath);
            return $filePath;
        } else {
            return 'No image to remove';
        }
    }

    public function removePreviousImage(string $oldFile, string $newFile, string $uploadPath)
    {
        $dirPath = PUBLICPATH . $this->basePath . $uploadPath;
        if($oldFile !== '' && $oldFile !== null && $oldFile !== 'null') {
            if($oldFile !== $newFile) {
                $filePath = $dirPath .'/'. $oldFile;
                if(file_exists($filePath)) {
                    unlink($filePath);
                    return $filePath;
                } else {
                    return 'No image to remove';
                }
            }
        }
    }

    private function validateFile($name, $maxSize)
    {
        $fileRules = [
            $name => "is_image[$name]|max_size[$name,$maxSize]",
        ];
        $fileMessages = [
            $name => [
                'is_image' => get_lang('Admin.invalid_filetype'),
                'max_size' => get_lang('Admin.file_too_large'),
            ]
        ];

        $isValid = $this->validation->withRequest(Services::request())
                             ->setRules($fileRules, $fileMessages)
                             ->run();

        return $isValid;
    }

}