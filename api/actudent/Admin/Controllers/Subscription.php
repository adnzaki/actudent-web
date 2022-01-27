<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Models\SubscriptionModel;

class Subscription extends \Actudent
{
    public function index()
	{
        if(! $this->isPrimaryAdmin())
        {
            return redirect()->to(base_url('admin/home'));
        }
        else 
        {
            $data = $this->common();
            $data['title'] = lang('AdminLangganan.title');
            return parse('Actudent\Admin\Views\langganan\langganan-view', $data);
        }
    }

    private function isPrimaryAdmin()
    {
        return session('id') === '1' ? true : false;
    }

    public function getPackage()
    {
        if($this->isPrimaryAdmin())
        {
            $subscription = new SubscriptionModel;
            return $this->response->setJSON($subscription->getPackageDetail());
        }
    }

    public function sendRequest()
    {
        if(! $this->isPrimaryAdmin())
        {
            return $this->response->setJSON(['msg' => 'You do not have access to this page.']);
        }
        else 
        {
            $data = $this->formData();
    
            $config = [
                // 'protocol'  => 'smtp',
                'mailType'  => 'html',
                // 'SMTPHost'  => 'mail.actudent.com',
                // 'SMTPUser'  => '_mainaccount@actudent.com',
                // 'SMTPPass'  => '&LxNm1nU8I',
                // 'SMTPPort'  => 465,
            ];
            $email              = \Config\Services::email();
            $email->initialize($config);
            $common             = $this->common();
            $sender             = session('email');
            $marketing          = 'marketing@actudent.com';
            $subject            = 'Informasi Pemesanan Actudent';
            $message            = "
                Nama: ".session('nama')."<br>
                Jabatan: Administrator Actudent <br>
                Email: $sender <br>
                Paket Layanan: ".ucfirst($data['package_type'])."<br>
                Durasi: {$data['package_duration']} Tahun<br>
                Alasan Pemesanan: Perpanjang masa aktif Actudent
            ";
    
            $email->setFrom($sender, session('nama'));
            $email->setTo($marketing);
            $email->setReplyTo($data['package_email']);
            $email->setSubject($subject);
            $email->setMessage($message);
    
            if($email->send())
            {
                // send back email to user
                $reply = 'Halo, ' . session('nama') . '! Terima kasih telah mengajukan perpanjangan
                        layanan Actudent. Permintaan anda anda akan segera diproses, mohon tunggu
                        informasi selanjutnya.<br><br>
                        Salam, <br><br><br>Wolestech';
                $email->setFrom($marketing, 'Actudent Marketing Team');
                $email->setTo($data['package_email']);
                $email->setSubject('Permintaan anda telah kami terima');
                $email->setMessage($reply);
                $email->send();
                return $this->response->setJSON(['msg' => 'Request sent successfully']);
            }
            else
            {
                return $this->response->setJSON(['msg' => $email->printDebugger()]);
            }
        }
    }

    public function validateForm()
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

    private function validation()
    {
        $data = $this->formData();
        $rules = [
            'package_email'     => 'required|valid_email',
            'package_type'      => 'required',
            'package_duration'  => 'required|is_natural',
        ];

        $messages = [
            'package_email' => [
                'required'      => lang('AdminFeedback.feedback_err_email_req'),
                'valid_email'   => lang('AdminFeedback.feedback_err_invalid_email')
            ],
            'package_type' => [
                'required'      => lang('AdminLangganan.subs_type_required'),
            ],
            'package_duration' => [
                'required'      => lang('AdminLangganan.subs_duration_required'),
                'is_natural'    => lang('AdminLangganan.subs_duration_natural'),
            ]
        ];

        return [$rules, $messages];
    }

    public function formData() 
    {
        return [
            'package_email'     => $this->request->getPost('package_email'),
            'package_type'      => $this->request->getPost('package_type'),
            'package_duration'  => $this->request->getPost('package_duration'),
        ];
    }
}