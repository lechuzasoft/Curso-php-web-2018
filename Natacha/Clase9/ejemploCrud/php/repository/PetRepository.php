<?php

Class PetRepository
{
    protected $dbConnection;

    public function __construct( $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    //@TODO MEDIUM Crear una clase para crear Usuarios desde variables o arrays
    public static function createPetFromRow($row) 
    {
        $newPet = new Pet();
        $newPet->setPetId($row['id']);
        $newPet->setPetRace($row['raza']);
        $newPet->setPetName($row['petname']);
        $newPet->setPetAge($row['edad']);
        $newPet->setPetSex($row['sexo']);
        return $newPet;
    }
    
    public static function createPetFromVariables($id, $petName, $petAge, $petRace, $petSex) 
    {
        $newPet = new Pet();
        $newPet->setPetId($id);
        $newPet->setPetRace($petRace);
        $newPet->setPetName($petName);
        $newPet->setPetAge($petAge);
        $newPet->setPetSex($petSex);
        return $newPet;
    }
    //estos dos metodos de arriba pueden ir en una clase que pase de arrays o 
    //variables a objetos usuario 

    public function getAllPets()
    {
        $sql = "SELECT * FROM pets";
        $result = $this->dbConnection->query($sql);
        $petArray = [];
        foreach ($result as $row) {
            $petArray[] = self::createPetFromRow($row);
        }

        return $petArray;      
    }

    public function getPetById($id)
    {
        $pet = NULL;
        $sql = "SELECT * FROM pets WHERE id = {$id}";
        $result = $this->dbConnection->query($sql);

        $row = $result->fetch_array();
        if ($row) {
            $pet = self::createPetFromRow($row);
        }

        return $pet;      
    }

    public function delete($pet)
    {
        $sql = "DELETE FROM pets WHERE id = {$pet->getPetId()}";
        $result = $this->dbConnection->query($sql);
        return $result;      
    }

    public function insert($pet)
    {
        $sql = "INSERT INTO `clase9`.`pets` 
                    (`raza`, `petname`, `edad`,`sexo` )
                VALUES (
                     '{$pet->getPetRace()}',
                     '{$pet->getPetName()}',
                     '{$pet->getPetAge()}',
                     '{$pet->getPetSex()}'   
                )";
        $result = $this->dbConnection->query($sql);

        return $result;      
    }

    public function update($pet)
    {
        $sql = "UPDATE `clase9`.`pets` 
                SET 
                    petname = '{$pet->getPetName()}',
                    raza = '{$pet->getPetRace()}',
                    edad = '{$pet->getPetAge()}',
                    sexo = '{$pet->getPetSex()}'   
                WHERE id = {$pet->getPetId()}
                ";
        $result = $this->dbConnection->query($sql);
        var_dump($sql);
        return $result;      
    }

}