<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: appplication/json');

    include_once('../core/initialize.php');
    
    $post = new Post($db);
    $result = $post->read();
    $rows = $result->rowCount();

    if ($rows > 0){
        $data = array();
        $data['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $item = array(
                'profile' => $profile,
                'name' => $name,
                'email' => $email,
                'age' => $age,
                'address' => $address,
                'neighborhod' => $neighborhood,
                'zipCode' => $zip_code,
                'state' => $state,
                'biography' => $biography
            );
            array_push($data['data'], $item);
        }

        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(
            array('message' => 'Nenhum registro foi encontrado.')
        );
    }
?>