<?php namespace Actudent\Admin\Models;

class TimelineModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builders
     */
    private $QBTimeline;
    private $QBTimelineComments;
    private $QBTimelineLikes;

    /**
     * tb_timeline table
     * 
     * @var string
     */
    private $timeline = 'tb_timeline';

    /**
     * tb_timeline_comments table
     * 
     * @var string
     */
    private $timelineComments = 'tb_timeline_comments';

    /**
     * tb_timeline_likes table
     * 
     * @var string
     */
    private $timelineLikes = 'tb_timeline_likes';

    /**
     * tb_user
     * 
     * @var string
     */
    private $user = 'tb_user';

    /**
     * The constructor
     * Set query builders
     *
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->QBTimeline = $this->db->table($this->timeline);
        $this->QBTimelineComments = $this->db->table($this->timelineComments);
        $this->QBTimelineLikes = $this->db->table($this->timelineLikes);
    }

    /**
     * Get timeline posts
     * 
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    public function getPosts($limit, $offset)
    {
        $field = 'timeline_id, timeline_title, timeline_content, timeline_date, 
                  timeline_image, timeline_status, user_name as author';
        $join = $this->QBTimeline->select($field)
                ->join($this->user, "{$this->user}.user_id = {$this->timeline}.user_id");
        $query = $join->orderBy('timeline_date', 'DESC')->limit($limit, $offset);

        return $query->get()->getResult();        
    }

    /**
     * Get total rows of timeline
     * 
     * @return int
     */
    public function getTimelineRows()
    {
        return $this->QBTimeline->countAllResults();
    }

    /**
     * Get post's comments
     * 
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    public function getPostComments($timelineID, $limit, $offset)
    {
        $query = $this->getAllComments()->where([
            'timeline_id' => $timelineID, 'comment_parent' => null
        ])->limit($limit, $offset);

        return $query->get()->getResult();
    }

    /**
     * Get replies from a comment
     * 
     * @param int $parentComment
     * @return object
     */
    public function getCommentReplies($parentComment)
    {
        return $this->getAllComments()->where(['comment_parent' => $parentComment])->get()->getResult();
    }

    /**
     * Get all comments (parent and child comments)
     * 
     * @return QueryBuilder
     */
    private function getAllComments()
    {
        $field = "timeline_id, timeline_comment_id, user_name as commenter, 
                  comment_parent, comment_content, {$this->timelineComments}.created";
        $join = $this->QBTimelineComments->select($field)->join($this->user, "{$this->user}.user_id = {$this->timelineComments}.user_id");

        return $join;
    }

    /**
     * Insert data from user input to tb_timeline 
     * 
     * @param string $status
     * @param array $data
     * @return int
     */
    public function insert($status, $value)
    {
        $data = $this->fillTimelineField($value);
        $data['user_id'] = session()->get('id');
        $data['timeline_status'] = $status;
        $this->QBTimeline->insert($data);

        // return the insertID
        return $this->db->insertID();
    }

    /**
     * Update timeline
     * 
     * @param string $status
     * @param array $data
     * @param int $id
     */
    public function update($status, $value, $id)
    {
        $data = $this->fillTimelineField($value);
        $data['timeline_status'] = $status;
        $this->QBTimeline->update($data, ['timeline_id' => $id]);

        // return the ID for image upload
        return $id;
    }

    /**
     * Delete timeline and related data
     * 
     * @param int $id 
     * @return void
     */
    public function delete($id)
    {
        // transaction started
        $this->db->transStart();
        $this->QBTimelineComments->delete(['timeline_id' => $id]);
        $this->QBTimelineLikes->delete(['timeline_id' => $id]);
        $this->QBTimeline->delete(['timeline_id' => $id]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Data to be filled in tb_timeline
     * 
     * @param array $data
     * @return array
     */
    private function fillTimelineField($data)
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
    public function setAttachment($filename, $id)
    {        
        $this->QBTimeline->where('timeline_id', $id)->update(['timeline_image' => $filename]);
    }
}