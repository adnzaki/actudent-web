<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Timeline;

class ReadTimeline extends Timeline
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminTimeline.timeline_title');
        return parse('Actudent\Admin\Views\timeline\timeline', $data);
    }
}