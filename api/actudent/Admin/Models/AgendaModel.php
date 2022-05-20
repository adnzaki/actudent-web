<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\SharedModel;
use Actudent\Core\Models\AuthModel;

class AgendaModel extends \Actudent\Core\Models\Connector
{
    /**
     * The Query Builders
     */
    private $QBAgenda;

    private $QBParent;

    private $QBAgendaUser;

    private $QBUser;

    /**
     * Table definition
     * 
     * @var string
     */
    private $agenda = 'tb_agenda';

    private $agendaUser = 'tb_agenda_user';

    private $parent = 'tb_parent';

    private $user = 'tb_user';

    private $studentParent = 'tb_student_parent';

    private $student = 'tb_student';

    private $studentGrade = 'tb_student_grade';

    private $grade = 'tb_grade';

    private $teacher = 'tb_staff';

    private $shared;

    public function __construct()
    {
        parent:: __construct();
        $this->QBAgenda = $this->db->table($this->agenda);
        $this->QBParent = $this->db->table($this->parent);
        $this->QBAgendaUser = $this->db->table($this->agendaUser);
        $this->QBUser = $this->db->table($this->user);
        $this->shared = new SharedModel();
    }

    /**
     * Grab data from tb_agenda and put them in FullCalendar plugin
     * 
     * @param string $viewStart
     * @param string $viewEnd
     * @param string $sort
     * 
     * @return array
     */
    public function getEvents(string $viewStart, string $viewEnd, string $sort = 'false'): array
    {
        $query = $this->QBAgenda->select('agenda_id, agenda_name, agenda_start, agenda_end')
                 ->where([
                     "{$this->agenda}.agenda_start >=" => $viewStart,
                     "{$this->agenda}.agenda_start <" => $viewEnd
                 ]);
        
        if($sort === 'true')
        {
            $query->orderBy('agenda_start', 'DESC');
        }
        
        return $query->get()->getResult();
    }

    /**
     * Get event's detail data
     * 
     * @param int $id
     * 
     * @return object
     */
    public function getEventDetail(int $id): object
    {
        return $this->QBAgenda->getWhere(['agenda_id' => $id])->getResult()[0];
    }

    /**
     * Get agenda's attachment
     * 
     * @param int $id
     * 
     * @return object
     */
    public function getAttachment(int $id): object
    {
        return $this->QBAgenda->select('agenda_attachment')
                ->where(['agenda_id' => $id])->get()->getResult()[0];
    }

    /**
     * Get event's guests
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function getEventGuests(int $id)
    {
        $eventGuest = $this->QBAgendaUser->getWhere(['agenda_id' => $id])->getResult();

        // process only if data is found
        if(count($eventGuest) > 0)
        {
            $eventGuest = explode(',', $eventGuest[0]->guests);
            $guests = [];
            foreach($eventGuest as $g)
            {
                $guests[] = $this->findUser($g);
            }
    
            return $guests;
        }
    }

    /**
     * Find a user based on user_id 
     * 
     * @param int $id
     * 
     * @return object
     */
    private function findUser(int $id): object
    {
        return $this->QBUser->select('user_id, user_name')
               ->where('user_id', $id)->get()->getResult()[0];
    }

    /**
     * Insert data from user input to tb_agenda and its relations
     * 
     * @param array $value
     * 
     * @return int
     */
    public function insert(array $value): int
    {
        $data = $this->fillAgendaField($value);
        $username = jwt_decode(bearer_token())->email;
        $auth = new AuthModel;
        $data['user_id'] = $auth->getDataPengguna($username)->user_id;
        $this->QBAgenda->insert($data);
        
        // insert data to tb_agenda
        $insertID = $this->db->insertID();

        if(! empty($value['agenda_guest']))
        {
            // insert guest IDs to tb_agenda_user
            $this->insertAgendaGuests($value['agenda_guest'], $insertID);
            $this->sendAgendaNotification($value['agenda_name'], $value['agenda_guest']);
        }

        return $insertID;
    }

