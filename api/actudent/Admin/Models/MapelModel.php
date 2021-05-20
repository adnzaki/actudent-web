<?php namespace Actudent\Admin\Models;

class MapelModel extends \Actudent\Core\Models\Connector
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
     * 
     * @return array
     */
    public function getLesson($limit, $offset, $orderBy = 'lesson_name', $searchBy = 'lesson_name', $sort = 'ASC', $search = ''): array
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole parent data
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return int
     */
    public function getLessonRows(string $searchBy = 'lesson_name', string $search = ''): int
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get lesson detail
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getLessonDetail(int $id): array
    {
        $field = 'lesson_id, lesson_code, lesson_name';
        $select = $this->QBMapel->select($field)
                  ->where('lesson_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Insert lessons data
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert(array $value): void
    {
        $lesson = $this->fillLessonField($value);
        $this->QBMapel->insert($lesson);
    }

    /**
     * Update lessons data
     * 
     * @param array $value
     * @param int $id 
     * 
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $data = $this->fillLessonField($value);
        $this->QBMapel->update($data, ['lesson_id' => $id]);
    }

    /**
     * Delete lessons
     * 
     * @param int $lessonID
     * 
     * @return void
     */
    public function delete(int $lessonID): void
    {
        $deleted = ['deleted' => '1'];
        $this->QBMapel->update($deleted, ['lesson_id' => $lessonID]);
    }

    /**
     * Fill tb_lessons field with these data
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillLessonField(array $data): array
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
     * @return QueryBuilder
     */
    private function search(string $searchBy, string $search)
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