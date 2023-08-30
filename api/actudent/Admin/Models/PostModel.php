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
     * @param int $timelineID
     * 
     * @return array
     */
    public function getPostDetail(int $timelineID): array
    {
        $field = "timeline_id, timeline_title, timeline_content, timeline_date, 
                  timeline_image, timeline_status, {$this->post}.created, user_name as author";
        $join = $this->QBPost->select($field)
                ->join($this->user, "{$this->user}.user_id = {$this->post}.user_id");
        return $join->where(['timeline_id' => $timelineID])->get()->getResult();
    }

    /**
     * Insert data from user input to tb_timeline 
     * 
     * @param string $status
     * @param array $data
     * 
     * @return int
     */
    public function insert(string $status, array $value): int
    {
        $data = $this->fillTimelineField($value);
        $data['user_id'] = session()->get('id');
        $data['timeline_status'] = $status;
        $this->QBPost->insert($data);

        // return the insertID
        return $this->db->insertID();
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
    public function update(string $status, array $value, int $id): int
    {
        $data = $this->fillTimelineField($value);
        $data['timeline_status'] = $status;
        $this->QBPost->update($data, ['timeline_id' => $id]);

        // return the ID for image upload
        return $id;
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
        $this->QBPost->delete(['timeline_id' => $id]);

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
            'timeline_date'     => date('Y-m-d H:i:s'),
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
            // Store search parameter "timeline_title-timeline_content",
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $join->like($searchBy[0], $search); 
                $join->orLike($searchBy[1], $search); 
            }
            else 
            {
                $join->like($searchBy, $search); // search by one parameter
            }
        }

        return $join;
    }
}