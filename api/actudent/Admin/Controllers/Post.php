<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\PostModel;

class Post extends \Actudent
{
    private $post;

    /**
     * The Constructor.
     */
    public function __construct()
    {
        $this->post = new PostModel;
    }

    public function getPosts($type, $mypost, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->post->getPosts($type, $mypost, $limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->post->getPostRows($type, $mypost, $searchBy, $search);

        foreach($data as $d) {
            $d->editable = $this->isEditable($d->user_id) ? 1 : 0;
        }
        
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function isEditable($author)
    {
        if(valid_token()) {
            $user = user_data();
    
            if($user->user_level === '1') {
                return true;
            } else {
                if($author === $user->user_id) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function getPostDetail($timelineID)
    {
        return $this->response->setJSON($this->post->getPostDetail($timelineID)[0]);
    }

    public function save($status, $id = null)
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
            if($id === null) 
            {
                $response = [
                    'code' => '200',
                    'id' => $this->post->insert($status, $data), // return the insert_id
                ];
            }
            else 
            {
                if($data['current_image'] !== $data['image_feature'])
                {
                    $path = PUBLICPATH . 'attachments/timeline/';
                    if(file_exists($path . $data['current_image']))
                    {
                        unlink($path . $data['current_image']);
                    }
                }
                
                $response = [
                    'code' => '200',
                    'id' => $this->post->update($status, $data, $id), // return the timeline_id
                ];
            }
            
            return $this->response->setJSON($response);
        }
    }

    public function delete($id)
    {
        $timeline = $this->post->getPostDetail($id)[0];
        
        // remove featured image from storage
        $featuredImage = PUBLICPATH . 'attachments/timeline/' . $timeline->timeline_image;
        if(file_exists($featuredImage))
        {
            unlink($featuredImage);
        }

        $this->post->delete($id);
        return $this->response->setJSON(['status' => 'OK']);
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'timeline_title' => 'required',
            'image_feature' => 'required',
        ];

        $messages = [
            'timeline_title' => [
                'required' => get_lang('AdminTimeline.timeline_title_required'),
            ],
            'image_feature' => [
                'required' => get_lang('AdminTimeline.timeline_image_required'),
            ],
        ];            

        return [$rules, $messages];
    }

    public function uploadFile($insertID)
    {        
        $validated = $this->validateFile();

        if($validated) 
        {
            $attachment = $this->request->getFile('timeline_image');
            $newFilename = 'img_' . $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'attachments/timeline', $newFilename);

            $image = \Config\Services::image();
            $image->withFile(PUBLICPATH . 'attachments/timeline/' . $newFilename)
                  ->fit(1280, 800)
                  ->save(PUBLICPATH . 'attachments/timeline/' . $newFilename);

            // Set attachment
            $this->post->setAttachment($newFilename, $insertID);
            return $this->response->setJSON(['msg' => 'OK']);
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
            'timeline_image' => 'mime_in[timeline_image,image/jpeg]|max_size[timeline_image,2048]'
        ];
        $fileMessages = [
            'timeline_image' => [
                'mime_in' => get_lang('Admin.invalid_filetype'),
                'max_size' => get_lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    private function formData()
    {
        $data = [
            'timeline_title'    => $this->request->getPost('timeline_title'),
            'timeline_content'  => $this->request->getPost('timeline_content'),
            'image_feature'     => $this->request->getPost('image_feature'),
            'current_image'     => $this->request->getPost('current_image'),
        ];

        return $data;
    } 
}