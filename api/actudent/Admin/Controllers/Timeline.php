<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\TimelineModel;

class Timeline extends \Actudent
{
    /**
     * TimelineModel
     * 
     * @var object
     */
    private $timeline;

    /**
     * The Constructor.
     */
    public function __construct()
    {
        $this->timeline = new TimelineModel;
    }

    public function getPosts($limit, $offset)
    {
        $data = $this->timeline->getPosts($limit, $offset);
        $formatted = [];
        foreach($data as $d)
        {
            // fetch comments
            $d->comments = $this->getPostComments($d->timeline_id, 5, 0);

            // push them into the formatted data
            array_push($formatted, $d);
        }
        
        return $this->response->setJSON([
            'timeline' => $data,
            'rows' => $this->timeline->getTimelineRows(),
        ]);
    }

    private function getPostComments($timelineID, $limit, $offset)
    {
        $parentComments = $this->timeline->getPostComments($timelineID, $limit, $offset);
        $groupedComments = [];
        foreach($parentComments as $pc)
        {
            $replies = $this->timeline->getCommentReplies($pc->timeline_comment_id);
            $pc->replies = count($replies);
            array_push($groupedComments, $pc);
        }

        return $groupedComments;
    }

    public function getPostDetail($timelineID)
    {
        return $this->response->setJSON($this->timeline->getPostDetail($timelineID)[0]);
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
                    'id' => $this->timeline->insert($status, $data), // return the insert_id
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
                    'id' => $this->timeline->update($status, $data, $id), // return the timeline_id
                ];
            }
            
            return $this->response->setJSON($response);
        }
    }

    public function delete($id)
    {
        $timeline = $this->timeline->getPostDetail($id)[0];
        
        // remove featured image from storage
        $featuredImage = PUBLICPATH . 'attachments/timeline/' . $timeline->timeline_image;
        if(file_exists($featuredImage))
        {
            unlink($featuredImage);
        }

        $this->timeline->delete($id);
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
                'required' => lang('AdminTimeline.timeline_title_required'),
            ],
            'image_feature' => [
                'required' => lang('AdminTimeline.timeline_image_required'),
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
            $this->timeline->setAttachment($newFilename, $insertID);
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
                'mime_in' => lang('Admin.invalid_filetype'),
                'max_size' => lang('Admin.file_too_large'),
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