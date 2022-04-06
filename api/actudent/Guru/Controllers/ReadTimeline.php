<?php namespace Actudent\Guru\Controllers;

class ReadTimeline extends \Actudent\Admin\Controllers\Timeline
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminTimeline.timeline_title');
        return parse('Actudent\Admin\Views\timeline\timeline', $data);
    }
}