<?php namespace Actudent\Core\Models;

class AuthModel extends \Actudent\Core\Models\Connector
{
    /**
     * tb_user table builder
     * 
     * @var object
     */
    private $user;

    /**
     * tb_user_token builder
     */
    private $token;

    /**
     * tb_user_themes table builder
     * To load theme after authentication successfully
     * 
     * @var object
     */
    private $userThemes;

    /**
     * tb_user_themes table builder
     * To load language after authentication successfully
     * 
     * @var object
     */
    public $userLanguage;

    public function __construct()
    {
        parent::__construct();

        // Initialize Query Builder for each tables
        $this->user = $this->db->table('tb_user');
        $this->userThemes = $this->db->table('tb_user_themes');
        $this->userLanguage = $this->db->table('tb_user_language');
        $this->token = $this->db->table('tb_user_token');
    }

    /**
     * Get user data who has been logged in
     * 
     * @param string $username 
     * 
     * @return object 
     */
    public function getDataPengguna(string $username): object
    {
        $query = $this->user->select('user_id, user_name, user_email, user_level')
                ->where('user_email', $username)->get()->getResult();
        return $query[0];
    }

    /**
     * Show get users query
     * 
     * @param string $username
     * 
     * @return string
     */
    public function showPenggunaQuery(string $username): string
    {
        $query = $this->user->select('user_name, user_email, user_level')
                ->where('user_email', $username)->getCompiledSelect();
        return $query;
    }

    /**
     * Get user themes
     * 
     * @param string $username
     * 
     * @return array
     */
    public function getUserThemes(string $username): array
    {
        $userID = $this->user->select('user_id, user_email')
                ->where('user_email', $username)->get()->getResult();
        
        return $this->userThemes->where(['user_id' => $userID[0]->user_id])->get()->getResult();
    }

    /**
     * Get user's language preference
     * 
     * @param string $username
     * 
     * @return array
     */
    public function getUserLanguage(string $username): array
    {
        $userID = $this->user->select('user_id, user_email')
                ->where('user_email', $username)->get()->getResult();
        
        return $this->userLanguage->where(['user_id' => $userID[0]->user_id])->get()->getResult();
    }

    /**
     * Set network status to "online" or "offline"
     * 
     * @param string $status
     * @param string $username
     * 
     * @return void
     */
    public function statusJaringan(string $status, string $username): void
    {
        $this->user->update([
            'network' => $status
        ], ['user_email' => $username]);
    }

    /**
     * Create user token for remembering password
     * 
     * @param string $token
     * 
     * @return void
     */
    public function createToken(string $token): void
    {
        $this->token->insert(['token_value' => $token]);
    }

    /**
     * Get user token, return false if not found
     * 
     * @param string $token
     * 
     * @return string|boolean
     */
    public function getUserToken($token)
    {
        $check = $this->token->getWhere(['token_value' => $token])->getResult();
        if(count($check) > 0)
        {
            return $check[0]->token_value;
        }
        else
        {
            return false;
        }
    }

    /**
     * Delete user token
     * 
     * @param string|null $token
     * 
     * @return void
     */
    public function deleteToken($token): void
    {
        if($token !== null)
        {
            $this->token->delete(['token_value' => $token]);
        }
    }

    /**
     * Validate username and possword
     * @param string $username
     * @param string $password
     * @param string $userLevel
     * 
     * @return bool
     */
    public function validasi(string $username, string $password, string $userLevel): bool
    {
        $find = $this->user->where(['user_email' => $username]);
        $userAktif = $find->get()->getResult();
        if($find->countAllResults() > 0 && $this->userAktif($username, $userLevel))
        {
            if(password_verify($password, $userAktif[0]->user_password))
            {
                return true;
            }
            else 
            {
                return false;
            }            
        }
        else 
        {
            return false;
        }
    }

    /**
     * Check if user is active or not
     * 
     * @param string $username
     * @param string $userLevel
     * 
     * @return boolean
     */
    public function userAktif(string $username, string $userLevel): bool
    {
        $query = $this->user->where('user_email', $username)->get()->getResult();
        if(count($query) > 0)
        {
            if($query[0]->deleted === '0' && $query[0]->user_level === $userLevel)
            {
                return true;
            }
            else 
            {
                return false;
            }
        }
        else 
        {
            return false;
        }
    }
}