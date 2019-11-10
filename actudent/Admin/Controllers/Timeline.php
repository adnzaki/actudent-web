<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\TimelineModel;

class Timeline extends Actudent
{
    /**
     * TimelineModel
     * 
     * @var object
     */
    private $timeline;

    public function __construct()
    {
        $this->timeline = new TimelineModel;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = 'Timeline';
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\timeline\timeline');
    }
}