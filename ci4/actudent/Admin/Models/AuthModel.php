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
     * Untuk memuat tema setelah autentikasi berhasil
     * 
     * @var object
     */
    private $userThemes;

    /**
     * tb_user_themes table builder
     * Untuk memuat tema setelah autentikasi berhasil
     * 
     * @var object
     */
    public $userLanguage;

    public function __construct()
    {
        parent::__construct();

        // Instantiasi query builder untuk masing-masing tabel
        $this->user = $this->db->table('tb_user');
        $this->userThemes = $this->db->table('tb_user_themes');
        $this->userLanguage = $this->db->table('tb_user_language');
    }

    /**
     * Mengambil data pengguna yang berhasil login 
     * 
     * @param string $username 
     * @return object 
     */
    public function getDataPengguna($username)
    {
        $query = $this->user->select('user_name, user_email, user_level')
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
     * Mengambil preferensi bahasa pengguna
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
     * Mengatur status jaringan pengguna menjadi "online" atau "offline"
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
     * Validasi input user_name dan password 
     * 
     * @return bool
     */
    public function validasi()
    {
        $username = $this->input->getPost('username');
        $password = $this->input->getPost('password');
        $find = $this->user->where(['user_email' => $username]);
        if($find->countAllResults() > 0 && $this->userAktif($username))
        {
            $getUserPassword = $this->user->where(['user_email' => $username]);
            $userAktif = $getUserPassword->get()->getResult();
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
     * Mengecek apakah user yang login adalah user aktif atau bukan
     * 
     * @param string $username
     * @return bool
     */
    public function userAktif(string $username): bool
    {
        $query = $this->user->where('user_email', $username)->get()->getResult();
        if($query[0]->user_status === '1' && $query[0]->user_level === '1')
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}