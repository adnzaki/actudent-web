<?php namespace Actudent\Admin\Models;

class PostModel extends \Actudent\Admin\Models\SharedModel
{
    /**
     * Query Builders
     */
    private $QBPost;
    private $QBPostImages;

    /**
     * tb_timeline table
     * 
     * @var string
     */
    private $post = 'tb_timeline';

    /**
     * tb_timeline_comments table
     * 
     * @var string
     */
    private $postImage = 'tb_timeline_images';

    /**
     * The constructor
     * Set query builders
     *
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->QBPost = $this->db->table($this->post);
        $this->QBPostImages = $this->db->table($this->postImage);
    }

    /**
     * Get timeline posts
     * 
     * @param string $type "all" | "draft" | "public"
     * @param int|string $mypost
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search
     * 
     * @return array
     */
    public function getPosts($type, $mypost, $limit, $offset, $orderBy, $searchBy, $sort, $search = ''): array
    {
        if($orderBy === 'date') {
            $orderBy = "{$this->post}.created";
        }

        $params = $this->postParams($type, $mypost);
        $query = $this->search($searchBy, $search)->where($params)->orderBy($orderBy, $sort)->limit($limit, $offset);

        return $query->get()->getResult();        
    }

    /**
     * Get total rows of posts  
     * 
     * @param string $type
     * @param int|string $mypost
     * @param string $orderBy
     * @param string $searchBy
     * 
     * @return int
     */
    public function getPostRows($type, $mypost, $searchBy, $search): int
    {
        $params = $this->postParams($type, $mypost);
        $query = $this->search($searchBy, $search)->getWhere($params);

        return $query->getNumRows();
    }

    private function postParams(string $type, $mypost)
    {
        $params = ["{$this->post}.deleted !=" => 1];

        if($type !== 'all') {
            $params = array_merge($params, ['timeline_status' => $type]);
        }

        if((int)$mypost === 1) {
            if(valid_token()) {
                $params = array_merge($params, ["{$this->post}.user_id" => user_data()->user_id]);
            }
        }

        return $params;
    }

    /**
     * Get post detail
     * 
     * @param int $id
     * 
     * @return object
     */
    public function getPostDetail(int $id): object
    {
        $field = "timeline_id, timeline_title, timeline_content, featured_image, 
                  timeline_status, {$this->post}.created, user_name as author";
        $join = $this->QBPost->select($field)
                ->join($this->user, "{$this->user}.user_id = {$this->post}.user_id");
        return $join->where(['timeline_id' => $id])->get()->getResult()[0];
    }

    public function getGallery(int $postId): array
    {
        $query = $this->QBPostImages->getWhere(['timeline_id' => $postId]);

        return $query->getResult();
    }

    public function getImageGallery(int $id)
    {
        $query = $this->QBPostImages->getWhere(['id' => $id]);

        return $query->getResult()[0];
    }

    public function deleteImageGallery(int $id)
    {
        $this->QBPostImages->delete(['id' => $id]);
    }

    /**
     * Insert data from user input to tb_timeline 
     * 
     * @param array $data
     * 
     * @return int
     */
    public function insert(array $value): int
    {
        $data = $this->fillTimelineField($value);
        if(valid_token()) {
            $data['user_id'] = user_data()->user_id;
        }

        $this->QBPost->insert($data);

        // return the insertID
        return $this->db->insertID();
    }

    public function deleteFeaturedImage($postId)
    {
        $this->QBPost->update(['featured_image' => null], ['timeline_id' => $postId]);
    }

    /**
     * Update timeline
     * 
     * @param string $status
     * @param array $value
     * @param int $id
     * 
     * @return int
     */
    public function update(array $value, int $id): int
    {
        $data = $this->fillTimelineField($value);
        $this->QBPost->update($data, ['timeline_id' => $id]);

        // return the ID for image upload
        return $id;
    }

    public function insertGallery(array $images) 
    {
        if(count($images) > 0) {
            $this->QBPostImages->insertBatch($images);
        }
    }

    /**
     * Delete timeline and related data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function delete(int $id): void
    {
        // transaction started
        $this->db->transStart();
        $this->QBPostImages->delete(['timeline_id' => $id]);
        $this->QBPost->update(['deleted' => 1], ['timeline_id' => $id]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Data to be filled in tb_timeline
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillTimelineField(array $data): array
    {
        return [
            'timeline_title'    => $data['timeline_title'],
            'timeline_content'  => $data['timeline_content'],
            'timeline_status'   => $data['timeline_status'],
            'featured_image'    => $data['featured_image']
        ];
    }

    /**
     * Set the attachment from user input
     * 
     * @param string $filename
     * @param int $id
     * 
     * @return void
     */
    public function setAttachment(string $filename, int $id): void
    {        
        $this->QBPost->where('timeline_id', $id)->update(['timeline_image' => $filename]);
    }

    private function search(string $searchBy, string $search)
    {
        $field = "timeline_id, timeline_title, timeline_content, timeline_date, timeline_status, 
                  featured_image, {$this->post}.created, {$this->post}.user_id, user_name as author";

        $select = $this->QBPost->select($field);
        $join = $select->join($this->user, "{$this->user}.user_id = {$this->post}.user_id");
        if(! empty($search))
        {
            // Store search parameter "timeline_title-timeline_content-created",
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $join->like($searchBy[0], $search); 
                $join->orLike($searchBy[1], $search); 
                $join->orLike($searchBy[2], $search); 
            }
            else 
            {
                $join->like($searchBy, $search); // search by one parameter
            }
        }

        return $join;
    }
}