<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Core\Libraries\OstiumDate;
use Actudent\Admin\Models\TimelineModel;

class Timeline extends Actudent
{
    /**
     * TimelineModel
     * 
     * @var object
     */
    private $timeline;

    /**
     * OstiumDate library
     * 
     * @var object
     */
    private $ostiumDate;

    /**
     * The Constructor.
     */
    public function __construct()
    {
        $this->timeline = new TimelineModel;
        $this->ostiumDate = new OstiumDate;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = 'Timeline';
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\timeline\timeline');
    }

    public function getPosts($limit, $offset)
    {
        $data = $this->timeline->getPosts($limit, $offset);
        $formatted = [];
        foreach($data as $d)
        {
            // format the date and time
            $split = explode(' ', $d->timeline_date);
            $date = $this->ostiumDate->format('DD-MM-Y', reverse($split[0], '-', '-'));
            $time = explode(':', $split[1]);
            $time = $time[0].'.'.$time[1];
            $d->timeline_date = $date . ' | ' . $time;

            // fetch comments
            $d->comments = $this->getPostComments($d->timeline_id, 5, 0);

            // push them into the formatted data
            array_push($formatted, $d);
        }
        
        return $this->response->setJSON($data);
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
}