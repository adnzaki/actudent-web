<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\SharedModel;

class ContributionModel extends SharedModel
{
	/**
	 * Table name
	 */
	private $table = 'tb_contribution';

	private $QB;

	public function __construct()
	{
		parent::__construct();
		$this->QB = $this->db->table($this->table);
	}


}
