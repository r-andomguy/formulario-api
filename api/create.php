<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: appplication/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

    include_once('../core/initialize.php');
    
    $post = new Post($db);
    $data = json_decode(file_get_contents('php://input'));
    
    $post->profile = $data->profile;
    $post->name = $data->name;
    $post->email = $data->email;
    $post->age = $data->age;
    $post->address = $data->address;
    $post->neighborhood = $data->neighborhood;
    $post->zipCode = $data->zipCode;
    $post->state = $data->state;
    $post->biography = $data->biography;

    if($post->create()){
        echo json_encode(
            array('message' => 'Registro criado com sucesso.')
        );
    } else {
        echo json_encode(
            array('message' => 'Não foi possível criar o registro.')
        );
    }

?>