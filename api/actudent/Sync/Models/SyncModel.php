<?php namespace Actudent\Sync\Models;

use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\OrtuModel;

class SyncModel extends \Actudent\Core\Models\Connector
{
    private $ot;

    private $s;

    public function __construct()
    {
        parent:: __construct();
        $this->ot = new OrtuModel;
        $this->s = new SiswaModel;
    }

    public function insertPesertaDidik($value)
    {
        $this->s->insert($value);
    }

    public function insertOrangTua($value)
    {
        if($this->orangTuaAccountExists($value['user_email']))
        {
            $value['user_email'] = $value['user_email'] . rand(1, 1000);
        }

        return $this->ot->insert($value);
    }

    public function pesertaDidikEmpty()
    {
        $query = $this->s->QBStudent->getWhere(['deleted' => '0']);
        if($query->getNumRows() === 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    private function orangTuaAccountExists($userEmail)
    {
        $fullEmail = $userEmail . '@' . $this->ot->getSchoolDomain();
        $findUser = $this->ot->QBUser->getWhere(['user_email' => $fullEmail]);

        if($findUser->getNumRows() === 0)
        {
            return false;
        }
        else 
        {
            return true;
        }
    }

    public function orangTuaExists($father, $mother, $phone)
    {
        $findParent = $this->ot->QBParent->getWhere([
            'parent_father_name' => $father,
            'parent_mother_name' => $mother,
            'parent_phone_number'=> $phone
        ]);

        if($findParent->getNumRows() === 0)
        {
            return false;
        }
        else 
        {
            return $findParent->getResult()[0];
        }
    }
}