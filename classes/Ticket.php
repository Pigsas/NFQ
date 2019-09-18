<?php

class Ticket extends Database
{
    public $id;
    public $completed;
    public $meetingTime;
    public $id_specialist = 1;
    public $id_client;

    public function __construct($id_ticket = null)
    {
        parent::__construct();
        $ticketInfo = $this->query("SELECT * FROM ticket WHERE id_ticket = '$id_ticket'")->fetch();
        
        if(!empty($specialistInfo))
        {
            $this->id = $ticketInfo['id_ticket'];
            $this->completed = $ticketInfo['completed'];
            $this->meetingTime = $ticketInfo['meetingTime'];
            $this->id_specialist = $ticketInfo['id_specialist'];
            $this->id_client = $ticketInfo['id_client'];

        }
    }

    public function add()
    {
        if(empty($this->query("SELECT 1 FROM ticket WHERE id_specialist = '$this->id_specialist' AND completed = 0 ORDER BY meetingTime DESC LIMIT 1")->fetch()))
        {
            $this->meetingTime = date('Y-m-d H:i');
        }else{
            $dateTime = new DateTime();
            $dateTime->modify('+5 minutes');
            $this->meetingTime =  $dateTime->format("Y-m-d H:i");
        }
        try {
            $this->exec("
                INSERT INTO ticket 
                (meetingTime, id_specialist, id_client) 
                VALUES
                ('$this->meetingTime', '$this->id_specialist', '$this->id_client')
            ");
            $this->id = $this->lastInsertId();
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    public function update()
    {
        try {
            $this->exec("
                UPDATE ticket SET
                meetingTime = '$this->meetingTime', 
                id_specialist = '$this->id_specialist', 
                id_client = '$this->id_client', 
                WHERE id_ticket = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    static function getTickets($id_specialist)
    {
        $data = (new Database)->query("
            SELECT * 
            FROM ticket 
            WHERE id_specialist = '$id_specialist' AND completed = 0 
            ORDER BY meetingTime DESC
        ")->fetchAll();
        return $data;
    }
}
