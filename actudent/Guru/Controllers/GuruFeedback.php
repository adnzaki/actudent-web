<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Feedback;

class GuruFeedback extends Feedback
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminFeedback.page_title');
        return parse('Actudent\Admin\Views\feedback\feedback-view', $data);
    }
}