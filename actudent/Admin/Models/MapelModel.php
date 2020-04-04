<?php namespace Actudent\Admin\Models;

class MapelModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for tb_lesson
     */
    private $QBMapel;

    /**
     * Table tb_lesson
     * 
     * @var string
     */
    public $mapel = 'tb_lessons';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBMapel = $this->db->table($this->mapel);    
    }

    /**
     * Get parents data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getLesson($limit, $offset, $orderBy = 'lesson_name', $searchBy = 'lesson_name', $sort = 'ASC', $search = '')
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole parent data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getLessonRows($searchBy = 'lesson_name', $search = '')
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get lesson detail
     * 
     * @param int $id
     * @return object
     */
    public function getLessonDetail($id)
    {
        $field = 'lesson_id, lesson_code, lesson_name';
        $select = $this->QBMapel->select($field)
                  ->where('lesson_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Insert lessons data
     * 
     * @return void
     */
    public function insert($value)
    {
        $lesson = $this->fillLessonField($value);
        $this->QBMapel->insert($lesson);
    }

    /**
     * Update lessons data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $data = $this->fillLessonField($value);
        $this->QBMapel->update($data, ['lesson_id' => $id]);
    }

    /**
     * Delete lessons
     * 
     * @param int parent_id
     * @param int user_id
     * 
     * @return void
     */
    public function delete($lessonID)
    {
        $deleted = ['deleted' => '1'];
        $this->QBMapel->update($deleted, ['lesson_id' => $lessonID]);
    }

    /**
     * Fill tb_lessons field with these data
     * 
     * @param array $data
     * @return array
     */
    private function fillLessonField($data)
    {
        return [
            'lesson_code'    => $data['lesson_code'],
            'lesson_name'    => $data['lesson_name'],
        ];
    }

    /**
     * Search for lessons by lesson_code, lesson_name fields
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return object
     */
    private function search($searchBy, $search)
    {
        $field = 'lesson_id, lesson_code, lesson_name';
        $select = $this->QBMapel->select($field);
        if(! empty($search))
        {
            // Store search parameter "lesson_code-lesson_name",
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $select->like($searchBy[0], $search); 
                $select->orLike($searchBy[1], $search); 
            }
            else 
            {
                $select->like($searchBy, $search); // search by one parameter
            }
        }

        return $select;
    }

}