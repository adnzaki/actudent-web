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

        return parse('Actudent\Admin\Views\ortu\ortu-view', $data);
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

    public function getParentDetail($id)
    {
        $parent = $this->ortu->getParentDetail($id);
        $children = $this->ortu->getChildren($id);
        $data = [
            'parent' => $parent[0],
            'children' => $children,
        ];

        return $this->response->setJSON($data);
    }

    public function delete()
    {
        $idString = $this->request->getPost('id');
        $idWrapper = [];
        if(strpos($idString, '&') !== false)
        {
            $idWrapper = explode('&', $idString);
            foreach($idWrapper as $id)
            {
                $toArray = explode('-', $id);
                $this->ortu->delete($toArray[0], $toArray[1]);
            }
        }
        else 
        {
            $toArray = explode('-', $idString);
            $this->ortu->delete($toArray[0], $toArray[1]);
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
                $this->ortu->insert($data);
            }
            else
            {
                $this->ortu->update($data, $id);
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
            'parent_family_card'    => "required|is_natural|exact_length[16]|is_unique[tb_parent.parent_family_card,parent_id,$id]",
            'parent_father_name'    => 'required',
            'parent_mother_name'    => 'required',
            'parent_phone_number'   => 'required|is_natural|min_length[11]|max_length[13]',
        ];

        $messages = [
            'parent_family_card' => [
                'required'      => lang('AdminOrtu.ortu_err_kk_required'),
                'is_natural'       => lang('AdminOrtu.ortu_err_kk_numeric'),
                'exact_length'  => lang('AdminOrtu.ortu_err_kk_exact'),
                'is_unique'     => lang('AdminOrtu.ortu_err_kk_duplicate'),
            ],
            'parent_father_name' => [
                'required'  => lang('AdminOrtu.ortu_err_ayah'),
            ],
            'parent_mother_name' => [
                'required'  => lang('AdminOrtu.ortu_err_ibu'),
            ],
            'parent_phone_number' => [
                'required'      => lang('AdminOrtu.ortu_err_phone_require'),
                'is_natural'       => lang('AdminOrtu.ortu_err_phone_num'),
                'min_length'    => lang('AdminOrtu.ortu_err_phone_min'),
                'max_length'    => lang('AdminOrtu.ortu_err_phone_max'),
            ],            
        ];      

        if($id === null) 
        {
            $insertRules = [
                'user_email'            => 'required|is_unique[tb_user.user_email]',
                'user_password'         => 'required|min_length[8]',
                'user_password_confirm' => 'required|matches[user_password]'
            ];

            $insertMessages = [
                'user_email' => [
                    'required'      => lang('AdminUser.user_err_email_required'),
                    'is_unique'     => lang('AdminUser.user_err_email_unique'),
                ],
                'user_password' => [
                    'required'      => lang('AdminUser.user_err_pass_required'),
                    'min_length'    => lang('AdminUser.user_err_pass_minchars'),
                ],
                'user_password_confirm' => [
                    'required'      => lang('AdminUser.user_err_passconf_required'),
                    'matches'       => lang('AdminUser.user_err_pass_confirm'),
                ],
            ];

            foreach($insertRules as $rule => $val)
            {
                $rules[$rule] = $val;
            }

            foreach($insertMessages as $msg => $val)
            {
                $messages[$msg] = $val;
            }
        }
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'parent_family_card'    => $this->request->getPost('parent_family_card'),
            'parent_father_name'    => $this->request->getPost('parent_father_name'),
            'parent_mother_name'    => $this->request->getPost('parent_mother_name'),
            'parent_phone_number'   => $this->request->getPost('parent_phone_number'),
            'user_name'             => $this->request->getPost('user_name'),
            'user_email'            => $this->request->getPost('user_email'),
            'user_password'         => $this->request->getPost('user_password'),
        ];
    }
}