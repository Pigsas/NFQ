<?php

class Client extends Database
{
    public $id;
    public $firstName;
    public $lastName;
    public $completed;
    public $meetingTime;

    public function __construct($id_client = null)
    {
        parent::__construct();
        $userInfo = $this->query("SELECT * FROM client WHERE id_client = '$id_client'")->fetch();
        
        if(!empty($userInfo))
        {
            $this->id = $userInfo['id_client'];
            $this->firstName = $userInfo['firstName'];
            $this->lastName = $userInfo['lastName'];
            $this->meetingTime = $userInfo['meetingTime'];
            $this->completed = $userInfo['completed'];
        }
    }

    public function add()
    {
        try {
            $this->exec("
                INSERT INTO client 
                (firstName, lastName, meetingTime) 
                VALUES
                ('$this->firstName', '$this->lastName', '$this->meetingTime')
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    public function update()
    {
        try {
            $this->exec("
                UPDATE client SET
                firstName = '$this->firstName', 
                lastName = '$this->lastName', 
                meetingTime = '$this->meetingTime' 
                WHERE id_client = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    public function complete()
    {
        try {
            $this->exec("
                UPDATE client SET
                completed = '1' 
                WHERE id_client = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    static function getClients($order_by = 'meetingTime')
    {
        
        $response = (new Database)->query("SELECT * FROM client WHERE completed = 0 ORDER BY $order_by ASC")->fetchAll();

        return $response;
    }

}
