<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: appplication/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

    include_once('../core/initialize.php');
    
    $post = new Post($db);
    $data = json_decode(file_get_contents('php://input'));
    
    $post->id = $data->id;


    if($post->delete()){
        echo json_encode(
            array('message' => 'Registro excluído com sucesso.')
        );
    } else {
        echo json_encode(
            array('message' => 'Não foi possível excluído o registro.')
        );
    }

?>