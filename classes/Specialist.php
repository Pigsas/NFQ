<?php

class Specialist extends Database
{
    public $id;
    public $firstName;
    public $lastName;

    public function __construct($id_specialist = null)
    {
        parent::__construct();
        $specialistInfo = $this->query("SELECT * FROM specialist WHERE id_specialist = '$id_specialist'")->fetch();
        
        if(!empty($specialistInfo))
        {
            $this->id = $specialistInfo['id_specialist'];
            $this->firstName = $specialistInfo['firstName'];
            $this->lastName = $specialistInfo['lastName'];
        }
    }

    public function add()
    {
        try {
            $this->exec("
                INSERT INTO specialist 
                (firstName, lastName) 
                VALUES
                ('$this->firstName', '$this->lastName')
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
                UPDATE specialist SET
                firstName = '$this->firstName', 
                lastName = '$this->lastName', 
                WHERE id_specialist = $this->id
            ");
            return true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

}
