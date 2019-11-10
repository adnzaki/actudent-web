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
}