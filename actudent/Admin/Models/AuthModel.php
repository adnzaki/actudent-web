<?php namespace Actudent\Admin\Models;

class AuthModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * tb_user table builder
     * 
     * @var object
     */
    private $user;

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
    }

    /**
     * Get user data who has been logged in
     * 
     * @param string $username 
     * @return object 
     */
    public function getDataPengguna($username)
    {
        $query = $this->user->select('user_id, user_name, user_email, user_level')
                ->where('user_email', $username)->get()->getResult();
        return $query[0];
    }

    public function showPenggunaQuery($username)
    {
        $query = $this->user->select('user_name, user_email, user_level')
                ->where('user_email', $username)->getCompiledSelect();
        return $query;
    }

    public function getUserThemes($username)
    {
        $userID = $this->user->select('user_id, user_email')
                ->where('user_email', $username)->get()->getResult();
        
        return $this->userThemes->where(['user_id' => $userID[0]->user_id])->get()->getResult();
    }

    /**
     * Get user's language preference
     * 
     * @param string $username
     * @return object
     */
    public function getUserLanguage($username)
    {
        $userID = $this->user->select('user_id, user_email')
                ->where('user_email', $username)->get()->getResult();
        
        return $this->userLanguage->where(['user_id' => $userID[0]->user_id])->get()->getResult();
    }

    /**
     * Set network status to "online" or "offline"
     * 
     * @param string $username
     * @return void
     */
    public function statusJaringan($status, $username)
    {
        $this->user->update([
            'network' => $status
        ], ['user_email' => $username]);
    }

    /**
     * Validate username and possword
     * 
     * @return bool
     */
    public function validasi($username, $password)
    {
        $find = $this->user->where(['user_email' => $username]);
        if($find->countAllResults() > 0 && $this->userAktif($username))
        {
            $userAktif = $find->get()->getResult();
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
     * @return bool
     */
    public function userAktif(string $username): bool
    {
        $query = $this->user->where('user_email', $username)->get()->getResult();
        if($query[0]->deleted === '0' && $query[0]->user_level === '1')
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}