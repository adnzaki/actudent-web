<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\LiburModel;
use OstiumDate;

class Libur extends \Actudent
{
	private $model;

	public function __construct()
	{
		$this->model = new LiburModel;
	}

	public function getHolidays($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
		if(is_admin()) {
			$data = $this->model->getHolidays($limit, $offset, $orderBy, $searchBy, $sort, $search);
			$rows = $this->model->getHolidaysRows($searchBy, $search);

			foreach($data as $v) {
				$user = $this->getDataPengguna();
            	$lang = $this->getAppConfig($user->user_id)->lang;

				$v->start_date_short = $lang === 'english' ? date('d M Y', strtotime($v->start_date)) : os_date()->create($v->start_date, 'd-M-Y');
				$v->end_date_short = $lang === 'english' ? date('d M Y', strtotime($v->end_date)) : os_date()->create($v->end_date, 'd-M-Y');
				$v->start_date = $lang === 'english' ? date('d F Y', strtotime($v->start_date)) : os_date()->create($v->start_date);
				$v->end_date = $lang === 'english' ? date('d F Y', strtotime($v->end_date)) : os_date()->create($v->end_date);
			}
			return $this->response->setJSON([
				'container' => $data,
				'totalRows' => $rows,
			]);

		}
    }

	public function getDetail($id)
	{
		return $this->createResponse($this->model->getHolidaysDetail($id), 'is_admin');
	}

	public function save($id = null)
	{
		if(is_admin()) {
			$validation = $this->validation();
			$data = $this->request->getPost(array_keys($validation[0]));

			if(! $this->validateForms($data, $validation[0], $validation[1])) {
				return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
			} else {
				if($id === null) {
					$this->model->insert($data);
				} else {
					$this->model->update($data, $id);
				}

				return $this->response->setJSON([
                    'code' 	=> '200',
					'msg'	=> 'Data submitted successfully',
                ]);
			}
		}
	}

	public function delete()
    {
        if(is_admin()) {
            $idString = $this->request->getPost('id');
            $idWrapper = [];
            if(strpos($idString, '-') !== false) {
                $idWrapper = explode('-', $idString);
                foreach($idWrapper as $id) {
                    $toArray = explode('-', $id);
                    $this->model->delete($toArray[0]);
                }
            }
            else
            {
                $toArray = explode('-', $idString);
                $this->model->delete($toArray[0]);
            }

            return $this->response->setJSON(['status' => 'OK']);
        }
    }

	private function validation()
	{
		$start = $this->request->getPost('start_date');
		$end = $this->request->getPost('end_date');
		$rules = [
			'holiday_title'	=> 'required',
			'start_date'	=> 'required|less_than_equal_to['.$end.']',
			'end_date'		=> 'required|greater_than_equal_to['.$start.']',
		];

		$messages = [
			'holiday_title' => [
				'required' => get_lang('AdminLibur.libur_holiday_required'),
			],
			'start_date' => [
				'required' => get_lang('AdminLibur.libur_holiday_start_required'),
				'less_than_equal_to' => get_lang('AdminLibur.libur_holiday_start_end'),
			],
			'end_date' => [
				'required' => get_lang('AdminLibur.libur_holiday_end_required'),
				'greater_than_equal_to' => get_lang('AdminLibur.libur_holiday_end_start'),
			],
		];

		return [$rules, $messages];
	}
}
