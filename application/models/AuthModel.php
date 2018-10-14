<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    /**
     * Tabel yang dibutuhkan untuk class AuthModel
     * 
     * @var array
     */
    private $table = [
        'user' => 'tb_user'
    ];

    /**
     * Mengambil data pengguna yang berhasil login 
     * 
     * @param string $username 
     * @return object 
     */
    public function getDataPengguna($username)
    {
        $query = $this->db->select('schoolID, userName, userEmail, userLevel')->from($this->table['user'])
                ->where('userEmail', $username)->get()->result();
        return $query[0];
    }

    /**
     * Mengatur status jaringan pengguna menjadi "online" atau "offline"
     * 
     * @param string $username
     * @return void
     */
    public function statusJaringan($status, $username)
    {
        $this->db->update($this->table['user'], [
            'network' => $status
        ], ['userEmail' => $username]);
    }

    /**
     * Validasi input username dan password 
     * 
     * @return bool
     */
    public function validasi()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $cari = $this->db->get_where($this->table['user'], ['userEmail' => $username]);
        if($cari->num_rows() > 0 && $this->userAktif($username))
        {
            $userAktif = $cari->result();
            if(password_verify($password, $userAktif[0]->userPassword))
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
        $query = $this->db->get_where($this->table['user'], ['userEmail' => $username])->result();
        if($query[0]->userStatus === '1')
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}