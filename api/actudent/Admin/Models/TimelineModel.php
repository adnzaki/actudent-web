<?php namespace Actudent\Admin\Models;

class TimelineModel extends \Actudent\Core\Models\Connector
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
     * @return array
     */
    public function getPosts(int $limit, int $offset): array
    {
        $field = "timeline_id, timeline_title, timeline_content, timeline_date, 
                  timeline_image, timeline_status, {$this->timeline}.created, user_name as author";
        $join = $this->QBTimeline->select($field)
                ->join($this->user, "{$this->user}.user_id = {$this->timeline}.user_id");
        $query = $join->orderBy("{$this->timeline}.created", 'DESC')->limit($limit, $offset);

        return $query->get()->getResult();        
    }

    /**
     * Get total rows of timeline
     * 
     * @return int
     */
    public function getTimelineRows(): int
    {
        return $this->QBTimeline->countAllResults();
    }

    /**
     * Get post's comments
     * 
     * @param int $timelineID
     * @param int $limit
     * @param int $offset
     * 
     * @return array
     */
    public function getPostComments(int $timelineID, int $limit, int $offset): array
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
     * 
     * @return array
     */
    public function getCommentReplies(int $parentComment): array
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
     * Get post detail
     * 
     * @param int $timelineID
     * 
     * @return array
     */
    public function getPostDetail(int $timelineID): array
    {
        $field = "timeline_id, timeline_title, timeline_content, timeline_date, 
                  timeline_image, timeline_status, {$this->timeline}.created, user_name as author";
        $join = $this->QBTimeline->select($field)
                ->join($this->user, "{$this->user}.user_id = {$this->timeline}.user_id");
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
        $this->QBTimeline->insert($data);

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
        $this->QBTimeline->update($data, ['timeline_id' => $id]);

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
        $this->QBTimeline->where('timeline_id', $id)->update(['timeline_image' => $filename]);
    }
}