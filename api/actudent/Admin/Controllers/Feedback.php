<?php namespace Actudent\Admin\Controllers;

use CodeIgniter\Files\File;

class Feedback extends \Actudent
{
    public function send($attachment = '')
    {
        $data = $this->formData();

        if(! empty($attachment))
        {
            $path = PUBLICPATH . 'attachments/email/' . $attachment;
            $file = new File($path);
            $attachment = $file->getRealPath();
        }        

        $email              = \Config\Services::email();
        $config['mailType'] = 'html';
        $email->initialize($config);
        $common             = $this->common();
        $type               = $data['feedback_type'];
        $description        = $data['feedback_description'];
        $sender             = 'feedback@' . $common['domainSekolah'];
        $subjectText        = '';
        switch ($type) {
            case 'Saran': $subjectText = "$type dari "; break;            
            case 'Bug': $subjectText = "Informasi $type dari "; break;
            case 'Bantuan': $subjectText = "Permintaan $type dari "; break;
            default: 'Unindentified subject'; break;
        }

        $email->setFrom($sender, $common['namaSekolah']);
        $email->setTo('wolesproject@gmail.com');
        $email->setSubject($subjectText . session('nama') . ' (' . session('email') . ')');
        $email->setMessage($description);

        if(! empty($attachment))
        {
            $email->attach($attachment);            
        }

        if($email->send())
        {
            if(file_exists($attachment))
            {
                unlink($attachment);
            }

            // send back email to user
            $reply = 'Halo, ' . session('nama') . '! Terima kasih telah mengirimkan umpan balik
                    ke Wolestech, informasi anda sangat berguna untuk pengembangan Actudent selanjutnya. 
                    Silakan balas pesan ini untuk kontak lebih lanjut dengan kami.<br><br>
                    Salam Hangat, <br><br><br>ActudentDev Team (Wolestech)';
            $email->clear(true);
            $email->setFrom('support@actudent.com', 'Actudent Support Service');
            $email->setTo($data['feedback_email']);
            $email->setSubject('Terima kasih telah mengirim umpan balik untuk Actudent!');
            $email->setMessage($reply);
            $email->send();
            return $this->response->setJSON(['msg' => 'Feedback sent successfully']);
        }
        else
        {
            return $this->response->setJSON(['msg' => $email->printDebugger()]);
        }
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

    public function uploadFile()
    {        
        $validated = $this->validateFile();

        if($validated) 
        {
            $attachment = $this->request->getFile('feedback_image');
            $newFilename = 'attachment_' . $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'attachments/email', $newFilename);    
            
            $path = PUBLICPATH . 'attachments/email/' . $newFilename;
            $file = new File($path);

            return $this->response->setJSON([
                'msg' => 'OK', 
                'attachment' => $newFilename,
                'filesize' => ($file->getSize() / 250),
            ]);
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
                'mime_in' => get_lang('Admin.invalid_filetype'),
                'max_size' => get_lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'feedback_type'         => 'required',
            'feedback_description'  => "required|min_length[10]",    
            'feedback_email'        => 'required|valid_email',
        ];

        $messages = [
            'feedback_type' => [
                'required'      => get_lang('AdminFeedback.feedback_err_type_req'),
            ], 
            'feedback_description' => [
                'required'      => get_lang('AdminFeedback.feedback_err_desc_req'),
                'min_length'    => get_lang('AdminFeedback.feedback_err_desc_min'),                
            ],         
            'feedback_email' => [
                'required'      => get_lang('AdminFeedback.feedback_err_email_req'),
                'valid_email'   => get_lang('AdminFeedback.feedback_err_invalid_email')
            ],
        ];

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'feedback_type'         => $this->request->getPost('feedback_type'),
            'feedback_description'  => $this->request->getPost('feedback_description'),
            'feedback_email'        => $this->request->getPost('feedback_email'),
        ];
    }
}