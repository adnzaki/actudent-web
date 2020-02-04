<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\OrtuModel;

class Ortu extends Actudent
{
    /**
     * @var Actudent\Admin\Models\OrtuModel
     */
    private $ortu;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ortu = new OrtuModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminOrtu.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\ortu\ortu-view');
    }

    public function getParents($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->ortu->getParents($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->ortu->getParentRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function save($id = null)
    {
        $validation = $this->validation(); // [0 => $rules, 1 => $messages]
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
            $this->ortu->insert($data);
            if($id === null) 
            {
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    public function selectUser($userID)
    {
        $check = $this->ortu->selectUser($userID);
        if(! $check)
        {
            return $this->response->setJSON(['msg' => lang('AdminOrtu.ortu_user_selected')]);
        }
        else 
        {
            return $this->response->setJSON([
                'msg' => 'OK',
                'data' => $check[0],
            ]);
        }
    }

    public function searchUser($param = '')
    {
        if(! empty($param))
        {
            return $this->response->setJSON($this->ortu->searchUser($param));            
        }
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'user_id'               => 'required|numeric',
            'parent_family_card'    => 'required|numeric|exact_length[16]',
            'parent_father_name'    => 'required',
            'parent_mother_name'    => 'required',
            'parent_phone_number'   => 'required|numeric|min_length[11]|max_length[13]',
        ];

        $messages = [
            'user_id' => [
                'required'      => lang('AdminOrtu.ortu_err_uid_required'),
                'numeric'       => lang('AdminOrtu.ortu_err_uid_numeric'),
            ],
            'parent_family_card' => [
                'required'      => lang('AdminOrtu.ortu_err_kk_required'),
                'numeric'       => lang('AdminOrtu.ortu_err_kk_numeric'),
                'exact_length'  => lang('AdminOrtu.ortu_err_kk_exact')
            ],
            'parent_father_name' => [
                'required'  => lang('AdminOrtu.ortu_err_ayah'),
            ],
            'parent_mother_name' => [
                'required'  => lang('AdminOrtu.ortu_err_ibu'),
            ],
            'parent_phone_number' => [
                'required'      => lang('AdminOrtu.ortu_err_phone_require'),
                'numeric'       => lang('AdminOrtu.ortu_err_phone_num'),
                'min_length'    => lang('AdminOrtu.ortu_err_phone_min'),
                'max_length'    => lang('AdminOrtu.ortu_err_phone_max'),
            ],
        ];      
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'user_id'               => $this->request->getPost('user_id'),
            'parent_family_card'    => $this->request->getPost('parent_family_card'),
            'parent_father_name'    => $this->request->getPost('parent_father_name'),
            'parent_mother_name'    => $this->request->getPost('parent_mother_name'),
            'parent_phone_number'   => $this->request->getPost('parent_phone_number'),
        ];
    }
}