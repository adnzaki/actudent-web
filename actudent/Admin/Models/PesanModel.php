<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\SharedModel;

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
        return $this->QBChatUser->like('participant', $_SESSION['id'])->get()->getResult();
    }

    /**
     * Get message by participant
     * 
     * @param string $participant
     * 
     * @return array
     */
    public function getMessagesByParticipant(string $participant): array
    {
        $chatUser = $this->QBChatUser->getWhere(['participant' => $participant])->getResult();

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
     * 
     * @return void
     */
    public function sendMessage(int $chatUserID, string $text): void
    {
        $values = [
            'chat_user_id'  => $chatUserID,
            'sender'        => $_SESSION['id'],
            'content'       => $text
        ];

        $this->QBChat->insert($values);
    }
}   