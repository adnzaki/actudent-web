<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model
{
    /**
     * Tabel tb_user
     * 
     * @var string
     */
    private $user = 'tb_user';

    /**
     * Tabel tb_user_themes 
     * Untuk memuat tema setelah autentikasi berhasil
     * 
     * @var string
     */
    private $userThemes = 'tb_user_themes';

    /**
     * Mengambil data pengguna yang berhasil login 
     * 
     * @param string $username 
     * @return object 
     */
    public function getDataPengguna($username)
    {
        $query = $this->db->select('userName, userEmail, userLevel')->from($this->user)
                ->where('userEmail', $username)->get()->result();
        return $query[0];
    }

    public function getUserThemes($username)
    {
        $userID = $this->db->select('userID, userEmail')->from($this->user)
                ->where('userEmail', $username)->get()->result();
        
        return $this->db->get_where($this->userThemes, ['userID' => $userID[0]->userID])->result();
    }

    /**
     * Mengatur status jaringan pengguna menjadi "online" atau "offline"
     * 
     * @param string $username
     * @return void
     */
    public function statusJaringan($status, $username)
    {
        $this->db->update($this->user, [
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
        $cari = $this->db->get_where($this->user, ['userEmail' => $username]);
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
        $query = $this->db->get_where($this->user, ['userEmail' => $username])->result();
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