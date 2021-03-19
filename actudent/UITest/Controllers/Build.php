<?php namespace Actudent\UITest\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Build extends \Actudent\Core\Controllers\Actudent
{
    public function js()
    {
        $data = $this->common();
        return parse('Actudent\UITest\Views\Main', $data);
    }

    public function testGetData()
    {
        $data = [
            'name'  => 'Adnan Zaki',
            'age'   => 27
        ];

        return $this->createApiResponse($data);
    }

    public function token()
    {
        if(valid_token())
        {
            //return $this->response->setJSON(['Token is valid']);
            echo 'Token is valid';
        }
        // return $this->response->setJSON([$token]);
    }

    public function generateToken()
    {
        $payload = [
            'id'        => 1,
            'email'     => 'admin@wolestech.com',
            'nama'      => 'Adnan Zaki',
            'userLevel' => '2',
            'logged_in' => true
        ];

        echo jwt_encode($payload);
    }
}