    /**
     * Update agenda
     * 
     * @param array $data
     * @param int $id
     * 
     * @return int
     */
    public function update(array $value, int $id): int
    {
        $data = $this->fillAgendaField($value);
        $this->QBAgenda->update($data, ['agenda_id' => $id]);

        if(! empty($value['agenda_guest']))
        {
            // insert guest IDs to tb_agenda_user
            if($this->getEventGuests($id) === null)
            {
                $this->insertAgendaGuests($value['agenda_guest'], $id);
            } 
            else 
            {
                $this->updateAgendaGuests($value['agenda_guest'], $id);
            }

            $this->sendAgendaNotification($value['agenda_name'], $value['agenda_guest']);
        }

        return $id;
    }

    /**
     * Send agenda notification 
     * 
     * @param string $name => agenda_name
     * @param string $guests
     * 
     * @return void
     */
    public function sendAgendaNotification(string $name, string $guests): void
    {
        $guestArray = explode(',', $guests);
        $content = [
            'title' => 'Undangan Kegiatan',
            'body' => 'Anda diundang dalam kegiatan ' . $name,
        ];

        foreach($guestArray as $guest)
        {
            $this->shared->sendNotification($guest, $content, 'mixed');
        }
    }

    /**
     * Delete agenda and related data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function delete(int $id): void
    {
        // transaction started
        $this->db->transStart();
        $this->QBAgendaUser->delete(['agenda_id' => $id]);
        $this->QBAgenda->delete(['agenda_id' => $id]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Data to be filled on tb_agenda
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillAgendaField(array $data): array
    {
        return [
            'agenda_name'           => $data['agenda_name'],
            'agenda_start'          => date('Y-m-d H:i:s', $data['agenda_start']),
            'agenda_end'            => date('Y-m-d H:i:s', $data['agenda_end']),
            'agenda_description'    => $data['agenda_description'],
            'agenda_priority'       => $data['agenda_priority'],
            'agenda_location'       => $data['agenda_location'],
            'agenda_attachment'     => $data['agenda_attachment']
        ];
    }

    /**
     * Insert guest IDs to tb_agenda_user
     * 
     * @param string $data
     * @param int $id
     * 
     * @return void
     */
    private function insertAgendaGuests(string $data, int $id): void
    {
        $this->QBAgendaUser->insert([
            'agenda_id' => $id,
            'guests'   => $data,
        ]);
    }

    /**
     * Update guest IDs on tb_agenda_user
     * 
     * @param string $data
     * @param int $id
     * 
     * @return void
     */
    private function updateAgendaGuests(string $data, int $id): void
    {
        $this->QBAgendaUser->update([
            'guests'    => $data,
        ], ['agenda_id' => $id]);
    }

    /**
     * Search the guests!
     * 
     * @param string $search
     * 
     * @return array
     */
    public function searchGuest(string $search): array
    {
        return $this->joinAndSearchQuery($search)->get()->getResult();
    }

    /**
     * Join And Search Query
     * Search for grade, teacher or parent with join table
     * 
     * @param string $search
     * 
     * @return CI_Query_Builder
     */
    private function joinAndSearchQuery(string $search)
    {
        $field = "{$this->parent}.user_id as user_parent,
                  {$this->teacher}.user_id as user_guru, 
                  parent_father_name, parent_mother_name, grade_name, staff_name";
        $query = $this->QBParent->select($field)
                ->join($this->studentParent, "{$this->studentParent}.parent_id = {$this->parent}.parent_id")
                ->join($this->student, "{$this->student}.student_id = {$this->studentParent}.student_id")
                ->join($this->studentGrade, "{$this->studentGrade}.student_id = {$this->student}.student_id and {$this->student}.deleted=0")
                ->join($this->grade, "{$this->grade}.grade_id = {$this->studentGrade}.grade_id")
                ->join($this->teacher, "{$this->teacher}.staff_id = {$this->grade}.teacher_id")
                ->like("{$this->grade}.grade_name", $search)->orLike("{$this->parent}.parent_father_name", $search)
                ->orLike("{$this->parent}.parent_mother_name", $search)->orLike("{$this->teacher}.staff_name", $search);
        
        return $query;                
    }
}