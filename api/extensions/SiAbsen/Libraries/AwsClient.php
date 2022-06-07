<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AwsClient
{
    use \SiAbsen\Libraries\AwsCredentials;

    private $bucket = 'wolestech';

    private $keyPrefix = 'siabsensi-smkn11kotabekasi/';

    private $folderName = 'staff-presence';

    private $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version'       => 'latest',
            'region'        => 'ap-southeast-3',
            // 'profile'       => 'default'
            'credentials'   => [
                'key'    => $this->accessKey,
                'secret' => $this->secretKey,
            ]
        ]);
    }

    public function folder($folderName)
    {
        $this->folderName = $folderName;

        return $this;
    }

    public function deleteObject($keyname)
    {
        $this->s3->deleteObject([
            'Bucket'        => $this->bucket,
            'Key'           => $this->keyPrefix . $this->folderName . '/' . basename($keyname),
        ]);
    }

    public function putObject($filepath)
    {
        $result = $this->s3->putObject([
            'Bucket'        => $this->bucket,
            'Key'           => $this->keyPrefix . $this->folderName . '/' . basename($filepath),
            'SourceFile'    => $filepath,
        ]);

        return $result['ObjectURL'];
    }

    public function getObjectUrl($keyname)
    {
        return $this->s3->getObjectUrl($this->bucket, $this->keyPrefix . $this->folderName . '/' . $keyname);
    }

    public function getPresignedObject($keyname)
    {
        $cmd = $this->s3->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key'    => $this->keyPrefix . $this->folderName . '/' . $keyname
        ]);

        $request = $this->s3->createPresignedRequest($cmd, '+1 minutes');
        $presignedUrl = (string)$request->getUri();

        return $presignedUrl;
    }

    public function getObject($keyname)
    {
        try {
            // Get the object.
            $result = $this->s3->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $this->keyPrefix . $this->folderName . '/' . $keyname
            ]);
        
            // Display the object in the browser.
            header("Content-Type: {$result['ContentType']}");
            echo $result['Body'];
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}