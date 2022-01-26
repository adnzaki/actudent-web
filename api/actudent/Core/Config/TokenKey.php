<?php namespace Actudent\Core\Config;

class TokenKey 
{
    use \Keys\JawaBarat\KotaBekasi;

    public function getSecretKey()
    {
        $subdomain = get_subdomain();

        // automatically detect private property 
        // based on its subdomain
        return $this->keys[$subdomain];
    }
}
