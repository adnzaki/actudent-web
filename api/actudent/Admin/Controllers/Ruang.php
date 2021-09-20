<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\RuangModel;

class Ruang extends Actudent
{
    /**
     * @var Actudent\Admin\Models\RuangModel
     */
    private $ruang;

    public function __construct()
    {
        $this->ruang = new RuangModel;
    }

    public function getRooms($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->ruang->getRoom($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->ruang->getRoomRows($searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getRoomDetail($id)
    {
        $rooms = $this->ruang->getRoomDetail($id);        

        return $this->createResponse($rooms[0], 'is_admin');
    }

    public function delete()
    {
        if(is_admin())
        {
            $idString = $this->request->getPost('id');
            $idWrapper = [];
            if(strpos($idString, '-') !== false)
            {
                $idWrapper = explode('-', $idString);
                foreach($idWrapper as $id)
                {
                    $toArray = explode('-', $id);
                    $this->ruang->delete($toArray[0]);
                }
            }
            else 
            {
                $toArray = explode('-', $idString);
                $this->ruang->delete($toArray[0]);
            }

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function save($id = null)
    {
        if(is_admin())
        {
            $validation = $this->validation($id); // [0 => $rules, 1 => $messages]
            if(! validate($validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else 
            {
                $data = $this->formData();
                if($id === null) 
                {
                    $this->ruang->insert($data);
                }
                else
                {
                    $this->ruang->update($data, $id);
                }
                
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'room_code'    => "required|min_length[3]|max_length[10]|is_unique[tb_room.room_code,room_id,$id]",
            'room_name'    => 'required',
        ];

        $messages = [
            'room_code' => [
                'required'      => lang('AdminRuang.ruang_err_code_required'),
                'min_length'    => lang('AdminRuang.ruang_err_code_min'),
                'max_length'    => lang('AdminRuang.ruang_err_code_max'),
                'is_unique'     => lang('AdminRuang.ruang_err_code_duplicate'),
            ],
            'room_name' => [
                'required'  => lang('AdminRuang.ruang_err_name_req'),
            ],                  
        ];

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'room_code'    => $this->request->getPost('room_code'),
            'room_name'    => $this->request->getPost('room_name'),
        ];
    }

}