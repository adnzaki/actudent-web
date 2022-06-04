<?php namespace SiAbsen\Models;

class CoreModel extends \Actudent\Admin\Models\PegawaiModel
{
    private $QBPresence;

    private $QBConfig;

    private $QBPermit;

    private $staffPresence = 'tb_staff_presence';

    private $presenceConfig = 'tb_staff_presence_config';

    private $presencePermit = 'tb_staff_presence_permit';

    public function __construct()
    {
        parent::__construct();
        $this->QBPresence = $this->db->table($this->staffPresence);
        $this->QBConfig = $this->db->table($this->presenceConfig);
        $this->QBPermit = $this->db->table($this->presencePermit);
    }

    public function sendPresence(string $tag, array $data, int $id): void
    {
        $values = [
            'staff_id'          => $id,
            'presence_tag'      => $tag,
            'presence_lat'      => $data['lat'],
            'presence_long'     => $data['long'],
            'presence_photo'    => $data['photo']
        ];

        $this->QBPresence->insert($values);
    }

    public function getPresence(string $staffId, string $date, string $tag)
    {
        $params = [
            'presence_tag'  => $tag,
            'staff_id'      => $staffId
        ];

        $query = $this->QBPresence->like('presence_datetime', $date)->where($params)->get();
        $result = $query->getResult();

        return count($result) > 0 ? $result[0] : null;
    }

    public function getConfig(): object
    {
        return $this->QBConfig->get()->getResult()[0];
    }
}