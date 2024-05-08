<?php

class Post {

    private $mySql;
    private string $table = 'forms';

    public int $id;
    public string $profile;
    public string $name;
    public string $address;
    public string $neighborhood;
    public string $zipCode;
    public string $state;
    public string $biography;

    public function __construct($db){
        $this->mySql = $db;
    }

    public function create(){

        $sql = 'INSERT INTO ' . $this->table . ' 
                SET profile = :profile, 
                    name = :name, 
                    address = :address, 
                    neighborhood = :neighborhood, 
                    zip_code = :zipCode,
                    state = :state,
                    biography = :biography'; 
        $statement = $this->mySql->prepare($sql);

        $this->profile = htmlspecialchars(strip_tags($this->profile));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->neighborhood = htmlspecialchars(strip_tags($this->neighborhood));
        $this->zipCode = htmlspecialchars(strip_tags($this->zipCode));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->biography = htmlspecialchars(strip_tags($this->biography));

        $statement->bindParam(':profile', $this->profile);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':address', $this->address);
        $statement->bindParam(':neighborhood', $this->neighborhood);
        $statement->bindParam(':zipCode', $this->zipCode);
        $statement->bindParam(':state', $this->state);
        $statement->bindParam(':biography', $this->biography);
        
        if ($statement->execute()){
            return true;
        }
        
        printf('Error %s. ' . PHP_EOL, $statement->error);
        return false;
    }

    public function read() {

        $sql = 'SELECT * FROM ' . $this->table;
        $statement = $this->mySql->prepare($sql);
        $statement->execute();

        return $statement;
    }

    public function readById(){
        $columns = [
            'profile',
            'name',
            'address',
            'neighborhood',
            'zip_code',
            'state',
            'biography'
        ];

        $sql = 'SELECT ' . implode(',', $columns) . ' 
                FROM ' . $this->table . '
                WHERE id =? LIMIT 1';
        $statement = $this->mySql->prepare($sql);
        $statement->bindParam(1, $this->id);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        
        $this->profile = $row['profile'];
        $this->name = $row['name'];
        $this->address = $row['address'];
        $this->neighborhood = $row['neighborhood'];
        $this->zipCode = $row['zip_code'];
        $this->state = $row['state'];
        $this->biography = $row['biography'];

        return $statement;
    }

    public function update(){

        $sql = 'UPDATE ' . $this->table . ' 
                SET profile = :profile, 
                    name = :name, 
                    address = :address, 
                    neighborhood = :neighborhood, 
                    zip_code = :zipCode,
                    state = :state,
                    biography = :biography
                WHERE id = :id'; 
        $statement = $this->mySql->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->profile = htmlspecialchars(strip_tags($this->profile));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->neighborhood = htmlspecialchars(strip_tags($this->neighborhood));
        $this->zipCode = htmlspecialchars(strip_tags($this->zipCode));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->biography = htmlspecialchars(strip_tags($this->biography));

        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':profile', $this->profile);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':address', $this->address);
        $statement->bindParam(':neighborhood', $this->neighborhood);
        $statement->bindParam(':zipCode', $this->zipCode);
        $statement->bindParam(':state', $this->state);
        $statement->bindParam(':biography', $this->biography);
        
        if ($statement->execute()){
            return true;
        }
        
        printf('Error %s. ' . PHP_EOL, $statement->error);
        return false;
    }

    public function delete(){
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $statement = $this->mySql->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(':id', $this->id);

        if ($statement->execute()){
            return true;
        }
        
        printf('Error %s. ' . PHP_EOL, $statement->error);
        return false;

    }

}

?>