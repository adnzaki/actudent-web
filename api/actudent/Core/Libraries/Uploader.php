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
     * - prefix: insert prefix into new filename
     * - fit-position: set position to apply with fit() method
     * 
     * 
     * @param array $config
     * 
     * @return array
     */
    public function uploadImage(array $config)
    {
        if($this->validateFile($config['file'], $config['maxSize'])) {            
            $dirPath = PUBLICPATH . $this->basePath . $config['dir'] . '/';            

            // check directory,
            // if it does not exist, then make it first
            if(! is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }

            $attachment = $this->request->getFiles();
            if(gettype($attachment[$config['file']]) === 'array') {
                $uploadedFiles = [];
                foreach($attachment[$config['file']] as $file) {
                    $uploadedFiles[] = $this->doUploadImage($config, $file, $dirPath);
                }

                $response = [
                    'msg'       => 'OK',
                    'uploaded'  => $uploadedFiles,
                ];
            } else {
                $uploaded = $this->doUploadImage($config, $attachment[$config['file']], $dirPath);
                $response = array_merge(['msg' => 'OK'], $uploaded);
            }
           
        } else {
            $response = [
                'msg'       => 'Error',
                'error'     => $this->validation->getErrors()
            ];
        }

        return $response;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    private function doUploadImage(array $config, $file, $dirPath)
    {
        $prefix = $config['prefix'] ?? '';
        $fitPosition = $config['fit-position'] ?? 'center';
        $newFilename = $prefix . $file->getRandomName();
        $filePath = $dirPath . $newFilename;
        $file->move($dirPath, $newFilename);

        $image = \Config\Services::image()->withFile($filePath);
        if($config['crop'] === 'resize') {
            $image->resize($config['width'], $config['height'], true);
        } elseif($config['crop'] === 'fit') {
            $image->fit($config['width'], $config['height'], $fitPosition);
        }                
        $image->save($filePath);

        return [
            'url'       => base_url($this->basePath . $config['dir'] .'/'. $newFilename),
            'filename'  => $newFilename,
        ];
    }

    public function removePreviousImage($oldFile, $newFile, $uploadPath)
    {
        if(empty($oldFile) && $oldFile !== null && $oldFile !== 'null') {
            if($oldFile !== $newFile) {
                $filePath = $uploadPath .'/'. $oldFile;
                $this->removeImage($filePath);
            }
        }
    }

    public function removeImage($targetFile)
    {
        if(empty($targetFile) && $targetFile !== null && $targetFile !== 'null') {
            $filePath = PUBLICPATH . $this->basePath . $targetFile;
            if(file_exists($filePath)) {
                unlink($filePath);
                return $filePath;
            } else {
                return 'No image to remove';
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