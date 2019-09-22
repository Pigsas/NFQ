<?php

class Client extends Database
{
    public $id;
    public $firstName;
    public $lastName;

    public function __construct($id_client = null)
    {
        parent::__construct();
        $userInfo = $this->query("SELECT * FROM client WHERE id_client = '$id_client'")->fetch();
        
        if(!empty($userInfo))
        {
            $this->id = $userInfo['id_client'];
            $this->firstName = $userInfo['firstName'];
            $this->lastName = $userInfo['lastName'];
        }
    }

    public function add()
    {
        try {
            if(!preg_match("/^[a-zA-Z ]*$/", $this->firstName))
                return "Neteisingas Vardo formatas !";
            if(!preg_match("/^[a-zA-Z ]*$/", $this->lastName))
                return "Neteisingas Pavardės formatas !";
            $this->exec("
                INSERT INTO client 
                (firstName, lastName) 
                VALUES
                ('$this->firstName', '$this->lastName')
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
                UPDATE client SET
                firstName = '$this->firstName', 
                lastName = '$this->lastName' 
                WHERE id_client = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

}
