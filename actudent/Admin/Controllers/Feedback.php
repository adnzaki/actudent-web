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

    public function feedbackValidation()
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
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    public function send($attachment = '')
    {
        $data = $this->formData();

        if(! empty($attachment))
        {
            $path = PUBLICPATH . 'attachments/email/' . $attachment;
            $file = new \CodeIgniter\Files\File($path);
            $attachment = $file->getRealPath();
        }        

        $email          = \Config\Services::email();
        $common         = $this->common();
        $type           = $data['feedback_type'];
        $description    = $data['feedback_description'];
        $sender         = 'feedback@' . $common['domainSekolah'];
        $subjectText    = '';
        switch ($type) {
            case 'Saran': $subjectText = "$type dari "; break;            
            case 'Bug': $subjectText = "Informasi $type dari "; break;
            case 'Bantuan': $subjectText = "Permintaan $type dari "; break;
            default: 'Unindentified subject'; break;
        }

        $email->setFrom($sender, $common['namaSekolah']);
        $email->setTo('wolesproject@gmail.com');
        $email->setSubject("{$type} dari " . session('nama') . ' (' . session('email') . ')');
        $email->setMessage($description);

        if(! empty($attachment))
        {
            $email->attach($attachment);            
        }

        if($email->send())
        {
            $email->send();
            if(file_exists($attachment))
            {
                unlink($attachment);
            }
            return $this->response->setJSON(['msg' => 'Feedback sent successfully']);
        }
        else
        {
            return $this->response->setJSON(['msg' => $email->printDebugger()]);
        }
    }

    public function uploadFile()
    {        
        $validated = $this->validateFile();

        if($validated) 
        {
            $attachment = $this->request->getFile('feedback_image');
            $newFilename = 'attachment_' . $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'attachments/email', $newFilename);           

            return $this->response->setJSON(['msg' => 'OK', 'attachment' => $newFilename]);
        }
        else 
        {
            return $this->response->setJSON($this->validation->getErrors());
        }
    }

    public function runFileValidation()
    {
        $validated = $this->validateFile();
        if($validated)
        {
            return $this->response->setJSON(['msg' => 'OK']);
        }
        else 
        {
            return $this->response->setJSON($this->validation->getErrors());
        }
    }

    private function validateFile()
    {
        $fileRules = [
            'feedback_image' => 'mime_in[feedback_image,image/jpeg]|max_size[feedback_image,2048]'
        ];
        $fileMessages = [
            'feedback_image' => [
                'mime_in' => lang('Admin.invalid_filetype'),
                'max_size' => lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'feedback_type'           => 'required',
            'feedback_description'    => "required|min_length[10]",            
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
}