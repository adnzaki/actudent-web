<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Feedback extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminFeedback.page_title');
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\feedback\feedback-view');
    }

    public function send($id = null)
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
            
            // $this->mapel->insert($data);
           
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'feedback_type'           => 'required',
            'feedback_description'    => "required|min_length[20]",            
        ];

        $messages = [
            'feedback_type' => [
                'required'  => lang('AdminFeedback.feedback_err_type_req'),
            ], 
            'feedback_description' => [
                'required'      => lang('AdminFeedback.feedback_err_desc_req'),
                'min_length'    => lang('AdminFeedback.feedback_err_desc_min'),                
            ],                             
        ];

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'feedback_type'           => $this->request->getPost('feedback_type'),
            'feedback_description'    => $this->request->getPost('feedback_description'),
        ];
    }

    // public function setWarnaTema($tema)
    // {
    //     $this->setting->setTheme($_SESSION['email'], $tema);
    //     return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    // }

    // public function setBahasa($bahasa)
    // {
    //     $this->setting->setUserLanguage($_SESSION['email'], $bahasa);
    //     return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    // }
}