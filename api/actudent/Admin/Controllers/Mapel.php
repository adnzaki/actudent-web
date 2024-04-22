<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\MapelModel;

class Mapel extends \Actudent
{
    private $mapel;

    public function __construct()
    {
        $this->mapel = new MapelModel;
    }

    public function getLessons($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->mapel->getLesson($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->mapel->getLessonRows($searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ], 'is_admin');
    }

    public function getLessonDetail($id)
    {
        $lessons = $this->mapel->getLessonDetail($id);

        return $this->createResponse($lessons[0], 'is_admin');
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
                    $this->mapel->delete($id);
                }
            }
            else
            {
                $this->mapel->delete($idString);
            }

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function save($id = null)
    {
        if(is_admin())
        {
			$validation = $this->validation($id); // [0 => $rules, 1 => $messages]
			$data = $this->request->getPost(array_keys($validation[0]));
            if(! $this->validateForms($data, $validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else
            {
                if($id === null)
                {
                    $this->mapel->insert($data);
                }
                else
                {
                    $this->mapel->update($data, $id);
                }

                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    private function validation($id)
    {
        $rules = [
            'lesson_code'    => "required|min_length[3]|max_length[10]|is_unique[tb_lessons.lesson_code,lesson_id,$id]",
            'lesson_name'    => 'required',
        ];

        $messages = [
            'lesson_code' => [
                'required'      => get_lang('AdminMapel.mapel_err_code_required'),
                'min_length'    => get_lang('AdminMapel.mapel_err_code_min'),
                'max_length'    => get_lang('AdminMapel.mapel_err_code_max'),
                'is_unique'     => get_lang('AdminMapel.mapel_err_code_duplicate'),
            ],
            'lesson_name' => [
                'required'  => get_lang('AdminMapel.mapel_err_name_req'),
            ],
        ];

        return [$rules, $messages];
    }
}
