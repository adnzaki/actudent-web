<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\MapelModel;

class Mapel extends Actudent
{
    /**
     * @var Actudent\Admin\Models\MapelModel
     */
    private $mapel;

    public function __construct()
    {
        $this->mapel = new MapelModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminMapel.page_title');

        return parse('Actudent\Admin\Views\mapel\mapel-view', $data);
    }

    public function getLessons($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->mapel->getLesson($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->mapel->getLessonRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getLessonDetail($id)
    {
        $lessons = $this->mapel->getLessonDetail($id);        
        $data = [
            'lesson' => $lessons[0],
        ];
        return $this->response->setJSON($data);
    }

    public function delete($idString)
    {
        $idWrapper = [];
        if(strpos($idString, '&') !== false)
        {
            $idWrapper = explode('&', $idString);
            foreach($idWrapper as $id)
            {
                $toArray = explode('-', $id);
                $this->mapel->delete($toArray[0]);
            }
        }
        else 
        {
            $toArray = explode('-', $idString);
            $this->mapel->delete($toArray[0]);
        }
        return $this->response->setJSON(['status' => 'OK']);
    }

    public function save($id = null)
    {
        $validation = $this->validation($id); // [0 => $rules, 1 => $messages]
        if(! $this->validate($validation[0], $validation[1]))
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

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'lesson_code'    => "required|min_length[3]|max_length[10]|is_unique[tb_lessons.lesson_code,lesson_id,$id]",
            'lesson_name'    => 'required',
        ];

        $messages = [
            'lesson_code' => [
                'required'      => lang('AdminMapel.mapel_err_code_required'),
                'min_length'    => lang('AdminMapel.mapel_err_code_min'),
                'max_length'    => lang('AdminMapel.mapel_err_code_max'),
                'is_unique'     => lang('AdminMapel.mapel_err_code_duplicate'),
            ],
            'lesson_name' => [
                'required'  => lang('AdminMapel.mapel_err_name_req'),
            ],                  
        ];

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'lesson_code'    => $this->request->getPost('lesson_code'),
            'lesson_name'    => $this->request->getPost('lesson_name'),
        ];
    }
}