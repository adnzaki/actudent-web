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

        return $this->getMessages($chatUser[0]->chat_user_id);
    }

    /**
     * Get messages 
     * 
     * @param int $chatUserID
     * 
     * @return array
     */
    public function getMessages(int $chatUserID): array
    {
        $chat = $this->QBChat->where([
            'chat_user_id' => $chatUserID
        ])->orderBy('created', 'DESC')->get()->getResult();

        return $chat;
    }    
}   