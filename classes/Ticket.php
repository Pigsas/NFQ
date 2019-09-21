<?php

class Ticket extends Database
{
    public $id;
    public $completed;
    public $meetingTime = null;
    public $meetingEnds = null;
    public $id_specialist = 1;
    public $id_client;

    public function __construct($id_ticket = null)
    {
        parent::__construct();
        $ticketInfo = $this->query("SELECT * FROM ticket WHERE id_ticket = '$id_ticket'")->fetch();
        
        if(!empty($ticketInfo))
        {
            $this->id = $ticketInfo['id_ticket'];
            $this->completed = $ticketInfo['completed'];
            $this->meetingTime = $ticketInfo['meetingTime'];
            $this->meetingEnds = $ticketInfo['meetingEnds'];
            $this->id_specialist = $ticketInfo['id_specialist'];
            $this->id_client = $ticketInfo['id_client'];

        }
    }

    public function add()
    {
        if(empty($client = $this->query("SELECT meetingTime FROM ticket WHERE id_specialist = '$this->id_specialist' AND completed = 0 ORDER BY meetingTime DESC LIMIT 1")->fetch()))
            $this->meetingTime = date('Y-m-d H:i');

        try {
            $this->exec("
                INSERT INTO ticket 
                (id_specialist, id_client) 
                VALUES
                ('$this->id_specialist', '$this->id_client')
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
                meetingEnds = ".($this->meetingEnds?"'$this->meetingEnds'":"NULL").",
                id_specialist = '$this->id_specialist', 
                id_client = '$this->id_client', 
                completed = '$this->completed' 
                WHERE id_ticket = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    static function getTickets($id_specialist, $limit = null)
    {
        $data = (new Database)->query("
            SELECT * 
            FROM ticket 
            WHERE id_specialist = '$id_specialist' AND completed = 0 
            ORDER BY id_ticket ASC 
            ".($limit?"LIMIT $limit":"")."
        ")->fetchAll();
        return $data;
    }
    public function meetingsDiff($date1, $date2)
    {
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);
        $diff = $date1->diff($date2);

        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;

        return $minutes;
    }
    public function averageTime(){
        $times = $this->query("
            SELECT meetingTime, meetingEnds 
            FROM ticket 
            WHERE id_specialist = '$this->id_specialist' AND 
            completed = 1 AND 
            DATE_FORMAT(meetingTime, '%Y-%m-%d') = DATE_FORMAT(meetingEnds, '%Y-%m-%d') AND 
            DATE_FORMAT(meetingTime, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')
            ")->fetchAll();
        $timesdiff = [];

        foreach ($times as $time) {
            $timesdiff[] = $this->meetingsDiff($time['meetingTime'], $time['meetingEnds']);
        }

        $average = array_sum($timesdiff)/count($timesdiff);

        return $average;
    }
}
