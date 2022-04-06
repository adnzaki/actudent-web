<?php namespace Actudent\Admin\Models;

class PesanModel extends SharedModel
{
    /**
     * Query builder for tb_chat
     * 
     * @var object
     */
    private $QBChat;

    /**
     * Query builder for tb_chat_users
     * 
     * @var object
     */
    private $QBChatUser;

    /**
     * Table tb_chat
     * 
     * @var string
     */
    private $chat = 'tb_chat';

    /**
     * Table tb_chat_users
     * 
     * @var string
     */
    private $chatUser = 'tb_chat_users';

    /**
     * Load the builders....
     */
    public function __construct()
    {
        parent:: __construct();
        $this->QBChat = $this->db->table($this->chat);
        $this->QBChatUser = $this->db->table($this->chatUser);
    }

    /**
     * Get chat list for logged on user
     * 
     * @return array
     */
    public function getChatList(): array
    {
        return $this->QBChatUser
                    ->where('participant_1', $_SESSION['id'])
                    ->orWhere('participant_2', $_SESSION['id'])
                    ->get()->getResult();
    }

    /**
     * Get message by participant
     * 
     * @param int $participant1
     * @param int $participant2
     * 
     * @return array
     */
    public function getMessagesByParticipant(int $participant1, int $participant2): array
    {
        $chatUser = $this->QBChatUser->getWhere([
            'participant_1' => $participant1,
            'participant_2' => $participant2,
        ])->getResult();

        return $this->getMessages($chatUser[0]->chat_user_id, 'DESC', 1, 0, 'loadAll');
    }

    /**
     * Get messages 
     * 
     * @param int $chatUserID
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @param string $event
     * 
     * @return array
     */
    public function getMessages(int $chatUserID, string $order, int $limit, int $offset, string $event): array
    {
        if($event === 'loadAll' || $event === 'loadMore')
        {
            $params = ['chat_user_id' => $chatUserID];
        }
        else
        {
            $params = [
                'chat_user_id' => $chatUserID,
                'read_status' => 0,
                'sender !=' => $_SESSION['id']
            ];
        }

        $chat = $this->QBChat->where($params)
                ->limit($limit, $offset)
                ->orderBy('created', $order)
                ->get()
                ->getResult();

        return $chat;
    }    

    /**
     * Get total number of messages
     * 
     * @param int $chatUserID
     * 
     * @return int
     */
    public function getTotalMessages(int $chatUserID): int
    {
        return $this->QBChat->where(['chat_user_id' => $chatUserID])->countAllResults();
    }

    /**
     * Get user as participant
     * 
     * @param string $search
     * 
     * @return array
     */
    public function getParticipant(string $search): array
    {
        $field = 'user_id, user_name, user_email, user_level';
        $params = [
            'deleted'       => 0,
            'user_id !='    => $_SESSION['id']
        ];

        return $this->QBUser->select($field)
                    ->like('user_name', $search)
                    ->where($params)
                    ->get()->getResult();
    }

    public function getChatUserID($userID)
    {
        $param1 = [
            'participant_1' => $userID,
            'participant_2' => $_SESSION['id'],
        ];

        $param2 = [
            'participant_1' => $_SESSION['id'],
            'participant_2' => $userID
        ];

        $result = $this->QBChatUser->groupStart()
                                        ->where($param1)
                                   ->groupEnd()
                                   ->orGroupStart()
                                        ->where($param2)
                                   ->groupEnd()
                                   ->get()->getResult();
                                   
        return count($result) > 0 ? $result[0]->chat_user_id : 0;
    }

    /**
     * Get unread messages from all sender to be 
     * displayed on all pages except Message page
     * 
     * @return int
     */
    public function getAllUnreadMessages(): int
    {
        $param = [
            'sender !=' => $_SESSION['id'],
            'read_status' => 0
        ];
        
        $field  = "{$this->chatUser}.chat_user_id, participant_1, participant_2, sender, read_status";
        $select = $this->QBChat->select($field);
        $join   = $select->join($this->chatUser, "{$this->chatUser}.chat_user_id={$this->chat}.chat_user_id");
        $where  = $join->groupStart()
                            ->where('participant_1', $_SESSION['id'])
                            ->orWhere('participant_2', $_SESSION['id'])
                        ->groupEnd()
                        ->where($param);

        return $where->countAllResults();
    }

    /**
     * Get unread messages to be displayed on chat list
     * 
     * @param int $chatUserID
     * 
     * @return int
     */
    public function getUnreadMessages(int $chatUserID): int
    {
        $params = [
            'read_status'   => 0,
            'sender !='     => $_SESSION['id'],
            'chat_user_id'  => $chatUserID
        ];
        
        return $this->QBChat->where($params)->countAllResults();
    }

    /**
     * Read message by recipient
     * 
     * @param int $chatUserID
     * 
     * @return void
     */
    public function readMessage(int $chatUserID): void
    {
        $this->QBChat->update(['read_status' => 1], [
            'chat_user_id' => $chatUserID,
            'read_status' => 0,
            'sender !=' => $_SESSION['id']            
        ]);
    }

    /**
     * Send a message
     * 
     * @param int $chatUserID
     * @param string $text
     * @param mixed $recipient
     * 
     * @return int
     */
    public function sendMessage(int $chatUserID, string $text, $recipient): int
    {
        if($chatUserID === 0 && ! empty($recipient))
        {
            $this->QBChatUser->insert([
                'participant_1' => $_SESSION['id'],
                'participant_2' => $recipient
            ]);

            $id = $this->db->insertID();
        }
        else 
        {
            $id = $chatUserID;
        }

        $values = [
            'chat_user_id'  => $id,
            'sender'        => $_SESSION['id'],
            'content'       => $text
        ];

        $this->QBChat->insert($values);

        return $id;
    }

    /**
     * Delete a chat
     * 
     * @param int $chatUserID
     * 
     * @return void
     */
    public function deleteChat(int $chatUserID): void
    {
        $this->db->transStart();
        $this->QBChat->delete(['chat_user_id' => $chatUserID]);
        $this->QBChatUser->delete(['chat_user_id' => $chatUserID]);
        $this->db->transComplete();
    }
}   