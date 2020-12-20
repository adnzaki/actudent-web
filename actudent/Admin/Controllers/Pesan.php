<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\PesanModel;
use Actudent\Admin\Models\PenggunaModel;
use OstiumDate;

class Pesan extends Actudent
{
    private $pesan;

    private $pengguna;

    private $ostium;

    public function __construct()
    {
        $this->pesan = new PesanModel();
        $this->ostium = new OstiumDate();
        $this->pengguna = new PenggunaModel();
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminPesan.page_title');
        $data['userID'] = $_SESSION['id'];

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\pesan\pesan-view');
    }

    public function getMessages($chatUserID, $limit, $offset, $event)
    {
        $chat = $this->pesan->getMessages($chatUserID, 'DESC', $limit, $offset, $event);
        $wrapper = [];
        foreach($chat as $key)
        {
            $dateToArray = explode(' ', $key->created);
            $wrapper[] = [
                'id'        => $key->chat_id,
                'sender'    => $key->sender,
                'content'   => $key->content,
                'date'      => reverse($dateToArray[0], '-', '/'),
                'time'      => substr($dateToArray[1], 0, 5),
            ];
        }

        if($event === 'loadAll' && $limit !== '1')
        {
            $this->pesan->readMessage($chatUserID);
        }

        return $this->response->setJSON([
            'chats' => $wrapper,
            'rows'  => $this->pesan->getTotalMessages($chatUserID)
        ]);
    }

    public function readMessage($chatUserID)
    {
        $this->pesan->readMessage($chatUserID);
        return $this->response->setJSON(['status' => 'OK']);
    }

    public function getChatList()
    {
        $data = $this->pesan->getChatList();
        $listWrapper = [];

        foreach($data as $key)
        {
            // participant in array
            $pArray = [
                $key->participant_1,
                $key->participant_2
            ];

            // loop them and find the current user
            foreach($pArray as $val)
            {
                // if current value is not current user,
                // make it as a recipient
                if($val !== $_SESSION['id'])
                {
                    $participant = $val;
                    break;
                }
            }
            
            // get user data and latest chat
            $userData = $this->pengguna->getUserDetail($participant);
            $chat = $this->pesan->getMessagesByParticipant($key->participant_1, $key->participant_2);
            $date = explode(' ', $chat[0]->created);
            $listWrapper[] = [
                'id'            => $key->chat_user_id,
                'recipient'     => $userData[0]->user_name,
                'latest_chat'   => $chat[0]->content,
                'datetime'      => $this->lastChatDate($chat[0]->created),
                'timestamp'     => strtotime($chat[0]->created) // used for data sorting
            ];

        }

        // don't forget to sort them by time
        $timestamp = array_column($listWrapper, 'timestamp');
        array_multisort($timestamp, SORT_DESC, $listWrapper);

        return $this->response->setJSON($listWrapper);
    }

    public function sendMessage($chatUserID)
    {
        $text = $this->request->getPost('text');
        $recipient = $this->request->getPost('recipient');

        // prevent user to send empty message
        if(! empty($text))
        {
            $response = [
                'status'    => 'OK', 
                'note'      => 'Message sent',
                'chatUser'  => $this->pesan->sendMessage($chatUserID, $text, $recipient),
            ];
        }


        return $this->response->setJSON($response);
    }

    public function delete($chatUserID)
    {
        $this->pesan->deleteChat($chatUserID);
        return $this->response->setJSON(['status' => 'OK']);
    }

    private function lastChatDate($datetime)
    {
        $oneDay = 60 * 60 * 24;
        $tomorrow = date('Y-m-d', time() + $oneDay);
        $today = strtotime("$tomorrow 00:00:00");
        $yesterday = $today - $oneDay;
        $fewDays = $yesterday - $oneDay;
        $timestamp = strtotime($datetime);

        $dateToArray = explode(' ', $datetime);
        $date = $this->ostium->format('d-m-y', reverse($dateToArray[0], '-', '-'), '/');
        $time = substr($dateToArray[1], 0, 5);

        if($timestamp <= $today && $timestamp >= $yesterday)
        {
            $output = $time;
        }

        if($timestamp <= $yesterday && $timestamp  > $fewDays)
        {
            $output = lang('Admin.kemarin');
        }
        
        if($timestamp < $fewDays)
        {
            $output = $date;
        }

        return $output;
    }

    public function selectParticipant($userID)
    {
        $data = $this->pesan->getChatUserID($userID);
        return $this->response->setJSON($data);
    }

    public function searchParticipant($search)
    {
        $data = $this->pesan->getParticipant($search);

        return $this->response->setJSON($data);
    }
}