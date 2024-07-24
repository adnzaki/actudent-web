<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

use Actudent\Core\Models\MigratorModel;

class Migrator extends \Actudent
{
    private $model;

    public function __construct()
    {
        $this->model = new MigratorModel;
    }

    public function checkDatabase()
    {
        return $this->response->setJSON([
            'shouldUpdate' => $this->model->getDbVersion() !== DB_VERSION ? 1 : 0
        ]);
    }

    public function updateDatabase()
    {
        $this->model->addPtkDapodikId();
        $this->model->updateDbVersion();

        return $this->response->setJSON([
            'status'    => 'OK',
            'message'   => $this->model->getDbVersion()
        ]);
    }
}
