<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $email = $_GET['email'];
    try{
        $sql = 'SELECT * FROM forms WHERE email =?';
        $statement = $conn->prepare($sql);
        $statement->bindParam(1, $email);
        $statement->execute();
        $forms = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($forms)){
            echo json_encode(['message' => 'Não há registros ligados a esse email.']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($forms);
    } catch(PDOException $e){
        echo json_encode(['error' => $e->getMessage()]);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name'])){
        echo json_encode(['error' => 'O nome é um capo obrigatório']);
        exit();
    } elseif (empty($data['age'])){
        echo json_encode(['error' => 'A idade é um capo obrigatório']);
        exit();
    }  elseif (empty($data['email'])){
        echo json_encode(['error' => 'O email é um capo obrigatório']);
        exit();
    }  elseif (empty($data['address'])){
        echo json_encode(['error' => 'O endereço é um capo obrigatório']);
        exit();
    }  elseif (empty($data['neighborhood'])){
        echo json_encode(['error' => 'O bairro é um capo obrigatório']);
        exit();
    } elseif (empty($data['zipCode'])){
        echo json_encode(['error' => 'O CEP é um capo obrigatório']);
        exit();
    }   elseif (empty($data['state'])){
        echo json_encode(['error' => 'O estado é um capo obrigatório']);
        exit();
    }

    $name = $data['name'];
    $age = $data['age'];
    $email = $data['email'];
    $address = $data['address'];
    $zipCode = $data['zipCode'];
    $neighborhood = $data['neighborhood'];
    $state = $data['state'];

    if(empty($data['profile'])){
        $profile = null;
    } else {
        $profile = $data['profile'];
    }

    if(empty($data['biography'])){
        $biography = null;
    } else {
        $biography = $data['biography'];
    }

    try {
        $sql = 'INSERT INTO forms (`profile`, `name`, `age`, `email`, `address`, `neighborhood`, `zipCode`, `state`, `biography`) 
                VALUES (:profile, :name, :age, :email, :address, :neighborhood, :zipCode, :state, :biography)';

        $statement = $conn->prepare($sql);
        $statement->bindParam(':profile', $profile);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':address', $address);
        $statement->bindParam(':neighborhood', $neighborhood);
        $statement->bindParam(':zipCode', $zipCode);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':biography', $biography);
        $statement->execute();
        
        echo json_encode([
            'message' => 'Registro criado com sucesso.', 
        ]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $profile = $data['profile'];
    $name = $data['name'];
    $age = $data['age'];
    $email = $data['email'];
    $address = $data['address'];
    $zipCode = $data['zipCode'];
    $neighborhood = $data['neighborhood'];
    $state = $data['state'];
    $biography = $data['biography'];


    $formEmail = $_GET['email'];
    try {
        $sql = 'SELECT * FROM forms WHERE email =?';
        $statement = $conn->prepare($sql);
        $statement->bindParam(1, $formEmail);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($row)){
            echo json_encode(['message' => 'Não há registros ligados a esse email.']);
            exit;
        }
        
        $sql = 'UPDATE forms 
                SET `profile` = :profile,
                    `name` = :name,
                    `age` = :age,
                    `email` = :email,
                    `address` = :address,
                    `neighborhood` = :neighborhood,
                    `zipCode` = :zipCode,
                    `state` = :state,
                    `biography` = :biography 
                WHERE email = :formEmail';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':profile', $profile);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':address', $address);
        $statement->bindParam(':neighborhood', $neighborhood);
        $statement->bindParam(':zipCode', $zipCode);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':biography', $biography);
        $statement->bindParam(':formEmail', $formEmail);
        
        if($statement->execute()){
            echo json_encode(['message' => 'Registro atualizado com sucesso.']);
        }

    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['email'])) {
        echo json_encode(['error' => 'O email é um campo obrigatório']);
        exit;
    }

    $formEmail = $data['email'];
    try {
        
        $sql = 'SELECT email FROM forms WHERE email = :email';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':email', $formEmail);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($row)){
            echo json_encode(['message' => 'Não há registros ligados a esse email.']);
            exit;
        }

        $sql = 'DELETE FROM forms WHERE email = :email';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':email', $formEmail);
        $statement->execute();

        echo json_encode(['message' => 'Registro deletado com sucesso.']);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

?>
