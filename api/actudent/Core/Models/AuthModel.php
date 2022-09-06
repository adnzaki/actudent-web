<?php namespace Actudent\Core\Models;

class AuthModel extends \Actudent\Core\Models\Connector
{
    /**
     * tb_user table builder
     * 
     * @var object
     */
    private $user;

    public function __construct()
    {
        parent::__construct();

        // Initialize Query Builder for each tables
        $this->user = $this->db->table('tb_user');
    }

    /**
     * Check whether the username is staff_nik or user_email
     * If it is staff_nik, then return their user_email,
     * if not, then return false
     * 
     * @param string $username
     * 
     * @return mixed
     */
    public function isNik(string $username)
    {
        $pegawai = new \Actudent\Admin\Models\PegawaiModel;
        $query = $pegawai->QBStaff->getWhere(['staff_nik' => $username]);

        if($query->getNumRows() > 0) {
            $staffData = $query->getResult()[0];
            $userId = $staffData->user_id;

            return $userId;
        } else {
            return false;
        }
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
        $field = 'user_id, user_name, user_email, user_level';
        $query = $this->user->select($field)
            ->where('user_email', $username)
            ->orWhere('user_id', (int)$username)
            ->get()->getResult();
        return $query[0];
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
     * Validate username and possword
     * @param string $username
     * @param string $password
     * 
     * @return bool
     */
    public function validasi(string $username, string $password): bool
    {
        $find = $this->user
                     ->where(['user_email' => $username])
                     ->orWhere(['user_id' => (int)$username]);
        $userAktif = $find->get()->getResult();
        if($find->countAllResults() > 0 && $this->userAktif($username))
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
     * 
     * @return boolean
     */
    public function userAktif(string $username): bool
    {
        $query = $this->user
                      ->where('user_email', $username)
                      ->orWhere(['user_id' => (int)$username])
                      ->get()->getResult();
        if(count($query) > 0)
        {
            if($query[0]->deleted === '0')
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