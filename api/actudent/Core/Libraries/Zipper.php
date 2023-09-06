<?php
class Zipper
{
    private $zip;

    private $path;

    private $inputPath = '';

    private $sameDir = false;

    /**
     * The Constructor
     * 
     * @param string $path Path for ZIP output
     * @param boolean $sameDir Whether to use same directory for input filepath as output path
     * 
     * @return this
     */
    public function __construct(string $path = '', bool $sameDir = false)
    {
        $this->zip = new ZipArchive;
        $this->path = $path;
        if($sameDir) {
            $this->inputPath = $path;
            $this->sameDir = $sameDir;
        }

        return $this;
    }

    /**
     * Create a zip file from sequence of files
     * 
     * @param array|string $files The input file
     * @param string $filename Filename for zip file (do not include ".zip" extension)
     * @param string $dir sub-directory inside $this->path (do not include trailing slash)
     * 
     * @return array
     */
    public function create($files, string $filename, string $dir = '')
    {
        if(! empty($dir)) {
            $this->path .= $dir.'/';
        }

        if(! is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
        $filename .= '_'.time() . '.zip';
        $filepath = $this->path . $filename;
        if($this->zip->open($filepath, $this->zip::CREATE)) {
            $zippedFiles = [];
            if(gettype($files) === 'array') {
                foreach($files as $file) {
                    $contentName = '/'. $this->getNameFromFilepath($file);
                    $this->zip->addFile($this->inputPath . $file, $contentName);
                    $zippedFiles[] = $contentName;
                }
            } else {
                $contentName = '/'. $this->getNameFromFilepath($files);
                $this->zip->addFile($this->inputPath . $files, $contentName);
                $zippedFiles[] = $contentName;
            }

            $this->zip->close();

            $response = ['status' => 'OK', 'files' => $zippedFiles, 'output' => $filename];
        } else {
            $response = ['status' => 'Error'];
        }

        return $response;
        // return $this->getNameFromFilepath($files);
    }

    /**
     * Set input path
     * If $this->sameDir is true, then $inputPath will be its sub-directory
     * 
     * @param string $inputPath The input file path
     * 
     * @return Zipper
     */
    public function setInputPath(string $inputPath)
    {
        if($this->sameDir) {
            $this->inputPath .= $inputPath . '/';
        } else {
            $this->inputPath = $inputPath . '/';
        }

        return $this;
    }

    /**
     * Get filename from the last sequence of filepath
     * This is an internal method
     * 
     * @param string $filepath
     * 
     * @return string
     */
    private function getNameFromFilepath(string $filepath)
    {
        $pathToArray = explode('/', $filepath);

        return $pathToArray[count($pathToArray) - 1];
    }

}