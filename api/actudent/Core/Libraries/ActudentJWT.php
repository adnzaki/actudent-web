<?php

require_once APPPATH . 'ThirdParty/jwt/vendor/autoload.php';

use \Firebase\JWT\JWT;

require ACTUDENTPATH . 'Core/Config/TokenKey.php';

class ActudentJWT
{
    /**
     * The private key
     * 
     * @var string
     */
    private $key = '';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->key = TOKEN_KEY;
    }

    /**
     * Alias for JWT::encode
     * 
     * @param array $payload
     * 
     * @return string
     */
    public function encode($payload)
    {
        return JWT::encode($payload, $this->key);
    }

    /**
     * Alias for JWT::decode
     * 
     * @param string $token
     * @param string $alg
     * 
     * @return string
     */
    public function decode($token, $alg = 'HS256')
    {
        return JWT::decode($token, $this->key, [$alg]);
    }

    /**
     * Validate user token
     * 
     * @param string $token
     * 
     * @return mixed
     */
    public function isValidToken($token)
    {
        try
        {
            $decoded = $this->decode($token);
            return true;
        }
        catch(Exception $e)
        {            
            if(ENVIRONMENT === 'development')
            {
                $response = [
                    'token' => 'Invalid token',
                    'error' => $e->getMessage()
                ];

                echo json_encode($response);
            }
        } 
    }
}