<?php namespace Actudent\Admin\Models;

class TimelineModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builders
     */
    private $QBTimeline;
    private $QBTimelineComments;

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
}