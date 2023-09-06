<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\PostModel;
use Actudent\Core\Libraries\Uploader;
use OstiumDate;

class Post extends \Actudent
{
    private $post;

    private $uploader;

    /**
     * The Constructor.
     */
    public function __construct()
    {
        $this->post = new PostModel;
        $this->uploader = new Uploader;
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

    public function getPostDetail($id)
    {
        $detail = $this->post->getPostDetail($id);
        $gallery = $this->post->getGallery($id);
        $postTime = explode(' ', $detail->created);
        $od = new OstiumDate;

        return $this->response->setJSON([
            'post'      => $detail,
            'gallery'   => $gallery,
            'time'      => $od->create($postTime[0], 'd-m-y', '-').' '.substr($postTime[1], 0, 5),
            'content'   => str_replace(['<script>', '</script>'], '', $detail->timeline_content)
        ]);
    }

    public function downloadMedia($postId)
    {
        $detail = $this->post->getPostDetail($postId);
        $gallery = $this->post->getGallery($postId);
        $featuredImage = explode('_', $detail->featured_image)[0] .'/'. $detail->featured_image;
        $images = [];
        foreach($gallery as $image) {
            $images[] = explode('_', $image->filename)[0]. '/' . $image->filename;
        }

        array_unshift($images, $featuredImage);
        $zip = new \Zipper(PUBLICPATH . 'images/posts/', true);
        $createZip = $zip->create($images, 'Post-Media', 'archive');

        return $this->createResponse([
            'files' => $images,
            'url'   => base_url('images/posts/archive/' . $createZip['output'])
        ]);
    }

    public function save($id = null)
    {
        if(valid_token()) {
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
                $data = [
                    'timeline_title'    => $this->request->getPost('timeline_title'),
                    'timeline_content'  => $this->request->getPost('timeline_content'),
                    'timeline_status'   => $this->request->getPost('timeline_status'),
                    'featured_image'    => $this->request->getPost('featured_image'),
                    'gallery'           => $this->request->getPost('imageGallery')
                ];
    
                if($id === null) {
                    $id = $this->post->insert($data);
                }
                else 
                {
                    $detail = $this->post->getPostDetail($id);
                    $getDate = explode('_', $detail->featured_image)[0];
                    $dirPath = "posts/$getDate";

                    // let Uploader class decides whether the featured image should be deleted or not
                    //$this->uploader->removePreviousImage($detail->featured_image, $data['featured_image'], $dirPath);

                    $id = $this->post->update($data, $id);
                }

                // insert gallery
                $images = json_decode($data['gallery'], true);
                $galleryValues = [];
                foreach($images as $img) {
                    $galleryValues[] = [
                        'timeline_id'   => $id,
                        'filename'      => $img
                    ];
                }

                $this->post->insertGallery($galleryValues);

                $response = [
                    'code'  => '200',
                    'id'    => $id, // return the timeline_id
                ];
                
                return $this->response->setJSON($response);
            }
        }
    }

    public function uploadFeaturedImage()
    {
        if(is_admin()) {
            $config = [
                'file'      => 'featured_image',
                'width'     => 1920,
                'height'    => 1200,
                'dir'       => 'posts/' . date('Y-m-d'),
                'maxSize'   => 10000,
                'crop'      => 'fit',
                'prefix'    => date('Y-m-d') . '_'
            ];

            $uploaded = $this->uploader->uploadImage($config);

            return $this->response->setJSON($uploaded);
        }
    }

    public function uploadImageGallery()
    {
        if(is_admin()) {
            $config = [
                'file'      => 'image_gallery',
                'width'     => 1920,
                'height'    => 1200,
                'dir'       => 'posts/' . date('Y-m-d'),
                'maxSize'   => 10000,
                'crop'      => 'fit',
                'prefix'    => date('Y-m-d') . '_gallery_',
            ];

            $uploaded = $this->uploader->uploadImage($config);

            return $this->response->setJSON($uploaded);
        }
    }

    public function removeImage($filename)
    {
        if(valid_token()) {
            $getDate = explode('_', $filename)[0];
            $dirPath = "posts/$getDate/";
            $this->uploader->removeImage($dirPath . $filename);

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function deleteFeaturedImage($postId)
    {
        if(valid_token()) {
            $detail = $this->post->getPostDetail($postId);
            $getDate = explode('_', $detail->featured_image)[0];
            $dirPath = "posts/$getDate/";
            $this->uploader->removeImage($dirPath . $detail->featured_image);
            $this->post->deleteFeaturedImage($postId);

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function deleteImageGallery($imageId)
    {
        if(valid_token()) {
            $detail = $this->post->getImageGallery($imageId);
            $getDate = explode('_', $detail->filename)[0];
            $dirPath = "posts/$getDate/";
            $this->uploader->removeImage($dirPath . $detail->filename);
            $this->post->deleteImageGallery($imageId);

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function delete()
    {
        if(valid_token()) {
            $post = $this->request->getPost('id');
            $post = json_decode($post, true);
            
            foreach($post as $id) {
                $detail = $this->post->getPostDetail($id);
                
                // delete featured image from storage
                $getDate = explode('_', $detail->featured_image)[0];
                $dirPath = "posts/$getDate/";
                $this->uploader->removeImage($dirPath . $detail->featured_image);
    
                // retrieve gallery
                $gallery = $this->post->getGallery($id);

                // delete image gallery from storage
                foreach($gallery as $g) {
                    $galleryPath = 'posts/'.explode('_', $g->filename)[0];
                    $this->uploader->removeImage($galleryPath . $g->filename);
                }
    
                // delete post and its gallery from database
                $this->post->delete($id);
            }

            return $this->response->setJSON(['status' => 'OK']);
        }
    }
    
    private function validation()
    {
        $rules = [
            'timeline_title'    => 'required',
        ];

        $messages = [
            'timeline_title' => [
                'required' => get_lang('AdminTimeline.timeline_title_required'),
            ],
        ];            

        return [$rules, $messages];
    }
}