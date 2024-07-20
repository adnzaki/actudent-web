<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\OrtuModel;

class Ortu extends \Actudent
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

    public function getParents($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->ortu->getParents($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->ortu->getParentRows($searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ], 'is_admin');
    }

    public function getParentDetail($id)
    {
        $parent = $this->ortu->getParentDetail($id);
        $children = $this->ortu->getChildren($id);
        $data = [
            'parent' => $parent[0],
            'children' => $children,
        ];

        return $this->createResponse($data, 'is_admin');
    }

    public function delete()
    {
        if(is_admin())
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
                'required'      => get_lang('AdminOrtu.ortu_err_kk_required'),
                'is_natural'    => get_lang('AdminOrtu.ortu_err_kk_numeric'),
                'exact_length'  => get_lang('AdminOrtu.ortu_err_kk_exact'),
                'is_unique'     => get_lang('AdminOrtu.ortu_err_kk_duplicate'),
            ],
            'parent_father_name' => [
                'required'  => get_lang('AdminOrtu.ortu_err_ayah'),
            ],
            'parent_mother_name' => [
                'required'  => get_lang('AdminOrtu.ortu_err_ibu'),
            ],
            'parent_phone_number' => [
                'required'      => get_lang('AdminOrtu.ortu_err_phone_require'),
                'is_natural'    => get_lang('AdminOrtu.ortu_err_phone_num'),
                'min_length'    => get_lang('AdminOrtu.ortu_err_phone_min'),
                'max_length'    => get_lang('AdminOrtu.ortu_err_phone_max'),
            ],
        ];

        if($id === null)
        {
            $insertRules = [
                'user_email'            => 'required|valid_email|is_unique[tb_user.user_email]',
                'user_password'         => 'required|min_length[8]',
                'user_password_confirm' => 'required|matches[user_password]'
            ];

            $insertMessages = [
                'user_email' => [
                    'required'      => get_lang('AdminUser.user_err_email_required'),
                    'is_unique'     => get_lang('AdminUser.user_err_email_unique'),
					'valid_email'   => get_lang('AdminPegawai.staff_err_email'),
                ],
                'user_password' => [
                    'required'      => get_lang('AdminUser.user_err_pass_required'),
                    'min_length'    => get_lang('AdminUser.user_err_pass_minchars'),
                ],
                'user_password_confirm' => [
                    'required'      => get_lang('AdminUser.user_err_passconf_required'),
                    'matches'       => get_lang('AdminUser.user_err_pass_confirm'),
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
        $fatherName = $this->request->getPost('parent_father_name');
        $motherName = $this->request->getPost('parent_mother_name');
        $userNameSelector = $this->request->getPost('user_name');
        $userName = $userNameSelector === '1' ? $fatherName : $motherName;

        return [
            'parent_family_card'    => $this->request->getPost('parent_family_card'),
            'parent_father_name'    => $fatherName,
            'parent_mother_name'    => $motherName,
            'parent_phone_number'   => $this->request->getPost('parent_phone_number'),
            'user_name'             => $userName,
            'user_email'            => $this->request->getPost('user_email'),
            'user_password'         => $this->request->getPost('user_password'),
        ];
    }
}
