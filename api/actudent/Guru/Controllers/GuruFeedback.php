<?php namespace Actudent\Guru\Controllers;

class GuruFeedback extends \Actudent\Admin\Controllers\Feedback
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminFeedback.page_title');
        return parse('Actudent\Admin\Views\feedback\feedback-view', $data);
    }
}